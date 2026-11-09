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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Support')); ?>
                        
                        
                      <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                    
                                        <h4 class="card-title">Customer Support</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            
                                            <button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>
                                            <button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#createTicketModal"><i class="fas fa-plus align-middle me-2"></i> Add New</butto>
                                            
                                        </div>
                                    </div>
                                    <p class="card-title-desc">Manage user support tickets effectively.</p>
                                    <div class="table-responsive">
                                    <table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
                                        <thead>
                                            <tr>
                                                <th>Ticket ID</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Submission Date</th>
                                                <th>Subject/Issue</th>
                                                <th>Status</th>
                                                <th>Priority</th>
                                                <th>Last Updated</th>
                                                <th>Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- Example of static data; replace with dynamic data from your database -->
                                            <tr>
                                                <td>101</td>
                                                <td>John Doe</td>
                                                <td>johndoe@example.com</td>
                                                <td>09/20/2024 10:15 AM</td>
                                                <td>Unable to reset password</td>
                                                <td>Open</td>
                                                <td>High</td>
                                                <td>09/20/2024 11:00 AM</td>
                                                <td>
                                                    <button class="btn btn-info btn-sm view-ticket" 
            data-user-name="John Doe"
            data-user-email="johndoe@example.com"
            data-submission-date="09/20/2024 10:15 AM"
            data-subject="Unable to reset password"
            data-status="Open"
            data-priority="High"
            data-last-updated="09/20/2024 11:00 AM">View</button>
                                                    <button class="btn btn-warning btn-sm update-ticket" data-bs-toggle="modal" data-bs-target="#updateTicketModal101">Update</button>
                                                    <button class="btn btn-danger btn-sm" onclick="deleteTicket(101)">Delete</button>
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
                                <label for="userName" class="form-label">User Name</label>
                                <input type="text" class="form-control" id="userName" required>
                            </div>
                            <div class="mb-3">
                                <label for="userEmail" class="form-label">User Email</label>
                                <input type="email" class="form-control" id="userEmail" required>
                            </div>
                            <div class="mb-3">
                                <label for="ticketSubject" class="form-label">Subject/Issue</label>
                                <input type="text" class="form-control" id="ticketSubject" required>
                            </div>
                            <div class="mb-3">
                                <label for="ticketDescription" class="form-label">Description</label>
                                <textarea class="form-control" id="ticketDescription" rows="3" required></textarea>
                            </div>
                            <div class="mb-3">
                                <label for="ticketPriority" class="form-label">Priority</label>
                                <select class="form-select" id="ticketPriority" required>
                                    <option value="" disabled selected>Select Priority</option>
                                    <option value="Low">Low</option>
                                    <option value="Medium">Medium</option>
                                    <option value="High">High</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="ticketStatus" class="form-label">Status</label>
                                <select class="form-select" id="ticketStatus" required>
                                    <option value="" disabled selected>Select Status</option>
                                    <option value="Open">Open</option>
                                    <option value="In Progress">In Progress</option>
                                    <option value="Resolved">Resolved</option>
                                    <option value="Closed">Closed</option>
                                </select>
                            </div>
                        </form>
                    </div>
                    <div class="modal-footer">
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <!--<button type="button" class="btn btn-primary">Submit</button>-->
                        
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                        <button type="submit" class="btn btn-primary" ><i class="fas fa-paper-plane align-middle me-2"></i>Submit</button>
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
                            <label for="modalUserName" class="form-label">User Name</label>
                            <input type="text" class="form-control" id="modalUserName" disabled>
                        </div>
                        <div class="mb-3">
                            <label for="modalUserEmail" class="form-label">User Email</label>
                            <input type="email" class="form-control" id="modalUserEmail" disabled>
                        </div>
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
                            <label for="modalPriority" class="form-label">Priority</label>
                            <input type="text" class="form-control" id="modalPriority" disabled>
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
                <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                <!--<button type="button" class="btn btn-primary" id="saveUpdateBtn">Save Changes</button>-->
                
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                <button type="submit" class="btn btn-primary" id="saveUpdateBtn"><i class="far fa-save align-middle me-2"></i>Save</button>
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
        
     

    </body>
</html>
