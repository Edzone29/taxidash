<?php
session_start();
include '../php/conn.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $user_id = $_SESSION['user_id'];
    if (isset($_FILES['qrPic']) && $_FILES['qrPic']['error'] === UPLOAD_ERR_OK) {
        $upload_dir = 'uploads/';
        $file_name = basename($_FILES['qrPic']['name']);
        $target_file = $upload_dir . $file_name;

        if (move_uploaded_file($_FILES['qrPic']['tmp_name'], $target_file)) {
            $sql = "UPDATE tbl_users SET address_proof = '$file_name', updated_at = NOW() WHERE id = '$user_id'";
            if (mysqli_query($conn, $sql)) {
                echo json_encode(['success' => true, 'message' => 'Profile QR successfully.']);
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
