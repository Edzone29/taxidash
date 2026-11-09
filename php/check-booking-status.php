<?php
// Include database connection
include 'conn.php';

header('Content-Type: application/json');

$userId = isset($_GET['userId']) ? intval($_GET['userId']) : 0;
$bookingId = isset($_GET['bookingId']) ? intval($_GET['bookingId']) : 0;

if ($userId <= 0 && $bookingId <= 0) {
    echo json_encode(["status" => "error", "message" => "userId or bookingId is required."]);
    exit;
}

if ($bookingId > 0) {
    $stmt = $conn->prepare("SELECT * FROM temp_ride_bookings WHERE id = ?");
    $stmt->bind_param("i", $bookingId);
} else {
    // Only fetch the single latest active searching/ongoing booking for this user (status 2 to 6)
    // NEVER fetch old completed (status 7) or cancelled (status 0) or unconfirmed draft (status 1)
    $stmt = $conn->prepare("SELECT * FROM temp_ride_bookings WHERE user_id = ? AND status BETWEEN 2 AND 6 ORDER BY id DESC LIMIT 1");
    $stmt->bind_param("i", $userId);
}

$stmt->execute();
$result = $stmt->get_result();
$booking = $result->fetch_assoc();
$stmt->close();
$conn->close();

if (!$booking) {
    echo json_encode([
        "status" => "searching",
        "driver_found" => false,
        "data" => []
    ]);
    exit;
}

$st = intval($booking['status']);

// Only return driver_found if THIS specific booking has been accepted by a driver (status 3 or 4)
if ($st === 3 || $st === 4) {
    echo json_encode([
        "status" => "success",
        "driver_found" => true,
        "data" => [$booking]
    ]);
} elseif ($st === 5) {
    echo json_encode([
        "status" => "pickup",
        "driver_found" => true,
        "data" => [$booking]
    ]);
} elseif ($st === 6) {
    echo json_encode([
        "status" => "dropoff",
        "driver_found" => true,
        "data" => [$booking]
    ]);
} else {
    // Status is 2 (still searching for driver), or other non-driver-accepted status
    // DO NOT report driver found!
    echo json_encode([
        "status" => "searching",
        "driver_found" => false,
        "data" => []
    ]);
}
?>