<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
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

        <?php include 'partials/client-menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'User' , 'title' => 'Waiting to dropoff')); ?>
                        
                        
                        <div class="row mb-3">



<div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-5">
  <div id="bookingCard" class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #3bafda, #1e3c72); border-top-left-radius: 15px; border-top-right-radius: 15px;">
       <h5 class="card-title">On the way to Destination</h5>
    </div>
      <div class="card-body">
           <div id="map"></div> 
           <br>
            <p id="pickupLocation"></p>
            <p id="dropoffLocation"></p>
         <p id="price"></p>
         <br>
        <button class="btn btn-info btn-block" id="dsa" >
            <i class="fas fa-map-marker-alt"></i> Get Directions
        </button>
     
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
//   $(document).ready(function () {
      
//           const userId = <?=$_SESSION['user_id']?>;

//     // Function to check booking status every 5 seconds
//     const checkBookingStatus = setInterval(() => {
//         $.ajax({
//             url: '../php/check-dropoff-status.php', // API to check booking status
//             method: 'GET',
//             data: { userId: userId },
//             dataType: 'json', // Ensure response is treated as JSON
//             success: function(response) {
//                 if (response.status === 'success' && response.data.length > 0) {
//                     clearInterval(checkBookingStatus);
//                     Swal.fire({
//                         title: 'Complete!',
//                         text: 'You are successfully Drop Off.',
//                         icon: 'success',
//                         timer: 10000,
//                         showConfirmButton: false
//                     }).then(() => {
//                         window.location.href = 'client-complete.php';
//                     });
//                 } else if (response.status === 'error') {
//                     console.error('Error fetching booking status:', response.message);
//                 }
//             },
//             error: function(xhr, status, error) {
//                 console.error('Error checking booking status:', error);
//             }
//         });
//     }, 5000); // Check every 5 seconds

      


// let map; // Declare map as a global variable
// let driverMarker; // For dynamic driver marker
// let pickupMarker; // For dynamic pickup marker

// function fetchBookingDetails() {
//     $.ajax({
//         url: '../php/get-client-dropoff-details.php?id=<?=$_SESSION['user_id']?>',
//         method: 'GET',
//         dataType: 'json',
//         success: function (response) {
//             if (response.status === 'success') {
//                 const booking = response.data;

//                 // Update booking details
//                 $('#pickupLocation').text(`Pickup Location: ${booking.pickup_location}`);
//                 $('#dropoffLocation').text(`Drop-off Location: ${booking.dropoff_location}`);
                
//                 // Initialize the map if it's not already initialized
//                 if (!map) {
//                     map = L.map('map').setView([booking.drvLoc_lat, booking.drvLoc_lng], 13);
//                     L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
//                         maxZoom: 16,
//                     }).addTo(map);
//                 }
                
//                   console.log('Location updated: Longitude:', booking.drvLoc_lng, 'Latitude:', booking.drvLoc_lat);

//                 // Update or add markers
//                 if (driverMarker) {
//                     driverMarker.setLatLng([booking.dropoff_lat, booking.dropoff_lng]);
//                 } else {
//                     driverMarker = L.marker([booking.dropoff_lat, booking.dropoff_lng])
//                         .addTo(map)
//                         .bindPopup('Drop off Location');
//                 }

//                 if (pickupMarker) {
//                     pickupMarker.setLatLng([booking.pickup_lat, booking.pickup_lng]);
//                 } else {
//                     pickupMarker = L.marker([booking.pickup_lat, booking.pickup_lng])
//                         .addTo(map)
//                         .bindPopup('Your Location');
//                 }

//                 // Update the price display
//                 const price = Number(booking.price) || 0; // Default to 0 if conversion fails
//                 $('#price').text(`Estimated Price: â‚±${price.toFixed(2)}`);
//                 $('#prc').val(price.toFixed(2));

//                 // Setup 'Get Directions' button
//                 $('#dsa').off('click').on('click', function () {
//                     getDirections(booking.drvLoc_lat, booking.drvLoc_lng);
//                 });

//                 // Confirm Booking logic
//                 $('#confirmBooking').off('click').on('click', function () {
//                     const paymentMethod = $('#paymentMethod').val();
//                     const price = $('#prc').val();

//                     Swal.fire({
//                         title: 'Accept Booking',
//                         text: 'Do you want to accept this booking?',
//                         icon: 'warning',
//                         showCancelButton: true,
//                         confirmButtonColor: '#3085d6',
//                         cancelButtonColor: '#d33',
//                         confirmButtonText: 'Yes, confirm it!',
//                         cancelButtonText: 'No, cancel!',
//                     }).then((result) => {
//                         if (result.isConfirmed) {
//                             $.ajax({
//                                 url: '../php/confirm-pickup.php',
//                                 method: 'POST',
//                                 data: { bookingId: booking.id, paymentMethod, price },
//                                 dataType: 'json',
//                                 success: function (confirmResponse) {
//                                     if (confirmResponse.status === 'success') {
//                                         Swal.fire('Confirmed!', confirmResponse.message, 'success').then(() => {
//                                             window.location.href = `driver-pickup.php?id=${booking.id}`;
//                                         });
//                                     } else {
//                                         Swal.fire('Error!', confirmResponse.message, 'error');
//                                     }
//                                 },
//                                 error: function () {
//                                     Swal.fire('Error!', 'Error confirming booking. Please try again.', 'error');
//                                 },
//                             });
//                         }
//                     });
//                 });
//             } else {
//                 Swal.fire('Error!', `Error fetching booking: ${response.message}`, 'error');
//             }
//         },
//         error: function () {
//             Swal.fire('Error!', 'Error fetching booking. Please try again.', 'error');
//         },
//     });
// }

// // Initial fetch to load data immediately
// fetchBookingDetails();

// // Periodic refresh every 5 seconds
// setInterval(fetchBookingDetails, 5000);

// // Helper function to convert degrees to radians
// function degreesToRadians(degrees) {
//     return degrees * (Math.PI / 180);
// }

    
    
//   });

//   // Helper function to convert degrees to radians
// //   function degreesToRadians(degrees) {
// //     return degrees * (Math.PI / 180);
// //   }

//   // Get Directions using Google Maps
// 









$(document).ready(function () {
    // const userId = parseInt($("#userId").data("id"));
    const userId = <?=$_SESSION['user_id']?>;
    // Helper function to convert degrees to radians
    function degreesToRadians(degrees) {
        return degrees * (Math.PI / 180);
    }

    // Function to check booking status
    const checkBookingStatus = setInterval(() => {
        $.ajax({
            url: '../php/check-dropoff-status.php',
            method: 'GET',
            data: { userId },
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success' && response.data.length > 0) {
                       clearInterval(checkBookingStatus);
                    Swal.fire({
                        title: 'Complete!',
                        text: 'You are successfully Drop Off.',
                        icon: 'success',
                        timer: 10000,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = 'client-complete.php';
                    });
                } else if (response.status === 'error') {
                    console.error('Error fetching booking status:', response.message);
                }
            },
            error: function (xhr, status, error) {
                console.error('Error checking booking status:', error);
            }
        });
    }, 5000);

 let map; // Declare map as a global variable

function fetchBookingDetails() {
    $.ajax({
        url: `../php/get-client-dropoff-details.php?id=${$("#bookingId").data("id")}`,
        method: 'GET',
        dataType: 'json',
        success: function (response) {
            if (response.status === 'success') {
                const booking = response.data;

                // Populate hidden input fields
                $('#clid').val(booking.user_id);
                $('#drid').val(booking.driver_id);
                $('#bkid').val(booking.id);

                // Populate booking details
                $('#pickupLocation').text(`Pickup Location: ${booking.pickup_location}`);
                $('#dropoffLocation').text(`Drop-off Location: ${booking.dropoff_location}`);

                // Initialize or update Leaflet map
                if (map) {
                    map.remove(); // Remove the existing map instance
                }

                map = L.map('map').setView([booking.drvLoc_lat, booking.drvLoc_lng], 13);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                    maxZoom: 16,
                }).addTo(map);

                // Add map markers
                L.marker([booking.drvLoc_lat, booking.drvLoc_lng]).addTo(map).bindPopup('Driver Location').openPopup();
                L.marker([booking.pickup_lat, booking.pickup_lng]).addTo(map).bindPopup('Your Location').openPopup();

                // Calculate distance and estimated time
                const R = 6371; // Radius of Earth in km
                const dLat = degreesToRadians(booking.pickup_lat - booking.drvLoc_lat);
                const dLon = degreesToRadians(booking.pickup_lng - booking.drvLoc_lng);
                const a = Math.sin(dLat / 2) ** 2 +
                          Math.cos(degreesToRadians(booking.drvLoc_lat)) *
                          Math.cos(degreesToRadians(booking.pickup_lat)) *
                          Math.sin(dLon / 2) ** 2;
                const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
                const distance = R * c; // Distance in km

                const averageSpeed = 40; // Assume 40 km/h
                const estimatedTime = ((distance / averageSpeed) * 60) + 1; // Time in minutes

                const price = Number(booking.price) || 0; // Default to 0 if conversion fails
                $('#price').text(`Estimated Price: â‚±${price.toFixed(2)}`);
                $('#est').text(`Estimated Time Pickup: ${Math.round(estimatedTime)} mins`);
                $('#prc').val(price.toFixed(2));

                // Fetch driver details
                fetch('../php/fetch_driver_details.php', {
                    method: 'POST',
                    headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                    body: new URLSearchParams({ 'driver_id': booking.driver_id })
                })
                .then(response => response.json())
                .then(data => {
                    if (data.success) {
                        $('#driverName').text(`Driver Name: ${data.fullname}`);
                          $('#driverpic').attr('src', 'uploads/' + data.profile);
                        $('#driverContact').text(`Contact: ${data.contact}`);
                        $('#plate').text(`Plate Number: ${data.plate}`);
                        $('#callDriverBtn').click(() => {
                            window.location.href = `tel:${data.contact}`;
                        });
                    } else {
                        $('#driverName').text('Driver not found.');
                        $('#driverContact').text('');
                    }
                })
                .catch(error => console.error('Error fetching driver details:', error));
            } else {
                Swal.fire('Error!', `Error fetching booking: ${response.message}`, 'error');
            }
        },
        error: function () {
            Swal.fire('Error!', 'Error fetching booking. Please try again.', 'error');
        },
    });
}

// Call the function every 5 seconds
setInterval(fetchBookingDetails, 5000);

// Initial fetch to load data immediately
fetchBookingDetails();

    // Get directions using Google Maps
    $('#dsa').click(() => {
        const { drvLoc_lat, drvLoc_lng } = booking;
        window.open(`https://www.google.com/maps/dir/?api=1&destination=${drvLoc_lat},${drvLoc_lng}`, '_blank');
    });
    
    
function getDirections(pickupLat, pickupLng) {
      window.open(`https://www.google.com/maps/dir/?api=1&destination=${drvLoc_lat},${drvLoc_lng}`, '_blank');
    }
});


</script>


    </script>

    </body>
</html>

