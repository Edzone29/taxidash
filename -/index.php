<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

$userType = $_SESSION['user_type'] ?? '';

if ($userType === 'admin') {
    header("Location: admin-dashboard.php");
} elseif ($userType === 'driver') {
    header("Location: driver-dashboard.php");
} elseif ($userType === 'user') {
    header("Location: client-dashboard.php");
} else {
    header("Location: ../login.php");
}
exit;
?>