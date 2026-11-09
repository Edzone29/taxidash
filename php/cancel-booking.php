<?php
// Include your database connection file
include 'conn.php';

$userId = isset($_POST['userId']) ? intval($_POST['userId']) : 0;
$bookingId = isset($_POST['bookingId']) ? intval($_POST['bookingId']) : 0;

if ($userId > 0 || $bookingId > 0) {
    if ($bookingId > 0) {
        $sql = "UPDATE temp_ride_bookings SET status = 0 WHERE id = ? AND status <= 2";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $bookingId);
    } else {
        $sql = "UPDATE temp_ride_bookings SET status = 0 WHERE user_id = ? AND status <= 2";
        $stmt = mysqli_prepare($conn, $sql);
        mysqli_stmt_bind_param($stmt, "i", $userId);
    }

    if ($stmt && mysqli_stmt_execute($stmt)) {
        if (mysqli_stmt_affected_rows($stmt) > 0) {
            echo json_encode(["status" => "success", "message" => "Booking cancelled successfully."]);
        } else {
            echo json_encode(["status" => "error", "message" => "No active booking found to cancel."]);
        }
        mysqli_stmt_close($stmt);
    } else {
        echo json_encode(["status" => "error", "message" => "Error cancelling booking."]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "User ID or Booking ID is required."]);
}

mysqli_close($conn);
?>