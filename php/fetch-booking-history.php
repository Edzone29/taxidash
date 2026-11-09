<?php
include 'conn.php';

date_default_timezone_set('Asia/Manila');

$driver_id = intval($_GET['id'] ?? 0);
$filter = $_POST['filter'] ?? 'all';

// Apply filter conditions
if ($filter === 'daily') {
    $dateCondition = "DATE(CONVERT_TZ(trb.created_at, '+00:00', '+08:00')) = CURDATE()";
} elseif ($filter === 'weekly') {
    $dateCondition = "YEARWEEK(CONVERT_TZ(trb.created_at, '+00:00', '+08:00'), 1) = YEARWEEK(CURDATE(), 1)";
} elseif ($filter === 'monthly') {
    $dateCondition = "MONTH(CONVERT_TZ(trb.created_at, '+00:00', '+08:00')) = MONTH(CURDATE()) 
                      AND YEAR(CONVERT_TZ(trb.created_at, '+00:00', '+08:00')) = YEAR(CURDATE())";
} else {
    $dateCondition = "1";
}

$query = "
    SELECT 
        trb.id, 
        trb.user_id, 
        trb.driver_id, 
        CONCAT(uu.firstname, ' ', uu.lastname) AS passenger, 
        uu.contact AS passenger_contact,
        trb.pickup_location, 
        trb.dropoff_location, 
        trb.payVia, 
        trb.price, 
        trb.status, 
        CONVERT_TZ(trb.created_at, '+00:00', '+08:00') AS created_at,
        r.rating,
        r.feedback
    FROM temp_ride_bookings trb
    JOIN tbl_users uu ON trb.user_id = uu.id
    LEFT JOIN tbl_ratings r ON r.booking_id = trb.id AND r.driver_id = trb.driver_id
    WHERE trb.driver_id = $driver_id AND trb.status = 7 AND $dateCondition
    ORDER BY trb.id DESC
";

$result = mysqli_query($conn, $query);

if ($result && mysqli_num_rows($result) > 0) {
    while ($row = mysqli_fetch_assoc($result)) {
        $created_at = date('M d, Y &bull; h:i A', strtotime($row['created_at']));
        $txCode = 'TXD-' . date('y', strtotime($row['created_at'])) . str_pad($row['id'], 5, '0', STR_PAD_LEFT);
        $passenger = htmlspecialchars($row['passenger']);
        $rating = intval($row['rating'] ?? 0);
        $price = number_format(floatval($row['price']), 2);

        echo "
        <div class='col-lg-6 mb-4 driver-trip-item' data-text='" . strtolower(htmlspecialchars($passenger . ' ' . $row['pickup_location'] . ' ' . $row['dropoff_location'])) . "'>
            <div class='card trip-card h-100' style='border-radius:16px; border:none; box-shadow:0 4px 16px rgba(0,0,0,0.06);'>
                <div class='card-header d-flex justify-content-between align-items-center' style='background:linear-gradient(135deg, #f8fafc, #edf2f7); border-bottom:1px solid #e2e8f0; padding:12px 18px;'>
                    <div>
                        <span class='badge bg-warning bg-opacity-10 text-dark fw-bold px-2 py-1' style='font-size:0.75rem;'>{$txCode}</span>
                        <span class='text-muted ms-2 small'>{$created_at}</span>
                    </div>
                    <span class='badge bg-success rounded-pill px-3 py-1'><i class='fas fa-check-circle me-1'></i> Completed</span>
                </div>
                <div class='card-body p-3'>
                    <div class='route-timeline mb-3'>
                        <div class='route-dot pickup'></div>
                        <div class='mb-2'>
                            <small class='text-muted text-uppercase' style='font-size:0.7rem;'>Pickup</small>
                            <div class='fw-semibold text-dark text-truncate'>" . htmlspecialchars($row['pickup_location']) . "</div>
                        </div>
                        <div class='route-dot dropoff'></div>
                        <div>
                            <small class='text-muted text-uppercase' style='font-size:0.7rem;'>Drop-off</small>
                            <div class='fw-semibold text-dark text-truncate'>" . htmlspecialchars($row['dropoff_location']) . "</div>
                        </div>
                    </div>

                    <hr class='my-2 text-muted opacity-25'>

                    <div class='d-flex align-items-center justify-content-between pt-1'>
                        <div class='d-flex align-items-center gap-2'>
                            <div class='rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center' style='width:38px; height:38px;'>
                                <i class='fas fa-user'></i>
                            </div>
                            <div>
                                <div class='fw-bold text-dark small mb-0'>{$passenger}</div>
                                <small class='text-muted' style='font-size:0.75rem;'><i class='fas fa-phone me-1'></i>" . htmlspecialchars($row['passenger_contact'] ?? 'No contact') . "</small>
                            </div>
                        </div>
                        <div class='text-end'>
                            <div class='fw-bold text-success fs-5 mb-0'>&#8369;{$price}</div>
                            <span class='badge bg-light text-muted border' style='font-size:0.7rem;'><i class='fas fa-wallet me-1'></i>" . strtoupper($row['payVia'] ?: 'GCash') . "</span>
                        </div>
                    </div>";

        if ($rating > 0) {
            echo "
                    <div class='mt-2 pt-2 border-top d-flex align-items-center justify-content-between'>
                        <small class='text-muted'>Passenger Rating:</small>
                        <div>";
            for ($i = 1; $i <= 5; $i++) {
                $starColor = $i <= $rating ? 'text-warning' : 'text-muted opacity-25';
                echo "<i class='fas fa-star {$starColor}' style='font-size:0.75rem;'></i>";
            }
            echo "      </div>
                    </div>";
        }

        echo "
                </div>
            </div>
        </div>";
    }
} else {
    echo "
        <div class='col-12 text-center py-5'>
            <div class='rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3' style='width:80px; height:80px;'>
                <i class='fas fa-inbox fa-3x text-muted opacity-50'></i>
            </div>
            <h5 class='fw-bold text-dark mb-1'>No Trips Found for this Filter</h5>
            <p class='text-muted small'>Completed passenger rides will appear here.</p>
        </div>";
}
?>
