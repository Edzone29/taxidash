<?php
include 'conn.php'; // Database connection

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $firstname = $_POST['firstname'];
    $middlename = $_POST['middlename'] ?? '';
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $contact = $_POST['contact'];

    $sql = "INSERT INTO tbl_users (firstname, middlename, lastname, email, contact, user_type, created_at) 
            VALUES ('$firstname', '$middlename', '$lastname', '$email', '$contact', 'driver', NOW())";

    if (mysqli_query($conn, $sql)) {
        echo json_encode(['success' => true, 'message' => 'Passenger created successfully.']);
    } else {
        echo json_encode(['success' => false, 'message' => 'Failed to create Passenger.']);
    }
}
?>
