<?php
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'] ?? '';
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $sql = "UPDATE tbl_users 
            SET firstname = '$firstname', middlename = '$middlename', lastname = '$lastname', 
                email = '$email', contact = '$contact'
            WHERE id = $id";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'User updated successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to update User.']);
    }
}
?>
