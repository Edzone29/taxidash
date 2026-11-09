<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Customer Support')); ?>
                        
                        
                      <div class="row">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <!--<div class="d-flex justify-content-between align-items-center mb-3">-->
                                    <!--    <h4 class="card-title">Customer Support</h4>-->
                                    <!--    <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#createTicketModal">Create Ticket</button>-->
                                    <!--</div>-->
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                    
                                        <h4 class="card-title">Customer Support</h4>
                                        <div class="d-flex flex-wrap gap-2">
                                            
                                            <!--<button type="button" class="btn btn-info btn-tour"><i class="fas fa-snowboarding align-middle me-2"></i> Guide</button>-->
                                            <button type="button" class="btn btn-primary add-filter-btn" data-bs-toggle="modal" data-bs-target="#createTicketModal"><i class="fas fa-plus align-middle me-2"></i> Create New</butto>
                                            
                                        </div>
                                    </div>
                                    <p class="card-title-desc">Manage user support tickets effectively.</p>
                                    <div class="table-responsive">
                           <?php

include "../php/conn.php";

// Fetch data from the database
$sql = "SELECT * FROM tickets WHERE user_id = '$_SESSION[user_id]'";
$result = $conn->query($sql);
?>

<table id="datatable" class="table table-bordered dt-responsive nowrap" style="border-collapse: collapse; border-spacing: 0; width: 100%;">
    <thead>
        <tr>
            <th>Ticket ID</th>
            <th>Submission Date</th>
            <th>Subject/Issue</th>
            <th>Description</th>
            <th>Status</th>
            <th>Last Updated</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Determine badge color and label based on status
                $statusBadge = '';
                switch ($row['status']) {
                    case 0:
                        $statusBadge = "<span class='badge bg-warning'>Pending</span>";
                        break;
                    case 1:
                        $statusBadge = "<span class='badge bg-primary'>Accepted</span>";
                        break;
                    case 2:
                        $statusBadge = "<span class='badge bg-danger'>Rejected</span>";
                        break;
                    case 3:
                        $statusBadge = "<span class='badge bg-success'>Resolved</span>";
                        break;
                    default:
                        $statusBadge = "<span class='badge bg-secondary'>Unknown</span>";
                        break;
                }

                echo "<tr>";
                echo "<td>" . $row['ticket_id'] . "</td>";
                echo "<td>" . date('m/d/Y h:i A', strtotime($row['submission_date'])) . "</td>";
                echo "<td>" . $row['subject'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td>" . $statusBadge . "</td>";
                echo "<td>" . date('m/d/Y h:i A', strtotime($row['last_updated'])) . "</td>";
                echo "<td>
                    <button class='btn btn-danger btn-sm' onclick='deleteTicket(" . $row['ticket_id'] . ")'>Delete</button>
                    <button class='btn btn-info btn-sm'  data-bs-toggle='modal' data-bs-target='#messageModal' data-ticket-id='{$row['ticket_id']}' data-user-id='{$row['user_id']}'><i class='fa fa-inbox'></i></button>
                    
                </td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='7'>No tickets found</td></tr>";
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
   
                        
      $(document).ready(function () {
    $('.btn-submit').on('click', function () {
        const subject = $('#ticketSubject').val();
        const description = $('#ticketDescription').val();
        const userId = <?= $_SESSION['user_id'] ?>; // Replace with actual user_id logic

     $.ajax({
    url: '../php/add-support.php',
    type: 'POST',
    data: {
        subject: subject,
        description: description,
        user_id: userId,
    },
    dataType: 'json',
    success: function (response) {
        if (response.status === "success") {
            // SweetAlert2 Success Message
            Swal.fire({
                title: 'Success!',
                text: response.message,
                icon: 'success',
                timer: 2000, // Auto close after 2 seconds
                showConfirmButton: false
            }).then(() => {
                // Reset form fields
                $('#ticketSubject').val('');
                $('#ticketDescription').val('');
                $('#createTicketModal').modal('hide');

                // Reload page after 2 seconds
                setTimeout(function () {
                    location.reload();
                }, 2000);
            });
        } else {
            // SweetAlert2 Error Message
            Swal.fire({
                title: 'Error!',
                text: response.message,
                icon: 'error',
                confirmButtonText: 'OK'
            });
        }
    },
    error: function (xhr, status, error) {
        console.error('Error:', error);
        Swal.fire({
            title: 'Error!',
            text: 'Something went wrong. Please try again.',
            icon: 'error',
            confirmButtonText: 'OK'
        });
    },
});

    });
});

        
   function deleteTicket(ticketId) {
    Swal.fire({
        title: 'Are you sure?',
        text: "You won't be able to revert this!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, delete it!',
        cancelButtonText: 'Cancel'
    }).then((result) => {
        if (result.isConfirmed) {
            // Make AJAX call to delete the ticket
            $.ajax({
                url: '../php/delete-ticket.php', // Adjust the path as needed
                type: 'POST',
                data: { ticket_id: ticketId },
                dataType: 'json',
                success: function (response) {
                    if (response.status === 'success') {
                        Swal.fire(
                            'Deleted!',
                            response.message,
                            'success'
                        );

                        // Reload the page or remove the row from the table
                        setTimeout(() => {
                            location.reload();
                        }, 2000);
                    } else {
                        Swal.fire(
                            'Error!',
                            response.message,
                            'error'
                        );
                    }
                },
                error: function (xhr, status, error) {
                    console.error('Error:', error);
                    Swal.fire(
                        'Error!',
                        'Something went wrong. Please try again.',
                        'error'
                    );
                }
            });
        }
    });
}
          
       
       
      let fetchMessagesInterval;

// Function to fetch messages
function fetchMessages(ticketID) {
    $.ajax({
        url: '../php/fetch_message2.php',
        method: 'POST',
        data: { ticket_id: ticketID },
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
    fetchMessages(ticketID); // Initial fetch
    fetchMessagesInterval = setInterval(() => fetchMessages(ticketID), 3000); // Auto-fetch every 3 seconds
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
            url: '../php/send_message2.php',
            method: 'POST',
            data: {
                ticket_id: ticketID,
                userID:userID,
                message: message
            },
            success: function (response) {
                $('#messageInput').val(''); // Clear input field
                fetchMessages(ticketID); // Refresh messages
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

