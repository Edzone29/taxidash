<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <style>
            #map {
                height: 380px;
                width: 100%;
                border-radius: 14px;
            }
            .trip-transit-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .trip-transit-header {
                background: linear-gradient(135deg, #059669, #10b981);
                padding: 22px 20px;
                color: #fff;
                text-align: center;
            }
            .transit-info-pill {
                display: inline-flex;
                align-items: center;
                gap: 8px;
                background: rgba(255,255,255,0.2);
                padding: 6px 16px;
                border-radius: 20px;
                font-size: 0.85rem;
                margin-top: 8px;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'In Transit - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Trip in Progress')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 6; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-7 col-lg-8 col-md-10 mx-auto mb-5">
                            <div id="bookingCard" class="card trip-transit-card">
                                <div class="trip-transit-header">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                        <i class="fas fa-route fa-2x text-white"></i>
                                    </div>
                                    <h4 class="card-title text-white mb-0">On the Way to Destination</h4>
                                    <div class="transit-info-pill text-white">
                                        <i class="fas fa-car-side"></i> Sit back and relax while your driver completes the trip
                                    </div>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Map -->
                                    <div class="mb-3">
                                        <div id="map"></div>
                                    </div>

                                    <!-- Route Details -->
                                    <div class="p-3 bg-light rounded-3 mb-4 border">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span class="text-muted small text-uppercase fw-bold">Live Route</span>
                                            <span id="price" class="badge bg-success text-white px-3 py-1 fw-bold fs-6">&#8369;50.00</span>
                                        </div>
                                        <div class="text-truncate mb-1"><i class="fas fa-map-marker-alt text-success me-2"></i><strong id="pickupLocation">Pickup: Loading...</strong></div>
                                        <div class="text-truncate"><i class="fas fa-flag-checkered text-danger me-2"></i><strong id="dropoffLocation">Destination: Loading...</strong></div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <button class="btn btn-outline-primary w-100 rounded-pill py-2" id="dsa">
                                            <i class="fas fa-location-arrow me-2"></i> Open in Google Maps Navigation
                                        </button>
                                        <button class="btn btn-outline-danger w-100 rounded-pill fw-bold" data-bs-toggle="modal" data-bs-target="#sosModal">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Emergency SOS
                                        </button>
                                        <button id="demoDropoffBtn" class="btn btn-outline-secondary btn-sm w-100 rounded-pill mt-1">
                                            <i class="fas fa-bolt me-1"></i> Quick Test: Complete Drop-off
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

        <!-- SOS Modal -->
        <div class="modal fade" id="sosModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Emergency SOS Assistance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <i class="fas fa-shield-alt fa-3x text-danger mb-3"></i>
                        <h5 class="fw-bold text-dark">Need Immediate Assistance?</h5>
                        <p class="text-muted small">Choose your emergency action:</p>
                        <div class="d-grid gap-2 mt-3">
                            <a href="tel:911" class="btn btn-danger btn-lg fw-bold rounded-pill">
                                <i class="fas fa-phone-alt me-2"></i> Call National Emergency (911)
                            </a>
                            <button id="copyLocBtn" class="btn btn-outline-secondary rounded-pill">
                                <i class="fas fa-share-alt me-1"></i> Share Live Location Link
                            </button>
                            <button id="triggerAdminSosBtn" class="btn btn-outline-danger btn-sm rounded-pill">
                                <i class="fas fa-bell me-1"></i> Send Silent Alert to TaxiDash Admin
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="assets/js/ride-back-guard.js"></script>

        <script>
        $(document).ready(function () {
            const userId = <?=$_SESSION['user_id']?>;
            let bookingId = parseInt(new URLSearchParams(window.location.search).get('id') || 0);

            // Check dropoff status every 3.5 seconds
            const checkBookingStatus = setInterval(() => {
                $.ajax({
                    url: '../php/check-dropoff-status.php',
                    method: 'GET',
                    data: { userId: userId, bookingId: bookingId },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success' && response.data.length > 0) {
                            clearInterval(checkBookingStatus);
                            Swal.fire({
                                title: 'Trip Complete!',
                                text: 'You have safely arrived at your destination.',
                                icon: 'success',
                                timer: 2000,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'client-complete.php';
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error checking dropoff status:', error);
                    }
                });
            }, 3500);

            let map, driverMarker;
            let currentBooking = null;

            function fetchBookingDetails() {
                $.ajax({
                    url: '../php/get-client-dropoff-details.php?id=' + userId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            const booking = response.data;
                            currentBooking = booking;
                            if (!bookingId) bookingId = booking.id;

                            $('#pickupLocation').text(`Pickup: ${booking.pickup_location}`);
                            $('#dropoffLocation').text(`Drop-off: ${booking.dropoff_location}`);
                            $('#price').html(`&#8369;${parseFloat(booking.price || 50).toFixed(2)}`);

                            const dLat = parseFloat(booking.dropoff_lat) || 14.5995;
                            const dLng = parseFloat(booking.dropoff_lng) || 120.9842;
                            const curLat = parseFloat(booking.drvLoc_lat) || dLat;
                            const curLng = parseFloat(booking.drvLoc_lng) || dLng;

                            if (!map) {
                                map = L.map('map').setView([curLat, curLng], 13);
                                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                                L.marker([curLat, curLng]).addTo(map).bindPopup('<b>Taxi Location</b>').openPopup();
                                L.marker([dLat, dLng]).addTo(map).bindPopup('<b>Drop-off Point</b>');

                                const bounds = L.latLngBounds([[curLat, curLng], [dLat, dLng]]);
                                map.fitBounds(bounds, { padding: [30, 30] });
                            }

                            $('#dsa').off('click').on('click', function () {
                                window.open(`https://www.google.com/maps/dir/?api=1&destination=${dLat},${dLng}`, '_blank');
                            });
                        }
                    }
                });
            }

            fetchBookingDetails();

            // Quick Test: Complete Dropoff button
            $(document).on('click', '#demoDropoffBtn', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Completing...');
                $.ajax({
                    url: '../php/demo-advance.php',
                    method: 'POST',
                    data: { step: 'confirm_dropoff', bookingId: bookingId },
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            Swal.fire({
                                title: 'Arrived at Destination!',
                                text: 'Trip completed safely. Thank you for riding!',
                                icon: 'success',
                                timer: 1500,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'client-complete.php';
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Complete Drop-off');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Complete Drop-off');
                    }
                });
            });

            // SOS Buttons
            $('#copyLocBtn').on('click', function() {
                if (navigator.geolocation) {
                    navigator.geolocation.getCurrentPosition((pos) => {
                        const link = `https://www.google.com/maps?q=${pos.coords.latitude},${pos.coords.longitude}`;
                        navigator.clipboard.writeText(link).then(() => {
                            Swal.fire('Location Copied', 'GPS link copied to clipboard.', 'success');
                        });
                    });
                }
            });

            $('#triggerAdminSosBtn').on('click', function() {
                const btn = $(this);
                btn.prop('disabled', true).text('Dispatching SOS...');
                $.ajax({
                    url: '../php/submit-sos.php',
                    method: 'POST',
                    data: { booking_id: bookingId },
                    dataType: 'json',
                    success: function(resp) {
                        Swal.fire('SOS Dispatched', resp.message || 'TaxiDash Admin alerted.', 'warning');
                        btn.prop('disabled', false).html('<i class="fas fa-bell me-1"></i> Send Silent Alert to TaxiDash Admin');
                    },
                    error: function() {
                        Swal.fire('Error', 'Unable to send SOS. Please dial 911 directly.', 'error');
                        btn.prop('disabled', false).html('<i class="fas fa-bell me-1"></i> Send Silent Alert to TaxiDash Admin');
                    }
                });
            });
        });
        </script>
    </body>
</html>