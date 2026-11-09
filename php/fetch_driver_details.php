<?php
include 'conn.php'; // Database connection file

// Check if the driver_id is provided in the request
if (isset($_POST['driver_id'])) {
    $driver_id = intval($_POST['driver_id']);

    // Query to fetch driver's first name, last name, and contact
    $query = "SELECT CONCAT(firstname, ' ', lastname) AS fullname, contact, plate, profile_photo, address_proof FROM tbl_users WHERE id = '$driver_id'";
    $result = mysqli_query($conn, $query);

    // Check if the query was successful and if a result is found
    if ($result && mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);

        // Fetch driver rating & review count
        $avgRating = 5.0;
        $ratingCount = 0;
        $rQ = mysqli_query($conn, "SELECT AVG(rating) as avg_r, COUNT(*) as cnt FROM tbl_ratings WHERE driver_id = '$driver_id'");
        if ($rQ && $rRow = mysqli_fetch_assoc($rQ)) {
            if (intval($rRow['cnt']) > 0) {
                $avgRating = round(floatval($rRow['avg_r']), 1);
                $ratingCount = intval($rRow['cnt']);
            }
        }
        
        // Return data as JSON
        echo json_encode([
            'success' => true,
            'fullname' => $row['fullname'],
            'contact' => $row['contact'],
            'plate' => $row['plate'],
            'gcash' => $row['address_proof'],
            'profile' => $row['profile_photo'],
            'rating' => $avgRating,
            'rating_count' => $ratingCount
        ]);
    } else {
        // Return error if no driver found
        echo json_encode([
            'success' => false
        ]);
    }
} else {
    // If no driver_id is provided, return an error
    echo json_encode([
        'success' => false
    ]);
}

mysqli_close($conn); // Close the database connection
?>
