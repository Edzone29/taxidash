<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
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
                height: 320px;
                width: 100%;
                border-radius: 14px;
            }
            .pickup-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .pickup-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 22px 20px;
                color: #fff;
                text-align: center;
            }
            .driver-profile-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 18px;
                margin-bottom: 20px;
            }
            .driver-avatar {
                width: 72px;
                height: 72px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #10b981;
                box-shadow: 0 4px 12px rgba(16,185,129,0.25);
            }
            #messageContainer {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Driver on the Way - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Waiting for Pickup')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 5; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-7 col-lg-8 col-md-10 mx-auto mb-5">
                            <div id="bookingCard" class="card pickup-card">
                                <div class="pickup-header">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                        <i class="fas fa-taxi fa-2x text-white"></i>
                                    </div>
                                    <h4 class="card-title text-white mb-1">Driver is Heading to You!</h4>
                                    <p class="mb-0 text-white-50 small">Track your driver in real-time as they approach your pickup spot</p>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Hidden state inputs -->
                                    <input type="hidden" id="clid" value="<?php echo isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : ''; ?>">
                                    <input type="hidden" id="bkid" value="<?php echo $bookingIdParam > 0 ? $bookingIdParam : ''; ?>">
                                    <input type="hidden" id="drid">
                                    <input type="hidden" id="prc">

                                    <!-- Driver Info -->
                                    <div class="driver-profile-card">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img id="driverpic" src="../taxi.jpg" alt="Driver" class="driver-avatar">
                                                <div>
                                                    <h5 id="driverName" class="fw-bold text-dark mb-1">Locating driver...</h5>
                                                    <div id="driverRatingBadge" class="mb-1">
                                                        <span class="badge bg-warning text-dark px-2 py-1 rounded-pill"><i class="fas fa-star me-1"></i>5.0</span>
                                                    </div>
                                                    <div class="small text-muted">
                                                        <span id="plate" class="badge bg-secondary me-2">Plate: Loading...</span>
                                                        <span id="driverContact"><i class="fas fa-phone me-1"></i>Contact</span>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="mlm" data-bs-toggle="modal" data-bs-target="#messageModal" data-toggle="modal" data-target="#messageModal">
                                                    <i class="fas fa-comment-dots me-1"></i> Message
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" id="callDriverBtn">
                                                    <i class="fas fa-phone-alt me-1"></i> Call
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Live Map -->
                                    <div class="mb-3">
                                        <div id="map"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                            <span id="est" class="badge bg-primary bg-opacity-10 text-primary py-2 px-3 fw-bold"><i class="fas fa-stopwatch me-1"></i>Calculating estimated arrival...</span>
                                            <span class="badge bg-success bg-opacity-10 text-success py-2 px-3 fw-bold" id="price">Fare Paid: &#8369;50.00</span>
                                        </div>
                                    </div>

                                    <!-- Locations text -->
                                    <div class="p-3 bg-light rounded-3 mb-4 small border">
                                        <div class="text-truncate mb-1"><i class="fas fa-map-marker-alt text-success me-2"></i><strong id="pickupLocation">Pickup: Loading...</strong></div>
                                        <div class="text-truncate"><i class="fas fa-flag-checkered text-danger me-2"></i><strong id="dropoffLocation">Destination: Loading...</strong></div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="d-grid gap-2">
                                        <button type="button" class="btn btn-outline-danger w-100 fw-bold rounded-pill" data-bs-toggle="modal" data-bs-target="#sosModal">
                                            <i class="fas fa-exclamation-triangle me-1"></i> Emergency SOS
                                        </button>
                                        <button type="button" id="demoPickupBtn" class="btn btn-outline-secondary btn-sm w-100 rounded-pill">
                                            <i class="fas fa-bolt me-1"></i> Quick Test: Complete Pickup
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

        <!-- Chat Modal -->
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3c72, #3bafda);">
                        <h5 class="modal-title text-white fw-bold" id="messageModalLabel"><i class="fas fa-comments me-2"></i>Live Chat</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="messageContainer" class="p-3" style="max-height: 380px; overflow-y: auto; background-color: #f8fafc; min-height: 220px;">
                        <div class="text-center text-muted py-4"><i class="fas fa-spinner fa-spin me-1"></i> Loading messages...</div>
                    </div>
                    <div class="modal-footer bg-white p-2">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control rounded-pill me-2" placeholder="Type message to driver...">
                            <button id="sendMessageButton" type="button" class="btn btn-primary rounded-circle" style="width:42px; height:42px;">
                                <i class="fas fa-paper-plane"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- SOS Modal -->
        <div class="modal fade" id="sosModal" tabindex="-1" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header bg-danger text-white">
                        <h5 class="modal-title text-white fw-bold"><i class="fas fa-exclamation-triangle me-2"></i>Emergency SOS Assistance</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body p-4 text-center">
                        <i class="fas fa-shield-alt text-danger fa-4x mb-3"></i>
                        <h5 class="fw-bold text-dark">Need Immediate Help?</h5>
                        <p class="text-muted small">If you feel unsafe or are in an emergency, contact emergency hotlines or send an urgent alert to TaxiDash safety monitoring.</p>
                        
                        <div class="d-grid gap-2 mt-4">
                            <a href="tel:911" class="btn btn-danger btn-lg fw-bold rounded-pill">
                                <i class="fas fa-phone-alt me-2"></i> Call 911 Emergency
                            </a>
                            <button id="dispatchSosBtn" class="btn btn-outline-danger rounded-pill fw-bold">
                                <i class="fas fa-bell me-2"></i> Alert TaxiDash Admin Dispatch
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
            let activeBooking = null;

            function degreesToRadians(degrees) {
                return degrees * (Math.PI / 180);
            }

            function fetchBookingDetails() {
                const urlParams = new URLSearchParams(window.location.search);
                const bookingIdParam = urlParams.get('id') || $('#bkid').val();

                $.ajax({
                    url: '../php/get-client-pickup-details.php' + (bookingIdParam ? '?id=' + bookingIdParam : ''),
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.status === 'success') {
                            const booking = response.data;
                            activeBooking = booking;

                            $('#clid').val(booking.user_id);
                            $('#drid').val(booking.driver_id);
                            $('#bkid').val(booking.id);

                            $('#pickupLocation').text(`Pickup: ${booking.pickup_location}`);
                            $('#dropoffLocation').text(`Drop-off: ${booking.dropoff_location}`);
                            $('#price').html(`Fare Paid: &#8369;${parseFloat(booking.price || 50).toFixed(2)}`);

                            const drvLat = parseFloat(booking.drvLoc_lat) || 14.5995;
                            const drvLng = parseFloat(booking.drvLoc_lng) || 120.9842;
                            const pLat = parseFloat(booking.pickup_lat) || drvLat;
                            const pLng = parseFloat(booking.pickup_lng) || drvLng;

                            const map = L.map('map').setView([drvLat, drvLng], 13);
                            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                            const taxiIcon = L.divIcon({
                                className: 'taxi-marker',
                                html: '<div style="background:#1e3c72; color:#fff; width:36px; height:36px; border-radius:50%; display:flex; align-items:center; justify-content:center; box-shadow:0 4px 10px rgba(0,0,0,0.3);"><i class="fas fa-taxi"></i></div>',
                                iconSize: [36, 36]
                            });

                            L.marker([drvLat, drvLng], { icon: taxiIcon }).addTo(map).bindPopup('<b>Driver</b>').openPopup();
                            L.marker([pLat, pLng]).addTo(map).bindPopup('<b>You</b>');

                            const bounds = L.latLngBounds([[drvLat, drvLng], [pLat, pLng]]);
                            map.fitBounds(bounds, { padding: [35, 35] });

                            const R = 6371;
                            const dLat = degreesToRadians(pLat - drvLat);
                            const dLon = degreesToRadians(pLng - drvLng);
                            const a = Math.sin(dLat / 2) ** 2 +
                                      Math.cos(degreesToRadians(drvLat)) *
                                      Math.cos(degreesToRadians(pLat)) *
                                      Math.sin(dLon / 2) ** 2;
                            const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                            const distance = R * c;
                            const estimatedTime = Math.max(1, Math.round(((distance / 35) * 60) + 1));

                            $('#est').html(`<i class="fas fa-stopwatch me-1"></i>Driver arriving in approx. ${estimatedTime} mins (${distance.toFixed(1)} km away)`);

                            fetch('../php/fetch_driver_details.php', {
                                method: 'POST',
                                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                                body: new URLSearchParams({ 'driver_id': booking.driver_id })
                            })
                            .then(res => res.json())
                            .then(data => {
                                if (data.success) {
                                    $('#driverName').text(data.fullname || 'Your Driver');
                                    if (data.rating) {
                                        $('#driverRatingBadge').html(`<span class="badge bg-warning text-dark px-2 py-1 rounded-pill"><i class="fas fa-star me-1"></i>${data.rating} / 5.0 (${data.rating_count} reviews)</span>`);
                                    }
                                    if (data.profile) {
                                        $('#driverpic').attr('src', 'uploads/' + data.profile);
                                    }
                                    $('#driverContact').html(`<i class="fas fa-phone me-1"></i>${data.contact}`);
                                    $('#plate').text(`Plate: ${data.plate || 'N/A'}`);
                                    $('#callDriverBtn').click(() => {
                                        window.location.href = `tel:${data.contact}`;
                                    });
                                }
                            });
                        }
                    }
                });
            }

            fetchBookingDetails();

            // ================= CHAT FUNCTIONALITY =================
            let fetchMessagesInterval;
            function fetchMessages() {
                const drvId = $('#drid').val();
                const uId = $('#clid').val();
                const bId = $('#bkid').val();

                if (!drvId || !uId) return;

                $.ajax({
                    url: '../php/fetch_message.php',
                    method: 'POST',
                    data: { driver_id: drvId, book_id: bId, user_id: uId },
                    success: function (resp) {
                        $('#messageContainer').html(resp);
                        const c = document.getElementById('messageContainer');
                        if (c) c.scrollTop = c.scrollHeight;
                    }
                });
            }

            function openChatModal() {
                const modalEl = document.getElementById('messageModal');
                if (modalEl) {
                    if (typeof bootstrap !== 'undefined' && bootstrap.Modal) {
                        const m = bootstrap.Modal.getOrCreateInstance(modalEl);
                        m.show();
                    } else if (typeof $().modal === 'function') {
                        $('#messageModal').modal('show');
                    }
                }
            }

            $(document).on('click', '#mlm, [data-bs-target="#messageModal"], [data-target="#messageModal"]', function (e) {
                e.preventDefault();
                openChatModal();
            });

            const msgModalEl = document.getElementById('messageModal');
            if (msgModalEl) {
                msgModalEl.addEventListener('shown.bs.modal', function () {
                    fetchMessages();
                    clearInterval(fetchMessagesInterval);
                    fetchMessagesInterval = setInterval(fetchMessages, 3000);
                    setTimeout(() => $('#messageInput').focus(), 300);
                });
                msgModalEl.addEventListener('hidden.bs.modal', function () {
                    clearInterval(fetchMessagesInterval);
                });
            }
            $('#messageModal').on('show.bs.modal shown.bs.modal', function () {
                fetchMessages();
                clearInterval(fetchMessagesInterval);
                fetchMessagesInterval = setInterval(fetchMessages, 3000);
            });
            $('#messageModal').on('hide.bs.modal hidden.bs.modal', function () {
                clearInterval(fetchMessagesInterval);
            });

            function sendMessage() {
                const msg = $('#messageInput').val().trim();
                const drvId = $('#drid').val();
                const uId = $('#clid').val();
                const bId = $('#bkid').val();

                if (!msg) return;

                $.ajax({
                    url: '../php/send_message.php',
                    method: 'POST',
                    data: { driver_id: drvId, user_id: uId, book_id: bId, message: msg },
                    success: function () {
                        $('#messageInput').val('');
                        fetchMessages();
                    }
                });
            }

            $('#sendMessageButton').on('click', sendMessage);
            $('#messageInput').on('keypress', function (e) {
                if (e.which === 13) {
                    e.preventDefault();
                    sendMessage();
                }
            });

            // Quick Test: Complete Pickup button
            $(document).on('click', '#demoPickupBtn', function() {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Completing...');
                $.ajax({
                    url: '../php/demo-advance.php',
                    method: 'POST',
                    data: {
                        action: 'advance_to_pickup',
                        bookingId: $('#bkid').val() || (new URLSearchParams(window.location.search)).get('id')
                    },
                    dataType: 'json',
                    success: function(resp) {
                        if (resp.status === 'success') {
                            Swal.fire({
                                title: 'Picked Up!',
                                text: 'Ride has started. Navigating to trip destination.',
                                icon: 'success',
                                timer: 1200,
                                showConfirmButton: false
                            }).then(() => {
                                window.location.href = 'client-7dropoff.php' + (resp.bookingId ? '?id=' + resp.bookingId : '');
                            });
                        } else {
                            btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Complete Pickup');
                            Swal.fire('Error', resp.message || 'Unable to advance.', 'error');
                        }
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-bolt me-1"></i> Quick Test: Complete Pickup');
                        Swal.fire('Error', 'Request failed.', 'error');
                    }
                });
            });

            // Dispatch SOS alert
            $('#dispatchSosBtn').click(function () {
                const btn = $(this);
                btn.prop('disabled', true).html('<i class="fas fa-spinner fa-spin me-1"></i> Sending Alert...');
                $.ajax({
                    url: '../php/submit-sos.php',
                    method: 'POST',
                    data: {
                        bookingId: $('#bkid').val() || (new URLSearchParams(window.location.search)).get('id'),
                        userId: $('#clid').val()
                    },
                    dataType: 'json',
                    success: function(resp) {
                        btn.prop('disabled', false).html('<i class="fas fa-bell me-2"></i> Alert TaxiDash Admin Dispatch');
                        $('#sosModal').modal('hide');
                        Swal.fire('SOS Dispatched', resp.message || 'TaxiDash Admin alerted.', 'warning');
                    },
                    error: function() {
                        btn.prop('disabled', false).html('<i class="fas fa-bell me-2"></i> Alert TaxiDash Admin Dispatch');
                        Swal.fire('Alert Sent', 'Emergency services notified.', 'info');
                    }
                });
            });

            // Polling: ONLY redirect if pickup confirmed
            const urlParams = new URLSearchParams(window.location.search);
            const currentBkid = urlParams.get('id') || $('#bkid').val();
            const pickupPoller = setInterval(() => {
                const targetId = $('#bkid').val() || currentBkid;
                $.ajax({
                    url: '../php/check-pickup-status.php' + (targetId ? '?bookingId=' + targetId : ''),
                    method: 'GET',
                    dataType: 'json',
                    success: function (res) {
                        if (res.status === 'success' && res.data && res.data.length > 0) {
                            const ride = res.data[0];
                            if (parseInt(ride.status) === 6) {
                                clearInterval(pickupPoller);
                                Swal.fire({
                                    title: 'Picked Up!',
                                    text: 'You have been picked up. Enjoy your ride!',
                                    icon: 'success',
                                    timer: 1500,
                                    showConfirmButton: false
                                }).then(() => {
                                    window.location.href = 'client-7dropoff.php?id=' + ride.id;
                                });
                            }
                        }
                    }
                });
            }, 4000);
        });
        </script>
    </body>
</html>
