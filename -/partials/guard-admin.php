<?php
// guard-admin.php — only allows admins (user_type = 'admin')
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'admin') {
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'driver') {
            header("Location: /taxidash/-/driver-dashboard.php");
        } else {
            header("Location: /taxidash/-/client-dashboard.php");
        }
    } else {
        header("Location: /taxidash/login.php");
    }
    exit;
}
?>