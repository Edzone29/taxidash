<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>
<?php
$bookingIdParam = isset($_GET['id']) ? intval($_GET['id']) : 0;
?>

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
            .dropoff-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .dropoff-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 22px 20px;
                color: #fff;
                text-align: center;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Drop-off Passenger - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'In-Transit to Destination')); ?>

                        <div class="row mb-4">
                            <div class="col-xl-7 col-lg-8 col-md-10 mx-auto">
                                <div id="bookingCard" class="card dropoff-card">
                                    <div class="dropoff-header">
                                        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                            <i class="fas fa-flag-checkered fa-2x text-white"></i>
                                        </div>
                                        <h4 class="card-title text-white mb-1">Heading to Drop-off Location</h4>
                                        <p class="mb-0 text-white-50 small">Passenger is on board. Drive safely to the destination.</p>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Map -->
                                        <div class="mb-3">
                                            <div id="map"></div>
                                        </div>

                                        <!-- Locations & Fare -->
                                        <div class="p-3 bg-light rounded-3 mb-4 small border">
                                            <div class="text-truncate mb-2"><i class="fas fa-map-marker-alt text-success me-2"></i><strong id="pickupLocation">Pickup: Loading...</strong></div>
                                            <div class="text-truncate mb-2"><i class="fas fa-flag-checkered text-danger me-2"></i><strong id="dropoffLocation">Destination: Loading...</strong></div>
                                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                                <span class="text-muted"><i class="fas fa-receipt me-1"></i>Trip Fare</span>
                                                <span class="fw-bold text-primary fs-6" id="price">&#8369;50.00</span>
                                            </div>
                                        </div>

                                        <input type="hidden" id="bkid" value="<?php echo $bookingIdParam > 0 ? $bookingIdParam : ''; ?>">
                                        <input type="hidden" id="prc">

                                        <!-- Actions -->
                                        <div class="d-grid gap-2">
                                            <button id="confirmBooking" type="button" class="btn btn-success btn-lg fw-bold rounded-pill">
                                                <i class="fas fa-check-circle me-2"></i> Complete Drop-off &amp; Finish Trip
                                            </button>
                                            <button class="btn btn-outline-info rounded-pill" type="button" id="dsa">
                                                <i class="fas fa-directions me-1"></i> Open Google Maps Navigation
                                            </button>
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

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="assets/js/app.js"></script>

        <script>
        $(document).ready(function () {
            let activeBooking = null;

            function degreesToRadians(degrees) {
                return degrees * (Math.PI / 180);
            }

            function getDirections(lat, lng) {
                window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
            }

            const urlParams = new URLSearchParams(window.location.search);
            const bId = urlParams.get('id') || $('#bkid').val();

            // Fetch dropoff booking details
            $.ajax({
                url: '../php/get-dropoff-details.php' + (bId ? '?id=' + bId : ''),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        const booking = response.data;
                        activeBooking = booking;

                        $('#bkid').val(booking.id);
                        $('#pickupLocation').text(`Pickup: ${booking.pickup_location}`);
                        $('#dropoffLocation').text(`Destination: ${booking.dropoff_location}`);

                        const price = Number(booking.price) || 50;
                        $('#price').html('&#8369;' + price.toFixed(2));
                        $('#prc').val(price.toFixed(2));

                        const pLat = parseFloat(booking.pickup_lat) || 14.5995;
                        const pLng = parseFloat(booking.pickup_lng) || 120.9842;
                        const dLat = parseFloat(booking.dropoff_lat) || pLat;
                        const dLng = parseFloat(booking.dropoff_lng) || pLng;

                        const map = L.map('map').setView([dLat, dLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                        L.marker([pLat, pLng]).addTo(map).bindPopup('<b>Pickup Point</b>');
                        L.marker([dLat, dLng]).addTo(map).bindPopup('<b>Drop-off Point</b>').openPopup();

                        const bounds = L.latLngBounds([[pLat, pLng], [dLat, dLng]]);
                        map.fitBounds(bounds, { padding: [35, 35] });

                        $('#dsa').click(function () {
                            getDirections(dLat, dLng);
                        });

                        // Geolocation tracking
                        function updateDriverLocation() {
                            if (navigator.geolocation && activeBooking) {
                                navigator.geolocation.getCurrentPosition(function (position) {
                                    const drvLocLng = position.coords.longitude;
                                    const drvLocLat = position.coords.latitude;

                                    $.ajax({
                                        url: 'update_driver_location.php',
                                        method: 'POST',
                                        data: { drvLocLng, drvLocLat, bookId: activeBooking.id }
                                    });
                                });
                            }
                        }
                        setInterval(updateDriverLocation, 6000);

                    } else {
                        Swal.fire({
                            title: 'Notice',
                            text: response.message || 'No active drop-off found.',
                            icon: 'info'
                        }).then(() => {
                            window.location.href = 'driver-dashboard.php';
                        });
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to retrieve drop-off details.', 'error');
                }
            });

            // Confirm Drop-off
            $('#confirmBooking').on('click', function () {
                if (!activeBooking) return;

                Swal.fire({
                    title: 'Complete Drop-off?',
                    text: 'Confirm that you have safely arrived and dropped off the passenger.',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#10b981',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, Complete Trip',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../php/confirm-dropoff.php',
                            method: 'POST',
                            data: {
                                bookingId: activeBooking.id,
                                price: $('#prc').val()
                            },
                            dataType: 'json',
                            success: function (confirmResponse) {
                                if (confirmResponse.status === 'success') {
                                    Swal.fire({
                                        title: 'Trip Completed!',
                                        text: 'You have safely dropped off the passenger.',
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = `driver-complete.php?id=${activeBooking.id}`;
                                    });
                                } else {
                                    Swal.fire('Error', confirmResponse.message || 'Failed to complete drop-off.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server request failed.', 'error');
                            }
                        });
                    }
                });
            });
        });
        </script>
    </body>
</html>
