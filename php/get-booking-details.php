<?php
session_start();
include 'conn.php'; // Include your database connection file

// Check if user is logged in
if (!isset($_GET['id'])) {
    // Return JSON response for unauthorized access
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit;
}

// Retrieve user ID from session
$userId = $_GET['id'];

// Prepare SQL statement to get the latest booking with status = 1
$sql = "SELECT * FROM temp_ride_bookings WHERE id = ? AND status = 2 ORDER BY id DESC LIMIT 1";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $userId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $booking]);
} else {
    echo json_encode(["status" => "error", "message" => "No active bookings found."]);
}

// Close statement and connection
$stmt->close();
$conn->close();
?>
