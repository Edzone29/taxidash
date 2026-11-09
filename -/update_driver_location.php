<?php
include '../php/conn.php'; // Include your database connection file


// Check if location data is sent
if (isset($_POST['drvLocLng'], $_POST['drvLocLat'], $_POST['bookId'])) {
    $drvLocLng = $_POST['drvLocLng'];
    $drvLocLat = $_POST['drvLocLat'];
    $bookId = $_POST['bookId'];

    // Update the driver's location in the database
    $query = "UPDATE temp_ride_bookings SET drvLoc_lng = ?, drvLoc_lat = ? WHERE id = ?";
    $stmt = $conn->prepare($query);
    $stmt->bind_param('ddi', $drvLocLng, $drvLocLat, $bookId);

    if ($stmt->execute()) {
        echo json_encode(["status" => "success", "message" => "Location updated successfully."]);
    } else {
        echo json_encode(["status" => "success", "message" => "Error updating location."]);
    }

    $stmt->close();
} else {
    echo json_encode(["status" => "success", "message" => "Location Updated."]);
}
$conn->close();
?>
