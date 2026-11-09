<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$driverId = intval($_SESSION['user_id'] ?? 0);

// Driver stats
$statQ = mysqli_query($conn, "SELECT COUNT(*) as total_trips, COALESCE(SUM(price), 0) as total_earned FROM temp_ride_bookings WHERE driver_id = $driverId AND status = 7");
$stat = mysqli_fetch_assoc($statQ);
$totalTrips = intval($stat['total_trips'] ?? 0);
$totalEarned = floatval($stat['total_earned'] ?? 0);

// Driver rating
$ratQ = mysqli_query($conn, "SELECT COALESCE(AVG(rating), 5.0) as avg_rating, COUNT(*) as review_count FROM tbl_ratings WHERE driver_id = $driverId");
$rat = mysqli_fetch_assoc($ratQ);
$avgRating = round(floatval($rat['avg_rating'] ?? 5.0), 1);
$reviewCount = intval($rat['review_count'] ?? 0);
?>

    <head>
        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Passenger Trip History - TaxiDash')); ?>
        <?php include 'partials/head-css.php'; ?>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
        <style>
            .stat-card-driver {
                border-radius: 16px;
                border: none;
                transition: transform 0.2s ease, box-shadow 0.2s ease;
                box-shadow: 0 4px 14px rgba(0,0,0,0.06);
            }
            .stat-card-driver:hover {
                transform: translateY(-3px);
                box-shadow: 0 8px 20px rgba(0,0,0,0.1);
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
        </style>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Passenger Trip History')); ?>

                        <!-- Stats Row -->
                        <div class="row mb-4">
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card stat-card-driver text-white p-3" style="background: linear-gradient(135deg, #f59e0b, #d97706) !important;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Trips Completed</span>
                                            <h2 class="fw-bold mb-0 mt-1"><?=$totalTrips?></h2>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-check-double fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4 mb-3 mb-md-0">
                                <div class="card stat-card-driver text-white p-3" style="background: linear-gradient(135deg, #059669, #10b981) !important;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Total Earnings</span>
                                            <h2 class="fw-bold mb-0 mt-1">&#8369;<?=number_format($totalEarned, 2)?></h2>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-coins fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="card stat-card-driver text-white p-3" style="background: linear-gradient(135deg, #1e3c72, #3bafda) !important;">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <div>
                                            <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem;">Driver Rating</span>
                                            <h2 class="fw-bold mb-0 mt-1"><?=$avgRating?> <small style="font-size:1rem;">/ 5.0</small></h2>
                                            <small class="text-white-50"><?=$reviewCount?> total passenger reviews</small>
                                        </div>
                                        <div class="rounded-circle bg-white bg-opacity-25 p-3 d-flex align-items-center justify-content-center" style="width:54px; height:54px;">
                                            <i class="fas fa-star fa-2x text-white"></i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Filter and Search Bar -->
                        <div class="card shadow-sm border-0 mb-4" style="border-radius:14px;">
                            <div class="card-body p-3">
                                <div class="row align-items-center g-2">
                                    <div class="col-md-6">
                                        <div class="input-group">
                                            <span class="input-group-text bg-light border-0"><i class="fas fa-search text-muted"></i></span>
                                            <input type="text" id="driverSearchInput" class="form-control bg-light border-0" placeholder="Search by passenger name or location...">
                                        </div>
                                    </div>
                                    <div class="col-md-6 text-md-end d-flex justify-content-md-end gap-2 align-items-center">
                                        <span class="text-muted small">Filter by:</span>
                                        <select id="filter" class="form-select form-select-sm w-auto rounded-pill border-primary">
                                            <option value="all" selected>All Time</option>
                                            <option value="daily">Today Only</option>
                                            <option value="weekly">This Week</option>
                                            <option value="monthly">This Month</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Trips Container -->
                        <div class="row" id="bookingHistory">
                            <div class="col-12 text-center py-5">
                                <div class="spinner-border text-primary" role="status">
                                    <span class="visually-hidden">Loading history...</span>
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
        <script src="assets/js/app.js"></script>

        <script>
        $(document).ready(function() {
            function fetchBookings(filter = 'all') {
                $('#bookingHistory').html(`
                    <div class="col-12 text-center py-5">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading history...</span>
                        </div>
                    </div>
                `);

                $.ajax({
                    url: '../php/fetch-booking-history.php?id=<?= $driverId ?>',
                    method: 'POST',
                    data: { filter: filter },
                    success: function(response) {
                        $('#bookingHistory').html(response);
                        filterItems();
                    },
                    error: function() {
                        $('#bookingHistory').html('<div class="col-12 text-center py-4 text-danger">Failed to load trip history.</div>');
                    }
                });
            }

            fetchBookings();

            $('#filter').change(function() {
                fetchBookings($(this).val());
            });

            function filterItems() {
                const query = ($('#driverSearchInput').val() || '').toLowerCase().trim();
                $('.driver-trip-item').each(function() {
                    const text = $(this).attr('data-text') || '';
                    $(this).toggle(text.includes(query));
                });
            }

            $('#driverSearchInput').on('input', filterItems);
        });
        </script>
    </body>
</html>