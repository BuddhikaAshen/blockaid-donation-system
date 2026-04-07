<?php
// ============================================================
//  INCLUDES
// ============================================================
require_once 'db.php';
require_once 'auth.php';   // sets $user_id, $account_type, $email

// ============================================================
//  CONFIG
// ============================================================
define('UPLOAD_DIR',  __DIR__ . '/uploads/bank_slips/');
define('UPLOAD_URL',  'uploads/bank_slips/');
define('MAX_FILE_SIZE', 5 * 1024 * 1024); // 5 MB per file
define('ALLOWED_MIME',  ['application/pdf', 'image/jpeg', 'image/png']);
define('ALLOWED_EXT',   ['pdf', 'jpg', 'jpeg', 'png']);

// ============================================================
//  GET request_id from URL
// ============================================================
$request_id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($request_id <= 0) {
    die('<p style="font-family:sans-serif;padding:2rem;color:red;">Invalid or missing request ID.</p>');
}

// ============================================================
//  FETCH DONATION REQUEST + RECIPIENT
// ============================================================
$stmt = $conn->prepare("
    SELECT
        dr.*,
        u.account_type                          AS acct_type,
        ip.full_name                            AS ind_full_name,
        ip.phone                                AS ind_phone,
        ip.city                                 AS ind_city,
        op.organization_name                    AS org_name,
        op.organization_type                    AS org_type,
        op.registration_number                  AS org_reg,
        op.responsible_person_name              AS org_responsible,
        op.phone                                AS org_phone,
        op.city                                 AS org_city,
        op.verification_status                  AS org_verified
    FROM donation_requests dr
    INNER JOIN users u ON u.id = dr.recipient_id
    LEFT JOIN individual_profiles   ip ON ip.user_id = u.id
    LEFT JOIN organization_profiles op ON op.user_id = u.id
    WHERE dr.id = ?
      AND dr.status IN ('approved','under_review')
    LIMIT 1
");
$stmt->bind_param('i', $request_id);
$stmt->execute();
$req = $stmt->get_result()->fetch_assoc();
$stmt->close();

if (!$req) {
    die('<p style="font-family:sans-serif;padding:2rem;color:red;">Donation request not found or not available.</p>');
}

// ============================================================
//  FETCH SUPPORTING DOCUMENTS
// ============================================================
$docs = [];
$dstmt = $conn->prepare("
    SELECT id, file_name, file_hash, uploaded_at
    FROM request_documents
    WHERE request_id = ?
    ORDER BY uploaded_at ASC
");
$dstmt->bind_param('i', $request_id);
$dstmt->execute();
$dres = $dstmt->get_result();
while ($row = $dres->fetch_assoc()) {
    $docs[] = $row;
}
$dstmt->close();

// ============================================================
//  HANDLE FILE DOWNLOAD (hash-based, prevents LFI)
// ============================================================
if (isset($_GET['download']) && !empty($_GET['download'])) {
    $hash = preg_replace('/[^a-fA-F0-9]/', '', $_GET['download']); // strip everything non-hex
    if (strlen($hash) < 8) { http_response_code(400); exit('Bad request'); }

    // Look up the file by hash for this request only
    $fstmt = $conn->prepare("
        SELECT file_name, file_hash
        FROM request_documents
        WHERE request_id = ? AND file_hash = ?
        LIMIT 1
    ");
    $fstmt->bind_param('is', $request_id, $hash);
    $fstmt->execute();
    $frow = $fstmt->get_result()->fetch_assoc();
    $fstmt->close();

    if (!$frow) { http_response_code(404); exit('File not found'); }

    // File is stored under its hash name in the upload dir
    $file_path = UPLOAD_DIR . $frow['file_hash'];
    if (!file_exists($file_path)) { http_response_code(404); exit('File not found on disk'); }

    $mime = mime_content_type($file_path) ?: 'application/octet-stream';
    // Serve original filename but path is always the hash — safe
    header('Content-Type: ' . $mime);
    header('Content-Disposition: attachment; filename="' . addslashes(basename($frow['file_name'])) . '"');
    header('Content-Length: ' . filesize($file_path));
    header('Cache-Control: no-store');
    readfile($file_path);
    exit;
}

// ============================================================
//  HANDLE DONATION FORM SUBMISSION
// ============================================================
$form_success = false;
$form_error   = '';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'donate') {

    $posted_request_id = (int)($_POST['request_id'] ?? 0);
    $amount            = (float)($_POST['amount'] ?? 0);
    $note              = trim($_POST['note'] ?? '');

    // Basic validation
    if ($posted_request_id !== $request_id) {
        $form_error = 'Invalid request.';
    } elseif ($amount < 1) {
        $form_error = 'Please enter a valid donation amount.';
    } elseif (empty($_FILES['bank_slip']['name'][0])) {
        $form_error = 'Please upload at least one bank slip.';
    } else {

        // Ensure upload directory exists
        if (!is_dir(UPLOAD_DIR)) {
            mkdir(UPLOAD_DIR, 0750, true);
        }

        $uploaded_hashes = [];
        $upload_errors   = [];

        foreach ($_FILES['bank_slip']['tmp_name'] as $i => $tmp_name) {
            $orig_name = $_FILES['bank_slip']['name'][$i];
            $file_size = $_FILES['bank_slip']['size'][$i];
            $file_err  = $_FILES['bank_slip']['error'][$i];

            if ($file_err !== UPLOAD_ERR_OK) {
                $upload_errors[] = "Upload error on file: " . htmlspecialchars($orig_name);
                continue;
            }
            if ($file_size > MAX_FILE_SIZE) {
                $upload_errors[] = htmlspecialchars($orig_name) . " exceeds 5 MB limit.";
                continue;
            }

            $ext = strtolower(pathinfo($orig_name, PATHINFO_EXTENSION));
            if (!in_array($ext, ALLOWED_EXT, true)) {
                $upload_errors[] = htmlspecialchars($orig_name) . " — unsupported file type.";
                continue;
            }

            $detected_mime = mime_content_type($tmp_name);
            if (!in_array($detected_mime, ALLOWED_MIME, true)) {
                $upload_errors[] = htmlspecialchars($orig_name) . " — MIME type not allowed.";
                continue;
            }

            // Hash the file contents (SHA-256) — used as storage name
            $file_hash = hash_file('sha256', $tmp_name);
            $dest_path = UPLOAD_DIR . $file_hash;

            if (!file_exists($dest_path)) {
                if (!move_uploaded_file($tmp_name, $dest_path)) {
                    $upload_errors[] = "Could not save: " . htmlspecialchars($orig_name);
                    continue;
                }
            }

            $uploaded_hashes[] = [
                'original_name' => $orig_name,
                'hash'          => $file_hash,
            ];
        }

        if (!empty($upload_errors)) {
            $form_error = implode('<br>', $upload_errors);
        } elseif (empty($uploaded_hashes)) {
            $form_error = 'No valid files were uploaded.';
        } else {
            // ---- Begin transaction ----
            $conn->begin_transaction();
            try {
                // Insert into donations table
                $ins = $conn->prepare("
                    INSERT INTO donations
                        (request_id, donor_id, amount, note, status, created_at)
                    VALUES
                        (?, ?, ?, ?, 'pending', NOW())
                ");
                $ins->bind_param('iiis', $request_id, $user_id, $amount, $note);
                $ins->execute();
                $donation_id = $conn->insert_id;
                $ins->close();

                // Insert each file into donation_slips table
                $slip_ins = $conn->prepare("
                    INSERT INTO donation_slips
                        (donation_id, file_name, file_hash, uploaded_at)
                    VALUES
                        (?, ?, ?, NOW())
                ");
                foreach ($uploaded_hashes as $f) {
                    $slip_ins->bind_param('iss', $donation_id, $f['original_name'], $f['hash']);
                    $slip_ins->execute();
                }
                $slip_ins->close();

                $conn->commit();
                $form_success = true;

            } catch (Exception $e) {
                $conn->rollback();
                $form_error = 'Database error. Please try again.';
                // In production, log $e->getMessage() to a log file — do NOT echo it
            }
        }
    }
}

// ============================================================
//  HELPERS
// ============================================================
function fmt_lkr(float $n): string {
    return 'LKR ' . number_format($n, 2);
}
function progress_pct(float $received, float $target): float {
    if ($target <= 0) return 0;
    return min(100, round(($received / $target) * 100, 1));
}
function ext_icon(string $name): string {
    $ext = strtolower(pathinfo($name, PATHINFO_EXTENSION));
    if ($ext === 'pdf') return '📄';
    if (in_array($ext, ['jpg','jpeg','png'])) return '🖼️';
    return '📎';
}
function days_left(?string $deadline): string {
    if (!$deadline) return '—';
    $diff = (new DateTime($deadline))->diff(new DateTime())->days;
    $sign = (new DateTime($deadline)) >= (new DateTime()) ? $diff . ' days left' : 'Expired';
    return $sign;
}

$pct         = progress_pct((float)$req['received_amount'], (float)$req['target_amount']);
$is_org      = ($req['acct_type'] === 'organization');
$recipient_name = $is_org ? htmlspecialchars($req['org_name']) : htmlspecialchars($req['ind_full_name']);
$deadline_str   = $req['deadline'] ? date('d M Y', strtotime($req['deadline'])) : 'No deadline';
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8"/>
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Donation Request — <?= htmlspecialchars($req['title']) ?></title>
  <script src="https://cdn.tailwindcss.com"></script>
  <link href="https://fonts.googleapis.com/css2?family=DM+Sans:ital,opsz,wght@0,9..40,300;0,9..40,400;0,9..40,500;0,9..40,600;0,9..40,700;1,9..40,400&family=DM+Mono:wght@400;500&display=swap" rel="stylesheet"/>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          fontFamily: { sans: ['DM Sans','sans-serif'], mono: ['DM Mono','monospace'] },
          keyframes: {
            fillBar: { '0%': {width:'0%'}, '100%': {width:'<?= $pct ?>%'} },
            fadeUp:  { '0%': {opacity:'0',transform:'translateY(16px)'}, '100%': {opacity:'1',transform:'translateY(0)'} },
          },
          animation: {
            fillBar: 'fillBar 1.6s .5s cubic-bezier(.4,0,.2,1) forwards',
            fadeUp:  'fadeUp .5s ease both',
          },
        }
      }
    };
  </script>
  <style>
    body { background: #f0f5fb; }
    .card-1{ animation: fadeUp .5s .05s ease both; }
    .card-2{ animation: fadeUp .5s .18s ease both; }
    .card-3{ animation: fadeUp .5s .30s ease both; }
    .card-4{ animation: fadeUp .5s .42s ease both; }
    .progress-fill{ animation: fillBar 1.6s .5s cubic-bezier(.4,0,.2,1) forwards; width:0%; }
    .progress-fill::after{
      content:''; position:absolute; top:0; left:-60px; width:60px; height:100%;
      background:linear-gradient(90deg,transparent,rgba(255,255,255,.35),transparent);
      animation: shimmer 2.2s 1.8s infinite;
    }
    @keyframes shimmer{ to{ left:110%; } }
    .field-input:focus{ outline:none; border-color:#3b96f5; box-shadow:0 0 0 3px rgba(59,150,245,.15); }
    input[type="file"]::file-selector-button{
      background:#2577ea; color:white; border:none; padding:6px 14px; border-radius:6px;
      cursor:pointer; font-family:'DM Sans',sans-serif; font-size:13px; font-weight:500;
      margin-right:10px; transition:background .2s;
    }
    input[type="file"]::file-selector-button:hover{ background:#1d60d8; }
    .file-item:hover{ background:#f1f5f9; }
    .hero-bg{ background-image:radial-gradient(circle,#c7d9f0 1px,transparent 1px); background-size:22px 22px; }
    .doc-row:hover .dl-btn{ opacity:1; }
    .dl-btn{ opacity:.7; transition:opacity .2s; }
  </style>
</head>
<body class="font-sans text-slate-800 min-h-screen">

<!-- ── HEADER ─────────────────────────────────────────── -->
<header class="hero-bg border-b border-slate-200 bg-white/70 backdrop-blur-sm sticky top-0 z-20">
  <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center gap-4">
    <div class="flex items-center justify-center w-9 h-9 rounded-lg bg-blue-600 shadow-sm flex-shrink-0">
      <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
        <path stroke-linecap="round" stroke-linejoin="round" d="M4.318 6.318a4.5 4.5 0 000 6.364L12 20.364l7.682-7.682a4.5 4.5 0 00-6.364-6.364L12 7.636l-1.318-1.318a4.5 4.5 0 00-6.364 0z"/>
      </svg>
    </div>
    <div>
      <h1 class="text-base sm:text-lg font-semibold text-slate-900 leading-tight">Donation Request Details</h1>
      <p class="text-xs sm:text-sm text-slate-500">Review the request and contribute securely</p>
    </div>
    <nav class="ml-auto hidden sm:flex items-center gap-1 text-xs text-slate-400 font-mono">
      <a href="dashboard.php" class="hover:text-blue-600 transition-colors">Dashboard</a>
      <span>/</span><span>Donations</span><span>/</span>
      <span class="text-blue-600 font-medium">REQ-<?= str_pad($req['id'],6,'0',STR_PAD_LEFT) ?></span>
    </nav>
  </div>
</header>

<!-- ── MAIN ──────────────────────────────────────────── -->
<main class="max-w-6xl mx-auto px-4 sm:px-6 py-8 lg:py-12">

  <?php if ($form_success): ?>
  <!-- SUCCESS BANNER -->
  <div class="card-1 mb-6 flex items-start gap-3 rounded-xl bg-green-50 border border-green-200 px-5 py-4 shadow-sm">
    <svg class="w-5 h-5 text-green-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
    </svg>
    <div>
      <p class="text-sm font-semibold text-green-800">Donation submitted successfully!</p>
      <p class="text-xs text-green-700 mt-0.5">Your bank slip(s) have been uploaded and your donation is pending verification. Thank you for your generosity.</p>
    </div>
  </div>
  <?php elseif (!empty($form_error)): ?>
  <!-- ERROR BANNER -->
  <div class="card-1 mb-6 flex items-start gap-3 rounded-xl bg-red-50 border border-red-200 px-5 py-4 shadow-sm">
    <svg class="w-5 h-5 text-red-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
      <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7 4a1 1 0 11-2 0 1 1 0 012 0zm-1-9a1 1 0 00-1 1v4a1 1 0 102 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
    </svg>
    <div>
      <p class="text-sm font-semibold text-red-800">Submission failed</p>
      <p class="text-xs text-red-700 mt-0.5"><?= $form_error ?></p>
    </div>
  </div>
  <?php else: ?>
  <!-- STATUS BANNER -->
  <div class="card-1 mb-6 flex items-center gap-3 rounded-xl bg-teal-50 border border-teal-100 px-5 py-3.5 shadow-sm">
    <span class="flex h-2.5 w-2.5 relative flex-shrink-0">
      <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-teal-400 opacity-75"></span>
      <span class="relative inline-flex rounded-full h-2.5 w-2.5 bg-teal-500"></span>
    </span>
    <p class="text-sm text-teal-700 font-medium">
      This campaign is <strong>actively accepting donations</strong>.
      <?php if ($req['deadline']): ?>
        Deadline: <?= $deadline_str ?> &middot; <span class="font-normal"><?= days_left($req['deadline']) ?></span>
      <?php endif; ?>
    </p>
    <span class="ml-auto text-xs font-mono text-teal-600 bg-teal-100 px-2.5 py-1 rounded-full border border-teal-200 uppercase"><?= htmlspecialchars($req['status']) ?></span>
  </div>
  <?php endif; ?>

  <!-- ── TWO-COLUMN GRID ──────────────────────────────── -->
  <div class="grid grid-cols-1 lg:grid-cols-5 gap-6 lg:gap-8 items-start">

    <!-- ════ LEFT: Request Details (3 cols) ════════════ -->
    <div class="lg:col-span-3 space-y-5">

      <!-- Request Details Card -->
      <section class="card-2 rounded-2xl bg-white shadow-md border border-slate-100 overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-blue-500 via-blue-400 to-teal-400"></div>
        <div class="p-6 sm:p-8">

          <!-- Title + category -->
          <div class="flex flex-wrap items-start gap-3 mb-4">
            <h2 class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight flex-1">
              <?= htmlspecialchars($req['title']) ?>
            </h2>
            <span class="flex-shrink-0 inline-flex items-center gap-1.5 bg-blue-50 text-blue-700 text-xs font-semibold px-3 py-1.5 rounded-full border border-blue-100">
              <?= htmlspecialchars($req['category']) ?>
            </span>
          </div>

          <!-- Description -->
          <p class="text-slate-600 text-sm leading-relaxed mb-6">
            <?= nl2br(htmlspecialchars($req['description'])) ?>
          </p>

          <!-- Progress block -->
          <div class="mb-6 p-4 bg-slate-50 rounded-xl border border-slate-100">
            <div class="flex justify-between items-end mb-2">
              <div>
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-0.5">Raised</p>
                <p class="text-2xl font-bold text-slate-900"><?= fmt_lkr((float)$req['received_amount']) ?></p>
              </div>
              <div class="text-right">
                <p class="text-xs text-slate-400 font-medium uppercase tracking-wider mb-0.5">Target</p>
                <p class="text-xl font-semibold text-slate-700"><?= fmt_lkr((float)$req['target_amount']) ?></p>
              </div>
            </div>
            <div class="relative w-full bg-slate-200 rounded-full h-3 overflow-hidden">
              <div class="progress-fill h-3 rounded-full relative bg-gradient-to-r from-blue-500 to-teal-400"></div>
            </div>
            <div class="flex justify-between mt-1.5">
              <span class="text-xs font-semibold text-blue-600"><?= $pct ?>% funded</span>
              <span class="text-xs text-slate-400"><?= fmt_lkr(max(0, (float)$req['target_amount'] - (float)$req['received_amount'])) ?> remaining</span>
            </div>
          </div>

          <!-- Meta grid -->
          <div class="grid grid-cols-2 sm:grid-cols-3 gap-3 mb-5">
            <div class="flex flex-col gap-1 p-3.5 bg-slate-50 rounded-xl border border-slate-100">
              <span class="text-xs text-slate-400 uppercase tracking-wide font-medium">Deadline</span>
              <span class="text-sm font-semibold text-slate-800"><?= $deadline_str ?></span>
              <span class="text-xs text-slate-400"><?= days_left($req['deadline']) ?></span>
            </div>
            <div class="flex flex-col gap-1 p-3.5 bg-slate-50 rounded-xl border border-slate-100">
              <span class="text-xs text-slate-400 uppercase tracking-wide font-medium">Request ID</span>
              <span class="text-sm font-mono font-semibold text-blue-700">REQ-<?= str_pad($req['id'],6,'0',STR_PAD_LEFT) ?></span>
            </div>
            <div class="flex flex-col gap-1 p-3.5 bg-slate-50 rounded-xl border border-slate-100 col-span-2 sm:col-span-1">
              <span class="text-xs text-slate-400 uppercase tracking-wide font-medium">Bank</span>
              <span class="text-sm font-semibold text-slate-800"><?= htmlspecialchars($req['bank_name'] ?: '—') ?></span>
              <span class="text-xs font-mono text-slate-500"><?= htmlspecialchars($req['bank_account_number'] ?: '') ?></span>
            </div>
          </div>

          <!-- Recipient block — conditional org vs individual -->
          <div class="flex items-start gap-3 p-4 rounded-xl bg-gradient-to-br from-blue-50 to-teal-50 border border-blue-100">
            <div class="w-11 h-11 rounded-full bg-blue-200 flex items-center justify-center flex-shrink-0 font-bold text-blue-700 text-sm uppercase">
              <?= mb_substr($recipient_name, 0, 2) ?>
            </div>
            <div class="flex-1 min-w-0">
              <p class="text-xs text-slate-400 uppercase tracking-wide font-medium mb-0.5">Recipient</p>
              <p class="text-sm font-semibold text-slate-800"><?= $recipient_name ?></p>

              <?php if ($is_org): ?>
                <!-- Organisation details -->
                <div class="mt-1 flex flex-wrap gap-2">
                  <?php if (!empty($req['org_type'])): ?>
                  <span class="text-xs bg-white border border-slate-200 text-slate-600 px-2 py-0.5 rounded-full">
                    <?= htmlspecialchars($req['org_type']) ?>
                  </span>
                  <?php endif; ?>
                  <?php if (!empty($req['org_reg'])): ?>
                  <span class="text-xs bg-white border border-blue-200 text-blue-700 font-mono px-2 py-0.5 rounded-full">
                    Reg: <?= htmlspecialchars($req['org_reg']) ?>
                  </span>
                  <?php endif; ?>
                  <?php if ($req['org_verified'] === 'verified'): ?>
                  <span class="text-xs flex items-center gap-1 text-teal-700 bg-teal-50 border border-teal-200 px-2 py-0.5 rounded-full">
                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M6.267 3.455a3.066 3.066 0 001.745-.723 3.066 3.066 0 013.976 0 3.066 3.066 0 001.745.723 3.066 3.066 0 012.812 2.812c.051.643.304 1.254.723 1.745a3.066 3.066 0 010 3.976 3.066 3.066 0 00-.723 1.745 3.066 3.066 0 01-2.812 2.812 3.066 3.066 0 00-1.745.723 3.066 3.066 0 01-3.976 0 3.066 3.066 0 00-1.745-.723 3.066 3.066 0 01-2.812-2.812 3.066 3.066 0 00-.723-1.745 3.066 3.066 0 010-3.976 3.066 3.066 0 00.723-1.745 3.066 3.066 0 012.812-2.812zm7.44 5.252a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                    Verified NGO
                  </span>
                  <?php endif; ?>
                </div>
                <?php if (!empty($req['org_responsible'])): ?>
                <p class="text-xs text-slate-500 mt-1">Contact: <?= htmlspecialchars($req['org_responsible']) ?>
                  <?= !empty($req['org_phone']) ? ' · ' . htmlspecialchars($req['org_phone']) : '' ?>
                </p>
                <?php endif; ?>
                <?php if (!empty($req['org_city'])): ?>
                <p class="text-xs text-slate-400 mt-0.5">📍 <?= htmlspecialchars($req['org_city']) ?></p>
                <?php endif; ?>

              <?php else: ?>
                <!-- Individual details — NO registration number -->
                <?php if (!empty($req['ind_phone'])): ?>
                <p class="text-xs text-slate-500 mt-1">📞 <?= htmlspecialchars($req['ind_phone']) ?></p>
                <?php endif; ?>
                <?php if (!empty($req['ind_city'])): ?>
                <p class="text-xs text-slate-400 mt-0.5">📍 <?= htmlspecialchars($req['ind_city']) ?></p>
                <?php endif; ?>
                <span class="inline-block mt-1.5 text-xs bg-amber-50 border border-amber-200 text-amber-700 px-2 py-0.5 rounded-full">Individual</span>
              <?php endif; ?>
            </div>
          </div>

        </div>
      </section>

      <!-- ── Supporting Documents Card ──────────────── -->
      <?php if (!empty($docs)): ?>
      <section class="card-3 rounded-2xl bg-white shadow-md border border-slate-100 overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-violet-400 to-blue-400"></div>
        <div class="p-6">
          <div class="flex items-center justify-between mb-4">
            <div>
              <h3 class="text-base font-bold text-slate-900">Supporting Documents</h3>
              <p class="text-xs text-slate-500 mt-0.5">Proof documents submitted with this request. Review before donating.</p>
            </div>
            <span class="text-xs font-mono bg-violet-50 text-violet-700 border border-violet-100 px-2.5 py-1 rounded-full"><?= count($docs) ?> file<?= count($docs) > 1 ? 's' : '' ?></span>
          </div>

          <ul class="space-y-2">
            <?php foreach ($docs as $doc): ?>
            <?php
              $ext  = strtolower(pathinfo($doc['file_name'], PATHINFO_EXTENSION));
              $icon = ext_icon($doc['file_name']);
              $ext_label = strtoupper($ext);
              $date = date('d M Y', strtotime($doc['uploaded_at']));
              $download_url = '?id=' . $request_id . '&download=' . urlencode($doc['file_hash']);
            ?>
            <li class="doc-row flex items-center gap-3 p-3 rounded-xl bg-slate-50 border border-slate-100 hover:border-violet-200 hover:bg-violet-50 transition-all group">
              <span class="text-xl flex-shrink-0"><?= $icon ?></span>
              <div class="flex-1 min-w-0">
                <p class="text-sm font-semibold text-slate-700 truncate"><?= htmlspecialchars($doc['file_name']) ?></p>
                <p class="text-xs text-slate-400 font-mono mt-0.5">
                  <span class="bg-slate-200 text-slate-600 px-1.5 py-0.5 rounded mr-1"><?= $ext_label ?></span>
                  Uploaded <?= $date ?>
                </p>
              </div>
              <a href="<?= htmlspecialchars($download_url) ?>"
                 class="dl-btn flex-shrink-0 flex items-center gap-1.5 text-xs font-semibold bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-lg transition-colors shadow-sm"
                 title="Download <?= htmlspecialchars($doc['file_name']) ?>">
                <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4"/>
                </svg>
                Download
              </a>
            </li>
            <?php endforeach; ?>
          </ul>

          <div class="mt-4 flex items-start gap-2 p-3 bg-amber-50 border border-amber-100 rounded-xl">
            <svg class="w-4 h-4 text-amber-500 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
              <path fill-rule="evenodd" d="M8.257 3.099c.765-1.36 2.722-1.36 3.486 0l5.58 9.92c.75 1.334-.213 2.98-1.742 2.98H4.42c-1.53 0-2.493-1.646-1.743-2.98l5.58-9.92zM11 13a1 1 0 11-2 0 1 1 0 012 0zm-1-8a1 1 0 00-1 1v3a1 1 0 002 0V6a1 1 0 00-1-1z" clip-rule="evenodd"/>
            </svg>
            <p class="text-xs text-amber-700">Review these documents carefully to verify the authenticity of this request before making your donation.</p>
          </div>
        </div>
      </section>
      <?php else: ?>
      <div class="card-3 rounded-2xl bg-slate-50 border border-dashed border-slate-200 p-6 text-center">
        <p class="text-sm text-slate-400">No supporting documents were submitted with this request.</p>
      </div>
      <?php endif; ?>

    </div><!-- end left col -->

    <!-- ════ RIGHT: Donation Form (2 cols) ═══════════════ -->
    <div class="lg:col-span-2 space-y-5">

      <!-- Donation Form Card -->
      <section class="card-4 rounded-2xl bg-white shadow-md border border-slate-100 overflow-hidden">
        <div class="h-1.5 w-full bg-gradient-to-r from-teal-400 to-blue-500"></div>
        <div class="p-6">
          <h3 class="text-base font-bold text-slate-900 mb-1">Make a Donation</h3>
          <p class="text-xs text-slate-500 mb-5">Your contribution is recorded securely and transparently.</p>

          <form method="POST" enctype="multipart/form-data" id="donationForm" class="space-y-5" action="?id=<?= $request_id ?>">
            <input type="hidden" name="action" value="donate"/>
            <input type="hidden" name="request_id" value="<?= $request_id ?>"/>

            <!-- Amount -->
            <div>
              <label for="amount" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                Donation Amount <span class="text-red-400">*</span>
              </label>
              <div class="relative">
                <span class="absolute left-3 top-1/2 -translate-y-1/2 text-slate-400 font-semibold text-sm pointer-events-none">LKR</span>
                <input type="number" id="amount" name="amount" min="1" step="0.01"
                  placeholder="0.00" required
                  value="<?= isset($_POST['amount']) && !$form_success ? htmlspecialchars($_POST['amount']) : '' ?>"
                  class="field-input w-full pl-12 pr-4 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm bg-slate-50 transition-all"/>
              </div>
              <div class="flex gap-2 mt-2 flex-wrap">
                <?php foreach ([500,1000,5000,10000] as $qa): ?>
                <button type="button" onclick="document.getElementById('amount').value=<?= $qa ?>"
                  class="text-xs bg-slate-100 hover:bg-blue-50 hover:text-blue-700 hover:border-blue-200 border border-slate-200 px-3 py-1.5 rounded-lg transition-all font-medium text-slate-600">
                  <?= number_format($qa) ?>
                </button>
                <?php endforeach; ?>
              </div>
            </div>

            <!-- Bank slip upload -->
            <div>
              <label class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                Upload Bank Slip <span class="text-red-400">*</span>
              </label>
              <div class="relative border-2 border-dashed border-slate-200 rounded-xl bg-slate-50 hover:border-blue-300 hover:bg-blue-50 transition-all p-4 text-center cursor-pointer group"
                   onclick="document.getElementById('bankSlip').click()">
                <svg class="w-8 h-8 text-slate-300 group-hover:text-blue-400 mx-auto mb-2 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                  <path stroke-linecap="round" stroke-linejoin="round" d="M3 16.5v2.25A2.25 2.25 0 005.25 21h13.5A2.25 2.25 0 0021 18.75V16.5m-13.5-9L12 3m0 0l4.5 4.5M12 3v13.5"/>
                </svg>
                <p class="text-sm font-medium text-slate-500 group-hover:text-blue-600 transition-colors">Click to upload files</p>
                <p class="text-xs text-slate-400 mt-0.5">PDF, JPG, PNG · Max 5 MB each</p>
                <input type="file" id="bankSlip" name="bank_slip[]"
                  accept=".pdf,.jpg,.jpeg,.png" multiple class="hidden" onchange="handleFiles(this)"/>
              </div>

              <!-- File preview -->
              <div id="filePreview" class="mt-3 space-y-2 hidden">
                <div class="flex items-center justify-between mb-1">
                  <p class="text-xs font-semibold text-slate-500 uppercase tracking-wide">Selected Files</p>
                  <span id="fileCount" class="text-xs font-mono bg-blue-50 text-blue-700 px-2 py-0.5 rounded-full border border-blue-100">0 files</span>
                </div>
                <ul id="fileList" class="space-y-1.5"></ul>
              </div>

              <p class="mt-2 text-xs text-slate-400 flex items-start gap-1.5">
                <svg class="w-3.5 h-3.5 text-blue-400 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20">
                  <path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/>
                </svg>
                Only cryptographic hashes of uploaded documents are stored on blockchain for integrity verification.
              </p>
            </div>

            <!-- Note -->
            <div>
              <label for="note" class="block text-xs font-semibold text-slate-600 uppercase tracking-wider mb-1.5">
                Note <span class="text-slate-300">(optional)</span>
              </label>
              <textarea id="note" name="note" rows="3"
                placeholder="Leave a message of support or any additional information…"
                class="field-input w-full px-3.5 py-2.5 rounded-lg border border-slate-200 text-slate-800 text-sm bg-slate-50 resize-none transition-all"><?= isset($_POST['note']) && !$form_success ? htmlspecialchars($_POST['note']) : '' ?></textarea>
            </div>

            <!-- Submit -->
            <button type="submit"
              class="w-full flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 active:bg-blue-800 text-white font-semibold text-sm py-3 rounded-xl shadow-sm hover:shadow-md transition-all duration-200 group">
              <svg class="w-4 h-4 group-hover:scale-110 transition-transform" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M4.5 12.75l6 6 9-13.5"/>
              </svg>
              Submit Donation
            </button>
          </form>
        </div>
      </section>

      <!-- Security box -->
      <div class="rounded-2xl bg-gradient-to-br from-slate-800 to-slate-900 border border-slate-700 shadow-md p-5 flex gap-4 items-start">
        <div class="flex-shrink-0 w-9 h-9 rounded-lg bg-teal-500/20 border border-teal-500/30 flex items-center justify-center">
          <svg class="w-5 h-5 text-teal-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 12.75L11.25 15 15 9.75m-3-7.036A11.959 11.959 0 013.598 6 11.955 11.955 0 003 10c0 5.592 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.31-.21-2.571-.598-3.751h-.152c-3.196 0-6.1-1.249-8.25-3.286z"/>
          </svg>
        </div>
        <div>
          <p class="text-xs font-semibold text-teal-400 uppercase tracking-wider mb-1">Blockchain Verified</p>
          <p class="text-xs text-slate-400 leading-relaxed">Your donation proof will be securely stored. Any tampering can be detected using blockchain verification. Each transaction is immutably recorded for full auditability.</p>
        </div>
      </div>

      <!-- Trust badges -->
      <div class="rounded-xl border border-slate-100 bg-white shadow-sm p-4 flex gap-4 items-center justify-around text-center">
        <div><p class="text-lg font-bold text-slate-800">SSL</p><p class="text-xs text-slate-400">Encrypted</p></div>
        <div class="h-8 w-px bg-slate-100"></div>
        <div><p class="text-lg font-bold text-slate-800">KYC</p><p class="text-xs text-slate-400">Verified</p></div>
        <div class="h-8 w-px bg-slate-100"></div>
        <div><p class="text-lg font-bold text-blue-600">Ξ</p><p class="text-xs text-slate-400">On-Chain</p></div>
      </div>

    </div><!-- end right col -->
  </div><!-- end grid -->
</main>

<!-- ── FOOTER ─────────────────────────────────────────── -->
<footer class="border-t border-slate-200 bg-white mt-10 py-5 px-6">
  <div class="max-w-6xl mx-auto flex flex-col sm:flex-row items-center justify-between gap-2 text-xs text-slate-400">
    <span>© <?= date('Y') ?> BlockAid Platform</span>
    <span class="font-mono">All records anchored to public blockchain</span>
  </div>
</footer>

<!-- ── JS ────────────────────────────────────────────── -->
<script>
function formatBytes(bytes) {
  if (bytes === 0) return '0 B';
  const k = 1024, sizes = ['B','KB','MB','GB'];
  const i = Math.floor(Math.log(bytes)/Math.log(k));
  return parseFloat((bytes/Math.pow(k,i)).toFixed(1)) + ' ' + sizes[i];
}
function fileIcon(name) {
  const ext = name.split('.').pop().toLowerCase();
  if (ext === 'pdf') return `<svg class="w-4 h-4 text-red-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 4a2 2 0 012-2h4.586A2 2 0 0112 2.586L15.414 6A2 2 0 0116 7.414V16a2 2 0 01-2 2H6a2 2 0 01-2-2V4zm2 6a1 1 0 011-1h6a1 1 0 110 2H7a1 1 0 01-1-1zm1 3a1 1 0 100 2h6a1 1 0 100-2H7z" clip-rule="evenodd"/></svg>`;
  return `<svg class="w-4 h-4 text-blue-400 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M4 3a2 2 0 00-2 2v10a2 2 0 002 2h12a2 2 0 002-2V5a2 2 0 00-2-2H4zm12 12H4l4-8 3 6 2-4 3 6z" clip-rule="evenodd"/></svg>`;
}
function handleFiles(input) {
  const files   = Array.from(input.files);
  const preview = document.getElementById('filePreview');
  const list    = document.getElementById('fileList');
  const counter = document.getElementById('fileCount');
  list.innerHTML = '';
  if (!files.length) { preview.classList.add('hidden'); return; }
  counter.textContent = `${files.length} file${files.length > 1 ? 's' : ''}`;
  preview.classList.remove('hidden');
  files.forEach((file, i) => {
    const li = document.createElement('li');
    li.className = 'file-item flex items-center gap-3 p-2.5 rounded-lg bg-slate-50 border border-slate-100 cursor-default transition-colors';
    li.innerHTML = `
      ${fileIcon(file.name)}
      <span class="flex-1 min-w-0">
        <span class="block text-xs font-semibold text-slate-700 truncate">${file.name}</span>
        <span class="block text-xs text-slate-400">${formatBytes(file.size)}</span>
      </span>
      <span class="flex-shrink-0 text-xs font-mono bg-green-50 text-green-600 border border-green-100 px-2 py-0.5 rounded-full">Ready</span>`;
    li.style.opacity = '0'; li.style.transform = 'translateY(6px)';
    list.appendChild(li);
    requestAnimationFrame(() => {
      setTimeout(() => {
        li.style.transition = 'opacity .25s ease, transform .25s ease';
        li.style.opacity = '1'; li.style.transform = 'translateY(0)';
      }, i * 60);
    });
  });
}
</script>
</body>
</html>