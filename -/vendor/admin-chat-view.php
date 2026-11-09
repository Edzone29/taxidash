<?php include 'partials/session.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
        <style>

            .chat-container {
                height: 400px;
                overflow-y: auto;
            }
            .message {
                max-width: 70%;
                margin-bottom: 10px;
                padding: 10px;
                border-radius: 15px;
            }
            .message-receiver {
                background-color: #f1f3f5;
                align-self: flex-start;
            }
            .message-sender {
                background-color: #007bff;
                color: white;
                align-self: flex-end;
            }
            .message-input {
                border-top: 1px solid #dee2e6;
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'View Message')); ?>
                        
                        <div class="row">
                            <div class="col-md-5">
                                <div class="card shadow">
                                    <div class="card-header bg-light">
                                        <h5 class="card-title mb-0">View Message</h5>
                                    </div>
                                    <div class="card-body p-0">
                                        <div class="chat-container p-3">
                                            <div class="d-flex flex-column">
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">Hello! How are you?</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">I'm doing well, thank you! How about you?</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">I'm great, thanks for asking. Did you have a chance to review the project proposal?</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">Yes, I did. I think it looks promising. I have a few questions though.</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">That's good to hear. What questions do you have?</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">I was wondering about the timeline. Do you think we can complete it within three months?</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">Three months might be a bit tight, but I believe we can make it work if we prioritize effectively.</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">Alright, that makes sense. We should probably schedule a meeting to discuss the details.</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">Absolutely. How about next Tuesday at 2 PM?</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">Tuesday at 2 PM works for me. I'll send out a calendar invite.</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">Perfect! Looking forward to it. Is there anything else you'd like to discuss before the meeting?</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">Not at the moment. I think we've covered the main points. I'll compile a list of detailed questions for the meeting.</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">Sounds good. Don't hesitate to reach out if anything comes up before then.</p>
                                                </div>
                                                <div class="message message-sender align-self-end">
                                                    <strong>You</strong>
                                                    <p class="mb-0">Will do. Thanks for your time!</p>
                                                </div>
                                                <div class="message message-receiver">
                                                    <strong>Sender 1</strong>
                                                    <p class="mb-0">You're welcome. Have a great day!</p>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="message-input p-3">
                                            <div class="input-group">
                                                <input type="text" class="form-control" placeholder="Type your message here..." aria-label="Type your message">
                                                <button class="btn btn-teal" type="button">Send</button>
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
