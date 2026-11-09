<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-admin.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link href="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/css/lightbox.min.css" rel="stylesheet">


    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
        
        <style>
            
            .job-card {
              /*max-width: 350px;*/
              border: 1px solid #e3e6ea;
              border-radius: 8px;
              box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            .job-card .card-title {
              font-size: 1.2rem;
              font-weight: bold;
            }
            
            .job-card .company-name {
              font-size: 0.9rem;
              font-weight: normal;
            }
            
            .job-card .company-logo {
              text-align: center;
            }
            
            .job-card ul {
              padding: 0;
              list-style-type: none;
            }
            
            .job-card ul li {
              font-size: 0.9rem;
              color: #495057;
              display: flex;
              align-items: center;  /* Ensures vertical alignment */
              gap: 10px;  /* Consistent spacing between icon and text */
            }
            
            .job-card ul li i {
              width: 24px; /* Set width of icon (1x1 size in px) */
              height: 24px; /* Set height of icon (1x1 size in px) */
              text-align: center;  /* Center icon */
              font-size: 1.2rem; /* Icon size */
              line-height: 24px;  /* Vertically center icon */
            }


            
            .heart-icon i {
              font-size: 1.2rem;
              color: #ccc;
            }
            
            .heart-icon i:hover {
              color: #e74c3c;
            }
            
            .badge {
              font-size: 0.85rem;
            }
            
            .list-unstyled {
              line-height: 1.8;
            }
            
            .cursor-pointer i{
                cursor:pointer;
            }
            
            .scrollable-job-list {
                max-height: 700; /* Adjust height as needed */
                overflow-y: auto;  /* Enable vertical scrolling */
                overflow-x: hidden; /* Prevent horizontal scrolling */
                padding-right: 15px; /* Optional: Add padding to prevent content from touching the scrollbar */
            }
            
            .dropdown-menu {
                width: auto; /* Use auto width to fit the content */
                min-width: 200px; /* Set a minimum width to maintain a standard appearance */
            }


            
        </style>

    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

        <?php include 'partials/admin-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                 <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'] ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= 'Admin' ?></a></li>
                    <li class="breadcrumb-item active"><?= 'Home' ?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
                        
                        <div class="row mb-3">
<?php
// Include database connection
include '../php/conn.php';

// Fetch data from the database
$sql = "SELECT `id`, `firstname`, `middlename`, `lastname`, profile_photo, `email`, `contact`, `user_type`, `created_at`, plate FROM `tbl_users` WHERE user_type = 'driver' and status = 1 ";
$result = mysqli_query($conn, $sql);
?>


<div class="container mt-5">
    <h2 class="text-center">Driver Accounts</h2>

    <!-- Create Driver Button -->
    <button class="btn btn-success mb-3 " data-bs-toggle="modal" data-bs-target="#createDriverModal">Create Driver</button>
<div class="table-responsive"> 
    <table id="dt_responsive_table" class="table table-striped table-responsive table-bordered">
        <thead>
            <tr>
                <th>ID</th>
                <th>Profile</th>
                <th>First Name</th>
                <th>Last Name</th>
                <th>Email</th>
                <th>Contact</th>
                <th>Plate Number</th>
                <th>User Type</th>
                <th>Created At</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php
            if (mysqli_num_rows($result) > 0) {
                while ($row = mysqli_fetch_assoc($result)) {
                    echo "<tr>
                            <td>{$row['id']}</td>
                    <td>
    <a href='uploads/{$row['profile_photo']}' data-lightbox='profile-photo' data-title='Profile Photo'>
        <img src='uploads/{$row['profile_photo']}' alt='Profile Photo' style='width: 50px; height: 50px; border-radius: 50%; cursor: pointer;'>
    </a>
</td>


                            <td>{$row['firstname']}</td>
                            <td>{$row['lastname']}</td>
                            <td>{$row['email']}</td>
                            <td>{$row['contact']}</td>
                            <td>{$row['plate']}</td>
                            
                            <td>{$row['user_type']}</td>
                            <td>{$row['created_at']}</td>
                            <td>
                                <button class='btn btn-primary collapse btn-sm update-driver-btn' 
                                    data-id='{$row['id']}' 
                                    data-firstname='{$row['firstname']}'
                                    data-middlename='{$row['middlename']}'
                                    data-lastname='{$row['lastname']}'
                                    data-email='{$row['email']}'
                                    data-contact='{$row['contact']}'>
                                    Update
                                </button>
                                <button class='btn btn-danger mt-1 btn-sm delete-driver-btn' data-id='{$row['id']}'>Block</button>
                            </td>
                          </tr>";
                }
            } else {
                echo "<tr><td colspan='9' class='text-center'>No drivers found</td></tr>";
            }
            ?>
        </tbody>
    </table>
    </div>
</div>




</div>


                       

<!-- Create Driver Modal -->
<div class="modal fade" id="createDriverModal" tabindex="-1" aria-labelledby="createDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="createDriverModalLabel">Create Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="createDriverForm">
                    <div class="mb-3">
                        <label for="firstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" required>
                    </div>
                   
                    <div class="mb-3">
                        <label for="lastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" class="form-control" id="email" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="contact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="contact" name="contact" required>
                    </div>
                    
                     <div class="mb-3">
                        <label for="contact" class="form-label">Plate Number</label>
                        <input type="text" class="form-control" id="plate" name="plate" required>
                    </div>
                    <button type="submit" class="btn btn-success">Create</button>
                </form>
            </div>
        </div>
    </div>
</div>



<!-- Update Driver Modal -->
<div class="modal fade" id="updateDriverModal" tabindex="-1" aria-labelledby="updateDriverModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateDriverModalLabel">Update Driver</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="updateDriverForm">
                    <input type="hidden" id="updateDriverId" name="id">
                    <div class="mb-3">
                        <label for="updateFirstname" class="form-label">First Name</label>
                        <input type="text" class="form-control" id="updateFirstname" name="firstname" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateMiddlename" class="form-label">Middle Name</label>
                        <input type="text" class="form-control" id="updateMiddlename" name="middlename">
                    </div>
                    <div class="mb-3">
                        <label for="updateLastname" class="form-label">Last Name</label>
                        <input type="text" class="form-control" id="updateLastname" name="lastname" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateEmail" class="form-label">Email</label>
                        <input type="email" class="form-control" id="updateEmail" name="email" required>
                    </div>
                    <div class="mb-3">
                        <label for="updateContact" class="form-label">Contact</label>
                        <input type="text" class="form-control" id="updateContact" name="contact" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Update</button>
                </form>
            </div>
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
        
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1"
            id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header border-bottom">
                <h2 class="offcanvas-title text-bold" id="offcanvasWithBothOptionsLabel">Filters
                </h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row border-bottom g-2 mb-3">
                    <h3>Work Type</h3>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Full Time
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Part Time
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Contract
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Casual
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row border-bottom g-2">
                    
                    <h3>Location</h3>
                    
                    <input type="" placeholder="Location" class="form-control w-100">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Manila
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Makati
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Pasig
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Quezon City
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- END layout-wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>

        <?php include 'partials/vendor-scripts.php'; ?>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

        <script src="assets/js/app.js"></script>
        
         <script>
       $(document).ready(function() {
    $('#createDriverForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../php/create_driver.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Reload to show the new driver
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('#updateDriverForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: '../php/update_driver.php',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.success) {
                    alert(response.message);
                    location.reload(); // Reload to reflect the updated driver
                } else {
                    alert(response.message);
                }
            }
        });
    });

    $('.delete-driver-btn').on('click', function() {
        const driverId = $(this).data('id');
        if (confirm('Are you sure you want to delete this driver?')) {
            $.ajax({
                url: '../php/delete_user.php',
                type: 'POST',
                data: { id: driverId },
                dataType: 'json',
                success: function(response) {
                    if (response.success) {
                        alert(response.message);
                        location.reload(); // Reload to remove the deleted driver
                    } else {
                        alert(response.message);
                    }
                }
            });
        }
    });
});

</script>
<script src="https://cdn.jsdelivr.net/npm/lightbox2@2.11.4/dist/js/lightbox.min.js"></script>
    </body>
</html>

