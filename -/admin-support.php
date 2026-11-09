<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-admin.php'; ?>
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Admin Support')); ?>
                        
                        
                      <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                                    <!--    <h4 class="card-title">Customer Support</h4>-->
                                    <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTicketModal">Create Ticket</button>-->
                                    <!--</div>-->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                    
                                        <h4 class="card-title">Admin Support</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            
                                            <!--<button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>-->
                                            <!--<button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#createTicketModal"><i class="fas fa-plus align-middle me-2"></i> Create New</button>-->
                                            
                                        </div>
                                    </div>
                                    <p class="card-title-desc">Manage user support tickets effectively.</p>
                                    <div class="table-responsive">
             <?php
include "../php/conn.php";

// Fetch data from the database with user details
$sql = "SELECT tickets.ticket_id, tickets.submission_date, tickets.subject, tickets.status, tickets.last_updated, description,tickets.user_id ,
        tbl_users.firstname, tbl_users.lastname, tbl_users.email, tbl_users.contact, tbl_users.user_type
        FROM tickets 
        JOIN tbl_users ON tickets.user_id = tbl_users.id";

$result = $conn->query($sql);
?>

<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Contact</th>
            <th>User Type</th>
            <th>Submission Date</th>
            <th>Subject/Issue</th>
            <th>Description</th>
            <th>Last Updated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Format status
                $statusBadge = '';
                $actionButton = '';

                if ($row['status'] == 0) {
                    $statusBadge = "<span class='badge badge-warning'>Pending</span>";
                    $actionButton = "
                        <button class='btn btn-success btn-sm mb-1' onclick='acceptTicket({$row['ticket_id']})'>Accept</button>
                        <button class='btn btn-danger btn-sm' onclick='rejectTicket({$row['ticket_id']})'>Reject</button>";
                } elseif ($row['status'] == 1) {
                    $statusBadge = "<span class='badge badge-success'>Accepted</span>";
                    $actionButton = "<button class='btn btn-info btn-sm  mb-1' onclick='clearIssue({$row['ticket_id']})'>Clear Issue</button>
                     <button class='btn btn-info btn-sm '  data-bs-toggle='modal' data-bs-target='#messageModal' data-ticket-id='{$row['ticket_id']}' data-user-id='{$row['user_id']}'><i class='fa fa-inbox'></i></button>
                    ";
                } elseif ($row['status'] == 2) {
                    $statusBadge = "<span class='badge badge-danger'>Rejected</span>";
                    $actionButton = "<button class='btn btn-danger btn-sm  mb-1'>Rejected</button>
                     <button class='btn btn-info btn-sm'  data-bs-toggle='modal' data-bs-target='#messageModal' data-ticket-id='{$row['ticket_id']}' data-user-id='{$row['user_id']}'><i class='fa fa-inbox'></i></button>
                    ";
                    
                }
                
          

                // Display rows
                echo "<tr>";
                echo "<td>" . $row['ticket_id'] . "</td>";
                echo "<td>" . $row['firstname'] . " " . $row['lastname'] . "</td>";
                echo "<td>" . $row['email'] . "</td>";
                echo "<td>" . $row['contact'] . "</td>";
                echo "<td>" . ucfirst($row['user_type']) . "</td>";
                echo "<td>" . date('m/d/Y h:i A', strtotime($row['submission_date'])) . "</td>";
                echo "<td>" . $row['subject'] . "</td>";
                                echo "<td>" . $row['description'] . "</td>";
                
          
                echo "<td>" . date('m/d/Y h:i A', strtotime($row['last_updated'])) . "</td>";
                echo "<td>" . $actionButton . "</td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='10'>No tickets found</td></tr>";
        }
        ?>
    </tbody>
</table>


<?php
$conn->close();
?>

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
                        <!--<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>-->
                        <!--<button type="button" class="btn btn-primary">Submit</button>-->
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal"><i class="dripicons-cross mt-2"></i> Close</button>
                        <button type="submit" class="btn btn-primary btn-submit" ><i class="fas fa-paper-plane align-middle me-2"></i>Submit</button>
                    </div>
                </div>
            </div>
        </div>
        
        
        
        <div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header  text-white">
        <h5 class="modal-title"><i class="fas fa-comments"></i> Chat</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
          <span aria-hidden="true">&times;</span>
        </button>
      </div>

      <!-- Message Area -->
      <div
        id="messageContainer"
        style="max-height: 400px; overflow-y: auto; background-color: #ffffff; padding: 15px; border: 1px solid #ddd; border-radius: 5px;">
        <!-- Example Chat Messages -->
    
      </div>

      <!-- Input Section -->
   <div class="modal-footer bg-white p-2" style="display: flex; align-items: center; gap: 10px;">
  <input
    type="text"
    id="messageInput"
    class="form-control"
    placeholder="Type your message"
    style="border-radius: 20px; flex: 1;">
  <button
    id="sendMessageButton"
    class="btn btn-success"
    style="border-radius: 50%; padding: 10px 12px;">
    <i class="fas fa-paper-plane"></i>
  </button>
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
                
          
            
            	document.querySelector('.btn-tour').addEventListener('click', function() {
                    tour.start(); 
                });
                
                 $('#datatable').DataTable();
            
                
                
            });
   // Accept Ticket
function acceptTicket(ticketId) {
    Swal.fire({
        title: 'Accept Ticket?',
        text: "Are you sure you want to accept this ticket?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#28a745',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, Accept'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../php/update-ticket-status.php',
                type: 'POST',
                data: { ticket_id: ticketId, status: 1 },
                success: function (response) {
                    Swal.fire('Accepted!', 'The ticket has been accepted.', 'success');
                    setTimeout(() => location.reload(), 2000);
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to update ticket status.', 'error');
                }
            });
        }
    });
}

// Reject Ticket
function rejectTicket(ticketId) {
    Swal.fire({
        title: 'Reject Ticket?',
        text: "Are you sure you want to reject this ticket?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Reject'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../php/update-ticket-status.php',
                type: 'POST',
                data: { ticket_id: ticketId, status: 2 },
                success: function (response) {
                    Swal.fire('Rejected!', 'The ticket has been rejected.', 'success');
                    setTimeout(() => location.reload(), 2000);
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to update ticket status.', 'error');
                }
            });
        }
    });
}

// Clear Issue
function clearIssue(ticketId) {
    Swal.fire({
        title: 'Clear Issue?',
        text: "Are you sure the issue has been resolved?",
        icon: 'info',
        showCancelButton: true,
        confirmButtonColor: '#17a2b8',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Yes, Clear'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: '../php/update-ticket-status.php',
                type: 'POST',
                data: { ticket_id: ticketId, status: 3 },
                success: function (response) {
                    Swal.fire('Cleared!', 'The issue has been cleared.', 'success');
                    setTimeout(() => location.reload(), 2000);
                },
                error: function () {
                    Swal.fire('Error!', 'Failed to update ticket status.', 'error');
                }
            });
        }
    });
}
 
 
 let fetchMessagesInterval;

// Function to fetch messages
function fetchMessages(ticketID, userID) {
    $.ajax({
        url: '../php/fetch_message1.php',
        method: 'POST',
        data: { ticket_id: ticketID , userID: userID },
        success: function (response) {
            $('#messageContainer').html(response);
            // Scroll to the bottom of the message container
            $('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
        },
        error: function (xhr, status, error) {
            console.error('Error fetching messages:', error);
        }
    });
}

$('#messageModal').on('show.bs.modal', function (event) {
    const button = event.relatedTarget; // Button that triggered the modal
    const ticketID = $(button).data('ticket-id'); 
      const userID = $(button).data('user-id');// Get ticket ID from button
    console.log('Ticket ID:', ticketID); // Log the ticket ID
     $(this).data('ticket-id', ticketID);
    $(this).data('user-id', userID);
    fetchMessages(ticketID, userID); // Initial fetch
    fetchMessagesInterval = setInterval(() => fetchMessages(ticketID, userID), 3000); // Auto-fetch every 3 seconds
});

// Stop fetching messages when modal is closed
$('#messageModal').on('hidden.bs.modal', function () {
    clearInterval(fetchMessagesInterval);
});

// Send message
$('#sendMessageButton').click(function () {
    const ticketID = $('#messageModal').data('ticket-id'); 
    const userID = $('#messageModal').data('user-id');// Retrieve ticket ID
    const message = $('#messageInput').val().trim();
    if (message !== '') {
        $.ajax({
            url: '../php/send_message1.php',
            method: 'POST',
            data: {
                ticket_id: ticketID,
                userID:userID,
                message: message
            },
            success: function (response) {
                $('#messageInput').val(''); // Clear input field
                fetchMessages(ticketID, userID); // Refresh messages
            },
            error: function (xhr, status, error) {
                console.error('Error sending message:', error);
            }
        });
    } else {
        Swal.fire('Message cannot be empty!', '', 'warning');
    }
});

             
             
        </script>

    </body>
</html>

