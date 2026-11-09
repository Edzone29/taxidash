<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$userId = intval($_SESSION['user_id'] ?? 0);
$bookingId = intval($_GET['id'] ?? 0);

// Validate booking status
if ($bookingId > 0) {
    $chk = mysqli_query($conn, "SELECT id, status, pickup_location, dropoff_location, price FROM temp_ride_bookings WHERE id = $bookingId AND user_id = $userId");
} else {
    $chk = mysqli_query($conn, "SELECT id, status, pickup_location, dropoff_location, price FROM temp_ride_bookings WHERE user_id = $userId AND status BETWEEN 2 AND 6 ORDER BY id DESC LIMIT 1");
}

$bookingData = null;
if ($chk && $crow = mysqli_fetch_assoc($chk)) {
    $bookingId = intval($crow['id']);
    $st = intval($crow['status']);
    $bookingData = $crow;
    
    // If it has already progressed, send directly to the right page
    if ($st === 3 || $st === 4) {
        header("Location: client-4payment.php?id=$bookingId");
        exit;
    } elseif ($st === 5) {
        header("Location: client-6pickup.php?id=$bookingId");
        exit;
    } elseif ($st === 6) {
        header("Location: client-7dropoff.php?id=$bookingId");
        exit;
    } elseif ($st >= 7) {
        header("Location: client-dashboard.php");
        exit;
    }
} else {
    // Check if user has an unconfirmed draft booking (status = 1)
    $dchk = mysqli_query($conn, "SELECT id FROM temp_ride_bookings WHERE user_id = $userId AND status = 1 ORDER BY id DESC LIMIT 1");
    if ($dchk && mysqli_num_rows($dchk) > 0) {
        header("Location: client-2proceed-booking.php");
        exit;
    }
    header("Location: client-1book.php");
    exit;
}
?>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
        .radar-box {
            position: relative;
            width: 170px;
            height: 170px;
            margin: 25px auto;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .radar-center {
            width: 74px;
            height: 74px;
            border-radius: 50%;
            background: linear-gradient(135deg, #1e3c72, #3bafda);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            box-shadow: 0 8px 24px rgba(30,60,114,0.4);
            z-index: 3;
            animation: bounceTaxi 2s infinite ease-in-out;
        }
        @keyframes bounceTaxi {
            0%, 100% { transform: scale(1); }
            50% { transform: scale(1.08); }
        }
        .radar-wave {
            position: absolute;
            border: 2px solid rgba(59,175,218,0.5);
            border-radius: 50%;
            width: 100%;
            height: 100%;
            animation: radarPulse 2.4s infinite cubic-bezier(0.215, 0.61, 0.355, 1);
            opacity: 0;
        }
        .radar-wave:nth-child(2) { animation-delay: 0.8s; }
        .radar-wave:nth-child(3) { animation-delay: 1.6s; }
        @keyframes radarPulse {
            0% { transform: scale(0.4); opacity: 0.9; }
            50% { opacity: 0.5; }
            100% { transform: scale(1.4); opacity: 0; }
        }
        .search-card {
            border-radius: 20px;
            border: none;
            box-shadow: 0 10px 30px rgba(0,0,0,0.08);
            overflow: hidden;
        }
        .search-header {
            background: linear-gradient(135deg, #1e3c72, #3bafda);
            padding: 20px;
            color: #fff;
            text-align: center;
        }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Searching for Driver - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Searching for Driver')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 3; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-3">
                            <div id="searchDriverCard" class="card search-card">
                                <div class="search-header">
                                    <h5 class="card-title text-white mb-0">
                                        <i class="fas fa-radar me-2"></i>Connecting to Nearest Drivers
                                    </h5>
                                </div>
                                <div class="card-body text-center p-4">
                                    <!-- Animated Radar -->
                                    <div class="radar-box">
                                        <div class="radar-wave"></div>
                                        <div class="radar-wave"></div>
                                        <div class="radar-wave"></div>
                                        <div class="radar-center">
                                            <i class="fas fa-taxi fa-2x"></i>
                                        </div>
                                    </div>

                                    <h5 class="fw-bold mb-1 text-dark">Locating available drivers...</h5>
                                    <p class="text-muted small mb-3">Please keep this window open while drivers in your area review your trip request.</p>

                                    <!-- Trip Mini Summary -->
                                    <?php if ($bookingData): ?>
                                    <div class="alert alert-light border py-2 px-3 small text-start mx-auto mb-3" style="max-width: 440px; border-radius:12px; background:#f8fafc;">
                                        <div class="d-flex justify-content-between mb-1">
                                            <span class="text-muted">Estimated Fare:</span>
                                            <strong class="text-success">&#8369;<?=number_format(floatval($bookingData['price']), 2)?></strong>
                                        </div>
                                        <div class="text-truncate text-muted">
                                            <i class="fas fa-map-marker-alt text-success me-1"></i> <?=htmlspecialchars($bookingData['pickup_location'])?>
                                        </div>
                                        <div class="text-truncate text-muted">
                                            <i class="fas fa-flag-checkered text-danger me-1"></i> <?=htmlspecialchars($bookingData['dropoff_location'])?>
                                        </div>
                                    </div>
                                    <?php endif; ?>

                                    <!-- Driver Action Hint -->
                                    <div class="alert alert-light border py-2 px-3 small mx-auto text-start mb-4" style="max-width: 440px; border-radius:12px;">
                                        <i class="fas fa-info-circle text-primary me-1"></i> <strong>Dual Device / Demo Testing:</strong> Log in as Driver (<code>driver@gmail.com</code>) in an <strong>Incognito window</strong>, go to <em>Pickup Booking</em>, and tap <em>"Accept Booking"</em>.
                                    </div>

                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <button id="cancelBooking" class="btn btn-outline-danger rounded-pill px-4">
                                            <i class="fas fa-times me-1"></i> Cancel Booking
                                        </button>
                                        <button id="demoAcceptBtn" class="btn btn-outline-primary rounded-pill px-4">
                                            <i class="fas fa-bolt me-1"></i> Quick Test: Auto-Accept
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include 'partials/footer.php'; ?>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/ride-back-guard.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        $(document).ready(function() {
            const userId = <?=$userId?>;
            const bookingId = <?=$bookingId?>;

            // Polling booking status for this specific booking
            const checkBookingStatus = setInterval(() => {
                $.ajax({
                    url: '../php/check-booking-status.php',
                    method: 'GET',
                    data: { userId: userId, bookingId: bookingId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.driver_found && response.data.length > 0) {
                            clearInterval(checkBookingStatus);
                            const bStatus = parseInt(response.data[0].status);
                            Swal.fire({
                                title: 'Driver Found!',
                                text: 'A driver has accepted your ride request.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                if (bStatus === 3 || bStatus === 4) {
                                    window.location.href = 'client-4payment.php?id=' + bookingId;
                                } else if (bStatus === 5) {
                                    window.location.href = 'client-6pickup.php?id=' + bookingId;
                                } else if (bStatus === 6) {
                                    window.location.href = 'client-7dropoff.php?id=' + bookingId;
                                } else {
                                    window.location.href = 'client-4payment.php?id=' + bookingId;
                                }
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking booking status:', error);
                    }
                });
            }, 3000);

            // Quick Test Auto-Accept button
            $('#demoAcceptBtn').on('click', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Accepting...');
                $.ajax({
                    url: '../php/demo-advance.php',
                    method: 'POST',
                    data: { step: 'accept_ride', bookingId: bookingId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            clearInterval(checkBookingStatus);
                            Swal.fire({
                                title: 'Driver Found!',
                                text: 'Driver accepted your ride.',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'client-4payment.php?id=' + bookingId;
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Auto-Accept');
                            Swal.fire('Notice', res.message, 'info');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Auto-Accept');
                    }
                });
            });

            // Cancel Booking button click event
            $('#cancelBooking').on('click', function() {
                Swal.fire({
                    title: 'Cancel Booking?',
                    text: 'Are you sure you want to cancel your ride request?',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, cancel it!',
                    cancelButtonText: 'Keep searching'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../php/cancel-booking.php',
                            method: 'POST',
                            data: { userId: userId, bookingId: bookingId },
                            dataType: 'json',
                            success: function(cancelResponse) {
                                if (cancelResponse.status === 'success') {
                                    Swal.fire('Cancelled', 'Your booking request was cancelled.', 'success').then(() => {
                                        window.location.href = 'client-dashboard.php';
                                    });
                                } else {
                                    Swal.fire('Error', cancelResponse.message, 'error');
                                }
                            },
                            error: function() {
                                Swal.fire('Error', 'Error cancelling booking. Please try again.', 'error');
                            }
                        });
                    }
                });
            });
        });
        </script>
    </body>
</html>