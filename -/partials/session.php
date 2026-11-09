<?php
// session.php — ensures session is started and user is authenticated
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// If not logged in at all, redirect to login
if (!isset($_SESSION['user_id']) || !isset($_SESSION['user_type'])) {
    header("Location: /taxidash/login.php");
    exit;
}
?>