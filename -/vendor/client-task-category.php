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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Task Category')); ?>
                        
                        <div class="row">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-body">
                                        <div class="d-flex justify-content-between align-items-center mb-3">
                                            <h4 class="card-title">Task Category</h4>
                                            
                                        </div>
                                        <p class="card-title-desc">This enables users to efficiently organize and manage their tasks by viewing categories. This functionality helps streamline task management and improves productivity.</p>

                                        <p class="card-title-desc"></code>.
                                        </p>
                                        <!--<div class="table-responsive">-->
                                       <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                            <thead>
                                                <tr>
                                                    <th>#</th>
                                                    <th>Category Name</th>
                                                    <th>Description</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                <tr>
                                                    <td>1</td>
                                                    <td>Work</td>
                                                    <td>Tasks related to professional projects.</td>
                                                </tr>
                                                <tr>
                                                    <td>2</td>
                                                    <td>Personal</td>
                                                    <td>Errands and personal chores.</td>
                                                </tr>
                                                <tr>
                                                    <td>3</td>
                                                    <td>Education</td>
                                                    <td>Study-related tasks, including assignments and research.</td>
                                                </tr>
                                                <tr>
                                                    <td>4</td>
                                                    <td>Health</td>
                                                    <td>Tasks focused on physical and mental well-being.</td>
                                                </tr>
                                                <tr>
                                                    <td>5</td>
                                                    <td>Finance</td>
                                                    <td>Budgeting, expense tracking, and financial planning tasks.</td>
                                                </tr>
                                                <tr>
                                                    <td>6</td>
                                                    <td>Household</td>
                                                    <td>Tasks related to home maintenance and organization.</td>
                                                </tr>
                                                <tr>
                                                    <td>7</td>
                                                    <td>Social</td>
                                                    <td>Planning events, outings, and gatherings with friends.</td>
                                                </tr>
                                                <tr>
                                                    <td>8</td>
                                                    <td>Travel</td>
                                                    <td>Arranging trips, bookings, and itineraries.</td>
                                                </tr>
                                                <tr>
                                                    <td>9</td>
                                                    <td>Volunteer</td>
                                                    <td>Community service and volunteer-related tasks.</td>
                                                </tr>
                                                <tr>
                                                    <td>10</td>
                                                    <td>Hobbies</td>
                                                    <td>Tasks related to leisure activities and personal interests.</td>
                                                </tr>
                                            </tbody>
                                        </table>

                                        <!--</div>-->
                        
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
        
         <div class="modal fade" id="taskCategoryModal" tabindex="-1" aria-labelledby="taskCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="taskCategoryModalLabel">Add Task Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="taskCategoryForm">
                            <input type="hidden" id="taskCategoryId">
                            <div class="mb-3">
                                <label for="categoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="categoryName" required>
                            </div>
                            <div class="mb-3">
                                <label for="categoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="categoryDescription" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveTaskCategory">Save</button>
                    </div>
                </div>
            </div>
        </div>
        
        <div class="modal fade" id="editTaskCategoryModal" tabindex="-1" aria-labelledby="editTaskCategoryModalLabel" aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTaskCategoryModalLabel">Edit Task Category</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <form id="editTaskCategoryForm">
                            <input type="hidden" id="editCategoryId">
                            <div class="mb-3">
                                <label for="editCategoryName" class="form-label">Category Name</label>
                                <input type="text" class="form-control" id="editCategoryName" required>
                            </div>
                            <div class="mb-3">
                                <label for="editCategoryDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="editCategoryDescription" rows="3" required></textarea>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                        <button type="button" class="btn btn-primary" id="saveEditButton">Save changes</button>
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
            
             $('#datatable').DataTable();
             
            var editModal = new bootstrap.Modal(document.getElementById('editTaskCategoryModal'));
        
            $(document).on('click', '.edit-btn', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                var name = row.find('td:eq(1)').text();
                var description = row.find('td:eq(2)').text();
        
                $('#editCategoryId').val(id);
                $('#editCategoryName').val(name);
                $('#editCategoryDescription').val(description);
        
                editModal.show();
            });
        
            // Save changes when save button is clicked
            $('#saveEditButton').click(function() {
                if ($('#editTaskCategoryForm')[0].checkValidity()) {
                    var id = $('#editCategoryId').val();
                    var name = $('#editCategoryName').val();
                    var description = $('#editCategoryDescription').val();
        
                    // Update the table row
                    var row = $('.edit-btn[data-id="' + id + '"]').closest('tr');
                    row.find('td:eq(1)').text(name);
                    row.find('td:eq(2)').text(description);
        
               
                    editModal.hide();
                } else {
                    $('#editTaskCategoryForm')[0].reportValidity();
                }
            });
            
            
            $('.delete-btn').on('click', function() {
                var row = $(this).closest('tr');
                var id = $(this).data('id');
                var categoryName = row.find('td:eq(1)').text();
        
                Swal.fire({
                    title: 'Are you sure?',
                    text: `You are about to delete the category "${categoryName}". This action cannot be undone.`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                     
        
                        // For demonstration, we'll just remove the row without an AJAX call
                        row.remove();
                        Swal.fire(
                            'Deleted!',
                            'The category has been deleted.',
                            'success'
                        );
                    }
                });
            });
            
        });
                   



        </script>

    </body>
</html>
