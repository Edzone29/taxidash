<?php
include 'conn.php';

// Set timezone to Asia/Manila
date_default_timezone_set('Asia/Manila');

$filter = $_POST['filter'] ?? 'all';

$whereClause = "WHERE b.status = 7"; // Default condition for completed bookings

// Apply filter conditions
if ($filter === 'daily') {
    $whereClause .= " AND DATE(CONVERT_TZ(b.created_at, '+00:00', '+08:00')) = CURDATE()";
} elseif ($filter === 'weekly') {
    $whereClause .= " AND YEARWEEK(CONVERT_TZ(b.created_at, '+00:00', '+08:00'), 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter === 'monthly') {
    $whereClause .= " AND MONTH(CONVERT_TZ(b.created_at, '+00:00', '+08:00')) = MONTH(CURDATE()) 
                      AND YEAR(CONVERT_TZ(b.created_at, '+00:00', '+08:00')) = YEAR(CURDATE())";
}

// Fetch successful bookings
$sqlBookings = "
SELECT 
    b.id, 
    CONCAT(u.firstname, ' ', u.lastname) AS passenger_name, 
    CONCAT(d.firstname, ' ', d.lastname) AS driver_name, 
    b.pickup_location, 
    b.dropoff_location, 
    b.payVia, 
    b.price, 
    DATE_FORMAT(CONVERT_TZ(b.created_at, '+00:00', '+08:00'), '%d %b %Y, %h:%i %p') AS booking_date
FROM 
    temp_ride_bookings b
JOIN 
    tbl_users u ON b.user_id = u.id
JOIN 
    tbl_users d ON b.driver_id = d.id
$whereClause
ORDER BY 
    b.created_at DESC";

$resultBookings = mysqli_query($conn, $sqlBookings);

if (mysqli_num_rows($resultBookings) > 0) {
    while ($row = mysqli_fetch_assoc($resultBookings)) {
        echo "
        <tr>
            <td>{$row['id']}</td>
            <td>{$row['passenger_name']}</td>
            <td>{$row['driver_name']}</td>
            <td style='white-space: normal; word-wrap: break-word;'>{$row['pickup_location']}</td>
            <td style='white-space: normal; word-wrap: break-word;'>{$row['dropoff_location']}</td>
            <td>{$row['payVia']}</td>
            <td>₱{$row['price']}</td>
            <td>{$row['booking_date']}</td>
        </tr>";
    }
} else {
    echo "<tr><td colspan='8' class='text-center'>No bookings found.</td></tr>";
}
?>
