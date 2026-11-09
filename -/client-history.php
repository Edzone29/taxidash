<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$userId = intval($_SESSION['user_id'] ?? 0);

// Fetch stats
$statQ = mysqli_query($conn, "SELECT COUNT(*) as total_rides, COALESCE(SUM(price), 0) as total_spent FROM temp_ride_bookings WHERE user_id = $userId AND status = 7");
$stat = mysqli_fetch_assoc($statQ);
$totalRides = intval($stat['total_rides'] ?? 0);
$totalSpent = floatval($stat['total_spent'] ?? 0);

// Fetch completed ride history
$query = "
    SELECT 
        trb.id, 
        trb.user_id, 
        trb.driver_id, 
        CONCAT(u.firstname, ' ', u.lastname) AS driver_name, 
        u.plate AS driver_plate,
        u.contact AS driver_contact,
        u.profile_photo AS driver_photo,
        trb.pickup_location, 
        trb.dropoff_location, 
        trb.payVia, 
        trb.price, 
        trb.status, 
        trb.created_at,
        r.rating,
        r.feedback
    FROM temp_ride_bookings trb
    LEFT JOIN tbl_users u ON trb.driver_id = u.id
    LEFT JOIN tbl_ratings r ON r.booking_id = trb.id AND r.user_id = trb.user_id
    WHERE trb.user_id = $userId AND trb.status = 7
    ORDER BY trb.id DESC
";
$result = mysqli_query($conn, $query);
$historyRows = [];
if ($result) {
    while ($r = mysqli_fetch_assoc($result)) {
        $historyRows[] = $r;
    }
}
?>

    <head>
        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Booking History - TaxiDash')); ?>
        <?php include 'partials/head-css.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            .history-stat-card {
                border-radius: 16px;
                border: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            }
            .history-stat-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
            }
            .trip-card {
                border: none;
                border-radius: 16px;
                background: #ffffff;
                box-shadow: 0 4px 16px rgba(0,0,0,0.06);
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                overflow: hidden;
            }
            .trip-card:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 24px rgba(0,0,0,0.12);
            }
            .trip-header {
                background: linear-gradient(135deg, #f8fafc, #edf2f7);
                border-bottom: 1px solid #e2e8f0;
                padding: 12px 18px;
            }
            .route-timeline {
                position: relative;
                padding-left: 24px;
            }
            .route-timeline::before {
                content: '';
                position: absolute;
                left: 7px;
                top: 14px;
                bottom: 14px;
                width: 2px;
                border-left: 2px dashed #cbd5e1;
            }
            .route-dot {
                position: absolute;
                left: 0;
                width: 16px;
                height: 16px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
            }
            .route-dot.pickup { top: 4px; background: #10b981; }
            .route-dot.dropoff { bottom: 4px; background: #ef4444; }
            .route-dot::after {
                content: '';
                width: 6px;
                height: 6px;
                border-radius: 50%;
                background: #ffffff;
            }
            .filter-pill {
                cursor: pointer;
                border-radius: 20px;
                padding: 6px 16px;
                font-weight: 600;
                font-size: 0.85rem;
                transition: all 0.2s;
            }
            .filter-pill.active {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                color: #fff;
            }
        </style>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Ride History')); ?>

                        <!-- Stats Row -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card history-stat-card bg-primary text-white p-3" style="background: linear-gradient(135deg, #1e3c72, #3bafda) !important;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Total Rides Completed</span>
                                            <h2 class="fw-bold mb-0 mt-1"><?=$totalRides?></h2>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-taxi fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card history-stat-card p-3" style="background: linear-gradient(135deg, #059669, #10b981) !important; color:#fff;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Total Amount Spent</span>
                                            <h2 class="fw-bold mb-0 mt-1">&#8369;<?=number_format($totalSpent, 2)?></h2>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-receipt fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card history-stat-card p-3" style="background: linear-gradient(135deg, #f59e0b, #d97706) !important; color:#fff;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Average Spending / Ride</span>
                                            <h2 class="fw-bold mb-0 mt-1">&#8369;<?=$totalRides > 0 ? number_format($totalSpent / $totalRides, 2) : '0.00'?></h2>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-chart-line fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Search & Filter Controls -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" id="historySearchInput" class="form-control bg-light border-0" placeholder="Search by destination, pickup, or driver name...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end">
                                        <span class="text-muted small me-2">Showing <?=count($historyRows)?> completed rides</span>
                                        <a href="client-1book.php" class="btn btn-primary btn-sm rounded-pill px-3">
                                            <i class="fas fa-plus me-1"></i> Book a New Ride
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Rides Grid -->
                        <div class="row" id="ridesContainer">
                            <?php if (!empty($historyRows)): ?>
                                <?php foreach ($historyRows as $row): 
                                    $created_at = date('M d, Y &bull; h:i A', strtotime($row['created_at']));
                                    $txCode = 'TXD-' . date('y', strtotime($row['created_at'])) . str_pad($row['id'], 5, '0', STR_PAD_LEFT);
                                    $driverName = !empty(trim($row['driver_name'] ?? '')) ? htmlspecialchars($row['driver_name']) : 'Assigned Driver';
                                    $plate = !empty($row['driver_plate']) ? htmlspecialchars($row['driver_plate']) : 'Plate N/A';
                                    $rating = intval($row['rating'] ?? 0);
                                ?>
                                <div class="col-lg-6 mb-4 trip-item" data-text="<?=strtolower(htmlspecialchars($row['pickup_location'] . ' ' . $row['dropoff_location'] . ' ' . $driverName))?>">
                                    <div class="card trip-card h-100">
                                        <div class="trip-header d-flex justify-content-between align-items-center">
                                            <div>
                                                <span class="badge bg-primary bg-opacity-10 text-primary fw-bold px-2 py-1" style="font-size:0.75rem;">
                                                    <?=$txCode?>
                                                </span>
                                                <span class="text-muted ms-2 small"><?=$created_at?></span>
                                            </div>
                                            <div>
                                                <span class="badge bg-success rounded-pill px-3 py-1">
                                                    <i class="fas fa-check-circle me-1"></i> Completed
                                                </span>
                                            </div>
                                        </div>

                                        <div class="card-body p-3">
                                            <!-- Route Visualizer -->
                                            <div class="route-timeline mb-3">
                                                <div class="route-dot pickup"></div>
                                                <div class="mb-2">
                                                    <small class="text-muted text-uppercase" style="font-size:0.7rem;">Pickup Location</small>
                                                    <div class="fw-semibold text-dark text-truncate" title="<?=htmlspecialchars($row['pickup_location'])?>">
                                                        <?=htmlspecialchars($row['pickup_location'])?>
                                                    </div>
                                                </div>
                                                <div class="route-dot dropoff"></div>
                                                <div>
                                                    <small class="text-muted text-uppercase" style="font-size:0.7rem;">Drop-off Destination</small>
                                                    <div class="fw-semibold text-dark text-truncate" title="<?=htmlspecialchars($row['dropoff_location'])?>">
                                                        <?=htmlspecialchars($row['dropoff_location'])?>
                                                    </div>
                                                </div>
                                            </div>

                                            <hr class="my-2 text-muted opacity-25">

                                            <!-- Bottom Info -->
                                            <div class="d-flex align-items-center justify-content-between pt-1">
                                                <div class="d-flex align-items-center gap-2">
                                                    <div class="rounded-circle bg-warning bg-opacity-10 text-warning d-flex align-items-center justify-content-center" style="width:38px; height:38px;">
                                                        <i class="fas fa-user-tie"></i>
                                                    </div>
                                                    <div>
                                                        <div class="fw-bold text-dark small mb-0"><?=$driverName?></div>
                                                        <small class="text-muted" style="font-size:0.75rem;"><i class="fas fa-id-card me-1"></i><?=$plate?></small>
                                                    </div>
                                                </div>

                                                <div class="text-end">
                                                    <div class="fw-bold text-success fs-5 mb-0">&#8369;<?=number_format(floatval($row['price']), 2)?></div>
                                                    <span class="badge bg-light text-muted border" style="font-size:0.7rem;">
                                                        <i class="fas fa-credit-card me-1"></i><?=strtoupper($row['payVia'] ?: 'GCash')?>
                                                    </span>
                                                </div>
                                            </div>

                                            <!-- Rating Bar if rated -->
                                            <?php if ($rating > 0): ?>
                                                <div class="mt-2 pt-2 border-top d-flex align-items-center justify-content-between">
                                                    <small class="text-muted">Your Rating:</small>
                                                    <div>
                                                        <?php for ($i = 1; $i <= 5; $i++): ?>
                                                            <i class="fas fa-star <?=$i <= $rating ? 'text-warning' : 'text-muted opacity-25'?>" style="font-size:0.75rem;"></i>
                                                        <?php endfor; ?>
                                                    </div>
                                                </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <div class="col-12 text-center py-5">
                                    <div class="rounded-circle bg-light d-flex align-items-center justify-content-center mx-auto mb-3" style="width:90px; height:90px;">
                                        <i class="fas fa-calendar-times fa-3x text-muted opacity-50"></i>
                                    </div>
                                    <h5 class="fw-bold text-dark mb-1">No Completed Rides Yet</h5>
                                    <p class="text-muted small mb-3">When you complete a ride with TaxiDash, your trips and receipts will be stored here.</p>
                                    <a href="client-1book.php" class="btn btn-primary rounded-pill px-4">
                                        <i class="fas fa-taxi me-1"></i> Book Your First Ride
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>

                    </div>
                </div>
                <?php include 'partials/footer.php'; ?>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/js/app.js"></script>

        <script>
        document.getElementById('historySearchInput').addEventListener('input', function() {
            const query = this.value.toLowerCase().trim();
            const items = document.querySelectorAll('.trip-item');
            items.forEach(function(item) {
                const text = item.getAttribute('data-text') || '';
                item.style.display = text.includes(query) ? '' : 'none';
            });
        });
        </script>
    </body>
</html>