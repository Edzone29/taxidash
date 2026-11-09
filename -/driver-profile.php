<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Driver Profile - TaxiDash')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

           <?php include 'partials/driver-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Profile')); ?>
                        
<?php
include '../php/conn.php';
$dId = intval($_SESSION['user_id'] ?? 0);
$avgRating = 5.0;
$totalRatings = 0;
$reviews = [];
if ($dId > 0) {
    $statQ = $conn->query("SELECT AVG(rating) as avg_r, COUNT(*) as cnt FROM tbl_ratings WHERE driver_id = $dId");
    if ($statQ && $row = $statQ->fetch_assoc()) {
        if ($row['cnt'] > 0) {
            $avgRating = round(floatval($row['avg_r']), 1);
            $totalRatings = intval($row['cnt']);
        }
    }
    $revQ = $conn->query("SELECT r.*, u.firstname, u.lastname, u.profile_photo as passenger_pic FROM tbl_ratings r LEFT JOIN tbl_users u ON r.user_id = u.id WHERE r.driver_id = $dId ORDER BY r.created_at DESC LIMIT 20");
    if ($revQ) {
        while ($rv = $revQ->fetch_assoc()) {
            $reviews[] = $rv;
        }
    }
}
?>

<div class="row">
    <!-- Driver Info Column -->
    <div class="col-lg-4 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white p-3">
                <h5 class="mb-0 text-white"><i class="fas fa-id-card me-2"></i>Personal Details</h5>
                <span class="badge bg-success" style="font-size: 13px;">Active</span>
            </div>
            <div class="card-body text-center">
                <div class="profile-img mb-3">
                    <?php 
                    $picFile = !empty($_SESSION['pic']) ? $_SESSION['pic'] : 'default.png';
                    ?>
                    <img src="uploads/<?=$picFile?>" alt="Profile Image" class="rounded-circle border border-3 border-primary shadow-sm" style="width: 110px; height: 110px; object-fit: cover;" onerror="this.src='assets/images/users/avatar-1.jpg';">
                </div>
                <h4 class="card-title mb-1"><?=htmlspecialchars(($_SESSION['firstname'] ?? '') . ' ' . ($_SESSION['lastname'] ?? ''))?></h4>
                <div class="mb-3">
                    <span class="badge bg-warning text-dark px-3 py-2 rounded-pill fw-bold" style="font-size: 14px;">
                        ⭐ <?=$avgRating?> / 5.0 (<?=$totalRatings?> reviews)
                    </span>
                </div>
                <div class="details text-start mt-3 p-3 bg-light rounded-3">
                    <p class="mb-2"><i class="fas fa-envelope me-2 text-primary"></i><strong>Email:</strong> <?=htmlspecialchars($_SESSION['email'] ?? 'N/A')?></p>
                    <p class="mb-2"><i class="fas fa-phone-alt me-2 text-primary"></i><strong>Phone:</strong> <?=htmlspecialchars($_SESSION['contact'] ?? 'N/A')?></p>
                    <p class="mb-2"><i class="fas fa-car me-2 text-primary"></i><strong>Plate:</strong> <span class="badge bg-dark"><?=htmlspecialchars($_SESSION['plate'] ?? 'N/A')?></span></p>
                    <p class="mb-0"><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Location:</strong> Cauayan, Isabela</p>
                </div>
                <div class="mt-3 d-grid gap-2">
                    <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#updateProfileModal"><i class="fas fa-user-edit me-1"></i> Edit Profile & QR</button>
                    <button class="btn btn-outline-secondary" data-bs-toggle="modal" data-bs-target="#updatePasswordModal"><i class="fas fa-key me-1"></i> Update Password</button>
                </div>
            </div>
        </div>
    </div>

    <!-- Passenger Feedback & Ratings Column -->
    <div class="col-lg-8 mb-4">
        <div class="card shadow-sm border-0">
            <div class="card-header bg-white border-bottom d-flex justify-content-between align-items-center p-3">
                <h5 class="mb-0 fw-bold"><i class="fas fa-star text-warning me-2"></i>Passenger Ratings & Reviews</h5>
                <span class="badge bg-info text-white"><?=count($reviews)?> Recent</span>
            </div>
            <div class="card-body">
                <!-- Rating Scoreboard -->
                <div class="p-3 mb-4 rounded-3 text-center text-md-start" style="background: linear-gradient(135deg, #fef9e7 0%, #fff 100%); border: 1px solid #fae588;">
                    <div class="row align-items-center">
                        <div class="col-md-4 text-center border-end">
                            <div class="display-4 fw-bold text-dark"><?=$avgRating?></div>
                            <div class="text-warning mb-1" style="font-size: 20px;">
                                <?php
                                for ($i = 1; $i <= 5; $i++) {
                                    if ($i <= floor($avgRating)) {
                                        echo '<i class="fas fa-star"></i>';
                                    } elseif ($i - $avgRating <= 0.5) {
                                        echo '<i class="fas fa-star-half-alt"></i>';
                                    } else {
                                        echo '<i class="far fa-star text-muted"></i>';
                                    }
                                }
                                ?>
                            </div>
                            <small class="text-muted fw-bold">Based on <?=$totalRatings?> total rides</small>
                        </div>
                        <div class="col-md-8 ps-md-4 pt-3 pt-md-0">
                            <h6 class="fw-bold mb-1"><i class="fas fa-shield-alt text-success me-1"></i> Top Rated Driver Quality</h6>
                            <p class="text-muted small mb-0">Ratings and passenger feedback are recorded automatically after every completed trip to ensure high service standards across TaxiDash.</p>
                        </div>
                    </div>
                </div>

                <!-- Reviews List -->
                <?php if (empty($reviews)): ?>
                    <div class="text-center py-5 text-muted">
                        <i class="far fa-comment-dots fa-3x mb-3 text-secondary"></i>
                        <p class="mb-0 fw-bold">No passenger reviews yet.</p>
                        <small>Completed passenger rides will display ratings and feedback comments here!</small>
                    </div>
                <?php else: ?>
                    <div class="list-group list-group-flush">
                        <?php foreach ($reviews as $rev): ?>
                            <div class="list-group-item px-0 py-3 border-bottom">
                                <div class="d-flex align-items-start">
                                    <div class="me-3">
                                        <div class="avatar-sm rounded-circle bg-primary bg-opacity-10 text-primary d-flex align-items-center justify-content-center fw-bold" style="width: 45px; height: 45px; font-size: 18px;">
                                            <?=strtoupper(substr($rev['firstname'] ?? 'P', 0, 1))?>
                                        </div>
                                    </div>
                                    <div class="flex-grow-1">
                                        <div class="d-flex justify-content-between align-items-center">
                                            <h6 class="mb-1 fw-bold"><?=htmlspecialchars(($rev['firstname'] ?? 'Passenger') . ' ' . ($rev['lastname'] ?? ''))?></h6>
                                            <small class="text-muted"><i class="far fa-clock me-1"></i><?=date('M d, Y h:i A', strtotime($rev['created_at']))?></small>
                                        </div>
                                        <div class="text-warning mb-2" style="font-size: 13px;">
                                            <?php
                                            $rVal = intval($rev['rating']);
                                            for ($s = 1; $s <= 5; $s++) {
                                                echo $s <= $rVal ? '<i class="fas fa-star"></i>' : '<i class="far fa-star text-muted"></i>';
                                            }
                                            ?>
                                            <span class="ms-1 fw-bold text-dark">(<?=$rVal?>.0)</span>
                                        </div>
                                        <p class="mb-0 text-secondary" style="font-size: 14px;">
                                            "<?=htmlspecialchars(!empty($rev['feedback']) ? $rev['feedback'] : 'Great and safe ride!')?>"
                                        </p>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-primary text-white">
                <h5 class="modal-title text-white" id="updateProfileModalLabel"><i class="fas fa-user-cog me-2"></i>Update Profile & Details</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProfileForm" class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-camera me-1 text-primary"></i> Update Profile Picture</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="profilePic" required name="profilePic" accept="image/*">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i> Upload</button>
                    </div>
                </form>
                
                <hr>

                <form id="updateProfileQR" class="mb-3">
                    <label class="form-label fw-bold"><i class="fas fa-qrcode me-1 text-primary"></i> Update GCash / Maya QR Code</label>
                    <div class="input-group">
                        <input type="file" class="form-control" id="qrPic" required name="qrPic" accept="image/*">
                        <button type="submit" class="btn btn-primary"><i class="fas fa-upload me-1"></i> Upload</button>
                    </div>
                </form>

                <hr>

                <form id="updateDetailsForm">
                    <h6 class="fw-bold mb-3"><i class="fas fa-address-card me-1 text-primary"></i> Contact & Vehicle Info</h6>
                    <div class="mb-3">
                        <label for="driverName" class="form-label">Driver Name</label>
                        <input type="text" class="form-control bg-light" id="driverName" readonly value="<?=htmlspecialchars(($_SESSION['firstname'] ?? '') . ' ' . ($_SESSION['lastname'] ?? ''))?>">
                    </div>
                    <div class="mb-3">
                        <label for="driverContact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="driverContact" name="driverContact" value="<?=htmlspecialchars($_SESSION['contact'] ?? '')?>" required>
                    </div>
                    <div class="mb-3">
                        <label for="driverPlate" class="form-label">Plate Number</label>
                        <input type="text" class="form-control" id="driverPlate" name="driverPlate" value="<?=htmlspecialchars($_SESSION['plate'] ?? '')?>" required>
                    </div>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-success"><i class="fas fa-save me-1"></i> Save Details</button>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>

<!-- Update Password Modal -->
<div class="modal fade" id="updatePasswordModal" tabindex="-1" aria-labelledby="updatePasswordModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-dark text-white">
                <h5 class="modal-title text-white" id="updatePasswordModalLabel"><i class="fas fa-key me-2"></i>Update Password</h5>
                <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <form id="updatePasswordForm">
                <div class="modal-body">
                    <input type="hidden" name="user_id" value="<?=intval($_SESSION['user_id'] ?? 0)?>">
                    <div class="mb-3">
                        <label for="currentPassword" class="form-label">Current Password</label>
                        <input type="password" class="form-control" id="currentPassword" name="currentPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="newPassword" class="form-label">New Password</label>
                        <input type="password" class="form-control" id="newPassword" name="newPassword" required>
                    </div>
                    <div class="mb-3">
                        <label for="confirmPassword" class="form-label">Confirm New Password</label>
                        <input type="password" class="form-control" id="confirmPassword" name="confirmPassword" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-primary"><i class="fas fa-check-circle me-1"></i> Update Password</button>
                </div>
            </form>
        </div>
    </div>
</div>

                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <?php include 'partials/footer.php'; ?>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>

        <?php include 'partials/vendor-scripts.php'; ?>

        <script src="assets/js/app.js"></script>
        <!-- SweetAlert2 CSS & JS -->
        <link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.js"></script>

        <script>
        // Handle profile picture update
        $("#updateProfileForm").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "update_profile_picture.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Profile Picture Updated",
                        text: response.message || "Updated successfully"
                    }).then(() => location.reload());
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: xhr.responseText
                    });
                }
            });
        });

        // Handle QR update
        $("#updateProfileQR").submit(function (e) {
            e.preventDefault();
            let formData = new FormData(this);
            $.ajax({
                url: "update_profile_qr.php",
                type: "POST",
                data: formData,
                contentType: false,
                processData: false,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Payment QR Updated",
                        text: response.message || "QR updated successfully"
                    }).then(() => location.reload());
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: xhr.responseText
                    });
                }
            });
        });

        // Handle driver details update
        $("#updateDetailsForm").submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "update_driver_details.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    Swal.fire({
                        icon: "success",
                        title: "Details Updated",
                        text: response.message || "Saved successfully"
                    }).then(() => location.reload());
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: xhr.responseText
                    });
                }
            });
        });

        // Handle password update
        $("#updatePasswordForm").submit(function (e) {
            e.preventDefault();
            let formData = $(this).serialize();
            $.ajax({
                url: "update_password.php",
                type: "POST",
                data: formData,
                success: function (response) {
                    try {
                        const parsedResponse = typeof response === 'object' ? response : JSON.parse(response);
                        if (parsedResponse.success) {
                            Swal.fire({
                                icon: "success",
                                title: parsedResponse.message
                            }).then(() => location.reload());
                        } else {
                            Swal.fire({
                                icon: "warning",
                                title: parsedResponse.message
                            });
                        }
                    } catch (error) {
                        Swal.fire({
                            icon: "error",
                            title: "Error",
                            text: "An unexpected error occurred. Please try again later."
                        });
                    }
                },
                error: function (xhr) {
                    Swal.fire({
                        icon: "error",
                        title: "Update Failed",
                        text: xhr.responseText
                    });
                }
            });
        });
        </script>
    </body>
</html>
