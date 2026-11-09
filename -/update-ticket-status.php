<?php
include "conn.php";

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $ticket_id = $_POST['ticket_id'];
    $status = $_POST['status'];

    $sql = "UPDATE tickets SET status = '$status', last_updated = NOW() WHERE ticket_id = '$ticket_id'";
    
    if (mysqli_query($conn, $sql)) {
        echo json_encode(['status' => 'success', 'message' => 'Status updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update status']);
    }
    exit;
}
?>
