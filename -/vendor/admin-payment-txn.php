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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Payment')); ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title">Secure Payments</h4>
                                            <div class="d-flex flex-wrap gap-2">
                                                
                                                <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                            </div>
                                        </div>
                                        <p class="card-title-desc">This section displays the list of payment transactions processed through the platform.</p>
                                        <div class="table-responsive">
                                        <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>Transaction ID</th>
                                                    <th>Date</th>
                                                    <th>User</th>
                                                    <th>Payment Method</th>
                                                    <th>Amount</th>
                                                    <th>Status</th>
                                                    <th>Recipient</th>
                                                    <th>Description</th>
                                                    <th>Actions</th>
                                                </tr>
                                            </thead>
                        
                                            <tbody>
                                                <tr>
                                                    <td>123456</td>
                                                    <td>2024-09-01</td>
                                                    <td>John Doe</td>
                                                    <td>Credit Card</td>
                                                    <td>$50.00</td>
                                                    <td>Successful</td>
                                                    <td>Job Listings Inc.</td>
                                                    <td>Job Posting Fee</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>123457</td>
                                                    <td>2024-09-05</td>
                                                    <td>Jane Smith</td>
                                                    <td>PayPal</td>
                                                    <td>$20.00</td>
                                                    <td>Pending</td>
                                                    <td>Job Seekers Ltd.</td>
                                                    <td>Premium Subscription</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>123458</td>
                                                    <td>2024-09-10</td>
                                                    <td>Mike Johnson</td>
                                                    <td>Bank Transfer</td>
                                                    <td>$30.00</td>
                                                    <td>Failed</td>
                                                    <td>Job Ads Corp.</td>
                                                    <td>Job Posting Fee</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>123459</td>
                                                    <td>2024-09-12</td>
                                                    <td>Emily Davis</td>
                                                    <td>Credit Card</td>
                                                    <td>$75.00</td>
                                                    <td>Successful</td>
                                                    <td>Recruitment Agency</td>
                                                    <td>Consultation Fee</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>123460</td>
                                                    <td>2024-09-15</td>
                                                    <td>Chris Brown</td>
                                                    <td>PayPal</td>
                                                    <td>$100.00</td>
                                                    <td>Successful</td>
                                                    <td>Job Postings Ltd.</td>
                                                    <td>Annual Membership</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td>123461</td>
                                                    <td>2024-09-18</td>
                                                    <td>Sara Wilson</td>
                                                    <td>Bank Transfer</td>
                                                    <td>$15.00</td>
                                                    <td>Pending</td>
                                                    <td>Job Seekers Hub</td>
                                                    <td>Resume Review</td>
                                                    <td>
                                                        <button class="btn btn-info btn-sm">View</button>
                                                        <button class="btn btn-secondary btn-sm">Download Receipt</button>
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
        
        <div class="modal fade" id="addFilterModal" tabindex="-1" aria-labelledby="addFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addFilterModalLabel">Add New Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="addFilterForm">
                            <div class="mb-3">
                                <label for="filterLabel" class="form-label">Filter Label</label>
                                <input type="text" class="form-control" id="filterLabel" name="filterLabel" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="addFilterForm">Save Filter</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="updateFilterModal" tabindex="-1" aria-labelledby="updateFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFilterModalLabel">Update Filter</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateFilterForm">
                            <div class="mb-3">
                                <label for="updateFilterLabel" class="form-label">Filter Label</label>
                                <input type="text" class="form-control" id="updateFilterLabel" name="updateFilterLabel" required>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="updateFilterForm">Update Filter</button>
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
                    title: 'Payment Transaction List',
                    text: 'This table displays the list of all transaction from the platform.',
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
                    title: 'Download Receipt',
                    text: 'This will let the user to download the transactions receipt',
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
                    title: 'View',
                    text: 'This will let the user to view the full details of transactions',
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
                    id: 'filter-list-step'
                });
                
                tour.start(); 
            
            	document.querySelector('.btn-tour').addEventListener('click', function() {
                    tour.start(); 
                });
                
                 $('#datatable').DataTable();
                 
    // Handle Update button click
                $('.update-btn').on('click', function() {
                    // Get the row data
                    var row = $(this).closest('tr');
                    var filterLabel = row.find('td:eq(1)').text();
                    var filterField = row.find('td:eq(0)').text();
            
                    // Set the data in the Update Filter modal
                    $('#updateFilterLabel').val(filterLabel);
                    $('#updateFilterField').val(filterField);
            
                    // Show the modal
                    $('#updateFilterModal').modal('show');
                });
                
                 $('.delete-btn').on('click', function() {
        var row = $(this).closest('tr');

                    Swal.fire({
                        title: 'Are you sure?',
                        text: "You won't be able to revert this!",
                        icon: 'warning',
                        showCancelButton: true,
                        confirmButtonColor: '#3085d6',
                        cancelButtonColor: '#d33',
                        confirmButtonText: 'Yes, delete it!'
                    }).then((result) => {
                        if (result.isConfirmed) {
                            // Remove the row from the table
                            row.remove();
            
                            // Show a success message
                            Swal.fire(
                                'Deleted!',
                                'The filter has been deleted.',
                                'success'
                            );
                        }
                    });
                })
            });

        </script>

    </body>
</html>
