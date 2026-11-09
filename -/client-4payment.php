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
                height: 280px;
                width: 100%;
                border-radius: 14px;
            }
            .payment-card {
                border-radius: 20px;
                border: none;
                box-shadow: 0 10px 30px rgba(0,0,0,0.08);
                overflow: hidden;
            }
            .payment-header {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                padding: 22px 20px;
                color: #fff;
                text-align: center;
            }
            .driver-profile-box {
                background: #f8fafc;
                border: 1px solid #e2e8f0;
                border-radius: 16px;
                padding: 18px;
                margin-bottom: 20px;
            }
            .driver-avatar {
                width: 74px;
                height: 74px;
                object-fit: cover;
                border-radius: 50%;
                border: 3px solid #3bafda;
                box-shadow: 0 4px 12px rgba(59,175,218,0.25);
            }
            .gcash-box {
                background: linear-gradient(135deg, #0056b3, #007bff);
                color: #fff;
                border-radius: 16px;
                padding: 20px;
                margin-bottom: 20px;
                box-shadow: 0 6px 18px rgba(0,123,255,0.25);
            }
            .upload-dropzone {
                border: 2px dashed #3bafda;
                border-radius: 16px;
                padding: 26px 20px;
                text-align: center;
                background: #f8fafc;
                cursor: pointer;
                transition: all 0.25s ease;
                display: block;
            }
            .upload-dropzone:hover, .upload-dropzone.dragover {
                border-color: #1e3c72;
                background: #f0f7ff;
                transform: translateY(-2px);
                box-shadow: 0 6px 18px rgba(59,175,218,0.15);
            }
            .btn-gradient-submit {
                background: linear-gradient(135deg, #1e3c72, #3bafda);
                border: none;
                color: #ffffff;
                font-weight: 700;
                font-size: 1.05rem;
                padding: 13px;
                border-radius: 14px;
                box-shadow: 0 6px 18px rgba(30,60,114,0.3);
                transition: all 0.2s;
            }
            .btn-gradient-submit:hover {
                transform: translateY(-2px);
                box-shadow: 0 10px 24px rgba(30,60,114,0.4);
                color: #ffffff;
            }
            #messageContainer {
                display: flex;
                flex-direction: column;
                gap: 8px;
            }
        </style>

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Payment Proof - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/client-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Passenger' , 'title' => 'Submit Payment')); ?>

                        <!-- Stepper -->
                        <?php 
                        $currentStep = 4; 
                        include 'partials/booking-stepper.php'; 
                        ?>

                        <div class="col-xl-7 col-lg-8 col-md-10 mx-auto mb-5">
                            <div id="bookingCard" class="card payment-card">
                                <div class="payment-header">
                                    <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:52px; height:52px;">
                                        <i class="fas fa-receipt fa-2x text-white"></i>
                                    </div>
                                    <h4 class="card-title text-white mb-1">Driver Found &bull; Complete Payment</h4>
                                    <p class="mb-0 text-white-50 small">Send fare via GCash and upload the transaction screenshot</p>
                                </div>

                                <div class="card-body p-4">
                                    <!-- Hidden state inputs with PHP pre-population -->
                                    <input type="hidden" id="clid" value="<?php echo isset($_SESSION['user_id']) ? intval($_SESSION['user_id']) : ''; ?>">
                                    <input type="hidden" id="bkid" value="<?php echo $bookingIdParam > 0 ? $bookingIdParam : ''; ?>">
                                    <input type="hidden" id="drid">
                                    <input type="hidden" id="prc">
                                    <input type="hidden" name="bookingId" id="booking" value="<?php echo $bookingIdParam > 0 ? $bookingIdParam : ''; ?>">

                                    <!-- Driver Info Section -->
                                    <div class="driver-profile-box">
                                        <div class="d-flex align-items-center justify-content-between flex-wrap gap-3">
                                            <div class="d-flex align-items-center gap-3">
                                                <img id="driverpic" src="../taxi.jpg" alt="Driver" class="driver-avatar">
                                                <div>
                                                    <h5 id="driverName" class="fw-bold text-dark mb-1">Connecting to driver...</h5>
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
                                                    <i class="fas fa-comment-dots me-1"></i> Chat
                                                </button>
                                                <button type="button" class="btn btn-outline-success btn-sm rounded-pill px-3" id="callDriverBtn">
                                                    <i class="fas fa-phone-alt me-1"></i> Call
                                                </button>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Map Route Mini View -->
                                    <div class="mb-3">
                                        <div id="map"></div>
                                        <div class="d-flex justify-content-between align-items-center mt-2 px-1">
                                            <span id="est" class="badge bg-light text-primary border"><i class="fas fa-clock me-1"></i>Est. arrival: Calculating...</span>
                                            <span class="text-muted small"><i class="fas fa-info-circle me-1"></i>Driver is en route to pickup point</span>
                                        </div>
                                    </div>

                                    <!-- Route Text -->
                                    <div class="p-3 bg-light rounded-3 mb-3 small border">
                                        <div class="text-truncate mb-1"><i class="fas fa-map-marker-alt text-success me-2"></i><strong id="pickupLocation">Pickup: Loading...</strong></div>
                                        <div class="text-truncate"><i class="fas fa-flag-checkered text-danger me-2"></i><strong id="dropoffLocation">Destination: Loading...</strong></div>
                                    </div>

                                    <!-- GCash Payment Box -->
                                    <div class="gcash-box text-center">
                                        <span class="text-white-50 text-uppercase fw-bold" style="font-size:0.75rem; letter-spacing:1px;">Total Fare to Pay</span>
                                        <h1 id="price" class="text-white fw-bold my-1">&#8369;50.00</h1>
                                        <p class="small text-white-50 mb-3">Please send the exact fare to driver's GCash account</p>

                                        <div class="bg-white bg-opacity-25 rounded-3 p-2 d-inline-block mx-auto mb-2" style="max-width:240px;">
                                            <img id="gcashlogo" src="" alt="Driver GCash QR" style="max-width:180px; max-height:180px; border-radius:10px; display:none;" class="mx-auto my-1">
                                            <div id="noQrNotice" class="small text-white"><i class="fas fa-mobile-alt me-1"></i> Send via GCash number above</div>
                                        </div>
                                    </div>

                                    <!-- Proof Upload Section -->
                                    <div class="mb-4">
                                        <label class="form-label fw-bold text-dark small text-uppercase" style="letter-spacing:0.5px;">
                                            <i class="fas fa-upload text-primary me-1"></i> Upload GCash Screenshot / Receipt
                                        </label>

                                        <!-- Semantic Label acts as direct native trigger -->
                                        <label for="paymentProof" class="upload-dropzone mb-0" id="dropzoneBox">
                                            <i class="fas fa-cloud-upload-alt fa-3x text-primary mb-2"></i>
                                            <h5 class="fw-bold mb-1 text-dark">Tap to choose screenshot</h5>
                                            <p class="text-muted small mb-2">or drag &amp; drop your GCash receipt image here</p>
                                            <span class="btn btn-sm btn-outline-primary rounded-pill px-3 py-1 fw-bold">
                                                <i class="fas fa-folder-open me-1"></i> Browse Photo
                                            </span>
                                            <!-- Standard file input -->
                                            <input type="file" name="paymentProof" id="paymentProof" accept="image/png, image/jpeg, image/jpg, image/webp, image/jfif" style="display:none;">
                                        </label>

                                        <!-- Preview Card -->
                                        <div id="filePreview" class="text-center mt-3 p-3 bg-light rounded-3 border" style="display:none;">
                                            <div class="position-relative d-inline-block mb-2">
                                                <img id="previewImage" src="" alt="Payment Proof Preview" style="max-width:260px; max-height:260px; border-radius:12px; border:2px solid #3bafda; box-shadow:0 4px 12px rgba(0,0,0,0.15);">
                                                <span class="badge bg-success position-absolute top-0 start-100 translate-middle rounded-pill"><i class="fas fa-check"></i></span>
                                            </div>
                                            <div class="d-flex justify-content-center align-items-center gap-2 mb-1">
                                                <span id="previewFileName" class="fw-bold text-dark small text-truncate" style="max-width:240px;"></span>
                                                <span id="previewFileSize" class="badge bg-secondary"></span>
                                            </div>
                                            <div class="text-success small fw-semibold mb-2"><i class="fas fa-check-circle me-1"></i> Image ready for submission</div>
                                            <button type="button" class="btn btn-sm btn-outline-secondary rounded-pill" onclick="$('#paymentProof').click();">
                                                <i class="fas fa-sync-alt me-1"></i> Change Image
                                            </button>
                                        </div>
                                    </div>

                                    <button id="submitProof" type="button" class="btn btn-gradient-submit btn-block w-100">
                                        <i class="fas fa-check-double me-2"></i> Submit Payment Proof
                                    </button>
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
                        <h5 class="modal-title text-white fw-bold" id="messageModalLabel"><i class="fas fa-comments me-2"></i>Chat with Driver</h5>
                        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div id="messageContainer" class="p-3" style="max-height: 380px; overflow-y: auto; background-color: #f8fafc; min-height: 220px;">
                        <div class="text-center text-muted py-4"><i class="fas fa-spinner fa-spin me-1"></i> Loading messages...</div>
                    </div>
                    <div class="modal-footer bg-white p-2">
                        <div class="input-group">
                            <input type="text" id="messageInput" class="form-control rounded-pill me-2" placeholder="Type a message to your driver...">
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
        <script src="assets/js/ride-back-guard.js"></script>

        <script>
        $(document).ready(function () {
            function degreesToRadians(degrees) {
                return degrees * (Math.PI / 180);
            }

            const urlParams = new URLSearchParams(window.location.search);
            const bookingIdParam = urlParams.get('id') || $('#bkid').val();

            // Fetch payment details
            $.ajax({
                url: '../php/get-client-payment-details.php' + (bookingIdParam ? '?id=' + bookingIdParam : ''),
                method: 'GET',
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        const booking = response.data;

                        $('#clid').val(booking.user_id);
                        $('#drid').val(booking.driver_id);
                        $('#bkid').val(booking.id);
                        $('#booking').val(booking.id);

                        $('#pickupLocation').text(`Pickup: ${booking.pickup_location}`);
                        $('#dropoffLocation').text(`Drop-off: ${booking.dropoff_location}`);

                        // Initialize map
                        const drvLat = parseFloat(booking.drvLoc_lat) || 14.5995;
                        const drvLng = parseFloat(booking.drvLoc_lng) || 120.9842;
                        const pLat = parseFloat(booking.pickup_lat) || drvLat;
                        const pLng = parseFloat(booking.pickup_lng) || drvLng;

                        const map = L.map('map').setView([drvLat, drvLng], 13);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { maxZoom: 16 }).addTo(map);

                        L.marker([drvLat, drvLng]).addTo(map).bindPopup('<b>Driver</b>').openPopup();
                        L.marker([pLat, pLng]).addTo(map).bindPopup('<b>You</b>');

                        const bounds = L.latLngBounds([[drvLat, drvLng], [pLat, pLng]]);
                        map.fitBounds(bounds, { padding: [30, 30] });

                        // Distance & Time
                        const R = 6371;
                        const dLat = degreesToRadians(pLat - drvLat);
                        const dLon = degreesToRadians(pLng - drvLng);
                        const a = Math.sin(dLat / 2) ** 2 +
                                  Math.cos(degreesToRadians(drvLat)) *
                                  Math.cos(degreesToRadians(pLat)) *
                                  Math.sin(dLon / 2) ** 2;
                        const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                        const distance = R * c;
                        const estimatedTime = Math.max(2, Math.round(((distance / 35) * 60) + 1));

                        const price = Number(booking.price) || 50;
                        $('#price').html('&#8369;' + price.toFixed(2));
                        $('#est').html(`<i class="fas fa-clock me-1"></i>Driver arriving in approx. ${estimatedTime} mins`);
                        $('#prc').val(price.toFixed(2));

                        // Fetch driver details
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
                                if (data.gcash) {
                                    $('#gcashlogo').attr('src', 'uploads/' + data.gcash).show();
                                    $('#noQrNotice').hide();
                                }
                                $('#driverContact').html(`<i class="fas fa-phone me-1"></i>${data.contact}`);
                                $('#plate').text(`Plate: ${data.plate || 'N/A'}`);
                                $('#callDriverBtn').click(() => {
                                    window.location.href = `tel:${data.contact}`;
                                });
                            }
                        })
                        .catch(err => console.error(err));
                    } else {
                        Swal.fire({
                            title: 'No Payment Needed',
                            text: 'No active booking waiting for payment.',
                            icon: 'info'
                        }).then(() => {
                            window.location.href = 'client-dashboard.php';
                        });
                    }
                }
            });

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

            // Click listener for Chat button
            $(document).on('click', '#mlm, [data-bs-target="#messageModal"], [data-target="#messageModal"]', function (e) {
                e.preventDefault();
                openChatModal();
            });

            // Modal lifecycle events
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
                const message = $('#messageInput').val().trim();
                const drvId = $('#drid').val();
                const uId = $('#clid').val();
                const bId = $('#bkid').val();

                if (!message) return;

                $.ajax({
                    url: '../php/send_message.php',
                    method: 'POST',
                    data: { driver_id: drvId, user_id: uId, book_id: bId, message: message },
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

            // ================= FILE UPLOAD & PREVIEW =================
            function handleFile(file) {
                if (!file) return;

                const allowed = ['image/jpeg', 'image/jpg', 'image/png', 'image/webp'];
                const ext = file.name.split('.').pop().toLowerCase();
                const allowedExts = ['jpg', 'jpeg', 'png', 'webp', 'jfif'];

                if (!allowed.includes(file.type) && !allowedExts.includes(ext)) {
                    Swal.fire('Invalid Format', 'Please choose a JPG, PNG, or WEBP image screenshot.', 'warning');
                    return;
                }

                let sizeStr = '';
                if (file.size < 1024 * 1024) {
                    sizeStr = (file.size / 1024).toFixed(1) + ' KB';
                } else {
                    sizeStr = (file.size / (1024 * 1024)).toFixed(1) + ' MB';
                }

                $('#previewFileName').text(file.name);
                $('#previewFileSize').text(sizeStr);

                const reader = new FileReader();
                reader.onload = function (e) {
                    $('#previewImage').attr('src', e.target.result);
                    $('#filePreview').slideDown();
                };
                reader.readAsDataURL(file);
            }

            const paymentInput = $('#paymentProof');
            paymentInput.on('change', function () {
                if (this.files && this.files[0]) {
                    handleFile(this.files[0]);
                }
            });

            // Drag and Drop
            const dropzone = $('#dropzoneBox');
            dropzone.on('dragover dragenter', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).addClass('dragover');
            });
            dropzone.on('dragleave dragend drop', function (e) {
                e.preventDefault();
                e.stopPropagation();
                $(this).removeClass('dragover');
            });
            dropzone.on('drop', function (e) {
                const files = e.originalEvent.dataTransfer.files;
                if (files && files.length > 0) {
                    paymentInput[0].files = files;
                    handleFile(files[0]);
                }
            });

            // Submit Payment Proof
            $('#submitProof').click(function () {
                const file = paymentInput[0].files ? paymentInput[0].files[0] : null;
                if (!file) {
                    Swal.fire({
                        title: 'Resibo Kailangan',
                        text: 'Paki-pili muna ang screenshot ng iyong GCash payment.',
                        icon: 'warning',
                        confirmButtonColor: '#3bafda'
                    });
                    return;
                }

                const currentBookingId = $('#bkid').val() || urlParams.get('id') || '<?php echo $bookingIdParam > 0 ? $bookingIdParam : ""; ?>';

                const formData = new FormData();
                formData.append('paymentProof', file);
                formData.append('bookingID', currentBookingId);

                Swal.fire({
                    title: 'Ipinapasa ang Resibo...',
                    text: 'Paki-antay habang ina-upload ang payment proof...',
                    icon: 'info',
                    showConfirmButton: false,
                    allowOutsideClick: false,
                    didOpen: () => { Swal.showLoading(); }
                });

                $.ajax({
                    url: 'upload_payment_proof.php',
                    type: 'POST',
                    data: formData,
                    contentType: false,
                    processData: false,
                    dataType: 'json',
                    success: function (res) {
                        Swal.close();
                        if (res && res.status === 'success') {
                            Swal.fire({
                                title: 'Naisumite na!',
                                text: 'Nai-submit na ang resibo. Bineberipika na ito ng iyong driver.',
                                icon: 'success',
                                timer: 1800,
                                showConfirmButton: false
                            }).then(() => {
                                const targetId = res.bookingId || currentBookingId;
                                window.location.href = 'client-5confirmpayment.php' + (targetId ? '?id=' + targetId : '');
                            });
                        } else {
                            Swal.fire({
                                title: 'Upload Failed',
                                text: (res && res.message) ? res.message : 'Hindi ma-upload ang file.',
                                icon: 'error',
                                confirmButtonColor: '#e02d1b'
                            });
                        }
                    },
                    error: function (xhr) {
                        Swal.close();
                        let msg = 'Failed to upload proof. Please try again.';
                        try {
                            const errObj = JSON.parse(xhr.responseText);
                            if (errObj && errObj.message) msg = errObj.message;
                        } catch(e) {}
                        Swal.fire({
                            title: 'Upload Error',
                            text: msg,
                            icon: 'error',
                            confirmButtonColor: '#e02d1b'
                        });
                    }
                });
            });
        });
        </script>
    </body>
</html>
