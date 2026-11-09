<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$userId = intval($_SESSION['user_id'] ?? 0);
$activeRide = null;

if ($userId > 0) {
    $aq = mysqli_query($conn, "SELECT b.*, u.firstname AS drv_fn, u.lastname AS drv_ln, u.plate AS drv_plate, u.contact AS drv_contact 
                               FROM temp_ride_bookings b 
                               LEFT JOIN tbl_users u ON b.driver_id = u.id 
                               WHERE b.user_id = $userId AND b.status BETWEEN 1 AND 6 
                               ORDER BY b.id DESC LIMIT 1");
    if ($aq && mysqli_num_rows($aq) > 0) {
        $activeRide = mysqli_fetch_assoc($aq);
        $st = intval($activeRide['status']);
        
        if ($st === 1) {
            $activeRide['url'] = 'client-2proceed-booking.php';
            $activeRide['label'] = 'Unconfirmed Ride';
            $activeRide['badge_class'] = 'bg-secondary';
        } elseif ($st === 2) {
            $activeRide['url'] = 'client-3search-driver.php';
            $activeRide['label'] = 'Searching for Driver...';
            $activeRide['badge_class'] = 'bg-warning text-dark';
        } elseif ($st === 3) {
            $activeRide['url'] = 'client-4payment.php';
            $activeRide['label'] = 'Driver Found - Upload Payment';
            $activeRide['badge_class'] = 'bg-info text-white';
        } elseif ($st === 4) {
            $activeRide['url'] = 'client-5confirmpayment.php';
            $activeRide['label'] = 'Verifying Payment Proof';
            $activeRide['badge_class'] = 'bg-primary text-white';
        } elseif ($st === 5) {
            $activeRide['url'] = 'client-6pickup.php';
            $activeRide['label'] = 'Driver Confirmed - Waiting for Pickup';
            $activeRide['badge_class'] = 'bg-success text-white';
        } elseif ($st === 6) {
            $activeRide['url'] = 'client-7dropoff.php';
            $activeRide['label'] = 'On the Way to Destination';
            $activeRide['badge_class'] = 'bg-success text-white';
        }
    }
}
?>

    <head>
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Passenger Dashboard - TaxiDash')); ?>
        <?php include 'partials/head-css.php'; ?>
        <style>
            .welcome-banner { background: linear-gradient(135deg, #1e3c72, #3bafda); border-radius: 18px; padding: 24px 28px; color: #fff; margin-bottom: 24px; }
            .welcome-banner h4 { font-weight: 700; font-size: 1.4rem; }
            .welcome-banner p { opacity: 0.85; margin: 0; font-size: 0.92rem; }
            .book-card { border-radius: 18px; border: none; background: linear-gradient(135deg, #3bafda, #1e3c72); color: #fff; box-shadow: 0 8px 24px rgba(59,175,218,0.4); transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: pointer; }
            .book-card:hover { transform: translateY(-6px); box-shadow: 0 16px 36px rgba(30,60,114,0.45); }
            .book-card .icon-wrap { width: 70px; height: 70px; border-radius: 50%; background: rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; margin: 0 auto 16px; }
            .info-card { border-radius: 14px; border: 1px solid #e5e7eb; transition: transform 0.2s ease, box-shadow 0.2s ease; }
            .info-card:hover { transform: translateY(-3px); box-shadow: 0 8px 20px rgba(0,0,0,0.08); }
            
            @keyframes pulse-soft {
                0%, 100% { transform: scale(1); opacity: 1; }
                50% { transform: scale(1.04); opacity: 0.9; }
            }
            .pulse-badge { animation: pulse-soft 2s infinite ease-in-out; }
        </style>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
        <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Welcome Banner -->
                        <div class="welcome-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h4><i class="bi bi-house-door me-2"></i>Welcome, <?php echo htmlspecialchars($_SESSION['firstname']); ?>!</h4>
                                <p>Ready to book a ride? Manage your trips and book taxis safely with TaxiDash.</p>
                            </div>
                            <div class="d-none d-md-block text-end">
                                <span style="font-size:0.82rem; opacity:0.8;" id="client-date"></span>
                            </div>
                        </div>

                        <?php if ($activeRide): ?>
                        <!-- ACTIVE / ONGOING RIDE RESUME CARD -->
                        <div class="card shadow-lg border-0 mb-4" style="border-radius: 18px; background: linear-gradient(135deg, #064e3b 0%, #065f46 50%, #047857 100%); color: #fff;">
                            <div class="card-body p-4">
                                <div class="d-flex align-items-center justify-content-between flex-wrap gap-2 mb-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <span class="badge bg-danger rounded-pill px-3 py-2 fw-bold pulse-badge">
                                            <i class="fas fa-circle me-1" style="font-size: 8px;"></i> ONGOING RIDE IN PROGRESS
                                        </span>
                                        <span class="badge <?=$activeRide['badge_class']?> rounded-pill px-3 py-2 fw-bold">
                                            <?=$activeRide['label']?>
                                        </span>
                                    </div>
                                    <div class="text-white fw-bold fs-5">
                                        ₱<?=number_format(floatval($activeRide['price']), 2)?>
                                    </div>
                                </div>

                                <div class="row align-items-center g-3">
                                    <div class="col-lg-8">
                                        <div class="p-3 rounded-3" style="background: rgba(255,255,255,0.12); backdrop-filter: blur(4px);">
                                            <div class="d-flex align-items-start mb-2">
                                                <i class="fas fa-map-marker-alt text-warning mt-1 me-2"></i>
                                                <div>
                                                    <small class="text-white-50 d-block">Pickup Location</small>
                                                    <span class="fw-semibold text-white"><?=htmlspecialchars($activeRide['pickup_location'])?></span>
                                                </div>
                                            </div>
                                            <div class="d-flex align-items-start">
                                                <i class="fas fa-flag-checkered text-info mt-1 me-2"></i>
                                                <div>
                                                    <small class="text-white-50 d-block">Destination</small>
                                                    <span class="fw-semibold text-white"><?=htmlspecialchars($activeRide['dropoff_location'])?></span>
                                                </div>
                                            </div>
                                            <?php if (!empty($activeRide['drv_fn'])): ?>
                                            <hr class="my-2 border-white-50">
                                            <div class="small text-white">
                                                <i class="fas fa-car me-1 text-warning"></i> Driver: <strong><?=htmlspecialchars($activeRide['drv_fn'] . ' ' . $activeRide['drv_ln'])?></strong> (Plate: <?=htmlspecialchars($activeRide['drv_plate'] ?? 'Assigned')?>)
                                            </div>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                    <div class="col-lg-4 text-center text-lg-end">
                                        <div class="d-grid gap-2">
                                            <a href="<?=$activeRide['url']?>" class="btn btn-warning btn-lg fw-bold text-dark shadow">
                                                <i class="fas fa-play-circle me-2"></i> Resume My Ride
                                            </a>
                                            <?php if (intval($activeRide['status']) <= 2): ?>
                                            <button id="cancelActiveRideBtn" data-id="<?=$activeRide['id']?>" class="btn btn-outline-light btn-sm">
                                                <i class="fas fa-times me-1"></i> Cancel Ride
                                            </button>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <!-- Book a Ride Card -->
                        <div class="row mb-4">
                            <div class="col-xl-3 col-md-4 col-sm-6">
                                <?php if ($activeRide): ?>
                                <div class="card book-card" onclick="alertActiveRide('<?=$activeRide['url']?>');">
                                <?php else: ?>
                                <div class="card book-card" onclick="window.location.href='client-1book.php';">
                                <?php endif; ?>
                                    <div class="card-body text-center py-4">
                                        <div class="icon-wrap">
                                            <i class="fas fa-taxi fa-2x text-white"></i>
                                        </div>
                                        <h4 class="fw-bold mb-1">Book a Ride</h4>
                                        <p style="opacity:0.8; font-size:0.85rem; margin:0;">
                                            <?=$activeRide ? 'Active ride in progress' : 'Tap to get started'?>
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Info Cards Row -->
                        <div class="row g-3">
                            <div class="col-12 mb-1">
                                <h6 class="fw-bold text-secondary"><i class="bi bi-info-circle me-2"></i>Fare Information</h6>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="card info-card">
                                    <div class="card-body d-flex align-items-center gap-3 py-3">
                                        <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#3bafda,#1e3c72);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-money-bill-wave text-white"></i>
                                        </div>
                                        <div>
                                            <div style="font-size:0.78rem;color:#6b7280;">Base Fare</div>
                                            <div class="fw-bold text-primary">₱50.00</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="card info-card">
                                    <div class="card-body d-flex align-items-center gap-3 py-3">
                                        <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#10b981,#065f46);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-road text-white"></i>
                                        </div>
                                        <div>
                                            <div style="font-size:0.78rem;color:#6b7280;">Per Kilometer</div>
                                            <div class="fw-bold text-success">₱15.00 / km</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 col-sm-6">
                                <div class="card info-card">
                                    <div class="card-body d-flex align-items-center gap-3 py-3">
                                        <div style="width:44px;height:44px;border-radius:12px;background:linear-gradient(135deg,#8b5cf6,#5b21b6);display:flex;align-items:center;justify-content:center;">
                                            <i class="fas fa-mobile-alt text-white"></i>
                                        </div>
                                        <div>
                                            <div style="font-size:0.78rem;color:#6b7280;">Payment Method</div>
                                            <div class="fw-bold text-purple" style="color:#8b5cf6;">GCash / Cash</div>
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
        <!-- SweetAlert2 -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.js"></script>

        <script>
            document.getElementById('client-date').textContent = new Date().toLocaleDateString('en-PH',{weekday:'long',year:'numeric',month:'long',day:'numeric'});

            function alertActiveRide(url) {
                Swal.fire({
                    title: 'Active Ride in Progress',
                    text: 'You already have an active ride ongoing. Would you like to resume it now?',
                    icon: 'info',
                    showCancelButton: true,
                    confirmButtonText: 'Resume Active Ride',
                    cancelButtonText: 'Stay on Dashboard'
                }).then((res) => {
                    if (res.isConfirmed) {
                        window.location.href = url;
                    }
                });
            }

            $('#cancelActiveRideBtn').on('click', function() {
                const bId = $(this).data('id');
                Swal.fire({
                    title: 'Cancel Booking',
                    text: 'Are you sure you want to cancel your ongoing booking?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    confirmButtonText: 'Yes, cancel ride'
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.post('../php/cancel-booking.php', { userId: <?=json_encode($userId)?> }, function() {
                            location.reload();
                        });
                    }
                });
            });
        </script>
    </body>
</html>
