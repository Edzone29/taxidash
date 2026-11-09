<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
        <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

        <style>
            #map {
                height: 420px;
                border-radius: 12px;
            }
            .booking-main-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .booking-card-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 24px 20px;
                color: #fff;
                text-align: center;
            }
            .loc-input-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 14px;
                padding: 16px;
                margin-bottom: 18px;
                transition: border-color 0.2s, box-shadow 0.2s;
            }
            .loc-input-card:focus-within {
                border-color: #3bafda;
                box-shadow: 0 0 0 3px rgba(59,175,218,0.15);
                background: #ffffff;
            }
            .loc-icon-pill {
                width: 38px;
                height: 38px;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                font-size: 1rem;
            }
            .btn-book-action {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                border: none;
                color: #ffffff;
                font-weight: 700;
                font-size: 1.05rem;
                padding: 14px;
                border-radius: 14px;
                letter-spacing: 0.5px;
                transition: transform 0.2s, box-shadow 0.2s;
                box-shadow: 0 6px 18px rgba(30,60,114,0.3);
            }
            .btn-book-action:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(30,60,114,0.4);
                color: #ffffff;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Book a Ride - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Book a Ride')); ?>

                        <!-- Booking Stepper -->
                        <?php 
                        $currentStep = 1; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <?php
                        include '../php/conn.php';
                        $uId = intval($_SESSION['user_id'] ?? 0);
                        $ongoing = null;
                        if ($uId > 0) {
                            $oq = mysqli_query($conn, "SELECT id, status, pickup_location, dropoff_location FROM temp_ride_bookings WHERE user_id = $uId AND status BETWEEN 2 AND 6 ORDER BY id DESC LIMIT 1");
                            if ($oq && $orow = mysqli_fetch_assoc($oq)) {
                                $ongoing = $orow;
                                $ost = intval($ongoing['status']);
                                $ourl = 'client-dashboard.php';
                                if ($ost === 2) $ourl = 'client-3search-driver.php?id=' . $ongoing['id'];
                                elseif ($ost === 3) $ourl = 'client-4payment.php?id=' . $ongoing['id'];
                                elseif ($ost === 4) $ourl = 'client-5confirmpayment.php?id=' . $ongoing['id'];
                                elseif ($ost === 5) $ourl = 'client-6pickup.php?id=' . $ongoing['id'];
                                elseif ($ost === 6) $ourl = 'client-7dropoff.php?id=' . $ongoing['id'];
                                $ongoing['url'] = $ourl;
                            }
                        }
                        ?>

                        <?php if ($ongoing): ?>
                        <div class="col-xl-6 col-lg-8 col-md-10 mx-auto mb-4">
                            <div class="card border-0 shadow-sm" style="border-radius:16px; background:linear-gradient(135deg, #064e3b, #047857); color:#fff;">
                                <div class="card-body p-3 d-flex align-items-center justify-content-between flex-wrap gap-2">
                                    <div>
                                        <span class="badge bg-danger rounded-pill px-3 py-1 mb-1 fw-bold">Active Ride In Progress</span>
                                        <div class="small text-white-50">Heading to: <strong class="text-white"><?=htmlspecialchars($ongoing['dropoff_location'])?></strong></div>
                                    </div>
                                    <div class="d-flex gap-2">
                                        <a href="<?=$ongoing['url']?>" class="btn btn-warning btn-sm fw-bold px-3 shadow">
                                            <i class="fas fa-play me-1"></i> Resume Trip
                                        </a>
                                        <button type="button" id="cancelOngoingRideBtn" class="btn btn-outline-light btn-sm">
                                            Cancel &amp; Book New
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endif; ?>

                        <div class="col-xl-6 col-lg-8 col-md-10 mx-auto">
                            <div class="card booking-main-card">
                                <div class="booking-card-header">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:58px; height:58px;">
                                        <i class="fas fa-taxi fa-2x text-white"></i>
                                    </div>
                                    <h4 class="fw-bold mb-1 text-white">Where are you going?</h4>
                                    <p class="mb-0 text-white-50 small">Select your pickup and drop-off points to calculate your fare</p>
                                </div>

                                <div class="card-body p-4">
                                    <form id="rideBookingForm">
                                        <!-- Pickup Section -->
                                        <div class="loc-input-card">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="loc-icon-pill bg-success bg-opacity-10 text-success">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                                <div>
                                                    <label for="pickupLocation" class="fw-bold text-dark mb-0 small text-uppercase" style="letter-spacing:0.5px;">Pickup Point</label>
                                                    <small class="text-muted d-block" style="font-size:0.75rem;">Where the driver will meet you</small>
                                                </div>
                                            </div>
                                            <input type="text" id="pickupLocation" class="form-control bg-white fw-semibold mb-2" placeholder="Tap 'Select on Map' or 'Current Location'" readonly required>
                                            <div class="d-flex gap-2 flex-wrap">
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" onclick="openPickupMapModal()">
                                                    <i class="fas fa-map-marked-alt me-1"></i> Select on Map
                                                </button>
                                                <button type="button" class="btn btn-light btn-sm rounded-pill px-3 border" onclick="useCurrentPickupLocation()">
                                                    <i class="fas fa-crosshairs text-primary me-1"></i> My GPS Location
                                                </button>
                                            </div>
                                            <input type="hidden" id="pickupLat">
                                            <input type="hidden" id="pickupLng">
                                        </div>

                                        <!-- Drop-off Section -->
                                        <div class="loc-input-card">
                                            <div class="d-flex align-items-center gap-2 mb-2">
                                                <div class="loc-icon-pill bg-danger bg-opacity-10 text-danger">
                                                    <i class="fas fa-flag-checkered"></i>
                                                </div>
                                                <div>
                                                    <label for="dropoffLocation" class="fw-bold text-dark mb-0 small text-uppercase" style="letter-spacing:0.5px;">Drop-off Destination</label>
                                                    <small class="text-muted d-block" style="font-size:0.75rem;">Where you want to go</small>
                                                </div>
                                            </div>
                                            <input type="text" id="dropoffLocation" class="form-control bg-white fw-semibold mb-2" placeholder="Tap 'Select Destination on Map'" readonly required>
                                            <div>
                                                <button type="button" class="btn btn-outline-danger btn-sm rounded-pill px-3" onclick="openDropoffMapModal()">
                                                    <i class="fas fa-map-pin me-1"></i> Select Destination on Map
                                                </button>
                                            </div>
                                            <input type="hidden" id="dropoffLat">
                                            <input type="hidden" id="dropoffLng">
                                        </div>

                                        <!-- Hidden Ride Type (Default standard) -->
                                        <div class="form-group collapse">
                                            <label for="rideType">Ride Type</label>
                                            <select id="rideType" class="form-control">
                                                <option selected value="standard">Standard</option>
                                                <option value="premium">Premium</option>
                                                <option value="shared">Shared</option>
                                            </select>
                                        </div>

                                        <!-- Transparent Fare Badge -->
                                        <div class="alert alert-light border py-2 px-3 small d-flex align-items-center justify-content-between mb-4" style="border-radius:12px; background:#f8fafc;">
                                            <span class="text-muted"><i class="fas fa-shield-alt text-primary me-1"></i> Transparent TaxiDash Rates:</span>
                                            <span class="fw-bold text-dark">Base &#8369;50.00 + &#8369;15.00/km</span>
                                        </div>

                                        <!-- Submit Button -->
                                        <button type="submit" class="btn btn-book-action btn-block w-100">
                                            <i class="fas fa-check-circle me-2"></i> Review Fare &amp; Proceed
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include 'partials/footer.php'; ?>
            </div>
        </div>

        <!-- Map Modal for Pickup and Drop-off Locations -->
        <div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3c72, #3bafda);">
                        <h5 class="modal-title text-white fw-bold" id="mapModalLabel"><i class="fas fa-map-marker-alt me-2"></i>Select Location</h5>
                        <button type="button" class="close text-white" data-dismiss="modal" aria-label="Close" style="opacity:0.85;">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body p-3">
                        <p class="text-muted small mb-2"><i class="fas fa-info-circle text-primary me-1"></i> Drag the marker or tap anywhere on the map to choose your exact point.</p>
                        <div id="map"></div>
                    </div>
                    <div class="modal-footer border-0 bg-light p-3">
                        <button type="button" class="btn btn-light rounded-pill px-4" data-dismiss="modal">Cancel</button>
                        <button type="button" class="btn btn-primary rounded-pill px-4 fw-bold" onclick="confirmLocation()">
                            <i class="fas fa-check me-1"></i> Confirm Location
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
        <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script src="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.js"></script>

        <script>
        $(document).ready(function() {
            $('form').on('submit', function(event) {
                event.preventDefault();

                const pickup = $('#pickupLocation').val().trim();
                const dropoff = $('#dropoffLocation').val().trim();

                if (!pickup) {
                    Swal.fire('Pickup Required', 'Please set your pickup location.', 'warning');
                    return;
                }
                if (!dropoff) {
                    Swal.fire('Drop-off Required', 'Please set your destination.', 'warning');
                    return;
                }

                const formData = {
                    user_id: <?php echo $_SESSION['user_id']; ?>,
                    pickupLocation: $('#pickupLocation').val(),
                    pickupLat: $('#pickupLat').val(),
                    pickupLng: $('#pickupLng').val(),
                    dropoffLocation: $('#dropoffLocation').val(),
                    dropoffLat: $('#dropoffLat').val(),
                    dropoffLng: $('#dropoffLng').val(),
                    rideType: $('#rideType').val()
                };

                Swal.fire({
                    title: 'Confirm Trip Details?',
                    text: 'Proceed to fare calculation & booking review?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#1e3c72',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, proceed!',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../php/save-ride.php',
                            type: 'POST',
                            data: formData,
                            dataType: 'json',
                            success: function(response) {
                                Swal.fire({
                                    title: 'Trip Saved!',
                                    text: 'Calculating route and fare...',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = 'client-2proceed-booking.php';
                                });
                            },
                            error: function(xhr, status, error) {
                                console.error('Error saving booking:', error);
                                Swal.fire('Error', 'Unable to save booking. Please try again.', 'error');
                            }
                        });
                    }
                });
            });

            $('#cancelOngoingRideBtn').on('click', function() {
                Swal.fire({
                    title: 'Cancel Ongoing Ride?',
                    text: 'This will cancel your current ride and let you book a new one.',
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, Cancel Ride',
                    cancelButtonText: 'Keep Current Ride'
                }).then((res) => {
                    if (res.isConfirmed) {
                        $.ajax({
                            url: '../php/cancel-booking.php',
                            method: 'POST',
                            data: { userId: <?=$uId?> },
                            dataType: 'json',
                            success: function() {
                                window.location.reload();
                            }
                        });
                    }
                });
            });
        });

        let map, marker, currentField;

        function openPickupMapModal() {
            openMapModal('pickup');
        }

        function openDropoffMapModal() {
            openMapModal('dropoff');
        }

        function openMapModal(field) {
            currentField = field;
            $('#mapModalLabel').html(field === 'pickup' ? '<i class="fas fa-map-marker-alt me-2 text-success"></i>Select Pickup Point' : '<i class="fas fa-flag-checkered me-2 text-danger"></i>Select Drop-off Destination');
            $('#mapModal').modal('show');

            setTimeout(() => {
                const defaultLat = 14.5995;
                const defaultLng = 120.9842;

                if (!map) {
                    map = L.map('map').setView([defaultLat, defaultLng], 13);
                    L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19
                    }).addTo(map);

                    marker = L.marker([defaultLat, defaultLng], { draggable: true }).addTo(map);

                    L.Control.geocoder().addTo(map);

                    map.on('click', function(e) {
                        marker.setLatLng(e.latlng);
                    });
                } else {
                    map.invalidateSize();
                }
            }, 300);
        }

        function confirmLocation() {
            if (marker) {
                const { lat, lng } = marker.getLatLng();

                fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                    .then(response => response.json())
                    .then(data => {
                        const address = data.display_name || `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
                        if (currentField === 'pickup') {
                            document.getElementById('pickupLocation').value = address;
                            document.getElementById('pickupLat').value = lat;
                            document.getElementById('pickupLng').value = lng;
                        } else if (currentField === 'dropoff') {
                            document.getElementById('dropoffLocation').value = address;
                            document.getElementById('dropoffLat').value = lat;
                            document.getElementById('dropoffLng').value = lng;
                        }
                        $('#mapModal').modal('hide');
                    })
                    .catch(error => {
                        console.error('Error fetching address:', error);
                        const fallback = `Point (${lat.toFixed(5)}, ${lng.toFixed(5)})`;
                        if (currentField === 'pickup') {
                            document.getElementById('pickupLocation').value = fallback;
                            document.getElementById('pickupLat').value = lat;
                            document.getElementById('pickupLng').value = lng;
                        } else {
                            document.getElementById('dropoffLocation').value = fallback;
                            document.getElementById('dropoffLat').value = lat;
                            document.getElementById('dropoffLng').value = lng;
                        }
                        $('#mapModal').modal('hide');
                    });
            }
        }

        function useCurrentPickupLocation() {
            if (navigator.geolocation) {
                navigator.geolocation.getCurrentPosition(
                    (position) => {
                        const lat = position.coords.latitude;
                        const lng = position.coords.longitude;
                        document.getElementById('pickupLat').value = lat;
                        document.getElementById('pickupLng').value = lng;

                        fetch(`https://nominatim.openstreetmap.org/reverse?format=jsonv2&lat=${lat}&lon=${lng}`)
                            .then(response => response.json())
                            .then(data => {
                                document.getElementById('pickupLocation').value = data.display_name || `Lat: ${lat.toFixed(5)}, Lng: ${lng.toFixed(5)}`;
                            })
                            .catch(() => {
                                document.getElementById('pickupLocation').value = `Current Location (${lat.toFixed(5)}, ${lng.toFixed(5)})`;
                            });
                    },
                    (error) => {
                        Swal.fire('GPS Error', 'Please enable location access in your device settings.', 'warning');
                    }
                );
            } else {
                Swal.fire('Notice', 'Geolocation is not supported by your browser.', 'warning');
            }
        }
        </script>
    </body>
</html>