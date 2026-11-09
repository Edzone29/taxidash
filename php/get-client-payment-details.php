<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include 'conn.php';

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit;
}

$userId = intval($_SESSION['user_id']);
$bookingId = isset($_GET['id']) ? intval($_GET['id']) : 0;

if ($bookingId > 0) {
    // If specific ID is requested, fetch it
    $sql = "SELECT * FROM temp_ride_bookings WHERE id = ? AND user_id = ? LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ii", $bookingId, $userId);
} else {
    // Look for latest ride waiting for payment (status 3 or 4)
    $sql = "SELECT * FROM temp_ride_bookings WHERE user_id = ? AND status IN (3, 4) ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $booking]);
} else {
    // Fallback: check latest booking overall for this user
    $fallbackSql = "SELECT * FROM temp_ride_bookings WHERE user_id = ? ORDER BY id DESC LIMIT 1";
    $stmt2 = $conn->prepare($fallbackSql);
    $stmt2->bind_param("i", $userId);
    $stmt2->execute();
    $fallbackRes = $stmt2->get_result();
    if ($fallbackRes->num_rows > 0) {
        $booking = $fallbackRes->fetch_assoc();
        echo json_encode(["status" => "success", "data" => $booking]);
    } else {
        echo json_encode(["status" => "error", "message" => "No active bookings found."]);
    }
    $stmt2->close();
}

$stmt->close();
$conn->close();
?>
