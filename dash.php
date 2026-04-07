<?php
// Default section
$section = 'overview';

// Check if URL has ?sec=
if (isset($_GET['section'])) {
    $sec_param = $_GET['section'];

    // Mapping URL param => navigate() ID
    $section_map = [
        'overview'            => 'overview',
        'my_requests'         => 'my-requests',
        'open_requests'       => 'open-requests',
        'create_request'      => 'create-request',
        'donations_received'  => 'donations-received',
        'donor_slips'         => 'donor-slips',
        'proof_usage'         => 'proof-usage',
        'notifications'       => 'notifications',
        'settings'            => 'settings',
        'security'            => 'security',
        'help'                => 'help'
    ];

    if (array_key_exists($sec_param, $section_map)) {
        $section = $section_map[$sec_param];
    }
}
?>

<script>
// Call navigate() with the mapped section ID
document.addEventListener('DOMContentLoaded', () => {
    navigate('<?= $section ?>');
});
</script>



<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>BlockAid – Dashboard</title>

<link rel="stylesheet" href="assets/css/dashboard.css">

</head>

<body>

<div id="overlay" onclick="closeSidebar()"></div>

<!-- TOPBAR -->
<?php include "components/topbar.php"; ?>

<!-- SIDEBAR -->
<?php include "components/sidebar.php"; ?>

<!-- MAIN -->
<main id="main">

<?php include "sections/overview.php"; ?>
<?php include "sections/my_requests.php"; ?>
<?php include "sections/open_requests.php"; ?>
<?php include "sections/create_request.php"; ?>
<?php include "sections/donations_received.php"; ?>
<?php include "sections/donor_slips.php"; ?>
<?php include "sections/proof_usage.php"; ?>
<?php include "sections/notifications.php"; ?>
<?php include "sections/settings.php"; ?>
<?php include "sections/security.php"; ?>
<?php include "sections/help.php"; ?>

<?php include "db.php"; ?>

</main>

<script src="assets/js/dashboard.js"></script>

</body>
</html>