<?php
session_start();
include 'conn.php';

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["status" => "error", "message" => "Unauthorized"]);
    exit;
}

$userId = intval($_SESSION['user_id']);
$step = isset($_POST['step']) ? $_POST['step'] : '';
$bId = isset($_POST['bookingId']) ? intval($_POST['bookingId']) : 0;

if ($bId > 0) {
    $q = mysqli_query($conn, "SELECT id, status, pickup_lat, pickup_lng FROM temp_ride_bookings WHERE id = $bId");
    $b = ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : null;
} else {
    $q = mysqli_query($conn, "SELECT id, status, pickup_lat, pickup_lng FROM temp_ride_bookings WHERE user_id = $userId ORDER BY id DESC LIMIT 1");
    $b = ($q && mysqli_num_rows($q) > 0) ? mysqli_fetch_assoc($q) : null;
}

if (!$b) {
    echo json_encode(["status" => "error", "message" => "No booking found"]);
    exit;
}
$bId = intval($b['id']);

// Default driver: first active driver (e.g. Ivan Jade ID 4)
$driverId = 4;
$dQuery = mysqli_query($conn, "SELECT id FROM tbl_users WHERE user_type = 'driver' LIMIT 1");
if ($dQuery && $dRow = mysqli_fetch_assoc($dQuery)) {
    $driverId = intval($dRow['id']);
}

$lat = floatval($b['pickup_lat'] ?? 14.5995) + 0.003;
$lng = floatval($b['pickup_lng'] ?? 120.9842) + 0.003;

if ($step === 'accept_ride') {
    mysqli_query($conn, "UPDATE temp_ride_bookings SET status = 3, driver_id = $driverId, drvLoc_lat = $lat, drvLoc_lng = $lng WHERE id = $bId");
    echo json_encode(["status" => "success", "message" => "Driver accepted ride!"]);
} elseif ($step === 'confirm_payment') {
    mysqli_query($conn, "UPDATE temp_ride_bookings SET status = 5, driver_id = $driverId WHERE id = $bId");
    echo json_encode(["status" => "success", "message" => "Payment confirmed by driver!"]);
} elseif ($step === 'confirm_pickup') {
    mysqli_query($conn, "UPDATE temp_ride_bookings SET status = 6, driver_id = $driverId WHERE id = $bId");
    echo json_encode(["status" => "success", "message" => "Passenger picked up!"]);
} elseif ($step === 'confirm_dropoff') {
    mysqli_query($conn, "UPDATE temp_ride_bookings SET status = 7, driver_id = $driverId WHERE id = $bId");
    echo json_encode(["status" => "success", "message" => "Trip completed!"]);
} else {
    echo json_encode(["status" => "error", "message" => "Invalid step"]);
}
?>