<!-- ── OPEN REQUESTS ──────────────────────────── -->
<div class="section-panel" id="section-open-requests">
  <div class="page-header">
    <h1>Open Requests</h1>
    <p>Active fundraising campaigns open for donations.</p>
  </div>

  <div class="three-col">
    <?php
    require_once __DIR__ . '/../db.php';
    require_once __DIR__ . '/../auth.php';

    $sql = "SELECT id, title, category, description, target_amount, received_amount, status
            FROM donation_requests
            WHERE status = 'approved'
              AND received_amount < target_amount
            ORDER BY approved_at DESC, created_at DESC";

    $result = $conn->query($sql);

    if ($result && $result->num_rows > 0):
      while ($row = $result->fetch_assoc()):

        $id = (int) $row['id'];
        $title = htmlspecialchars($row['title']);
        $category = htmlspecialchars($row['category']);
        $description = htmlspecialchars($row['description']);

        $target_amount = (float) $row['target_amount'];
        $received_amount = (float) $row['received_amount'];

        $percentage = 0;
        if ($target_amount > 0) {
          $percentage = round(($received_amount / $target_amount) * 100);
          if ($percentage > 100) {
            $percentage = 100;
          }
        }

        $remaining = $target_amount - $received_amount;
        if ($remaining < 0) {
          $remaining = 0;
        }
        ?>
        <div class="req-card">
          <div class="req-card-head">
            <span class="req-category"><?php echo $category; ?></span>
            <span class="badge badge-verified">✓ Verified</span>
          </div>

          <div class="req-card-body">
            <h3 class="req-title"><?php echo $title; ?></h3>
            <p class="req-desc"><?php echo $description; ?></p>

            <div class="prog-wrap">
              <div class="prog-labels">
                <span class="prog-left">LKR <?php echo number_format($received_amount, 2); ?> raised</span>
                <span class="prog-right"><?php echo $percentage; ?>%</span>
              </div>

              <div class="prog-bar">
                <div class="prog-fill" style="width:<?php echo $percentage; ?>%"></div>
              </div>

              <div class="prog-goal">
                Goal: LKR <?php echo number_format($target_amount, 2); ?>
              </div>
            </div>

            <div class="req-card-footer">
              <span class="days-badge ok">
                LKR <?php echo number_format($remaining, 2); ?> needed
              </span>
              <a href="request_details.php?id=<?php echo $id; ?>" class="btn btn-outline btn-sm">View &amp; Donate</a>
            </div>
          </div>
        </div>
        <?php
      endwhile;
    else:
      ?>
      <div class="card card-pad" style="grid-column: 1 / -1;">
        <p style="margin:0;">No active verified donation requests available right now.</p>
      </div>
    <?php endif; ?>
  </div>
</div>