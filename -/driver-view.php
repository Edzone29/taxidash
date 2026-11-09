<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <!-- Leaflet JavaScript -->
    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>

      <style>
        /* Set the size of the map */
        #map {
            height: 400px; /* Adjust height as needed */
            width: 100%;   /* Full width */
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Accept Booking')); ?>
                        
                        
                        <div class="row mb-3">



<div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-5">
  <div id="bookingCard" class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #3bafda, #1e3c72); border-top-left-radius: 15px; border-top-right-radius: 15px;">
       <h5 class="card-title">Booking Details</h5>
    </div>
      <div class="card-body">
           <div id="map"></div> 
           <br>
            <p id="pickupLocation"></p>
            <p id="dropoffLocation"></p>
         <p id="price"></p>
        
       
            <button id="confirmBooking" class="btn btn-primary btn-block">Accept Booking</button>
            
            <button  class="btn btn-secondary btn-block"  onclick="window.location.href='driver-book.php';"> Back</button>
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


        <?php include 'partials/right-sidebar.php'; ?>

        <?php include 'partials/vendor-scripts.php'; ?>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

        <script src="assets/js/app.js"></script>
      
<!-- Include jQuery -->
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- Include Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.bundle.min.js"></script>
<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
   <script>
   $(document).ready(function() {
    // Fetch latest booking for the logged user
    $.ajax({
        url: '../php/get-booking-details.php?id=<?=$_GET["id"]?>',
        method: 'GET',
        dataType: 'json',
        success: function(response) {
            if (response.status === 'success') {
                const booking = response.data;
                $('#pickupLocation').text(`Pickup Location: ${booking.pickup_location}`);
                $('#dropoffLocation').text(`Drop-off Location: ${booking.dropoff_location}`);

                // Initialize Leaflet map
                const map = L.map('map').setView([booking.pickup_lat, booking.pickup_lng], 13);

                // Add OpenStreetMap tiles
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 16,
                }).addTo(map);

                // Add markers for pickup and drop-off
                L.marker([booking.pickup_lat, booking.pickup_lng]).addTo(map)
                    .bindPopup('Pickup Location').openPopup();
                L.marker([booking.dropoff_lat, booking.dropoff_lng]).addTo(map)
                    .bindPopup('Drop-off Location').openPopup();

                // Calculate distance using Haversine formula (in kilometers)
                const R = 6371; // Radius of the Earth in km
                const dLat = degreesToRadians(booking.dropoff_lat - booking.pickup_lat);
                const dLon = degreesToRadians(booking.dropoff_lng - booking.pickup_lng);
                const a = Math.sin(dLat/2) * Math.sin(dLat/2) +
                          Math.cos(degreesToRadians(booking.pickup_lat)) * Math.cos(degreesToRadians(booking.dropoff_lat)) *
                          Math.sin(dLon/2) * Math.sin(dLon/2);
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1-a));
                const distance = R * c; // Distance in km

                // Compute price
                const boardingFee = 50; // Flat boarding fee
                const perKmRate = 15; // Rate per km
                const price = boardingFee + (perKmRate * distance);
                $('#price').text(`Estimated Price: ${price.toFixed(2)} pesos`);
 $('#prc').val(`${price.toFixed(2)}`);
                // Confirm Booking
        $('#confirmBooking').on('click', function() {
    const paymentMethod = $('#paymentMethod').val();

var price = $('#prc').val();
    // Using SweetAlert2 for confirmation prompt


if (navigator.geolocation) {
    navigator.geolocation.getCurrentPosition(function(position) {
        // Get the driver's latitude and longitude
        let latitude = position.coords.latitude;
        let longitude = position.coords.longitude;

        // Call the SweetAlert confirmation
        Swal.fire({
            title: 'Confirm Booking Acceptance',
            text: "Do you want to accept this booking?",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, accept it!',
            cancelButtonText: 'No, cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Proceed with confirmation logic
                $.ajax({
                    url: '../php/confirm-accept.php', // Replace with your actual confirmation API
                    method: 'POST',
                    data: {
                        bookingId: booking.id,       // Pass booking ID
                                  
                        latitude: latitude,           // Pass driver's latitude
                        longitude: longitude            // Driver's ID
                    },
                    dataType: 'json', // Ensure response is parsed as JSON
                    success: function(confirmResponse) {
                        if (confirmResponse.status === 'success') {
                            Swal.fire(
                                'Confirmed!',
                                confirmResponse.message, // Use the success message from the response
                                'success'
                            ).then(() => {
                                // Redirect after confirmation
                                window.location.href = `driver-2acceptpayment.php?id=${booking.id}`;
                            });
                        } else {
                            Swal.fire(
                                'Error!',
                                'Error confirming booking: ' + confirmResponse.message,
                                'error'
                            );
                        }
                    },
                    error: function() {
                        Swal.fire(
                            'Error!',
                            'Error confirming booking. Please try again.',
                            'error'
                        );
                    }
                });
            }
        });
    }, function(error) {
        console.error("Error getting location:", error);
        Swal.fire('Error', 'Unable to retrieve location. Please try again.', 'error');
    });
} else {
    Swal.fire('Error', 'Geolocation is not supported by this browser.', 'error');
}




});

            } else {
                alert('Error fetching booking: ' + response.message);
            }
        },
        error: function() {
            alert('Error fetching booking. Please try again.');
        }
    });
});

// Helper function to convert degrees to radians
function degreesToRadians(degrees) {
    return degrees * (Math.PI / 180);
}

    </script>

    </body>
</html>

