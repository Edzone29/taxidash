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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Search Filters')); ?>
                        
                        
                      <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h4 class="card-title">Search Filters</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            
                                            <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                            <button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#addFilterModal"><i class="fas fa-plus align-middle me-2"></i> Add New</butto>
                                        </div>
                                    </div>
                                    <p class="card-title-desc">The **Search Filters Table** allows users to effectively manage their search preferences by adding, updating, and deleting filters.
                                    </p>
                    
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Category Name</th>
                                                <th>Description</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                    
                                        <tbody>
                                            <tr>
                                                <td>1</td>
                                                <td>Work</td>
                                                <td>Tasks related to professional projects.</td>
                                                <td>
                                                    <button class="btn btn-warning edit-btn" data-id="1">Update</button>
                                                    <button class="btn btn-danger delete-btn" data-id="1">Delete</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td>2</td>
                                                <td>Personal</td>
                                                <td>Errands and personal chores.</td>
                                                <td>
                                                    <button class="btn btn-warning edit-btn" data-id="2">Update</button>
                                                    <button class="btn btn-danger delete-btn" data-id="2">Delete</button>
                                                </td>
                                            </tr>
                                            
                                        </tbody>
                                    </table>
                    
                                </div>
                            </div>
                        </div> <!-- end col -->
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
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                        <button type="submit" class="btn btn-primary" form="addFilterForm"><i class="far fa-save align-middle me-2"></i>Save Filter</button>
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
                    title: 'Add a New Filter',
                    text: 'Adding a new filter is simple. Just click this button.',
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
                    title: 'New Filter Fields',
                    text: `
                        <p>Use these fields to input the filter criteria you need.</p>
                        <img src="new-filterr.png" alt="Tour example image" style="width: 100%; height: auto;">
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
                    text: 'This will let user to update the filter details.</p>',
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
                    text: '<p>This will let user to delete particular filter</p>',
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
                
                
                
                $('#datatable').DataTable({
        responsive: true
    });
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
