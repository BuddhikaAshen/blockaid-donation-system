<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../auth.php';

if ($account_type == "individual") {

  $sql = "SELECT full_name,phone,address,city 
FROM individual_profiles 
WHERE user_id=?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();

  $result = $stmt->get_result();
  $profile = $result->fetch_assoc();

} else {

  $sql = "SELECT organization_name,organization_type,registration_number,
responsible_person_name,phone,address,city
FROM organization_profiles
WHERE user_id=?";

  $stmt = $conn->prepare($sql);
  $stmt->bind_param("i", $user_id);
  $stmt->execute();

  $result = $stmt->get_result();
  $profile = $result->fetch_assoc();

}



// SAVE PROFILE
if (isset($_POST['save_profile'])) {

  $phone = $_POST['phone'] ?? '';
  $address = $_POST['address'] ?? '';
  $city = $_POST['city'] ?? '';

  if ($account_type == "individual") {

    $full_name = $_POST['full_name'] ?? '';

    $sql = "UPDATE individual_profiles 
        SET full_name=?, phone=?, address=?, city=? 
        WHERE user_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssi", $full_name, $phone, $address, $city, $user_id);
    $stmt->execute();

  } else {

    $organization_name = $_POST['organization_name'] ?? '';
    $organization_type = $_POST['organization_type'] ?? '';
    $registration_number = $_POST['registration_number'] ?? '';
    $responsible_person_name = $_POST['responsible_person_name'] ?? '';

    $sql = "UPDATE organization_profiles 
        SET organization_name=?, organization_type=?, registration_number=?, 
        responsible_person_name=?, phone=?, address=?, city=? 
        WHERE user_id=?";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param(
      "sssssssi",
      $organization_name,
      $organization_type,
      $registration_number,
      $responsible_person_name,
      $phone,
      $address,
      $city,
      $user_id
    );

    $stmt->execute();

  }

  echo "<script>
window.location.href='dash.php?section=settings&stat=succ';
</script>";
  exit();
}


// UPDATE PASSWORD
if (isset($_POST['update_password'])) {

  $current_password = $_POST['current_password'];
  $new_password = $_POST['new_password'];
  $confirm_password = $_POST['confirm_password'];

  if ($new_password !== $confirm_password) {
    echo "<script>alert('Passwords do not match');</script>";
  } else {

    $sql = "SELECT password_hash FROM users WHERE id=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();

    $result = $stmt->get_result();
    $user = $result->fetch_assoc();

    if (password_verify($current_password, $user['password_hash'])) {

      $new_hash = password_hash($new_password, PASSWORD_DEFAULT);

      $update = $conn->prepare("UPDATE users SET password_hash=? WHERE id=?");
      $update->bind_param("si", $new_hash, $user_id);
      $update->execute();

      echo "<script>alert('Password updated successfully');</script>";

    } else {
      echo "<script>alert('Current password incorrect');</script>";
    }

  }

}


?>

<style>
  .notif {
    display: flex;
    align-items: flex-start;
    gap: 12px;
    padding: 14px 16px;
    border-radius: 12px;
    border: 1px solid;
    max-width: 420px;
    width: 100%;
    animation: notifIn 0.35s cubic-bezier(0.16, 1, 0.3, 1) both;
    position: relative;
    overflow: hidden;
    box-sizing: border-box;
  }

  .notif.hiding {
    animation: notifOut 0.3s ease-in forwards;
  }

  .notif-success {
    background: #eaf3de;
    border-color: #97c459;
  }

  .notif-fail {
    background: #fcebeb;
    border-color: #f09595;
  }

  .notif-icon {
    width: 20px;
    height: 20px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
    margin-top: 1px;
  }

  .notif-success .notif-icon {
    background: #3b6d11;
  }

  .notif-fail .notif-icon {
    background: #a32d2d;
  }

  .notif-icon svg {
    width: 11px;
    height: 11px;
  }

  .notif-body {
    flex: 1;
  }

  .notif-title {
    font-size: 14px;
    font-weight: 600;
    margin: 0 0 2px;
  }

  .notif-success .notif-title {
    color: #27500a;
  }

  .notif-fail .notif-title {
    color: #791f1f;
  }

  .notif-msg {
    font-size: 13px;
    margin: 0;
  }

  .notif-success .notif-msg {
    color: #3b6d11;
  }

  .notif-fail .notif-msg {
    color: #a32d2d;
  }

  .notif-close {
    background: none;
    border: none;
    cursor: pointer;
    padding: 0;
    width: 18px;
    height: 18px;
    opacity: 0.5;
    display: flex;
    align-items: center;
    justify-content: center;
    flex-shrink: 0;
  }

  .notif-close:hover {
    opacity: 1;
  }

  .notif-progress {
    position: absolute;
    bottom: 0;
    left: 0;
    height: 3px;
    border-radius: 0 0 0 12px;
    animation: notifProgress 4s linear forwards;
  }

  .notif-success .notif-progress {
    background: #3b6d11;
  }

  .notif-fail .notif-progress {
    background: #a32d2d;
  }

  #notif-container {
    position: fixed;
    top: 20px;
    right: 20px;
    z-index: 9999;
    display: flex;
    flex-direction: column;
    gap: 10px;
    max-width: 420px;
    width: calc(100% - 40px);
  }

  @keyframes notifIn {
    from {
      opacity: 0;
      transform: translateY(-10px) scale(0.97);
    }

    to {
      opacity: 1;
      transform: translateY(0) scale(1);
    }
  }

  @keyframes notifOut {
    from {
      opacity: 1;
      transform: translateY(0) scale(1);
      max-height: 100px;
    }

    to {
      opacity: 0;
      transform: translateY(-8px) scale(0.97);
      max-height: 0;
      padding: 0;
      margin: 0;
    }
  }

  @keyframes notifProgress {
    from {
      width: 100%;
    }

    to {
      width: 0%;
    }
  }
</style>
<div id="notif-container"></div>

<script>
function showNotif(type, title, msg) {
  const container = document.getElementById('notif-container');
  const isSuccess = type === 'success';
  const div = document.createElement('div');
  div.className = 'notif notif-' + (isSuccess ? 'success' : 'fail');
  div.innerHTML = `
    <div class="notif-icon">
      ${isSuccess
        ? `<svg viewBox="0 0 12 12" fill="none"><polyline points="2,6 5,9 10,3" stroke="white" stroke-width="1.8" stroke-linecap="round" stroke-linejoin="round"/></svg>`
        : `<svg viewBox="0 0 12 12" fill="none"><line x1="3" y1="3" x2="9" y2="9" stroke="white" stroke-width="1.8" stroke-linecap="round"/><line x1="9" y1="3" x2="3" y2="9" stroke="white" stroke-width="1.8" stroke-linecap="round"/></svg>`
      }
    </div>
    <div class="notif-body">
      <p class="notif-title">${title}</p>
      <p class="notif-msg">${msg}</p>
    </div>
    <button class="notif-close" onclick="dismissNotif(this.closest('.notif'))">
      <svg width="10" height="10" viewBox="0 0 10 10" fill="none">
        <line x1="1" y1="1" x2="9" y2="9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
        <line x1="9" y1="1" x2="1" y2="9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"/>
      </svg>
    </button>
    <div class="notif-progress"></div>
  `;
  container.appendChild(div);
  setTimeout(() => dismissNotif(div), 4000);
}
function dismissNotif(el) {
  if (!el) return;
  el.classList.add('hiding');
  setTimeout(() => el.remove(), 300);
}

// Auto-trigger on page load from URL params
window.addEventListener('DOMContentLoaded', () => {
  const params = new URLSearchParams(window.location.search);
  const stat = params.get('stat');
  if (stat === 'succ') showNotif('success', 'Profile updated', 'Your changes have been saved successfully.');
  if (stat === 'fail') showNotif('fail', 'Something went wrong', 'Unable to save changes. Please try again.');
});
</script>


<!-- ── SETTINGS ───────────────────────────────── -->
<div class="section-panel" id="section-settings">
  <div class="page-header">
    <h1>Settings</h1>
    <p>Manage your profile, password, and account preferences.</p>
  </div>

  <div style="max-width:680px;display:flex;flex-direction:column;gap:1.5rem;">

    <!-- PROFILE FORM -->
    <form method="POST">

      <div class="card card-pad">
        <div class="form-section-title">👤 Profile Information</div>

        <div class="form-grid">

          <div class="form-group">
            <label>Full Name</label>
            <input type="text" name="full_name" value="<?= $profile['full_name'] ?? '' ?>">
          </div>

          <div class="form-group">
            <label>Email Address</label>
            <input type="email" value="<?= $email ?>" disabled>
          </div>

          <div class="form-group">
            <label>Phone Number</label>
            <input type="tel" name="phone" value="<?= $profile['phone'] ?? '' ?>">
          </div>

          <div class="form-group">
            <label>State</label>
            <select name="city">
              <option <?= ($profile['city'] ?? '') == 'Selangor' ? 'selected' : '' ?>>Selangor</option>
              <option <?= ($profile['city'] ?? '') == 'Kuala Lumpur' ? 'selected' : '' ?>>Kuala Lumpur</option>
              <option <?= ($profile['city'] ?? '') == 'Kelantan' ? 'selected' : '' ?>>Kelantan</option>
              <option <?= ($profile['city'] ?? '') == 'Johor' ? 'selected' : '' ?>>Johor</option>
            </select>
          </div>

        </div>

        <div class="form-group">
          <label>Address (Optional)</label>
          <textarea name="address" style="min-height:70px;"><?= $profile['address'] ?? '' ?></textarea>
        </div>

        <div class="form-actions" style="margin-top:0;padding-top:1rem;">
          <button class="btn btn-primary" name="save_profile">Save Profile</button>
        </div>

      </div>


      <!-- ORGANIZATION DETAILS -->
      <?php if ($account_type == "organization"): ?>

        <div class="card card-pad">

          <div class="form-section-title">🏢 Organisation Details</div>

          <div class="form-grid">

            <div class="form-group">
              <label>Organisation Name</label>
              <input type="text" name="organization_name" value="<?= $profile['organization_name'] ?? '' ?>"
                placeholder="e.g. Yayasan Sejahtera">
            </div>

            <div class="form-group">
              <label>Organisation Type</label>
              <select name="organization_type">
                <option value="NGO" <?= ($profile['organization_type'] ?? '') == 'NGO' ? 'selected' : '' ?>>NGO</option>

                <option value="Foundation" <?= ($profile['organization_type'] ?? '') == 'Foundation' ? 'selected' : '' ?>>
                  Foundation</option>

                <option value="Religious Body" <?= ($profile['organization_type'] ?? '') == 'Religious Body' ? 'selected' : '' ?>>Religious Body</option>

                <option value="Government Agency" <?= ($profile['organization_type'] ?? '') == 'Government Agency' ? 'selected' : '' ?>>Government Agency</option>
              </select>
            </div>

            <div class="form-group">
              <label>Registration No.</label>
              <input type="text" name="registration_number" value="<?= $profile['registration_number'] ?? '' ?>"
                placeholder="PPM-001-14-01012023">
            </div>

            <div class="form-group">
              <label>Responsible Person</label>
              <input type="text" name="responsible_person_name" value="<?= $profile['responsible_person_name'] ?? '' ?>"
                placeholder="Full name">
            </div>

          </div>

          <div class="form-actions" style="margin-top:0;padding-top:1rem;">
            <button class="btn btn-primary" name="save_profile">Save Organisation</button>
          </div>

        </div>

      <?php endif; ?>

    </form>


    <!-- PASSWORD FORM -->
    <form method="POST">

      <div class="card card-pad">

        <div class="form-section-title">🔑 Change Password</div>

        <div class="form-group">
          <label>Current Password</label>
          <input type="password" name="current_password" placeholder="••••••••">
        </div>

        <div class="form-grid">

          <div class="form-group">
            <label>New Password</label>
            <input type="password" name="new_password" placeholder="••••••••">
          </div>

          <div class="form-group">
            <label>Confirm New Password</label>
            <input type="password" name="confirm_password" placeholder="••••••••">
          </div>

        </div>

        <div class="form-actions" style="margin-top:0;padding-top:1rem;">
          <button class="btn btn-primary" name="update_password">Update Password</button>
        </div>

      </div>

    </form>


    <!-- TWO FACTOR -->
    <div class="card card-pad">
      <div class="toggle-row">
        <div>
          <div style="font-family:var(--ff-head);font-weight:700;font-size:.95rem;color:var(--c-dark);">🔐
            Two-Factor Authentication</div>
          <div style="font-size:.83rem;color:var(--c-muted);margin-top:.25rem;">
            Add an extra layer of security to your account.
          </div>
        </div>

        <button class="toggle-btn" id="twoFAToggle" onclick="toggle2FA()" role="switch" aria-checked="false"
          aria-label="Enable two-factor authentication">
          <span class="toggle-knob"></span>
        </button>
      </div>
    </div>

  </div>
</div>