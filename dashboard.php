<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

if (!isset($_SESSION['user_type'])) {
    header("Location: login.php");
    exit;
}

$userType = $_SESSION['user_type'];

if ($userType === 'admin') {
    header("Location: -/admin-dashboard.php");
} elseif ($userType === 'driver') {
    header("Location: -/driver-dashboard.php");
} else {
    header("Location: -/client-dashboard.php");
}
exit;
?>