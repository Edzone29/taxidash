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
            .passenger-profile-card {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 18px;
                margin-bottom: 20px;
            }
            .passenger-avatar {
                width: 64px;
                height: 64px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #3bafda;
                box-shadow: 0 4px 12px rgba(59,175,218,0.25);
            }
            #messageContainer {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Pickup Passenger - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Pickup Passenger')); ?>

                        <div class="row mb-4">
                            <div class="col-xl-7 col-lg-8 col-md-10 mx-auto">
                                <div id="bookingCard" class="card pickup-card">
                                    <div class="pickup-header">
                                        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                            <i class="fas fa-map-marker-alt fa-2x text-white"></i>
                                        </div>
                                        <h4 class="card-title text-white mb-1">En Route to Pickup Passenger</h4>
                                        <p class="mb-0 text-white-50 small">Navigate to the pickup location and confirm when passenger has boarded</p>
                                    </div>

                                    <div class="card-body p-4">
                                        <!-- Passenger Info Box -->
                                        <div class="passenger-profile-card">
                                            <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                                <div class="d-flex align-items-center gap-3">
                                                    <img id="passengerPic" src="../taxi.jpg" alt="Passenger" class="passenger-avatar">
                                                    <div>
                                                        <h5 id="driverName" class="fw-bold text-dark mb-1">Loading passenger...</h5>
                                                        <div class="small text-muted" id="driverContact"><i class="fas fa-phone me-1"></i>Contact: Loading...</div>
                                                    </div>
                                                </div>

                                                <div class="d-flex gap-2">
                                                    <button type="button" class="btn btn-outline-primary btn-sm rounded-pill px-3" id="mlm" data-bs-toggle="modal" data-bs-target="#messageModal">
                                                        <i class="fas fa-comment-dots me-1"></i> Message
                                                    </button>
                                                    <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" id="callDriverBtn">
                                                        <i class="fas fa-phone-alt me-1"></i> Call
                                                    </button>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Map -->
                                        <div class="mb-3">
                                            <div id="map"></div>
                                        </div>

                                        <!-- Location & Fare Info -->
                                        <div class="p-3 bg-light rounded-3 mb-4 small border">
                                            <div class="text-truncate mb-2"><i class="fas fa-map-marker-alt text-success me-2"></i><strong id="pickupLocation">Pickup: Loading...</strong></div>
                                            <div class="text-truncate mb-2"><i class="fas fa-flag-checkered text-danger me-2"></i><strong id="dropoffLocation">Destination: Loading...</strong></div>
                                            <div class="d-flex justify-content-between align-items-center border-top pt-2 mt-2">
                                                <span class="text-muted"><i class="fas fa-receipt me-1"></i>Trip Fare</span>
                                                <span class="fw-bold text-primary fs-6" id="price">&#8369;50.00</span>
                                            </div>
                                        </div>

                                        <!-- Hidden Inputs -->
                                        <input type="hidden" id="bkid" value="<?php echo $bookingIdParam > 0 ? $bookingIdParam : ''; ?>">
                                        <input type="hidden" id="prc">

                                        <!-- Actions -->
                                        <div class="d-grid gap-2">
                                            <button id="confirmBooking" type="button" class="btn btn-primary btn-lg fw-bold rounded-pill">
                                                <i class="fas fa-user-check me-2"></i> Confirm Passenger Picked Up
                                            </button>
                                            <button class="btn btn-outline-info rounded-pill" type="button" id="dsa">
                                                <i class="fas fa-directions me-1"></i> Open in Google Maps Navigation
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

        <!-- Chat Modal -->
        <div class="modal fade" id="messageModal" tabindex="-1" aria-labelledby="messageModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-dialog-centered" role="document">
                <div class="modal-content" style="border-radius:18px; overflow:hidden;">
                    <div class="modal-header text-white" style="background: linear-gradient(135deg, #1e3c72, #3bafda);">
                        <h5 class="modal-title text-white fw-bold" id="messageModalLabel"><i class="fas fa-comments me-2"></i>Chat with Passenger</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="messageContainer" class="p-3" style="max-height: 380px; overflow-y: auto; background-color: #f8fafc; min-height: 220px;">
                        <div class="text-center text-muted py-4"><i class="fas fa-spinner fa-spin me-1"></i> Loading messages...</div>
                    </div>
                    <div class="modal-footer bg-white p-2">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control rounded-pill me-2" placeholder="Type a message to passenger...">
                            <button id="sendMessageButton" type="button" class="btn btn-primary rounded-circle" style="width:42px; height:42px;">
                                <i class="fas fa-paper-plane"></i>
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

        <script>
        $(document).ready(function () {
            let activeBooking = null;
            let currentPassId = 0;
            let currentDriverId = 0;
            let currentBookId = 0;

            function degreesToRadians(degrees) {
                return degrees * (Math.PI / 180);
            }

            function getDirections(lat, lng) {
                window.open(`https://www.google.com/maps/dir/?api=1&destination=${lat},${lng}`, '_blank');
            }

            const urlParams = new URLSearchParams(window.location.search);
            const bId = urlParams.get('id') || $('#bkid').val();

            // Fetch booking details
            $.ajax({
                url: '../php/get-pickup-details.php' + (bId ? '?id=' + bId : ''),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        const booking = response.data;
                        activeBooking = booking;
                        currentPassId = booking.user_id;
                        currentDriverId = booking.driver_id;
                        currentBookId = booking.id;

                        $('#bkid').val(booking.id);
                        $('#pickupLocation').text(`Pickup: ${booking.pickup_location}`);
                        $('#dropoffLocation').text(`Destination: ${booking.dropoff_location}`);

                        const price = Number(booking.price) || 50;
                        $('#price').html('&#8369;' + price.toFixed(2));
                        $('#prc').val(price.toFixed(2));

                        // Initialize Leaflet map
                        const pLat = parseFloat(booking.pickup_lat) || 14.5995;
                        const pLng = parseFloat(booking.pickup_lng) || 120.9842;
                        const dLat = parseFloat(booking.dropoff_lat) || pLat;
                        const dLng = parseFloat(booking.dropoff_lng) || pLng;

                        const map = L.map('map').setView([pLat, pLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                        L.marker([pLat, pLng]).addTo(map).bindPopup('<b>Pickup Location</b>').openPopup();
                        L.marker([dLat, dLng]).addTo(map).bindPopup('<b>Drop-off Location</b>');

                        const bounds = L.latLngBounds([[pLat, pLng], [dLat, dLng]]);
                        map.fitBounds(bounds, { padding: [35, 35] });

                        // GPS directions button
                        $('#dsa').click(function () {
                            getDirections(pLat, pLng);
                        });

                        // Fetch passenger details
                        fetch('../php/fetch_driver_details.php', {
                            method: 'POST',
                            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                            body: new URLSearchParams({ 'driver_id': currentPassId })
                        })
                        .then(res => res.json())
                        .then(data => {
                            if (data.success) {
                                $('#driverName').text(data.fullname || 'Passenger');
                                $('#driverContact').html(`<i class="fas fa-phone me-1"></i>Contact: ${data.contact}`);
                                $('#callDriverBtn').click(() => {
                                    window.location.href = `tel:${data.contact}`;
                                });
                                if (data.profile) {
                                    $('#passengerPic').attr('src', 'uploads/' + data.profile);
                                }
                            }
                        })
                        .catch(err => console.error(err));

                        // Driver Geolocation updates
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
                            text: response.message || 'No active pickup found.',
                            icon: 'info'
                        }).then(() => {
                            window.location.href = 'driver-dashboard.php';
                        });
                    }
                },
                error: function () {
                    Swal.fire('Error', 'Failed to retrieve pickup details.', 'error');
                }
            });

            // Confirm Pickup Action
            $('#confirmBooking').on('click', function () {
                if (!activeBooking) return;

                Swal.fire({
                    title: 'Confirm Passenger Boarded?',
                    text: 'Are you ready to begin the trip to the drop-off destination?',
                    icon: 'question',
                    showCancelButton: true,
                    confirmButtonColor: '#3bafda',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, Start Trip',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $.ajax({
                            url: '../php/confirm-pickup.php',
                            method: 'POST',
                            data: {
                                bookingId: activeBooking.id,
                                price: $('#prc').val()
                            },
                            dataType: 'json',
                            success: function (confirmResponse) {
                                if (confirmResponse.status === 'success') {
                                    Swal.fire({
                                        title: 'Passenger Picked Up!',
                                        text: 'Trip is now in progress.',
                                        icon: 'success',
                                        timer: 1500,
                                        showConfirmButton: false
                                    }).then(() => {
                                        window.location.href = `driver-5dropoff.php?id=${activeBooking.id}`;
                                    });
                                } else {
                                    Swal.fire('Error', confirmResponse.message || 'Failed to confirm pickup.', 'error');
                                }
                            },
                            error: function () {
                                Swal.fire('Error', 'Server request failed.', 'error');
                            }
                        });
                    }
                });
            });

            // ================= CHAT FUNCTIONALITY =================
            let fetchMessagesInterval;
            function fetchMessages() {
                if (!currentPassId) return;

                $.ajax({
                    url: '../php/fetch_message.php',
                    method: 'POST',
                    data: { driver_id: currentDriverId, book_id: currentBookId, user_id: currentPassId },
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
                        bootstrap.Modal.getOrCreateInstance(modalEl).show();
                    } else if (typeof $().modal === 'function') {
                        $('#messageModal').modal('show');
                    }
                }
            }

            $(document).on('click', '#mlm, [data-bs-target="#messageModal"]', function (e) {
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

            function sendMessage() {
                const msg = $('#messageInput').val().trim();
                if (!msg || !currentPassId) return;

                $.ajax({
                    url: '../php/send_message.php',
                    method: 'POST',
                    data: {
                        driver_id: currentPassId,
                        user_id: currentDriverId,
                        book_id: currentBookId,
                        message: msg
                    },
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
        });
        </script>
    </body>
</html>
