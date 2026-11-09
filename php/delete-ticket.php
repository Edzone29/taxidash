<?php
header("Content-Type: application/json");
include 'conn.php'; // Include your database connection

$response = array();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if (isset($_POST['ticket_id'])) {
        $ticket_id = mysqli_real_escape_string($conn, $_POST['ticket_id']);
        
        // Delete query
        $sql = "DELETE FROM tickets WHERE ticket_id = '$ticket_id'";
        
        if (mysqli_query($conn, $sql)) {
            $response['status'] = 'success';
            $response['message'] = 'Ticket deleted successfully.';
        } else {
            $response['status'] = 'error';
            $response['message'] = 'Failed to delete ticket: ' . mysqli_error($conn);
        }
    } else {
        $response['status'] = 'error';
        $response['message'] = 'Ticket ID is required.';
    }
} else {
    $response['status'] = 'error';
    $response['message'] = 'Invalid request method.';
}

echo json_encode($response);
mysqli_close($conn);
?>
