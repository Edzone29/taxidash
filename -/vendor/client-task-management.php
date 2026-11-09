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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Task Management')); ?>
                        
                        <div class="row">
         <div class="col-12">
    <div class="card">
        <div class="card-body">
            <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
            <!--    <h4 class="card-title">Task Management</h4>-->
            <!--</div>-->
            <div class="d-flex justify-content-between align-items-center mb-3">
                <h4 class="card-title">Task Management</h4>
                <div class="d-flex flex-wrap gap-2">
                    
                    <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                    <!--<button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#addFilterModal"><i class="fas fa-plus align-middle me-2"></i> Add New</butto>-->
                </div>
            </div>
            <p class="card-title-desc">
                Manage your tasks efficiently. Use the options below to view and update task progress.
            </p>
            <!--<div class="table-responsive">-->
            <table id="datatable" class="table dt-responsive table-bordered nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Task ID</th>
            <th>Task Name</th>
            <th>Applicant</th>
            <th>Due Date</th>
            <th>Status</th>
            <th>Progress</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>1</td>
            <td>Design Mockup</td>
            <td>John Doe</td>
            <td>2024-10-01</td>
            <td>In Progress</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 50%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">50%</div>
                </div>
            </td>
            <td>
                <button class="btn btn-warning btn-sm update-btn" data-filter-label="Work Type" data-bs-toggle="modal" data-bs-target="#updateFilterModal">Edit</button>
            </td>
        </tr>
        <tr>
            <td>2</td>
            <td>Develop API</td>
            <td>Jane Smith</td>
            <td>2024-09-30</td>
            <td>Completed</td>
            <td>
                <div class="progress">
                    <div class="progress-bar bg-success" role="progressbar" style="width: 100%;" aria-valuenow="100" aria-valuemin="0" aria-valuemax="100">100%</div>
                </div>
            </td>
            <td>
                <button class="btn btn-warning btn-sm update-btn" data-filter-label="Work Type" data-bs-toggle="modal" data-bs-target="#updateFilterModal">Edit</button>
            </td>
        </tr>
        <tr>
            <td>3</td>
            <td>Testing</td>
            <td>Michael Brown</td>
            <td>2024-10-05</td>
            <td>Not Started</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">0%</div>
                </div>
            </td>
            <td>
                <button class="btn btn-warning btn-sm update-btn" data-filter-label="Work Type" data-bs-toggle="modal" data-bs-target="#updateFilterModal">Edit</button>
            </td>
        </tr>
        <tr>
            <td>4</td>
            <td>Deployment</td>
            <td>Emily Davis</td>
            <td>2024-10-10</td>
            <td>In Progress</td>
            <td>
                <div class="progress">
                    <div class="progress-bar" role="progressbar" style="width: 20%;" aria-valuenow="20" aria-valuemin="0" aria-valuemax="100">20%</div>
                </div>
            </td>
            <td>
                <button class="btn btn-warning btn-sm update-btn" data-filter-label="Work Type" data-bs-toggle="modal" data-bs-target="#updateFilterModal">Edit</button>
            </td>
        </tr>
    </tbody>
</table>

            <!--</div>-->
        </div>
    </div>
</div>
 <!-- end col -->
                        </div>
                      



                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <?php include 'partials/footer.php'; ?>

            </div>
            <!-- end main content-->

        </div>
        
        <!-- Modal for editing task -->
        <!-- Update Filter Modal -->
        <div class="modal fade" id="updateFilterModal" tabindex="-1" aria-labelledby="updateFilterModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="updateFilterModalLabel">Update Task</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="updateTaskForm">
                            <div class="mb-3">
                                <label for="status" class="form-label">Statuss</label>
                                <select class="form-select" required>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Completed">Completed</option>
                                    <option value="Pending">Pending</option>
                                    <option value="Cancelled">Cancelled</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="progress" class="form-label">Progress (%)</label>
                                <input type="number" class="form-control" id="progress" name="progress" min="0" max="100" required>
                            </div>
                            <input type="hidden" id="taskId" name="taskId"> <!-- To store the task ID if needed -->
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveChangesBtn">Save changes</button>
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
                    title: 'Task Management List',
                    text: 'This table displays the list of all your existing task',
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
                    text: 'This will let user to update the status of your Task.</p>',
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
                
                // $('.update-btn').on('click', function() {
                //     const row = $(this).closest('tr'); // Get the closest table row
                //     const status = row.find('td').eq(4).text(); // Get the current status from the fifth cell
                //     const progress = row.find('.progress-bar').css('width'); // Get the current progress width
            
                //     // Populate the modal fields
                //     $('#status').val(status);
                //     $('#progress').val(parseInt(progress)); // Convert '20%' to 20
                //     $('#taskId').val(row.find('td').eq(0).text()); // Get the task ID from the first cell if needed
                // });
            
                $('#saveChangesBtn').on('click', function() {
                    const status = $('#status').val();
                    const progress = $('#progress').val();
                    const taskId = $('#taskId').val();
            
                    // Logic to update the table with new values
                    const rowToUpdate = $('tr').find('td:first-child').filter(function() {
                        return $(this).text() === taskId; // Find the row by task ID
                    }).closest('tr');
            
                    rowToUpdate.find('td').eq(4).text(status); // Update status
                    rowToUpdate.find('.progress-bar').css('width', progress + '%').text(progress + '%'); // Update progress bar
            
                    // Close the modal
                    $('#updateFilterModal').modal('hide');
                });
            });



        </script>

    </body>
</html>
