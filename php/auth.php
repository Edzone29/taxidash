<?php
session_start();

require 'conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';

    $stmt = $conn->prepare("SELECT id, firstname, lastname, email, contact, password, user_type, profile_photo, plate FROM tbl_users WHERE TRIM(email) = ? AND status = 1");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $user = $result->fetch_assoc();

        if ($password == $user['password']) {
            // Fully destroy old session before setting new one
            session_unset();
            session_destroy();

            // Start a brand-new session for this login
            session_start();
            session_regenerate_id(true);

            $_SESSION['user_id']   = $user['id'];
            $_SESSION['firstname'] = $user['firstname'];
            $_SESSION['lastname']  = $user['lastname'];
            $_SESSION['user_type'] = $user['user_type'];
            $_SESSION['email']     = $user['email'];
            $_SESSION['contact']   = $user['contact'];
            $_SESSION['pic']       = $user['profile_photo'];
            $_SESSION['plate']     = $user['plate'];

            echo $user['user_type'];
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No account found or account is inactive.";
    }

    $stmt->close();
}
