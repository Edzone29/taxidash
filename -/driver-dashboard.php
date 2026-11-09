<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$driverId = intval($_SESSION['user_id']);
$ratQ = mysqli_query($conn, "SELECT COUNT(*) c, COALESCE(AVG(rating), 5.0) a FROM tbl_ratings WHERE driver_id = $driverId");
$ratData = mysqli_fetch_assoc($ratQ);
$avgRating = round(floatval($ratData['a']), 1);
$totalReviews = intval($ratData['c']);

// Completed trips count
$tripQ = mysqli_query($conn, "SELECT COUNT(*) c FROM temp_ride_bookings WHERE driver_id = $driverId AND status = 7");
$tripCount = intval(mysqli_fetch_assoc($tripQ)['c']);

// Check for active assigned trip for this driver (status 3..6)
$activeTrip = null;
$atQ = mysqli_query($conn, "SELECT b.*, u.firstname AS pass_fn, u.lastname AS pass_ln, u.contact AS pass_contact 
                            FROM temp_ride_bookings b 
                            LEFT JOIN tbl_users u ON b.user_id = u.id 
                            WHERE b.driver_id = $driverId AND b.status BETWEEN 3 AND 6 
                            ORDER BY b.id DESC LIMIT 1");
if ($atQ && mysqli_num_rows($atQ) > 0) {
    $activeTrip = mysqli_fetch_assoc($atQ);
    $ast = intval($activeTrip['status']);
    $abId = intval($activeTrip['id']);
    
    if ($ast === 3) {
        $activeTrip['url'] = "driver-2acceptpayment.php?id=$abId";
        $activeTrip['label'] = 'Awaiting Passenger Payment';
        $activeTrip['badge_class'] = 'bg-warning text-dark';
    } elseif ($ast === 4) {
        $activeTrip['url'] = "driver-3checkpayment.php";
        $activeTrip['label'] = 'Passenger Sent Payment - Needs Verification';
        $activeTrip['badge_class'] = 'bg-primary text-white';
    } elseif ($ast === 5) {
        $activeTrip['url'] = "driver-4pickup.php?id=$abId";
        $activeTrip['label'] = 'Payment Accepted - Head to Pickup';
        $activeTrip['badge_class'] = 'bg-info text-white';
    } elseif ($ast === 6) {
        $activeTrip['url'] = "driver-5dropoff.php?id=$abId";
        $activeTrip['label'] = 'Passenger On Board - Head to Drop-off';
        $activeTrip['badge_class'] = 'bg-success text-white';
    }
}
?>

    <head>
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Driver Dashboard - TaxiDash')); ?>
        <?php include 'partials/head-css.php'; ?>
        <style>
            .welcome-banner { background: linear-gradient(135deg, #d97706, #f59e0b); border-radius: 18px; padding: 24px 28px; color: #fff; margin-bottom: 24px; }
            .welcome-banner h4 { font-weight: 700; font-size: 1.4rem; }
            .welcome-banner p { opacity: 0.9; margin: 0; font-size: 0.92rem; }
            .action-card { border-radius: 18px; border: none; color: #fff; box-shadow: 0 8px 24px rgba(0,0,0,0.2); transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: pointer; }
            .action-card:hover { transform: translateY(-6px); box-shadow: 0 16px 36px rgba(0,0,0,0.3); }
            .action-card .icon-wrap { width:70px;height:70px;border-radius:50%;background:rgba(255,255,255,0.2);display:flex;align-items:center;justify-content:center;margin:0 auto 16px; }
            .tip-card { border-radius: 14px; border: 1px solid #e5e7eb; }
            
            @keyframes pulse-soft {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.04); opacity: 0.9; }
            }
            .pulse-badge { animation: pulse-soft 2s infinite ease-in-out; }
        </style>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
        <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Welcome Banner -->
                        <div class="welcome-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h4><i class="bi bi-car-front me-2"></i>Driver Dashboard</h4>
                                <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['firstname']); ?></strong>! Ready to pick up passengers?</p>
                            </div>
                            <div class="d-none d-md-block text-end">
                                <span style="font-size:0.82rem; opacity:0.85;" id="driver-date"></span>
                            </div>
                        </div>

                        <?php if ($activeTrip): ?>
                        <!-- ACTIVE TRIP RESUME BANNER -->
                        <div class="card shadow-lg border-0 mb-4" style="border-radius: 18px; background: linear-gradient(135deg, #1e293b 0%, #0f172a 100%); color: #fff; border-left: 6px solid #f59e0b !important;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-warning text-dark rounded-pill px-3 py-2 fw-bold pulse-badge">
                                            <i class="fas fa-car me-1"></i> ACTIVE TRIP IN PROGRESS
                                        </span>
                                        <span class="badge <?=$activeTrip['badge_class']?> rounded-pill px-3 py-2 fw-bold">
                                            <?=$activeTrip['label']?>
                                        </span>
                                    </div>
                                    <div class="text-warning fw-bold fs-5">
                                        ₱<?=number_format(floatval($activeTrip['price']), 2)?>
                                    </div>
                                </div>

                                <div class="row align-items-center g-3">
                                    <div class="col-lg-8">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.08);">
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="fas fa-user text-warning mt-1 me-2"></i>
                                                <div>
                                                    <small class="text-white-50 d-block">Passenger</small>
                                                    <span class="fw-semibold text-white"><?=htmlspecialchars(($activeTrip['pass_fn'] ?? 'Passenger') . ' ' . ($activeTrip['pass_ln'] ?? ''))?> (<?=htmlspecialchars($activeTrip['pass_contact'] ?? 'N/A')?>)</span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="fas fa-map-marker-alt text-success mt-1 me-2"></i>
                                                <div>
                                                    <small class="text-white-50 d-block">Pickup</small>
                                                    <span class="fw-semibold text-white small"><?=htmlspecialchars($activeTrip['pickup_location'])?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-flag-checkered text-danger mt-1 me-2"></i>
                                                <div>
                                                    <small class="text-white-50 d-block">Destination</small>
                                                    <span class="fw-semibold text-white small"><?=htmlspecialchars($activeTrip['dropoff_location'])?></span>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-center text-lg-end">
                                        <div class="d-grid gap-2">
                                            <a href="<?=$activeTrip['url']?>" class="btn btn-warning btn-lg fw-bold text-dark shadow">
                                                <i class="fas fa-play-circle me-2"></i> Resume Active Trip
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Action Cards -->
                        <div class="row g-3 mb-4">
                            <div class="col-xl-4 col-md-4 col-sm-6">
                                <div class="card action-card text-center py-4"
                                     style="background:linear-gradient(135deg,#3bafda,#1e3c72);"
                                     onclick="window.location.href='driver-book.php';">
                                    <div class="card-body">
                                        <div class="icon-wrap"><i class="fas fa-taxi fa-2x text-white"></i></div>
                                        <h4 class="fw-bold mb-1 text-white">Pickup Booking</h4>
                                        <p class="mb-0" style="opacity:0.8;font-size:0.85rem;">View &amp; accept bookings</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-6">
                                <div class="card action-card text-center py-4"
                                     style="background:linear-gradient(135deg,#10b981,#065f46);"
                                     onclick="window.location.href='driver-history.php';">
                                    <div class="card-body">
                                        <div class="icon-wrap"><i class="mdi mdi-history fa-2x text-white" style="font-size:2rem;"></i></div>
                                        <h4 class="fw-bold mb-1 text-white"><?php echo $tripCount; ?> Trips Completed</h4>
                                        <p class="mb-0" style="opacity:0.8;font-size:0.85rem;">View past rides</p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-md-4 col-sm-6">
                                <div class="card action-card text-center py-4"
                                     style="background:linear-gradient(135deg,#f59e0b,#b45309);"
                                     onclick="window.location.href='driver-profile.php';">
                                    <div class="card-body">
                                        <div class="icon-wrap"><i class="fas fa-star fa-2x text-white"></i></div>
                                        <h4 class="fw-bold mb-1 text-white">⭐ <?php echo $avgRating; ?> / 5.0</h4>
                                        <p class="mb-0" style="opacity:0.85;font-size:0.85rem;"><?php echo $totalReviews; ?> Passenger Reviews</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Driver Tips Row -->
                        <div class="row g-3">
                            <div class="col-12 mb-1">
                                <h6 class="fw-bold text-secondary"><i class="bi bi-lightbulb me-2"></i>Driver Safety &amp; Service Tips</h6>
                            </div>
                            <div class="col-md-4">
                                <div class="card tip-card h-100">
                                    <div class="card-body d-flex gap-3 align-items-start py-3">
                                        <div style="width:40px;height:40px;border-radius:10px;background:#fef3c7;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-bell text-warning"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size:0.88rem;">Audio Alerts Active</div>
                                            <div class="text-muted" style="font-size:0.8rem;">Keep Pickup Booking open; chime plays on new requests.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card tip-card h-100">
                                    <div class="card-body d-flex gap-3 align-items-start py-3">
                                        <div style="width:40px;height:40px;border-radius:10px;background:#dbeafe;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-shield-alt text-primary"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size:0.88rem;">Safe Driving Standards</div>
                                            <div class="text-muted" style="font-size:0.8rem;">Maintain high star ratings by driving safely and politely.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card tip-card h-100">
                                    <div class="card-body d-flex gap-3 align-items-start py-3">
                                        <div style="width:40px;height:40px;border-radius:10px;background:#d1fae5;display:flex;align-items:center;justify-content:center;flex-shrink:0;">
                                            <i class="fas fa-qrcode text-success"></i>
                                        </div>
                                        <div>
                                            <div class="fw-semibold" style="font-size:0.88rem;">GCash QR Code</div>
                                            <div class="text-muted" style="font-size:0.8rem;">Keep your payment QR updated in your Profile.</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div><!-- container-fluid -->
                </div><!-- page-content -->
                <?php include 'partials/footer.php'; ?>
            </div><!-- main-content -->
        </div><!-- layout-wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/js/app.js"></script>
        <script>
            document.getElementById('driver-date').textContent = new Date().toLocaleDateString('en-PH',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
        </script>
    </body>
</html>
