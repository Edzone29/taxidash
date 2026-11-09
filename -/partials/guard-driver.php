<?php
// guard-driver.php — only allows drivers (user_type = 'driver')
if (!isset($_SESSION['user_type']) || $_SESSION['user_type'] !== 'driver') {
    if (isset($_SESSION['user_type'])) {
        if ($_SESSION['user_type'] === 'admin') {
            header("Location: /taxidash/-/admin-dashboard.php");
        } else {
            header("Location: /taxidash/-/client-dashboard.php");
        }
    } else {
        header("Location: /taxidash/login.php");
    }
    exit;
}
?>