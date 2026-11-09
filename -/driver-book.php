<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet-control-geocoder/dist/Control.Geocoder.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

    <style>
        #map { height: 400px; }
        .radar-box {
            background: linear-gradient(135deg, #1e3c72, #3bafda);
            color: #fff;
            border-radius: 16px;
            padding: 18px 24px;
            margin-bottom: 24px;
            box-shadow: 0 4px 15px rgba(59,175,218,0.3);
        }
        .pulse-dot {
            width: 14px;
            height: 14px;
            background: #10b981;
            border-radius: 50%;
            display: inline-block;
            box-shadow: 0 0 0 rgba(16,185,129, 0.7);
            animation: pulseGreen 1.5s infinite;
        }
        @keyframes pulseGreen {
            0% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16,185,129, 0.7); }
            70% { transform: scale(1); box-shadow: 0 0 0 10px rgba(16,185,129, 0); }
            100% { transform: scale(0.95); box-shadow: 0 0 0 0 rgba(16,185,129, 0); }
        }
        .booking-card {
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            transition: transform 0.25s, box-shadow 0.25s;
            overflow: hidden;
        }
        .booking-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 24px rgba(0,0,0,0.12) !important;
        }
    </style>

    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash – Pickup Booking')); ?>
    <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
    <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
        <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Available Pickups')); ?>

                        <!-- Live Radar Banner -->
                        <div class="radar-box d-flex justify-content-between align-items-center flex-wrap gap-2">
                            <div class="d-flex align-items-center gap-3">
                                <span class="pulse-dot"></span>
                                <div>
                                    <h5 class="mb-0 fw-bold text-white">Live Booking Radar</h5>
                                    <small class="opacity-75">Auto-scanning for passenger ride requests every 4 seconds...</small>
                                </div>
                            </div>
                            <div>
                                <button class="btn btn-sm btn-light rounded-pill px-3 fw-bold text-primary" id="testSoundBtn">
                                    <i class="fas fa-volume-up me-1"></i> Test Chime
                                </button>
                            </div>
                        </div>

                        <!-- Bookings Container -->
                        <div class="row" id="bookings-container">
                            <div class="col-12 text-center py-5">
                                <div class="spinner-border text-primary" role="status"></div>
                                <p class="text-muted mt-3">Connecting to radar...</p>
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
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

        <script>
        // Synthesizer Audio Chime (Ding-Dong dispatch chime)
        function playChime() {
            try {
                const ctx = new (window.AudioContext || window.webkitAudioContext)();
                const now = ctx.currentTime;

                // High tone (Ding)
                const osc1 = ctx.createOscillator();
                const gain1 = ctx.createGain();
                osc1.type = 'sine';
                osc1.frequency.setValueAtTime(880, now); // A5
                gain1.gain.setValueAtTime(0.3, now);
                gain1.gain.exponentialRampToValueAtTime(0.001, now + 0.4);
                osc1.connect(gain1);
                gain1.connect(ctx.destination);
                osc1.start(now);
                osc1.stop(now + 0.4);

                // Lower tone (Dong)
                const osc2 = ctx.createOscillator();
                const gain2 = ctx.createGain();
                osc2.type = 'sine';
                osc2.frequency.setValueAtTime(659.25, now + 0.2); // E5
                gain2.gain.setValueAtTime(0.35, now + 0.2);
                gain2.gain.exponentialRampToValueAtTime(0.001, now + 0.8);
                osc2.connect(gain2);
                gain2.connect(ctx.destination);
                osc2.start(now + 0.2);
                osc2.stop(now + 0.8);
            } catch (err) {
                console.warn('Audio play error:', err);
            }
        }

        document.getElementById('testSoundBtn').addEventListener('click', function() {
            playChime();
            Swal.fire({
                title: 'Audio Working!',
                text: 'You will hear this chime automatically whenever a passenger books a ride.',
                icon: 'info',
                timer: 2000,
                showConfirmButton: false
            });
        });

        let knownBookingIds = new Set();
        let isFirstLoad = true;

        function fetchBookings() {
            fetch('../php/get-bookings.php')
                .then(response => response.json())
                .then(bookings => {
                    const container = document.getElementById('bookings-container');
                    
                    if (!Array.isArray(bookings) || bookings.length === 0) {
                        knownBookingIds.clear();
                        isFirstLoad = false;
                        container.innerHTML = `
                            <div class="col-12 text-center py-5">
                                <div class="rounded-circle d-flex align-items-center justify-content-center mx-auto mb-3"
                                     style="width:80px;height:80px;background:#f1f5f9;">
                                    <i class="fas fa-car-side fa-2x text-muted"></i>
                                </div>
                                <h5 class="fw-bold text-dark">No ride requests right now</h5>
                                <p class="text-muted small">Stay on this page. We will chime and notify you the moment a ride appears!</p>
                            </div>
                        `;
                        return;
                    }

                    // Check for new bookings
                    let hasNew = false;
                    let newestPassenger = '';

                    bookings.forEach(b => {
                        if (!knownBookingIds.has(b.id)) {
                            knownBookingIds.add(b.id);
                            if (!isFirstLoad) {
                                hasNew = true;
                                newestPassenger = `${b.firstname} ${b.lastname}`;
                            }
                        }
                    });

                    if (hasNew) {
                        playChime();
                        Swal.fire({
                            title: '🔔 New Ride Request!',
                            text: `Passenger ${newestPassenger} is looking for a driver!`,
                            icon: 'info',
                            timer: 3500,
                            timerProgressBar: true,
                            showConfirmButton: false
                        });
                    }

                    isFirstLoad = false;
                    container.innerHTML = '';

                    bookings.forEach(booking => {
                        const card = document.createElement('div');
                        card.className = 'col-lg-4 col-md-6 mb-4';
                        card.innerHTML = `
                            <div class="card booking-card shadow-sm h-100">
                                <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center py-3">
                                    <div class="d-flex align-items-center gap-2">
                                        <div class="rounded-circle bg-primary-subtle text-primary d-flex align-items-center justify-content-center"
                                             style="width:36px;height:36px;">
                                            <i class="fas fa-user"></i>
                                        </div>
                                        <h6 class="mb-0 fw-bold text-dark">${booking.firstname} ${booking.lastname}</h6>
                                    </div>
                                    <span class="badge bg-success-subtle text-success border border-success px-2 py-1">₱${booking.price}</span>
                                </div>
                                <div class="card-body">
                                    <div class="small mb-2 text-truncate" title="${booking.pickup_location}">
                                        <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                        <strong>Pickup:</strong> ${booking.pickup_location}
                                    </div>
                                    <div class="small mb-3 text-truncate" title="${booking.dropoff_location}">
                                        <i class="fas fa-flag-checkered text-success me-1"></i>
                                        <strong>Drop-off:</strong> ${booking.dropoff_location}
                                    </div>
                                    <button class="btn btn-primary btn-block w-100 fw-bold py-2" onclick="window.location.href='driver-view.php?id=${booking.id}'">
                                        <i class="fas fa-eye me-1"></i> View &amp; Accept Ride
                                    </button>
                                </div>
                            </div>
                        `;
                        container.appendChild(card);
                    });
                })
                .catch(error => console.error('Error fetching bookings:', error));
        }

        document.addEventListener("DOMContentLoaded", function () {
            fetchBookings();
            setInterval(fetchBookings, 4000); // Auto-scan every 4 seconds
        });
        </script>
    </body>
</html>
