<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
      <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>

    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

           <?php include 'partials/client-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                    
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Client' , 'title' => 'Profile')); ?>
                        
                        
<div class="row">
    <div class="col-lg-4 mb-3">
        <div class="card shadow-lg border-0">
            <div class="card-header d-flex justify-content-between align-items-center bg-primary text-white p-3">
                <h4 class="mb-0">Personal Details</h4>
                <span class="badge bg-success" style="font-size: 14px;">Active</span>
            </div>
            <div class="card-body text-center">
                <div class="profile-img mb-3">
                    <img src="uploads/<?=$_SESSION['pic']?>" alt="Profile Image" class="rounded-circle border border-3 border-primary shadow-sm" style="width: 100px; height: 100px; object-fit: cover;">
                </div>
                <h4 class="card-title mb-1"><?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?></h4>
                <div class="details mt-3">
                    <p><i class="fas fa-envelope me-2 text-primary"></i><strong>Email:</strong> <?=$_SESSION['email']?></p>
                    <p><i class="fas fa-phone-alt me-2 text-primary"></i><strong>Phone:</strong> <?=$_SESSION['contact']?></p>

                    <p><i class="fas fa-map-marker-alt me-2 text-primary"></i><strong>Location:</strong> Cauayan, Isabela</p>
                    <button class="btn btn-primary me-2 mb-2" data-bs-toggle="modal" data-bs-target="#updateProfileModal">Edit Profile</button>
                    <br>    
                    <button class="btn btn-secondary" data-bs-toggle="modal" data-bs-target="#updatePasswordModal">Update Password</button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Update Profile Modal -->
<div class="modal fade" id="updateProfileModal" tabindex="-1" aria-labelledby="updateProfileModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateProfileModalLabel">Update Profile</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateProfileForm">
                    <!-- Profile Picture Update -->
                    <div class="mb-3">
                        <label for="profilePic" class="form-label">Profile Picture</label>
                        <input type="file" class="form-control" id="profilePic" required name="profilePic">
                    </div>
                    
                <button type="submit" form="updateProfileForm" class="btn btn-primary">Update Picture</button>
                </form>
                
                <!--   <form id="updateProfileQR">-->
                    <!-- Profile Picture Update -->
                <!--    <div class="mb-3">-->
                <!--        <label for="profilePic" class="form-label">QR Code</label>-->
                <!--        <input type="file" class="form-control" id="qrPic" required name="qrPic">-->
                         
                <!--    </div>-->
                <!--    <button type="submit" form="updateProfileQR" class="btn btn-primary">Update QR</button>-->
                <!--</form>-->
                <form id="updateDetailsForm">
                    <!-- Driver Details -->
                    <div class="mb-3">
                        <label for="driverName" class="form-label">CLient Name</label>
                        <input type="text" class="form-control" id="driverName" readonly value="<?=$_SESSION['firstname']?> <?=$_SESSION['lastname']?>" readonly>
                    </div>
                    <div class="mb-3">
                        <label for="driverContact" class="form-label">Contact Number</label>
                        <input type="text" class="form-control" id="driverContact" name="driverContact" value="<?=$_SESSION['contact']?>">
                    </div>
                  
                    
                <button type="submit" form="updateDetailsForm" class="btn btn-primary">Save Details</button>
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
            <div class="modal-header">
                <h5 class="modal-title" id="updatePasswordModalLabel">Update Password</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updatePasswordForm">
                    <input type="hidden" name="user_id" value="<?=$_SESSION['user_id']?>">
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
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="submit" form="updatePasswordForm" class="btn btn-primary">Update Password</button>
            </div>
        </div>
    </div>
</div>



<!-- Bootstrap 5 CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/css/bootstrap.min.css" rel="stylesheet">
<!-- Font Awesome Icons -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>
<!-- Bootstrap 5 JS and Popper.js -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>





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

        <!-- jquery.vectormap map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

        <script src="assets/js/app.js"></script>
        <!-- SweetAlert2 CSS -->
<link href="https://cdn.jsdelivr.net/npm/sweetalert2@11.7.5/dist/sweetalert2.min.css" rel="stylesheet">

<!-- SweetAlert2 JS -->
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
                text: response.message
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
                text: response.message
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
                text: response.message
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

    let formData = $(this).serialize(); // Collect form data
    $.ajax({
        url: "update_password.php", // URL to send the request to
        type: "POST", // HTTP method
        data: formData, // Form data
        success: function (response) {
            try {
                // Parse response as JSON
                const parsedResponse = JSON.parse(response);
                
                // Check if the response contains a success or failure message
                if (parsedResponse.success) {
                    Swal.fire({
                        icon: "success",
                        title: parsedResponse.message
                    }).then(() => location.reload()); // Reload the page on success
                } else {
                    Swal.fire({
                        icon: "warning",
                        title: parsedResponse.message
                    });
                }
            } catch (error) {
                // If JSON parsing fails, display a generic error message
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
                text: xhr.responseText // Display error response text
            });
        }
    });
});


            
        </script>

    </body>
</html>

