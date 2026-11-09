<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
    <style>
 .loading-spinner {
    margin: 20px 0;
}

.card {
    transition: all 0.3s;
}

.card:hover {
    box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
}

    </style>

    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
        
   
    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

        <?php include 'partials/driver-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Accept Payment')); ?>
                        
                        
                        <div class="row mb-3">


<div id="searchDriverCard" class="card mb-3">
    <div class="card-body text-center">
        <h5 class="card-title">Confirming the payment...</h5>
        <div class="loading-spinner">
            <div class="spinner-border" role="status">
                <span class="sr-only">Loading...</span>
            </div>
        </div>
        <p class="card-text">Please wait while the driver confirming the payment.</p>
        <!--<button id="cancelBooking" class="btn btn-danger">Cancel Booking</button>-->
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
        

<!-- Map Modal for Pickup and Drop-off Locations -->
<div class="modal fade" id="mapModal" tabindex="-1" role="dialog" aria-labelledby="mapModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg modal-dialog-centered" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="mapModalLabel">Select Location</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span>&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div id="map"></div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-primary" onclick="confirmLocation()">Confirm Location</button>
            </div>
        </div>
    </div>
</div>
        <?php include 'partials/right-sidebar.php'; ?>

        <?php include 'partials/vendor-scripts.php'; ?>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

        <script src="assets/js/app.js"></script>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<script>
    
$(document).ready(function() {
    // Example: Retrieve user ID from session or context
    const userId = <?=$_SESSION['user_id']?>;

    // Function to check booking status every 5 seconds
    const checkBookingStatus = setInterval(() => {
        $.ajax({
            url: '../php/check-driver-payment.php', // API to check booking status
            method: 'GET',
            data: { userId: userId },
            dataType: 'json', // Ensure response is treated as JSON
            success: function(response) {
                if (response.status === 'success' && response.data.length > 0) {
                    clearInterval(checkBookingStatus);
                    Swal.fire({
                        title: 'Passenger Confirm!',
                        text: 'Passenger sent payment.',
                        icon: 'success',
                        timer: 2000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'driver-3checkpayment.php';
                    });
                } else if (response.status === 'error') {
                    console.error('Error fetching booking status:', response.message);
                }
            },
            error: function(xhr, status, error) {
                console.error('Error checking booking status:', error);
            }
        });
    }, 5000); // Check every 5 seconds

    // Cancel Booking button click event
  
    $('#cancelBooking').on('click', function() {
        Swal.fire({
            title: 'Cancel Booking',
            text: 'Are you sure you want to cancel your booking?',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#3085d6',
            cancelButtonColor: '#d33',
            confirmButtonText: 'Yes, cancel it!',
            cancelButtonText: 'No, keep it!'
        }).then((result) => {
            if (result.isConfirmed) {
                // Call the API to cancel the booking
                $.ajax({
                    url: '../php/cancel-booking.php', // API to cancel booking
                    method: 'POST',
                    data: { userId: userId },
                    dataType: 'json', // Ensure response is treated as JSON
                    success: function(cancelResponse) {
                        console.log(cancelResponse); // Log the response for debugging
                        if (cancelResponse.status === 'success') {
                            Swal.fire('Cancelled!', 'Your booking has been cancelled.', 'success').then(() => {
                                window.location.href = 'client-dashboard.php';
                            });
                        } else {
                            Swal.fire('Error!', cancelResponse.message, 'error');
                        }
                    },
                    error: function(xhr, status, error) {
                        Swal.fire('Error!', 'Error cancelling booking. Please try again.', 'error');
                    }
                });
            }
        });
    });
});


</script>


    </body>
</html>

