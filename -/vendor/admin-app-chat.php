<?php include 'partials/session.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
       <style>
        .message-list {
            max-height: 400px;
            overflow-y: auto;
        }
        .avatar {
            width: 50px;
            height: 50px;
            background-color: #e9ecef;
        }
        .message-preview {
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }
        .btn-teal {
            background-color: #20c997;
            border-color: #20c997;
            color: white;
        }
        .btn-teal:hover {
            background-color: #1ba87e;
            border-color: #1ba87e;
            color: white;
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Message List')); ?>
                        
                        <div class="row">
            <div class="col-md-4">
                <div class="card shadow">
                    <div class="card-header bg-light">
                        <h5 class="card-title mb-0">Client Messages</h5>
                    </div>
                    <div class="card-body">
                        <div class="input-group mb-3 search-message">
                            <input type="text" class="form-control" placeholder="Search messages..." aria-label="Search messages">
                            <button class="btn btn-teal" type="button">Search</button>
                        </div>
                        <button class="btn btn-teal w-100 mb-3 start-chat">Start Chat</button>
                        <ul class="list-group message-list message-list">
                             <a href="admin-chat-view">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="avatar rounded-circle me-3"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Sender 1</h6>
                                    <p class="mb-0 small text-muted message-preview">Hello! How are you? I hope everything...</p>
                                </div>
                            </li>
                            </a>
                             <a href="admin-chat-view">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="avatar rounded-circle me-3"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Sender 2</h6>
                                    <p class="mb-0 small text-muted message-preview">Are you coming to the meeting? I need to know...</p>
                                </div>
                            </li>
                            </a>
                             <a href="admin-chat-view">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="avatar rounded-circle me-3"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Sender 3</h6>
                                    <p class="mb-0 small text-muted message-preview">Please review the attached document. Let me know...</p>
                                </div>
                            </li>
                            </a>
                             <a href="admin-chat-view">
                            <li class="list-group-item d-flex align-items-center">
                                <div class="avatar rounded-circle me-3"></div>
                                <div class="flex-grow-1">
                                    <h6 class="mb-0">Sender 4</h6>
                                    <p class="mb-0 small text-muted message-preview">Looking forward to your feedback on the proposal...</p>
                                </div>
                            </li>
                            </a>
                        </ul>
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
                    title: 'Search',
                    text: 'For Searching specific message',
                    attachTo: {
                        element: '.search-message',
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
                    title: 'Start Chat',
                    text: 'For starting new conversation',
                    attachTo: {
                        element: '.start-chat',
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
                    id: 'filter-fields-step'
                });
                
                tour.addStep({
                    title: 'Message List',
                    text: 'List of available messages',
                     attachTo: {
                        element: '.message-list',
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
                                return this.complete();
                            },
                            text: 'Finish'
                        }
                    ],
                    id: 'filter-list-step'
                });

                
                
                
                tour.start(); 
                
                
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
