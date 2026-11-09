<?php
session_start();
header('Content-Type: application/json; charset=utf-8');
include 'conn.php';

$bookingId = isset($_GET['id']) ? intval($_GET['id']) : 0;
$driverId = isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : 0;

if ($bookingId > 0) {
    $sql = "SELECT * FROM temp_ride_bookings WHERE id = ? AND status IN (5, 6) LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $bookingId);
} else if ($driverId > 0) {
    $sql = "SELECT * FROM temp_ride_bookings WHERE driver_id = ? AND status IN (5, 6) ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $driverId);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request. No active session or booking ID."]);
    exit;
}

$stmt->execute();
$result = $stmt->get_result();

if ($result && $result->num_rows > 0) {
    $booking = $result->fetch_assoc();
    echo json_encode(["status" => "success", "data" => $booking]);
} else {
    // Fallback: check by booking ID alone if specified
    if ($bookingId > 0) {
        $stmt2 = $conn->prepare("SELECT * FROM temp_ride_bookings WHERE id = ? LIMIT 1");
        $stmt2->bind_param("i", $bookingId);
        $stmt2->execute();
        $res2 = $stmt2->get_result();
        if ($res2 && $res2->num_rows > 0) {
            $booking = $res2->fetch_assoc();
            echo json_encode(["status" => "success", "data" => $booking]);
            $stmt2->close();
            $stmt->close();
            $conn->close();
            exit;
        }
        $stmt2->close();
    }
    echo json_encode(["status" => "error", "message" => "No active pickup booking found."]);
}

$stmt->close();
$conn->close();
?>
