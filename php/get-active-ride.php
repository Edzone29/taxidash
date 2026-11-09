<?php
session_start();
include 'conn.php';

header('Content-Type: application/json');

if (!isset($_SESSION['user_id'])) {
    echo json_encode(["has_active" => false, "message" => "Unauthorized"]);
    exit;
}

$userId = intval($_SESSION['user_id']);
$userType = $_SESSION['user_type'] ?? 'user';

if ($userType === 'driver') {
    // Check driver active ride (status 3 = accepted, 4 = payment sent, 5 = payment confirmed, 6 = picked up)
    $q = mysqli_query($conn, "SELECT b.*, u.firstname AS pass_fn, u.lastname AS pass_ln, u.contact AS pass_contact 
                             FROM temp_ride_bookings b 
                             LEFT JOIN tbl_users u ON b.user_id = u.id 
                             WHERE b.driver_id = $userId AND b.status BETWEEN 3 AND 6 
                             ORDER BY b.id DESC LIMIT 1");
    if ($q && $row = mysqli_fetch_assoc($q)) {
        $st = intval($row['status']);
        $bId = intval($row['id']);
        $resumeUrl = 'driver-dashboard.php';
        $label = 'Active Trip';

        if ($st === 3) {
            $resumeUrl = "driver-2acceptpayment.php?id=$bId";
            $label = 'Awaiting Passenger Payment Proof';
        } elseif ($st === 4) {
            $resumeUrl = "driver-3checkpayment.php";
            $label = 'Passenger Paid - Needs Verification';
        } elseif ($st === 5) {
            $resumeUrl = "driver-4pickup.php?id=$bId";
            $label = 'Heading to Pickup Location';
        } elseif ($st === 6) {
            $resumeUrl = "driver-5dropoff.php?id=$bId";
            $label = 'Passenger On Board - Heading to Destination';
        }

        echo json_encode([
            "has_active" => true,
            "booking_id" => $bId,
            "status" => $st,
            "status_label" => $label,
            "pickup" => $row['pickup_location'],
            "dropoff" => $row['dropoff_location'],
            "price" => floatval($row['price']),
            "resume_url" => $resumeUrl,
            "passenger_name" => trim(($row['pass_fn'] ?? '') . ' ' . ($row['pass_ln'] ?? '')),
            "passenger_contact" => $row['pass_contact'] ?? ''
        ]);
        exit;
    }
} else {
    // Passenger active ride (status 1 = draft, 2 = searching, 3 = driver found, 4 = verifying payment, 5 = pickup, 6 = on the way)
    $q = mysqli_query($conn, "SELECT b.*, u.firstname AS drv_fn, u.lastname AS drv_ln, u.plate AS drv_plate, u.contact AS drv_contact 
                             FROM temp_ride_bookings b 
                             LEFT JOIN tbl_users u ON b.driver_id = u.id 
                             WHERE b.user_id = $userId AND b.status BETWEEN 1 AND 6 
                             ORDER BY b.id DESC LIMIT 1");
    if ($q && $row = mysqli_fetch_assoc($q)) {
        $st = intval($row['status']);
        $bId = intval($row['id']);
        $resumeUrl = 'client-dashboard.php';
        $label = 'Active Booking';

        if ($st === 1) {
            $resumeUrl = 'client-2proceed-booking.php';
            $label = 'Unconfirmed Ride - Ready to Proceed';
        } elseif ($st === 2) {
            $resumeUrl = 'client-3search-driver.php';
            $label = 'Searching for Nearest Driver';
        } elseif ($st === 3) {
            $resumeUrl = 'client-4payment.php';
            $label = 'Driver Found - Upload Payment';
        } elseif ($st === 4) {
            $resumeUrl = 'client-5confirmpayment.php';
            $label = 'Payment Uploaded - Verifying with Driver';
        } elseif ($st === 5) {
            $resumeUrl = 'client-6pickup.php';
            $label = 'Driver Confirmed - Waiting for Pickup';
        } elseif ($st === 6) {
            $resumeUrl = 'client-7dropoff.php';
            $label = 'On the Way to Destination';
        }

        echo json_encode([
            "has_active" => true,
            "booking_id" => $bId,
            "status" => $st,
            "status_label" => $label,
            "pickup" => $row['pickup_location'],
            "dropoff" => $row['dropoff_location'],
            "price" => floatval($row['price']),
            "resume_url" => $resumeUrl,
            "driver_name" => trim(($row['drv_fn'] ?? '') . ' ' . ($row['drv_ln'] ?? '')),
            "driver_plate" => $row['drv_plate'] ?? 'Assigned Driver',
            "driver_contact" => $row['drv_contact'] ?? ''
        ]);
        exit;
    }
}

echo json_encode(["has_active" => false]);
?>
