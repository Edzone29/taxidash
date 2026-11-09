<?php
session_start();
require 'conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(['status' => 'error', 'message' => 'Unauthorized']);
    exit;
}

$userId = intval($_SESSION['user_id']);
$bookingId = isset($_POST['booking_id']) ? intval($_POST['booking_id']) : 0;
$userFullname = $_SESSION['firstname'] . ' ' . $_SESSION['lastname'];
$userEmail = isset($_SESSION['email']) ? $_SESSION['email'] : 'N/A';
$userContact = isset($_SESSION['contact']) ? $_SESSION['contact'] : 'N/A';

$now = date('Y-m-d H:i:s');
$subject = "EMERGENCY SOS ALERT - Trip #$bookingId";
$description = "URGENT: Passenger $userFullname triggered the SOS emergency button on Trip #$bookingId at $now. Immediate assistance required.";
$priority = 'Urgent';
$status = '0'; // 0 = Pending/Open

$stmt = $conn->prepare("INSERT INTO tickets (submission_date, subject, description, last_updated, user_name, user_email, user_contact, priority, user_id, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param("ssssssssis", $now, $subject, $description, $now, $userFullname, $userEmail, $userContact, $priority, $userId, $status);

if ($stmt->execute()) {
    echo json_encode([
        'status' => 'success',
        'message' => 'Emergency SOS alert sent to TaxiDash Dispatch & Admin! If you are in immediate danger, please dial 911 directly.'
    ]);
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Failed to dispatch SOS: ' . $conn->error
    ]);
}

$stmt->close();
$conn->close();
?>