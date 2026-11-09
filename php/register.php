<?php
// Database connection
include 'conn.php'; // Ensure this file connects to your database

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Retrieve input data
    $firstname = $_POST['fullname_first'];
    $lastname = $_POST['fullname_last'];
    $email = $_POST['email'];
    $password = $_POST['password']; // You may want to hash this for security
    $contact = $_POST['phone'];
    $user_type = 'user'; // Default user type

    // Check if the email already exists
    $email_check_query = "SELECT * FROM tbl_users WHERE email = ?";
    $stmt = mysqli_prepare($conn, $email_check_query);
    mysqli_stmt_bind_param($stmt, 's', $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);

    if (mysqli_num_rows($result) > 0) {
        // Email already exists
        echo json_encode(['status' => 'error', 'message' => 'Email already exists.']);
    } else {
    // Insert data into the database
    $query = "INSERT INTO tbl_users (firstname, lastname, email, password, contact, user_type) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($conn, $query);

    if ($stmt) {
        mysqli_stmt_bind_param($stmt, 'ssssss', $firstname, $lastname, $email, $password, $contact, $user_type);
        
        if (mysqli_stmt_execute($stmt)) {
            echo json_encode(['status' => 'success', 'message' => 'Registration successful']);
        } else {
            echo json_encode(['status' => 'error', 'message' => 'Registration failed: ' . mysqli_error($conn)]);
        }

        mysqli_stmt_close($stmt); // Close the statement
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Preparation of statement failed: ' . mysqli_error($conn)]);
    }
}


    // mysqli_stmt_close($stmt);
    // mysqli_close($conn);
}
?>
