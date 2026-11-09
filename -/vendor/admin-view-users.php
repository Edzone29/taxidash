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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Users')); ?>
                        
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                                        <!--    <h4 class="card-title">User Management</h4>-->
                                        <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#addUser">Add User</button>-->
                                        <!--</div>-->
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title">User Management</h4>
                                            <div class="d-flex flex-wrap gap-2">
                                                
                                                <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                                <button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#addUser"><i class="fas fa-plus align-middle me-2"></i> Add New</butto>
                                            </div>
                                        </div>
                                        <p class="card-title-desc">Manage users on the platform, including creating, updating, and deleting user accounts.</p>
                                        <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>User ID</th>
                                                    <th>Name</th>
                                                    <th>Email Address</th>
                                                    <th>Role</th>
                                                    <th>Registration Date</th>
                                                    <th>Last Login</th>
                                                    <th>Account Status</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>John Doe</td>
                                                    <td>john.doe@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>2024-01-15</td>
                                                    <td>2024-09-20 10:45 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Jane Smith</td>
                                                    <td>jane.smith@example.com</td>
                                                    <td>Employer</td>
                                                    <td>2024-02-10</td>
                                                    <td>2024-09-21 09:30 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Mike Johnson</td>
                                                    <td>mike.j@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>2024-03-05</td>
                                                    <td>2024-09-19 11:20 AM</td>
                                                    <td>Suspended</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Emily Davis</td>
                                                    <td>emily.d@example.com</td>
                                                    <td>Admin</td>
                                                    <td>2024-04-15</td>
                                                    <td>2024-09-22 08:15 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Chris Brown</td>
                                                    <td>chris.b@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>2024-05-25</td>
                                                    <td>2024-09-20 12:00 PM</td>
                                                    <td>Inactive</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Sara Wilson</td>
                                                    <td>sara.w@example.com</td>
                                                    <td>Job Seeker</td>
                                                    <td>2024-06-30</td>
                                                    <td>2024-09-18 09:45 AM</td>
                                                    <td>Active</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm btn-view">View</button>
                                                        <button class="btn btn-secondary btn-sm btn-update">Update</button>
                                                        <button class="btn btn-danger btn-sm btn-delete">Delete</button>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                        </div>
                        
                                    </div>
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
        
        <div class="modal fade" id="addUser" tabindex="-1" aria-labelledby="addUserLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addUserLabel">Add New User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addUserForm">
                            <div class="mb-3">
                                <label for="userName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="userName" required>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="userEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="userRole" class="form-label">Role</label>
                                <select class="form-select" id="userRole" required>
                                    <option value="">Select Role</option>
                                    <option value="Job Seeker">Job Seeker</option>
                                    <option value="Employer">Employer</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="userStatus" class="form-label">Account Status</label>
                                <select class="form-select" id="userStatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>
                            <!--<button type="submit" class="btn btn-primary">Add User</button>-->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                        <button type="submit" class="btn btn-primary" form="addFilterForm"><i class="far fa-save align-middle me-2"></i>Add User</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Modal for Editing User -->
        <div class="modal fade" id="editUserModal" tabindex="-1" aria-labelledby="editUserModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editUserModalLabel">Update User</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editUserForm">
                            <input type="hidden" id="editUserId">
                            <div class="mb-3">
                                <label for="editUserName" class="form-label">Name</label>
                                <input type="text" class="form-control" id="editUserName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserEmail" class="form-label">Email Address</label>
                                <input type="email" class="form-control" id="editUserEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="editUserRole" class="form-label">Role</label>
                                <select class="form-select" id="editUserRole" required>
                                    <option value="">Select Role</option>
                                    <option value="Job Seeker">Job Seeker</option>
                                    <option value="Employer">Employer</option>
                                    <option value="Admin">Admin</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="editUserStatus" class="form-label">Account Status</label>
                                <select class="form-select" id="editUserStatus" required>
                                    <option value="">Select Status</option>
                                    <option value="Active">Active</option>
                                    <option value="Inactive">Inactive</option>
                                    <option value="Suspended">Suspended</option>
                                </select>
                            </div>
                            <button type="submit" class="btn btn-primary">Save Changes</button>
                        </form>
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
                    title: 'Add a New user',
                    text: 'Adding a new user is simple. Just click this button.',
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
                    title: 'Add User Fields',
                    text: `
                        <p>Use these fields to input the details of new user.</p>
                        <img src="add-user.png" alt="Tour example image" style="width: 100%; height: auto;">
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
                    title: 'Filter List',
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
                    title: 'Update',
                    text: `
                        <p>This will let user to update the details of existing user.</p>
                        <img src="update-user.png" alt="Tour example image" style="width: 100%; height: auto;">
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
                    title: 'Delete',
                    text: `
                        <p>This will let user to delete particular user</p>
                        <img src="delete.png" alt="Tour example image" style="width: 100%; height: auto;">
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
                                return this.complete();
                            },
                            text: 'Finish'
                        }
                    ],
                    id: 'filter-fields-step'
                });
                
                
            
            	document.querySelector('.btn-tour').addEventListener('click', function() {
                    tour.start(); 
                });
                
                
                $('#datatable').DataTable();
                
                $('.btn-delete').on('click', function() {
                    var row = $(this).closest('tr'); // Get the closest row
                    var userName = row.find('td:nth-child(2)').text(); // Get the user's name from the second column
            
                    // Show SweetAlert confirmation
                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You will not be able to recover this user!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#d33',
                        cancelButtonColor: '#3085d6',
                        confirmButtonText: 'Yes, delete it!',
                        cancelButtonText: 'No, cancel!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // If confirmed, proceed with deletion
                            // (Replace this with your deletion logic)
                            row.remove(); // Remove the row from the table
                            Swal.fire(
                                'Deleted!',
                                userName + ' has been deleted.',
                                'success'
                            );
                        }
                    });
                });
                
                $('.btn-update').on('click', function() {
                    var row = $(this).closest('tr'); // Get the closest row
            
                    // Retrieve existing user data from the row
                    var userId = row.find('td:nth-child(1)').text(); // User ID
                    var userName = row.find('td:nth-child(2)').text(); // User Name
                    var userEmail = row.find('td:nth-child(3)').text(); // User Email
                    var userRole = row.find('td:nth-child(4)').text(); // User Role
                    var userStatus = row.find('td:nth-child(7)').text(); // User Status
                   
            
                    // Populate the modal fields with existing data
                    $('#editUserId').val(userId);
                    $('#editUserName').val(userName);
                    $('#editUserEmail').val(userEmail);
                    $('#editUserRole').val(userRole);
                    $('#editUserStatus').val(userStatus);
                   
            
                    // Show the modal
                    $('#editUserModal').modal('show');
                });
            });

        </script>

    </body>
</html>
