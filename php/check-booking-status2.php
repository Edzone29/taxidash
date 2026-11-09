<?php
// Include database connection
include 'conn.php';

// Check if userId is provided
if (isset($_GET['userId'])) {
    $userId = intval($_GET['userId']);
    
    // Prepare the SQL query to get the latest booking
    $query = "SELECT * FROM temp_ride_bookings WHERE user_id = ? ORDER BY id DESC LIMIT 1";
    $stmt = $conn->prepare($query);
    $stmt->bind_param("i", $userId);
    
    if ($stmt->execute()) {
        $result = $stmt->get_result();
        $bookings = $result->fetch_all(MYSQLI_ASSOC);
        
        echo json_encode([
            "status" => "success",
            "data" => $bookings
        ]);
    } else {
        echo json_encode([
            "status" => "error",
            "message" => "Error executing query."
        ]);
    }

    $stmt->close();
    $conn->close();
} else {
    echo json_encode([
        "status" => "error",
        "message" => "userId is required."
    ]);
}
?>
