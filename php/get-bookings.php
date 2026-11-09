<?php
include 'conn.php';

$sql = "SELECT 
            trb.id, 
            u.firstname, 
            u.lastname, 
            trb.pickup_location, 
            trb.dropoff_location, 
            trb.price 
        FROM temp_ride_bookings trb
        JOIN tbl_users u ON trb.user_id = u.id
        WHERE trb.status = 2
        AND trb.id IN (
            SELECT MAX(id) 
            FROM temp_ride_bookings 
            WHERE status = 2 
            GROUP BY user_id
        )
        ORDER BY trb.id DESC";

$result = mysqli_query($conn, $sql);
$bookings = [];

while ($row = mysqli_fetch_assoc($result)) {
    $bookings[] = $row;
}

header('Content-Type: application/json');
echo json_encode($bookings);
?>
