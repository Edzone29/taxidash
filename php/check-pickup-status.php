<?php
include 'conn.php';

header('Content-Type: application/json');

$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
$bookingId = isset($_GET['bookingId']) ? intval($_GET['bookingId']) : 0;

if ($userId <= 0 && $bookingId <= 0) {
    echo json_encode(["status" => "error", "message" => "userId or bookingId is required."]);
    exit;
}

if ($bookingId > 0) {
    // Check if THIS specific booking has been picked up (status 6)
    $stmt = $conn->prepare("SELECT * FROM temp_ride_bookings WHERE id = ?");
    $stmt->bind_param("i", $bookingId);
} else {
    // Check user's single latest booking overall
    $stmt = $conn->prepare("SELECT * FROM temp_ride_bookings WHERE user_id = ? ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();
$row = $result->fetch_assoc();
$stmt->close();
$conn->close();

if ($row && intval($row['status']) === 6) {
    echo json_encode(["status" => "success", "data" => [$row]]);
} else {
    echo json_encode(["status" => "waiting", "data" => []]);
}
?>