<?php
session_start();
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email']; // Get the email from the form
    $pass = $_POST['pass']; // New password
    $passConfirm = $_POST['passConfirm']; // Confirm password

    // Sanitize email input to prevent SQL injection
    $email = mysqli_real_escape_string($conn, $email);

    // Check if the email exists in the database
    $sql = "SELECT * FROM tbl_users WHERE email = '$email'";
    $result = mysqli_query($conn, $sql);
    
    if (mysqli_num_rows($result) > 0) {
        // Email exists, validate the new password
        if ($pass !== $passConfirm) {
            echo json_encode(['status' => 'error', 'message' => 'Passwords do not match.']);
        } else {
            // Update the password in the database
            $hashed_password = password_hash($pass, PASSWORD_DEFAULT); // Hash the new password for security
            $update_sql = "UPDATE tbl_users SET password = '$passConfirm' WHERE email = '$email'";
            
            if (mysqli_query($conn, $update_sql)) {
                echo json_encode(['status' => 'success', 'message' => 'Password has been updated successfully.']);
            } else {
                echo json_encode(['status' => 'error', 'message' => 'Failed to update the password.']);
            }
        }
    } else {
        // Email does not exist
        echo json_encode(['status' => 'error', 'message' => 'Email does not exist.']);
    }
}
?>
