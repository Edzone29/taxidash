<?php
session_start();
include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Sanitize user input
    $user_id = $_SESSION['user_id'];
    $current_password = $_POST['currentPassword'];
    $new_password = $_POST['newPassword'];

    // Validate new password (example: minimum 8 characters)
    if (strlen($new_password) < 8) {
        echo json_encode(['success' => false, 'message' => 'New password must be at least 8 characters long.']);
        exit;
    }

    // Fetch the user's password from the database
    $sql = "SELECT password FROM tbl_users WHERE id = '$user_id'";
    $result = mysqli_query($conn, $sql);
    $row = mysqli_fetch_assoc($result);

    // Check if the current password matches the one in the database
    if ($current_password === $row['password']) {
        // Update the password in the database
        $update_sql = "UPDATE tbl_users SET password = '$new_password', updated_at = NOW() WHERE id = '$user_id'";
        if (mysqli_query($conn, $update_sql)) {
            echo json_encode(['success' => true, 'message' => 'Password updated successfully.']);
        } else {
            echo json_encode(['success' => false, 'message' => 'Database update failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'Current password is incorrect.']);
    }
}
?>
