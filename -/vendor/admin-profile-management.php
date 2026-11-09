<?php include 'partials/session.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>

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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Profile Management')); ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                                        <!--    <h4 class="card-title">Profile Management</h4>-->
                                        <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Profile</button>-->
                                        <!--</div>-->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title">Profile Management</h4>
                                            <div class="d-flex flex-wrap gap-2">
                                                
                                                <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                                <!--<button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUserModal">Add Profile</button>-->
                                                <button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#addUserModal"><i class="fas fa-plus align-middle me-2"></i> Add New</button>
                                            </div>
                                        </div>
                                        <p class="card-title-desc">Manage users on the platform, including creating, updating, and deleting user accounts.</p>
                         <!--<div class="table-responsive">-->
                                        <table id="datatable" class="table table-bordered dt-responsive display responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th> ID</th>
                                                    <th>Name</th>
                                                    <th>Email</th>
                                                    <th>Profile Type</th>
                                                    <th>Registration Date</th>
                                                    <th>Last Login</th>
                                                    <th>Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>John Doe</td>
                                                    <td>john.doe@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>01/15/2023</td>
                                                    <td>09/27/2024 10:00 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info btn-view" data-id="1">View</button>
                                                        <button type="button" class="btn btn-sm btn-warning btn-update" data-id="1">Update</button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="1">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Jane Smith</td>
                                                    <td>jane.smith@example.com</td>
                                                    <td>Employer</td>
                                                    <td>02/20/2023</td>
                                                    <td>09/26/2024 09:45 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info btn-view" data-id="2">View</button>
                                                        <button type="button" class="btn btn-sm btn-warning btn-update" data-id="2">Update</button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="2">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Alex Johnson</td>
                                                    <td>alex.j@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>03/10/2023</td>
                                                    <td>08/30/2024 08:15 AM</td>
                                                    <td>Inactive</td>
                                                    <td>
                                                        <button type="button" class="btn btn-sm btn-info btn-view" data-id="3">View</button>
                                                        <button type="button" class="btn btn-sm btn-warning btn-update" data-id="3">Update</button>
                                                        <button type="button" class="btn btn-sm btn-danger btn-delete" data-id="3">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                        <!--</div>-->
                                    </div>
                                </div>
                            </div>
                        </div>

                        
                    </div>
                   
                    </div> <!-- container-fluid -->
                </div>
                
                <div class="modal fade" id="addUserModal" tabindex="-1" aria-labelledby="addUserModalLabel" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="addUserModalLabel">Add New Profile</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <form id="addUserForm">
                                    <div class="mb-3">
                                        <label for="userName" class="form-label">Name</label>
                                        <input type="text" class="form-control" id="userName" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="userEmail" class="form-label">Email</label>
                                        <input type="email" class="form-control" id="userEmail" required>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profileType" class="form-label">Profile Type</label>
                                        <select class="form-select" id="profileType" required>
                                            <option value="" disabled selected>Select profile type</option>
                                            <option value="Job Seeker">Job Seeker</option>
                                            <option value="Employer">Employer</option>
                                        </select>
                                    </div>
                                    <div class="mb-3">
                                        <label for="profileImage" class="form-label">Upload Profile Image</label>
                                        <input type="file" class="form-control" id="profileImage" accept="image/*" onchange="previewImage(event)">
                                        <img id="imagePreview" src="#" alt="Image Preview" class="mt-2" style="display:none; width: 100%; max-height: 200px; object-fit: cover;">
                                    </div>
                                </form>
                            </div>
                            <div class="modal-footer">
                                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                                <!--<button type="submit" class="btn btn-primary" form="addUserForm">Add Profile</button>-->
                                
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                                <button type="submit" class="btn btn-primary" form="addUserForm"><i class="far fa-save align-middle me-2"></i>Add Profile</button>
                            </div>
                        </div>
                    </div>
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
        
<!-- DataTables CSS -->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.13.6/css/jquery.dataTables.min.css">-->

<!-- DataTables Responsive Extension CSS -->
<!--<link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/responsive/2.4.1/css/responsive.dataTables.min.css">-->

<!-- jQuery -->
<!--<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>-->

<!-- DataTables JS -->
<!--<script src="https://cdn.datatables.net/1.13.6/js/jquery.dataTables.min.js"></script>-->

<!-- DataTables Responsive Extension JS -->
<!--<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>-->


        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        
        <script>
           $(document).ready(function() {
               
               
               const tour = new Shepherd.Tour({
                    defaultStepOptions: {
                        cancelIcon: {
                            enabled: true
                        },
                        classes: 'class-1 class-2',
                        scrollTo: { behavior: 'smooth', block: 'center' }
                    },
                    useModalOverlay: true
                });
                
                tour.addStep({
                    title: 'Add a New profile',
                    text: 'Adding a new profile is simple. Just click this button.',
                    attachTo: {
                        element: '.add-filter-btn',
                        on: 'bottom'
                    },
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'Next'
                        }
                    ],
                    id: 'add-filter-step'
                });
                
                tour.addStep({
                    title: 'Add Profile Fields',
                    text: `
                        <p>Use these fields to input the details of new profile.</p>
                        <img src="add-profile.png" alt="Tour example image" style="width: 100%; height: auto;">
                    `,
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'Next'
                        }
                    ],
                    id: 'filter-fields-step'
                });
                
                tour.addStep({
                    title: 'Profile List',
                    text: 'This table displays the list of existing and newly added filters.',
                    attachTo: {
                        element: '.table',
                        on: 'bottom'
                    },
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'Next'
                        }
                    ],
                    id: 'filter-list-step'
                });
                
                
                 tour.addStep({
                    title: 'View',
                    text: 'This will let user to view the full details of existing profile.',
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'Next'
                        }
                    ],
                    id: 'filter-fields-step'
                });

                
                tour.addStep({
                    title: 'Update',
                    text: 'This will let user to update the details of existing profile.',
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.next();
                            },
                            text: 'Next'
                        }
                    ],
                    id: 'filter-fields-step'
                });
                
                tour.addStep({
                    title: 'Delete',
                    text: 'This will let user to delete particular profile',
                    buttons: [
                        {
                            action() {
                                return this.back();
                            },
                            classes: 'shepherd-button-secondary',
                            text: 'Back'
                        },
                        {
                            action() {
                                return this.complete();
                            },
                            text: 'Finish'
                        }
                    ],
                    id: 'filter-fields-step'
                });
                
                tour.start();
                
                document.querySelector('.btn-tour').addEventListener('click', function() {
                    tour.start(); 
                });
               
               
               $('#datatable').DataTable();

            });

        </script>

    </body>
</html>
