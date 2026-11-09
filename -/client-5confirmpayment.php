<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            .verify-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .verify-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 22px;
                color: #fff;
                text-align: center;
            }
            .pulse-circle {
                width: 90px;
                height: 90px;
                border-radius: 50%;
                background: linear-gradient(135deg, #3bafda, #1e3c72);
                color: #fff;
                display: flex;
                align-items: center;
                justify-content: center;
                margin: 20px auto;
                box-shadow: 0 0 0 0 rgba(59,175,218,0.7);
                animation: pulseRing 1.8s infinite cubic-bezier(0.66, 0, 0, 1);
            }
            @keyframes pulseRing {
                to {
                    box-shadow: 0 0 0 24px rgba(59,175,218,0);
                }
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Verifying Payment - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Verifying Payment')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 4; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-3">
                            <div id="searchDriverCard" class="card verify-card">
                                <div class="verify-header">
                                    <h5 class="card-title text-white mb-0">
                                        <i class="fas fa-file-invoice-dollar me-2"></i>Verifying Payment Proof...
                                    </h5>
                                </div>
                                <div class="card-body text-center p-4">
                                    <div class="pulse-circle">
                                        <i class="fas fa-shield-alt fa-3x"></i>
                                    </div>

                                    <h5 class="fw-bold mb-2 text-dark">Payment Receipt Submitted!</h5>
                                    <p class="text-muted small mb-3">Your driver is currently inspecting the transaction reference and confirming your fare.</p>

                                    <div class="alert alert-light border py-2 px-3 small mx-auto text-start mb-4" style="max-width: 440px; border-radius:12px; background:#f8fafc;">
                                        <i class="fas fa-info-circle text-primary me-1"></i> <strong>What happens next:</strong> Once verified, your driver will mark the payment as confirmed and continue directly to your pickup location.
                                    </div>

                                    <div class="d-flex justify-content-center gap-2 flex-wrap">
                                        <button id="demoConfirmPayBtn" class="btn btn-outline-primary rounded-pill px-4">
                                            <i class="fas fa-bolt me-1"></i> Quick Test: Auto-Confirm Payment
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
        <script src="assets/js/app.js"></script>
        <script src="assets/js/ride-back-guard.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        $(document).ready(function() {
            const userId = <?=$_SESSION['user_id']?>;
            const bookingId = new URLSearchParams(window.location.search).get('id') || 0;

            const checkBookingStatus = setInterval(() => {
                $.ajax({
                    url: '../php/check-booking-status2.php',
                    method: 'GET',
                    data: { userId: userId, bookingId: bookingId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.data.length > 0) {
                            const bookingStatus = parseInt(response.data[0].status);
                            const bId = response.data[0].id || bookingId;

                            if (bookingStatus === 5) {
                                clearInterval(checkBookingStatus);
                                Swal.fire({
                                    title: 'Payment Confirmed!',
                                    text: 'Driver confirmed your payment. On the way to pickup!',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = 'client-6pickup.php?id=' + bId;
                                });
                            } else if (bookingStatus === 3) {
                                clearInterval(checkBookingStatus);
                                Swal.fire({
                                    title: 'Payment Rejected',
                                    text: 'Driver rejected payment proof. Please re-upload.',
                                    icon: 'error',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = 'client-4repayment.php?id=' + bId;
                                });
                            } else if (bookingStatus === 2) {
                                clearInterval(checkBookingStatus);
                                Swal.fire({
                                    title: 'Driver Cancelled',
                                    text: 'Driver cancelled. Searching for a new driver.',
                                    icon: 'warning',
                                    timer: 2000,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = 'client-3search-driver.php?id=' + bId;
                                });
                            } else if (bookingStatus >= 6) {
                                clearInterval(checkBookingStatus);
                                window.location.href = bookingStatus === 6 ? ('client-7dropoff.php?id=' + bId) : 'client-complete.php';
                            }
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking booking status:', error);
                    }
                });
            }, 3000);

            // Quick Test Auto-Confirm Payment button
            $('#demoConfirmPayBtn').on('click', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Confirming...');
                $.ajax({
                    url: '../php/demo-advance.php',
                    method: 'POST',
                    data: { step: 'confirm_payment', bookingId: bookingId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            clearInterval(checkBookingStatus);
                            Swal.fire({
                                title: 'Payment Confirmed!',
                                text: 'Driver confirmed payment. Proceeding to pickup!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'client-6pickup.php' + (bookingId ? ('?id=' + bookingId) : '');
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Auto-Confirm Payment');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Auto-Confirm Payment');
                    }
                });
            });
        });
        </script>
    </body>
</html>