<?php
session_start();
include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    if (isset($_FILES['profilePic']) && $_FILES['profilePic']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['profilePic']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['profilePic']['tmp_name'], $target_file)) {
            $sql = "UPDATE tbl_users SET profile_photo = '$file_name', updated_at = NOW() WHERE id = '$user_id'";
            if (mysqli_query($conn, $sql)) {
                 $_SESSION['pic'] = $file_name;
                echo json_encode(['success' => true, 'message' => 'Profile picture updated successfully.']);
            } else {
                echo json_encode(['success' => false, 'message' => 'Database update failed.']);
            }
        } else {
            echo json_encode(['success' => false, 'message' => 'File upload failed.']);
        }
    } else {
        echo json_encode(['success' => false, 'message' => 'No valid file uploaded.']);
    }
}
?>
