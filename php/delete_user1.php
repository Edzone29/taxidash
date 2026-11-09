<?php
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];

    $sql = "UPDATE  tbl_users Set status = 1 WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'User Unblock successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to delete User.']);
    }
}
?>
