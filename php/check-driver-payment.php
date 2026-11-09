<?php
// Include database connection
include 'conn.php';

// Check if userId is provided
if (isset($_GET['userId'])) {
    $userId = $_GET['userId'];
    
    // Prepare the SQL query
    $query = "SELECT * FROM temp_ride_bookings WHERE driver_id = ? AND status = 4"; // status = 3 indicates driver is found
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    
    // Execute the query
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);
        
        // Return success response with bookings
        echo json_encode([
            "status" => "success",
            "data" => $bookings
        ]);
    } else {
        // Return error response
        echo json_encode([
            "status" => "error",
            "message" => "Error executing query."
        ]);
    }

    // Close the statement and connection
    $stmt->close();
    $conn->close();
} else {
    // Return error response if userId is not set
    echo json_encode([
        "status" => "error",
        "message" => "userId is required."
    ]);
}
?>
