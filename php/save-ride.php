<?php
session_start();
include 'conn.php'; // Include your database connection file

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    // Return JSON response for unauthorized access
    echo json_encode(["status" => "error", "message" => "Unauthorized access. Please log in."]);
    exit;
}

// Retrieve user ID from session
$userId = intval($_SESSION['user_id']);

// Cancel any old incomplete bookings for this user so they don't block new rides
mysqli_query($conn, "UPDATE temp_ride_bookings SET status = 0 WHERE user_id = $userId AND status < 7 AND status > 0");

// Get ride booking details from POST request
$pickupLocation = mysqli_real_escape_string($conn, $_POST['pickupLocation'] ?? '');
$pickupLat = mysqli_real_escape_string($conn, $_POST['pickupLat'] ?? '0');
$pickupLng = mysqli_real_escape_string($conn, $_POST['pickupLng'] ?? '0');
$dropoffLocation = mysqli_real_escape_string($conn, $_POST['dropoffLocation'] ?? '');
$dropoffLat = mysqli_real_escape_string($conn, $_POST['dropoffLat'] ?? '0');
$dropoffLng = mysqli_real_escape_string($conn, $_POST['dropoffLng'] ?? '0');
$rideType = mysqli_real_escape_string($conn, $_POST['rideType'] ?? 'standard');

// Prepare SQL statement to insert into temp_ride_bookings with a default status of 1
$sql = "INSERT INTO temp_ride_bookings (user_id, pickup_location, pickup_lat, pickup_lng, dropoff_location, dropoff_lat, dropoff_lng, ride_type, status, created_at) 
        VALUES ($userId, '$pickupLocation', '$pickupLat', '$pickupLng', '$dropoffLocation', '$dropoffLat', '$dropoffLng', '$rideType', 1, NOW())";

// Execute the SQL query
if (mysqli_query($conn, $sql)) {
    // Return JSON response for successful insertion
    echo json_encode(["status" => "success", "message" => "Booking saved successfully."]);
} else {
    // Return JSON response for error
    echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($conn)]);
}

// Close the connection
mysqli_close($conn);
?>
