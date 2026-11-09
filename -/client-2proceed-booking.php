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
                height: 340px;
                width: 100%;
                border-radius: 14px;
            }
            .proceed-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .proceed-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 22px 20px;
                color: #fff;
                text-align: center;
            }
            .fare-badge-box {
                background: linear-gradient(135deg, #f0fdf4, #dcfce7);
                border: 2px solid #86efac;
                border-radius: 14px;
                padding: 16px 20px;
                text-align: center;
                margin-bottom: 20px;
            }
            .route-info-box {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px;
                margin-bottom: 20px;
            }
            .btn-confirm-action {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                border: none;
                color: #ffffff;
                font-weight: 700;
                font-size: 1.05rem;
                padding: 14px;
                border-radius: 14px;
                letter-spacing: 0.5px;
                box-shadow: 0 6px 18px rgba(30,60,114,0.3);
                transition: transform 0.2s, box-shadow 0.2s;
            }
            .btn-confirm-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(30,60,114,0.4);
                color: #ffffff;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Review Booking - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Review Booking')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 2; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-6 col-lg-8 col-md-10 mx-auto mb-5">
                            <div id="bookingCard" class="card proceed-card">
                                <div class="proceed-header">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                        <i class="fas fa-file-invoice-dollar fa-2x text-white"></i>
                                    </div>
                                    <h4 class="card-title text-white mb-1">Trip Summary &amp; Fare</h4>
                                    <p class="mb-0 text-white-50 small">Review route and confirm your ride request</p>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Interactive Route Map -->
                                    <div class="mb-3">
                                        <div id="map"></div>
                                    </div>

                                    <!-- Route Details -->
                                    <div class="route-info-box">
                                        <div class="d-flex align-items-start gap-2 mb-2">
                                            <i class="fas fa-map-marker-alt text-success mt-1"></i>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">Pickup Location</small>
                                                <div id="pickupLocation" class="fw-semibold text-dark small">Loading...</div>
                                            </div>
                                        </div>
                                        <hr class="my-2">
                                        <div class="d-flex align-items-start gap-2">
                                            <i class="fas fa-flag-checkered text-danger mt-1"></i>
                                            <div>
                                                <small class="text-muted text-uppercase fw-bold" style="font-size:0.7rem;">Drop-off Destination</small>
                                                <div id="dropoffLocation" class="fw-semibold text-dark small">Loading...</div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Fare Box -->
                                    <div class="fare-badge-box">
                                        <span class="text-muted small text-uppercase fw-bold" style="letter-spacing:0.5px;">Estimated Total Fare</span>
                                        <h2 id="price" class="text-success fw-bold mb-0 my-1">&#8369;50.00</h2>
                                        <small id="distInfo" class="text-muted" style="font-size:0.8rem;">Base Fare: &#8369;50.00 &bull; &#8369;15.00/km</small>
                                    </div>

                                    <input type="hidden" id="prc">

                                    <!-- Payment Method -->
                                    <div class="mb-4">
                                        <label for="paymentMethod" class="form-label fw-bold small text-uppercase text-muted" style="letter-spacing:0.5px;">
                                            <i class="fas fa-wallet text-primary me-1"></i> Payment Method
                                        </label>
                                        <select id="paymentMethod" class="form-select border-primary py-2 fw-semibold">
                                            <option value="gcash" selected>GCash Transfer (Fast &amp; Cashless)</option>
                                            <option value="cash">Cash on Drop-off</option>
                                        </select>
                                    </div>

                                    <button id="confirmBooking" class="btn btn-confirm-action btn-block w-100 mb-2">
                                        <i class="fas fa-paper-plane me-2"></i> Confirm Booking &amp; Find Driver
                                    </button>

                                    <a href="client-1book.php" class="btn btn-light btn-block w-100 rounded-pill text-muted small py-2">
                                        <i class="fas fa-arrow-left me-1"></i> Change Route or Addresses
                                    </a>
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

        <script>
        $(document).ready(function() {
            $.ajax({
                url: '../php/get-latest-booking.php',
                method: 'GET',
                dataType: 'json',
                success: function(response) {
                    if (response.status === 'success') {
                        const booking = response.data;
                        $('#pickupLocation').text(booking.pickup_location || 'Pickup point selected');
                        $('#dropoffLocation').text(booking.dropoff_location || 'Drop-off point selected');

                        // Initialize Leaflet map
                        const pLat = parseFloat(booking.pickup_lat) || 14.5995;
                        const pLng = parseFloat(booking.pickup_lng) || 120.9842;
                        const dLat = parseFloat(booking.dropoff_lat) || (pLat + 0.02);
                        const dLng = parseFloat(booking.dropoff_lng) || (pLng + 0.02);

                        const map = L.map('map').setView([pLat, pLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                        L.marker([pLat, pLng]).addTo(map).bindPopup('<b>Pickup</b><br>' + booking.pickup_location).openPopup();
                        L.marker([dLat, dLng]).addTo(map).bindPopup('<b>Drop-off</b><br>' + booking.dropoff_location);

                        // Fit bounds to show both pins
                        const bounds = L.latLngBounds([ [pLat, pLng], [dLat, dLng] ]);
                        map.fitBounds(bounds, { padding: [40, 40] });

                        // Compute distance & price
                        const R = 6371;
                        const dLatRad = degreesToRadians(dLat - pLat);
                        const dLonRad = degreesToRadians(dLng - pLng);
                        const a = Math.sin(dLatRad/2) * Math.sin(dLatRad/2) +
                                  Math.cos(degreesToRadians(pLat)) * Math.cos(degreesToRadians(dLat)) *
                                  Math.sin(dLonRad/2) * Math.sin(dLonRad/2);
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                        const distance = Math.max(1, R * c);

                        const boardingFee = 50;
                        const perKmRate = 15;
                        const price = boardingFee + (perKmRate * distance);

                        $('#price').html('&#8369;' + price.toFixed(2));
                        $('#prc').val(price.toFixed(2));
                        $('#distInfo').text(`Approx. ${distance.toFixed(1)} km • Base: ₱50.00 + ₱15.00/km`);

                        // Confirm booking action
                        $('#confirmBooking').on('click', function() {
                            const paymentMethod = $('#paymentMethod').val();
                            const calculatedPrice = $('#prc').val();

                            Swal.fire({
                                title: 'Confirm Ride Booking?',
                                text: `Dispatch booking to nearby drivers for ₱${calculatedPrice}?`,
                                icon: 'question',
                                showCancelButton: true,
                                confirmButtonColor: '#1e3c72',
                                cancelButtonColor: '#d33',
                                confirmButtonText: 'Yes, Find Driver!',
                                cancelButtonText: 'Cancel'
                            }).then((result) => {
                                if (result.isConfirmed) {
                                    $('#confirmBooking').prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-2"></i> Connecting to Drivers...');
                                    $.ajax({
                                        url: '../php/confirm-booking.php',
                                        method: 'POST',
                                        data: { bookingId: booking.id, paymentMethod: paymentMethod, price: calculatedPrice },
                                        dataType: 'json',
                                        success: function(confirmResponse) {
                                            if (confirmResponse.status === 'success') {
                                                Swal.fire({
                                                    title: 'Booking Confirmed!',
                                                    text: 'Searching for the nearest TaxiDash driver...',
                                                    icon: 'success',
                                                    timer: 1500,
                                                    showConfirmButton: false
                                                }).then(() => {
                                                    window.location.href = 'client-3search-driver.php?id=' + booking.id;
                                                });
                                            } else {
                                                $('#confirmBooking').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Confirm Booking & Find Driver');
                                                Swal.fire('Error', confirmResponse.message, 'error');
                                            }
                                        },
                                        error: function() {
                                            $('#confirmBooking').prop('disabled', false).html('<i class="fas fa-paper-plane me-2"></i> Confirm Booking & Find Driver');
                                            Swal.fire('Error', 'Unable to confirm booking. Please try again.', 'error');
                                        }
                                    });
                                }
                            });
                        });
                    } else {
                        Swal.fire({
                            title: 'No Pending Booking',
                            text: 'Please set your pickup and destination first.',
                            icon: 'info'
                        }).then(() => {
                            window.location.href = 'client-1book.php';
                        });
                    }
                },
                error: function() {
                    Swal.fire('Error', 'Error fetching booking details. Please try again.', 'error');
                }
            });
        });

        function degreesToRadians(degrees) {
            return degrees * (Math.PI / 180);
        }
        </script>
    </body>
</html>