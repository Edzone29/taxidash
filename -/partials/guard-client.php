<?php
// guard-client.php — only allows passengers (user_type = 'user')
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'user') {
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'admin') {
            header("Location: /taxidash/-/admin-dashboard.php");
        } else {
            header("Location: /taxidash/-/driver-dashboard.php");
        }
    } else {
        header("Location: /taxidash/login.php");
    }
    exit;
}
?>