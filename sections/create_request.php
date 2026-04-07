<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../auth.php';

// CREATE REQUEST
if (isset($_POST['create_request'])) {

  $title = $_POST['title'] ?? '';
  $category = $_POST['category'] ?? '';
  $target = $_POST['target_amount'] ?? 0;
  $deadline = $_POST['deadline'] ?? null;
  $description = $_POST['description'] ?? '';

  $bank_name = $_POST['bank_name'] ?? '';
  $bank_account_number = $_POST['bank_account_number'] ?? '';
  $bank_account_holder = $_POST['bank_account_holder'] ?? '';

  // INSERT REQUEST
  $sql = "INSERT INTO donation_requests
(recipient_id,title,category,description,target_amount,received_amount,bank_name,bank_account_number,bank_account_holder,status,created_at)
VALUES (?,?,?,?,?,0,?,?,?,'pending',NOW())";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param(
    "isssdsss",
    $user_id,
    $title,
    $category,
    $description,
    $target,
    $bank_name,
    $bank_account_number,
    $bank_account_holder
  );

  $stmt->execute();

  // GET REQUEST ID
  $request_id = $stmt->insert_id;


  // 📎 HANDLE MULTIPLE FILE UPLOADS
  if (!empty($_FILES['documents']['name'][0])) {

    foreach ($_FILES['documents']['tmp_name'] as $key => $tmp_name) {

      if ($_FILES['documents']['error'][$key] == 0) {

        $originalName = $_FILES['documents']['name'][$key];
        $ext = strtolower(pathinfo($originalName, PATHINFO_EXTENSION));

        // ✅ ALLOWED TYPES
        $allowed = ['pdf', 'jpg', 'jpeg', 'png'];

        if (in_array($ext, $allowed)) {

          // 🔐 RANDOM FILE NAME
          $newName = bin2hex(random_bytes(16)) . "." . $ext;

          // 📁 PATH
          $uploadPath = "uploads/" . $newName;

          // MOVE FILE
          move_uploaded_file($tmp_name, $uploadPath);

          // 🔗 HASH (SHA-256)
          $fileHash = hash_file("sha256", $uploadPath);

          // INSERT INTO request_documents
          $sql2 = "INSERT INTO request_documents
(request_id,file_name,file_hash)
VALUES (?,?,?)";

          $stmt2 = $conn->prepare($sql2);
          $stmt2->bind_param("iss", $request_id, $newName, $fileHash);
          $stmt2->execute();

        }

      }

    }

  }

  echo "<script>alert('Request submitted successfully');window.location='dash.php?section=create_request&stat=succ';</script>";
  exit();

}
?>

<!-- ── CREATE REQUEST ─────────────────────────── -->
<div class="section-panel" id="section-create-request">
  <div class="page-header">
    <h1>Create Donation Request</h1>
    <p>Fill in the details to submit a new fundraising request for admin review.</p>
  </div>

  <div style="max-width:700px;">

    <form method="POST" enctype="multipart/form-data">

      <div class="card card-pad">

        <div class="form-group">
          <label>Request Title <span class="req-star">*</span></label>
          <input type="text" name="title" required>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label>Category <span class="req-star">*</span></label>
            <select name="category" required>
              <option value="">Select category</option>
              <option>Medical</option>
              <option>Education</option>
              <option>Disaster Relief</option>
              <option>Community</option>
              <option>Other</option>
            </select>
          </div>

          <div class="form-group">
            <label>Target Amount (LKR) <span class="req-star">*</span></label>
            <input type="number" name="target_amount" required>
          </div>
        </div>

        <div class="form-group">
          <label>Deadline <span class="req-star">*</span></label>
          <input type="date" name="deadline" required>
        </div>

        <div class="form-section-title">🏦 Bank Details</div>

        <div class="form-group">
          <label>Account Holder Name <span class="req-star">*</span></label>
          <input type="text" name="bank_account_holder" required>
        </div>

        <div class="form-grid">
          <div class="form-group">
            <label>Bank Name <span class="req-star">*</span></label>
            <select name="bank_name" required>
              <option>Bank of Ceylon</option>
              <option>People's Bank</option>
              <option>Commercial Bank of Ceylon PLC</option>
              <option>Hatton National Bank PLC</option>
              <option>Sampath Bank PLC</option>
              <option>Seylan Bank PLC</option>
              <option>National Development Bank PLC</option>
              <option>DFCC Bank PLC</option>
              <option>Nations Trust Bank PLC</option>
              <option>Pan Asia Banking Corporation PLC</option>
              <option>Union Bank of Colombo PLC</option>
              <option>Amana Bank PLC</option>
              <option>Cargills Bank PLC</option>
              <option>Citibank N.A.</option>
              <option>Deutsche Bank AG</option>
              <option>Habib Bank Ltd.</option>
              <option>Indian Bank</option>
              <option>Indian Overseas Bank</option>
              <option>MCB Bank Ltd.</option>
              <option>Standard Chartered Bank</option>
              <option>State Bank of India</option>
              <option>Bank of China Ltd.</option>
              <option>The Hongkong & Shanghai Banking Corporation Ltd.</option>
              <option>Public Bank Berhad</option>
              <option>Housing Development Finance Corporation Bank of Sri Lanka (HDFC)</option>
              <option>National Savings Bank</option>
              <option>Pradeshiya Sanwardhana Bank</option>
              <option>Sanasa Development Bank PLC</option>
              <option>State Mortgage and Investment Bank</option>
              <option>Sri Lanka Savings Bank Ltd.</option>
            </select>
          </div>

          <div class="form-group">
            <label>Account Number <span class="req-star">*</span></label>
            <input type="text" name="bank_account_number" required>
          </div>
        </div>

        <div class="form-hint" style="margin-bottom:1rem;">
          🔒 Account details are encrypted and shown as masked in public view.
        </div>

        <div class="form-group">
          <label>Description <span class="req-star">*</span></label>
          <textarea name="description" required></textarea>
        </div>

        <div class="form-section-title">📎 Supporting Documents</div>

        <!-- ✅ MULTIPLE FILE INPUT -->
        <div class="form-group">
          <input type="file" name="documents[]" multiple accept=".pdf,.jpg,.jpeg,.png">
        </div>

        <div class="info-box" style="margin-top:.75rem;">
          <span class="info-ico">ℹ️</span>
          Documents stored off-chain; only cryptographic hashes (SHA-256) are recorded on-chain.
        </div>

        <div class="form-actions">
          <button class="btn btn-primary" name="create_request">Submit Request</button>
        </div>

      </div>

    </form>

  </div>
</div>