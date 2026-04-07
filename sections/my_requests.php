<!-- ── MY DONATION REQUESTS ───────────────────── -->
<div class="section-panel" id="section-my-requests">
  <div class="page-header-row page-header">
    <div>
      <h1>My Donation Requests</h1>
      <p>Manage and track all your submitted requests.</p>
    </div>
    <button class="btn btn-primary btn-sm" onclick="navigate('create-request')">➕ New Request</button>
  </div>

  <?php
  require_once __DIR__ . '/../db.php';
  require_once __DIR__ . '/../auth.php'; // must provide $user_id

  $filter_status = $_GET['req_status'] ?? '';
  $search = trim($_GET['req_search'] ?? '');

  $sql = "SELECT id, title, category, target_amount, received_amount, status, created_at
          FROM donation_requests
          WHERE recipient_id = ?";

  $params = [$user_id];
  $types = "i";

  if ($filter_status !== '') {
      if ($filter_status === 'approved_group') {
          $sql .= " AND (status = 'approved' OR status = 'apprved')";
      } else {
          $sql .= " AND status = ?";
          $params[] = $filter_status;
          $types .= "s";
      }
  }

  if ($search !== '') {
      $sql .= " AND (title LIKE ? OR CAST(id AS CHAR) LIKE ?)";
      $search_like = "%" . $search . "%";
      $params[] = $search_like;
      $params[] = $search_like;
      $types .= "ss";
  }

  $sql .= " ORDER BY id DESC";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param($types, ...$params);
  $stmt->execute();
  $result = $stmt->get_result();

  function getBadgeClass($status) {
      $status = strtolower(trim($status));

      if ($status === 'pending') return 'badge-review';
      if ($status === 'approved' || $status === 'apprved') return 'badge-verified';
      if ($status === 'rejected') return 'badge-rejected';
      if ($status === 'completed') return 'badge-closed';

      return 'badge-review';
  }

  function getDisplayStatus($status) {
      $status = strtolower(trim($status));

      if ($status === 'pending') return 'Under Review';
      if ($status === 'approved' || $status === 'apprved') return 'Verified';
      if ($status === 'rejected') return 'Rejected';
      if ($status === 'completed') return 'Closed';

      return ucfirst($status);
  }
  ?>

  <div class="card">
    <form method="GET">
      <input type="hidden" name="section" value="my-requests">

      <div class="filters-bar">
        <select name="req_status" class="filter-input" aria-label="Filter by status">
          <option value="">All Statuses</option>
          <option value="pending" <?php echo ($filter_status === 'pending') ? 'selected' : ''; ?>>Under Review</option>
          <option value="approved_group" <?php echo ($filter_status === 'approved_group') ? 'selected' : ''; ?>>Verified</option>
          <option value="rejected" <?php echo ($filter_status === 'rejected') ? 'selected' : ''; ?>>Rejected</option>
          <option value="completed" <?php echo ($filter_status === 'completed') ? 'selected' : ''; ?>>Closed</option>
        </select>

        <input
          type="text"
          name="req_search"
          class="filter-input"
          placeholder="Search by title or ID…"
          aria-label="Search requests"
          style="flex:1;min-width:180px;"
          value="<?php echo htmlspecialchars($search); ?>"
        >

        <button type="submit" class="btn btn-outline btn-sm">Filter</button>
      </div>
    </form>

    <div class="table-wrap">
      <table aria-label="My donation requests">
        <thead>
          <tr>
            <th>Request ID</th>
            <th>Title</th>
            <th>Category</th>
            <th>Target</th>
            <th>Received</th>
            <th>Status</th>
            <th>Submitted</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php if ($result && $result->num_rows > 0): ?>
            <?php while ($row = $result->fetch_assoc()): ?>
              <?php
                $id = (int)$row['id'];
                $request_code = 'REQ-' . str_pad($id, 3, '0', STR_PAD_LEFT);

                $title = htmlspecialchars($row['title']);
                $category = htmlspecialchars($row['category']);
                $target = number_format((float)$row['target_amount'], 2);
                $received = number_format((float)$row['received_amount'], 2);

                $status = $row['status'];
                $badge_class = getBadgeClass($status);
                $status_text = getDisplayStatus($status);

                $submitted_date = '—';
                if (!empty($row['created_at'])) {
                    $submitted_date = date('d M Y', strtotime($row['created_at']));
                }
              ?>
              <tr>
                <td class="td-mono"><?php echo $request_code; ?></td>
                <td style="font-weight:600;color:var(--c-dark);"><?php echo $title; ?></td>
                <td class="td-muted"><?php echo $category; ?></td>
                <td>LKR <?php echo $target; ?></td>
                <td>LKR <?php echo $received; ?></td>
                <td>
                  <span class="badge <?php echo $badge_class; ?>">
                    <?php echo $status_text; ?>
                  </span>
                </td>
                <td class="td-muted"><?php echo $submitted_date; ?></td>
                <td>
                  <a href="request_details.php?id=<?php echo $id; ?>" class="td-action" style="text-decoration:none;">
                    View
                  </a>
                </td>
              </tr>
            <?php endwhile; ?>
          <?php else: ?>
            <tr>
              <td colspan="8" class="td-muted" style="text-align:center;padding:20px;">
                No donation requests found.
              </td>
            </tr>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  </div>
</div>