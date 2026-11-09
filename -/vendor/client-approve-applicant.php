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

        <?php include 'partials/client-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Client' , 'title' => 'Approve Applicant')); ?>
                        
                        
                      <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                                    <!--    <h4 class="card-title">Approve Applicant</h4>-->
                                    <!--</div>-->
                                     <div class="d-flex justify-content-between align-items-center mb-3">
                                    
                                        <h4 class="card-title">Approve Applicant</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            
                                            <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                            <!--<button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#createTicketModal"><i class="fas fa-plus align-middle me-2"></i> Add New</butto>-->
                                            
                                        </div>
                                    </div>
                                    <p class="card-title-desc">Manage applicants effectively.</p>

                                    <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Applicant #</th>
                                                <th>Applicant Name</th>
                                                <th>Profile Picture</th>
                                                <th>Location (PH)</th>
                                                <th>Status</th>
                                                <th>Last Updated</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example of static data; replace with dynamic data from your database -->
                                            <tr>
                                                <td>1</td>
                                                <td>John Doe</td>
                                                <td><img src="https://via.placeholder.com/50x50" alt="Profile" width="50" height="50"></td>
                                                <td>Manila, PH</td>
                                                <td>Pending</td>
                                                <td>09/28/2024</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="#" class="btn btn-sm btn-warning">Update</a>
                                                    <button class="btn btn-sm btn-success hire-button" data-id="1" data-name="John Doe">Hire</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Jane Smith</td>
                                                <td><img src="https://via.placeholder.com/50x50" alt="Profile" width="50" height="50"></td>
                                                <td>Cebu City, PH</td>
                                                <td>Interview</td>
                                                <td>09/27/2024</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="#" class="btn btn-sm btn-warning">Update</a>
                                                    <button class="btn btn-sm btn-success hire-button" data-id="2" data-name="Jane Smith">Hire</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>3</td>
                                                <td>Mike Johnson</td>
                                                <td><img src="https://via.placeholder.com/50x50" alt="Profile" width="50" height="50"></td>
                                                <td>Davao City, PH</td>
                                                <td>Hired</td>
                                                <td>09/26/2024</td>
                                                <td>
                                                    <a href="#" class="btn btn-sm btn-primary">View</a>
                                                    <a href="#" class="btn btn-sm btn-warning">Update</a>
                                                    <button class="btn btn-sm btn-success hire-button" data-id="2" data-name="Mike Johnson">Hire</button>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>

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
        
        <div class="modal fade" id="createTicketModal" tabindex="-1" aria-labelledby="createTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="createTicketModalLabel">Create Ticket</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <!-- Form for creating a ticket -->
                        <form>


                            <div class="mb-3">
                                <label for="ticketSubject" class="form-label">Subject/Issue</label>
                                <input type="text" class="form-control" id="ticketSubject" required>
                            </div>
                            <div class="mb-3">
                                <label for="ticketDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="ticketDescription" rows="3" required></textarea>
                            </div>


                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary">Submit</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- View Ticket Modal -->
        <div class="modal fade" id="viewTicketModal" tabindex="-1" aria-labelledby="viewTicketModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="viewTicketModalLabel">Ticket Details</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">

                        <div class="mb-3">
                            <label for="modalSubmissionDate" class="form-label">Submission Date</label>
                            <input type="text" class="form-control" id="modalSubmissionDate" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="modalSubject" class="form-label">Subject/Issue</label>
                            <textarea class="form-control" id="modalSubject" rows="3" disabled></textarea>
                        </div>
                        <div class="mb-3">
                            <label for="modalStatus" class="form-label">Status</label>
                            <input type="text" class="form-control" id="modalStatus" disabled>
                        </div>

                        <div class="mb-3">
                            <label for="modalLastUpdated" class="form-label">Last Updated</label>
                            <input type="text" class="form-control" id="modalLastUpdated" disabled>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Update Ticket Modal -->
<div class="modal fade" id="updateTicketModal" tabindex="-1" aria-labelledby="updateTicketModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="updateTicketModalLabel">Update Ticket Status</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="mb-3">
                    <label for="updateStatus" class="form-label">Status</label>
                    <select class="form-select" id="updateStatus">
                        <option value="" disabled selected>Select status</option>
                        <option value="open">Open</option>
                        <option value="in_progress">In Progress</option>
                        <option value="resolved">Resolved</option>
                        <option value="closed">Closed</option>
                    </select>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                <button type="button" class="btn btn-primary" id="saveUpdateBtn">Save Changes</button>
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
                    title: 'Applicant List',
                    text: 'This table displays the list of applicants for specific task',
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
                     text: 'This action will help you to view the full details of applicant',
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
                     text: 'This action will help you to update the status of applicant',
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
                    title: 'Hire',
                     text: 'This action will help you to hire the applicant',
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
                            text: 'Fnish'
                        }
                    ],
                    id: 'filter-fields-step'
                });
                
                tour.start(); 
            
            	document.querySelector('.btn-tour').addEventListener('click', function() {
                    tour.start(); 
                });
                
                 $('#datatable').DataTable();
                
                
                // $('.hire-button').on('click', function() {
                //     // const applicantId = $(this).data('id');
                //     // const applicantName = $(this).data('name');
            
                //     // Swal.fire({
                //     //     title: 'Are you sure?',
                //     //     text: `Do you want to hire ${applicantName}?`,
                //     //     icon: 'warning',
                //     //     showCancelButton: true,
                //     //     confirmButtonColor: '#3085d6',
                //     //     cancelButtonColor: '#d33',
                //     //     confirmButtonText: 'Yes',
                //     //     cancelButtonText: 'No'
                //     // }).then((result) => {
                //     //     if (result.isConfirmed) {
                //     //         // Proceed with the hiring process, e.g., make an AJAX call to hire the applicant
                //     //         // Example: hireApplicant(applicantId);
                //     //         Swal.fire(
                //     //             'Hired!',
                //     //             `${applicantName} has been hired.`,
                //     //             'success'
                //     //         );
                //     //     }
                //     // });
                // });
            });
            
             $(document).on('click', '#datatable .hire-button', function() {
                 
                const applicantId = $(this).data('id');
                const applicantName = $(this).data('name');
        
                Swal.fire({
                    title: 'Are you sure?',
                    text: `Do you want to hire ${applicantName}?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes',
                    cancelButtonText: 'No'
                }).then((result) => {
                    if (result.isConfirmed) {
                        // Proceed with the hiring process, e.g., make an AJAX call to hire the applicant
                        // Example: hireApplicant(applicantId);
                        Swal.fire(
                            'Hired!',
                            `${applicantName} has been hired.`,
                            'success'
                        );
                    }
                });
             });

        </script>

    </body>
</html>
