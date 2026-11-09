<?php
header("Content-Type: application/json");
include 'conn.php'; // Database connection

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Check if required fields are provided
    if (isset($_POST['subject']) && isset($_POST['description']) && isset($_POST['user_id'])) {
        
        // Sanitize input data
        $subject = mysqli_real_escape_string($conn, $_POST['subject']);
        $description = mysqli_real_escape_string($conn, $_POST['description']);
        $user_id = mysqli_real_escape_string($conn, $_POST['user_id']);
        $status = 0; // Default status value
        $submission_date = date('Y-m-d H:i:s'); // Current timestamp

        // Insert query
        $sql = "INSERT INTO tickets (submission_date, subject, description, user_id, status) 
                VALUES ('$submission_date', '$subject', '$description', '$user_id', '$status')";

        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Ticket created successfully!';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to create ticket: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'All fields are required.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
mysqli_close($conn);
?>
