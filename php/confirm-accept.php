<?php
// Include your database connection
include 'conn.php'; // Assuming you have a file for database connection
session_start();
// Check if the request method is POST
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the booking ID and payment method from the request
    $bookingId = isset($_POST['bookingId']) ? intval($_POST['bookingId']) : 0;
  $userId = $_SESSION['user_id'];
   $latitude = $_POST['latitude'];
    $longitude = $_POST['longitude'];

    // Prepare the SQL statement to update the status
    $query = "UPDATE temp_ride_bookings SET status = 3, drvLoc_lng = $longitude, drvLoc_lat=$latitude, driver_id = $userId WHERE id = $bookingId";
    
 
    // Execute the query
    if (mysqli_query($conn, $query)) {
        // Check if any row was affected
        if (mysqli_affected_rows($conn) > 0) {
            // Success response
            echo json_encode(['status' => 'success', 'message' => 'Accept status updated successfully.']);
        } else {
            // Booking ID not found or status already set to 2
            echo json_encode(['status' => 'error', 'message' => 'No pickup found with that ID or status is already set to 3.']);
        }
    } else {
        // Error executing the query
        echo json_encode(['status' => 'error', 'message' => 'Error updating booking status: ' . mysqli_error($conn)]);
    }

    // Close the database connection
    mysqli_close($conn);
} else {
    // Invalid request method
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method.']);
}
?>
