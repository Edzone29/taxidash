<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
include '../php/conn.php';
$userId = intval($_SESSION['user_id'] ?? 0);

// Fetch latest completed booking for this user
$query = "SELECT b.*, u.firstname AS driver_fn, u.lastname AS driver_ln, u.plate, u.contact AS driver_contact 
          FROM temp_ride_bookings b 
          LEFT JOIN tbl_users u ON b.driver_id = u.id 
          WHERE b.user_id = $userId 
          ORDER BY b.id DESC LIMIT 1";
$res = mysqli_query($conn, $query);
$booking = mysqli_fetch_assoc($res);

$bookingId = $booking ? intval($booking['id']) : 0;
$driverId = $booking ? intval($booking['driver_id']) : 0;
$driverName = $booking ? htmlspecialchars(trim(($booking['driver_fn'] ?? '') . ' ' . ($booking['driver_ln'] ?? ''))) : 'Your Driver';
$driverPlate = ($booking && !empty($booking['plate'])) ? htmlspecialchars($booking['plate']) : 'Plate N/A';
$pickupLoc = $booking ? htmlspecialchars($booking['pickup_location']) : 'Pickup Location';
$dropoffLoc = $booking ? htmlspecialchars($booking['dropoff_location']) : 'Drop-off Location';
$price = $booking ? floatval($booking['price']) : 50.00;
$tripDate = $booking ? date('F d, Y \a\t h:i A', strtotime($booking['created_at'])) : date('F d, Y \a\t h:i A');
$txCode = 'TXD-' . date('y') . str_pad($bookingId, 5, '0', STR_PAD_LEFT);

// Check if already rated
$ratedQuery = mysqli_query($conn, "SELECT rating, feedback FROM tbl_ratings WHERE booking_id = $bookingId AND user_id = $userId");
$existingRating = mysqli_fetch_assoc($ratedQuery);
?>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            .star-rating {
                display: inline-flex;
                flex-direction: row-reverse;
                justify-content: center;
                font-size: 2.4rem;
                gap: 8px;
            }
            .star-rating input { display: none; }
            .star-rating label {
                color: #d1d5db;
                cursor: pointer;
                transition: color 0.2s, transform 0.2s;
            }
            .star-rating label:hover,
            .star-rating label:hover ~ label,
            .star-rating input:checked ~ label {
                color: #fbbf24;
                transform: scale(1.15);
            }

            /* Printable Receipt */
            @media print {
                body * { visibility: hidden; }
                #receiptModal .modal-body, #receiptModal .modal-body * { visibility: visible; }
                #receiptModal .modal-body {
                    position: absolute;
                    left: 0;
                    top: 0;
                    width: 100%;
                    padding: 24px;
                    background: white;
                }
                .no-print { display: none !important; }
            }

            .receipt-box {
                background: #ffffff;
                border: 2px dashed #3bafda;
                border-radius: 16px;
                padding: 24px;
            }
            .complete-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Trip Complete - TaxiDash')); ?>
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Trip Complete')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 7; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="row justify-content-center my-3">
                            <div class="col-xl-6 col-lg-8 col-md-10">
                                <div class="card complete-card">
                                    <div class="card-header text-center text-white py-4" style="background: linear-gradient(135deg, #059669, #10b981);">
                                        <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-2"
                                             style="width:72px; height:72px; background:rgba(255,255,255,0.25);">
                                            <i class="fas fa-check fa-2x text-white"></i>
                                        </div>
                                        <h3 class="fw-bold mb-1 text-white">Arrived Safely!</h3>
                                        <p class="mb-0 text-white-50 small">Thank you for riding with TaxiDash</p>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Trip Summary Info -->
                                        <div class="p-3 mb-4 rounded-3" style="background: #f8fafc; border: 1px solid #e2e8f0;">
                                            <div class="d-flex justify-content-between align-items-center mb-2">
                                                <span class="text-muted small text-uppercase fw-bold">Total Fare Paid</span>
                                                <span class="h3 text-success fw-bold mb-0">&#8369;<?php echo number_format($price, 2); ?></span>
                                            </div>
                                            <hr class="my-2">
                                            <div class="mb-2 small">
                                                <i class="fas fa-user-circle text-primary me-2"></i>
                                                <strong>Driver:</strong> <?php echo $driverName; ?> 
                                                <span class="badge bg-secondary ms-1"><?php echo $driverPlate; ?></span>
                                            </div>
                                            <div class="mb-1 text-truncate small">
                                                <i class="fas fa-map-marker-alt text-success me-2"></i>
                                                <strong>From:</strong> <?php echo $pickupLoc; ?>
                                            </div>
                                            <div class="text-truncate small">
                                                <i class="fas fa-flag-checkered text-danger me-2"></i>
                                                <strong>To:</strong> <?php echo $dropoffLoc; ?>
                                            </div>
                                        </div>

                                        <!-- Rating status preview -->
                                        <?php if ($existingRating): ?>
                                            <div class="alert alert-success d-flex align-items-center justify-content-between mb-4 py-3 px-3 rounded-3">
                                                <div>
                                                    <i class="fas fa-check-circle text-success me-2 fs-5"></i>
                                                    <strong>You rated this trip:</strong> 
                                                    <span class="text-warning fw-bold fs-6 ms-1">
                                                        <?php echo str_repeat('&#9733;', intval($existingRating['rating'])); ?>
                                                        (<?php echo $existingRating['rating']; ?> / 5)
                                                    </span>
                                                    <?php if (!empty($existingRating['feedback'])): ?>
                                                        <div class="text-muted small mt-1"><em>"<?php echo htmlspecialchars($existingRating['feedback']); ?>"</em></div>
                                                    <?php endif; ?>
                                                </div>
                                            </div>
                                        <?php else: ?>
                                            <!-- Rating Form -->
                                            <div class="card border p-4 mb-4 text-center rounded-3 shadow-sm" style="background: #ffffff;">
                                                <h5 class="fw-bold mb-1 text-dark">Rate Your Trip Experience</h5>
                                                <p class="text-muted small mb-3">How was your trip with <?php echo $driverName; ?>?</p>

                                                <form id="ratingForm">
                                                    <input type="hidden" name="booking_id" value="<?php echo $bookingId; ?>">
                                                    <input type="hidden" name="driver_id" value="<?php echo $driverId; ?>">
                                                    <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

                                                    <div class="star-rating mb-3">
                                                        <input type="radio" id="star5" name="rating" value="5" required /><label for="star5" title="5 stars"><i class="fas fa-star"></i></label>
                                                        <input type="radio" id="star4" name="rating" value="4" /><label for="star4" title="4 stars"><i class="fas fa-star"></i></label>
                                                        <input type="radio" id="star3" name="rating" value="3" /><label for="star3" title="3 stars"><i class="fas fa-star"></i></label>
                                                        <input type="radio" id="star2" name="rating" value="2" /><label for="star2" title="2 stars"><i class="fas fa-star"></i></label>
                                                        <input type="radio" id="star1" name="rating" value="1" /><label for="star1" title="1 star"><i class="fas fa-star"></i></label>
                                                    </div>

                                                    <div class="mb-3">
                                                        <textarea class="form-control rounded-3" name="feedback" rows="3" placeholder="Leave comments or feedback for your driver (optional)..." style="font-size:0.9rem;"></textarea>
                                                    </div>

                                                    <button type="submit" id="submitRatingBtn" class="btn btn-warning rounded-pill fw-bold px-4 shadow-sm">
                                                        <i class="fas fa-star me-1"></i> Submit Review
                                                    </button>
                                                </form>
                                            </div>
                                        <?php endif; ?>

                                        <!-- Actions -->
                                        <div class="d-grid gap-2">
                                            <button type="button" class="btn btn-outline-primary rounded-pill py-2 fw-semibold" data-bs-toggle="modal" data-bs-target="#receiptModal">
                                                <i class="fas fa-receipt me-2"></i> View &amp; Print E-Receipt
                                            </button>
                                            <div class="row g-2 mt-1">
                                                <div class="col-6">
                                                    <a href="client-1book.php" class="btn btn-primary rounded-pill w-100 py-2 fw-semibold">
                                                        <i class="fas fa-taxi me-1"></i> Book Again
                                                    </a>
                                                </div>
                                                <div class="col-6">
                                                    <a href="client-dashboard.php" class="btn btn-light border rounded-pill w-100 py-2 text-muted fw-semibold">
                                                        <i class="fas fa-home me-1"></i> Dashboard
                                                    </a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include 'partials/footer.php'; ?>
            </div>
        </div>

        <!-- E-Receipt Modal -->
        <div class="modal fade" id="receiptModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3c72, #3bafda);">
                        <h5 class="modal-title fw-bold text-white"><i class="fas fa-file-invoice me-2"></i>Official Trip E-Receipt</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>

                    <div class="modal-body p-4">
                        <div class="receipt-box text-center">
                            <img src="../taxi.jpg" alt="TaxiDash" height="48" class="rounded mb-2" style="object-fit:cover;">
                            <h4 class="fw-bold mb-0 text-dark">TAXIDASH</h4>
                            <p class="text-muted small mb-2">Fast, Safe &amp; Convenient Taxi Transport</p>
                            <span class="badge bg-success rounded-pill px-3 py-1 mb-3">PAID &bull; COMPLETED</span>

                            <div class="text-start small p-3 rounded" style="background:#f8fafc; border:1px solid #e2e8f0;">
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Receipt Ref:</span>
                                    <strong class="text-dark"><?=$txCode?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Date &amp; Time:</span>
                                    <strong class="text-dark"><?php echo $tripDate; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span class="text-muted">Driver:</span>
                                    <strong class="text-dark"><?php echo $driverName; ?></strong>
                                </div>
                                <div class="d-flex justify-content-between mb-2">
                                    <span class="text-muted">Vehicle Plate:</span>
                                    <strong class="text-dark"><?php echo $driverPlate; ?></strong>
                                </div>
                                <hr class="my-2">
                                <div class="mb-1 text-truncate">
                                    <span class="text-muted">Pickup:</span><br>
                                    <strong><?php echo $pickupLoc; ?></strong>
                                </div>
                                <div class="text-truncate">
                                    <span class="text-muted">Drop-off:</span><br>
                                    <strong><?php echo $dropoffLoc; ?></strong>
                                </div>
                                <hr class="my-2">
                                <div class="d-flex justify-content-between align-items-center">
                                    <span class="fs-6 fw-bold text-dark">Total Amount:</span>
                                    <span class="fs-4 fw-bold text-success">&#8369;<?php echo number_format($price, 2); ?></span>
                                </div>
                            </div>

                            <p class="text-muted small mt-3 mb-0" style="font-size:0.75rem;">
                                Thank you for riding with us! For questions or lost items, reach out via Customer Support.
                            </p>
                        </div>
                    </div>

                    <div class="modal-footer border-0 p-3 bg-light d-flex justify-content-between">
                        <button type="button" class="btn btn-secondary rounded-pill px-4" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4" onclick="window.print();">
                            <i class="fas fa-print me-1"></i> Print / Save PDF
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/js/app.js"></script>

        <script>
        $(document).ready(function() {
            $('#ratingForm').on('submit', function(e) {
                e.preventDefault();
                const btn = $('#submitRatingBtn');
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Submitting...');

                $.ajax({
                    url: '../php/submit-rating.php',
                    method: 'POST',
                    data: $(this).serialize(),
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status === 'success') {
                            Swal.fire({
                                title: 'Thank You!',
                                text: resp.message || 'Rating submitted successfully.',
                                icon: 'success',
                                timer: 1800,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.reload();
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-star me-1"></i> Submit Review');
                            Swal.fire('Notice', resp.message || 'Error saving review.', 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-star me-1"></i> Submit Review');
                        Swal.fire('Error', 'Unable to submit rating. Please try again.', 'error');
                    }
                });
            });
        });
        </script>
    </body>
</html>