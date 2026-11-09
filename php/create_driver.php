<?php
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['plate'] ?? '';
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO tbl_users (profile_photo,firstname, plate, lastname, email, contact, user_type, created_at, password) 
            VALUES ('d1.jpg', '$firstname', '$middlename', '$lastname', '$email', '$contact', 'driver', '$ct', '$lastname')";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Driver created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create driver.']);
    }
}
?>
