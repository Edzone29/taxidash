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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Pickup Passenger')); ?>
                        
                        
                        <div class="row mb-3">



<div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-5">
  <div id="bookingCard" class="card" style="border-radius: 15px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);">
    <div class="card-header text-center text-white" style="background: linear-gradient(135deg, #3bafda, #1e3c72); border-top-left-radius: 15px; border-top-right-radius: 15px;">
       <h5 class="card-title">Pickup Details</h5>
    </div>
      <div class="card-body">
           <div id="map"></div> 
           <br>
           
           
              <p id="driverName"></p>
               <p id="driverContact"></p>
            <p id="pickupLocation"></p>
            <p id="dropoffLocation"></p>
         <p id="price"></p>
        
            <b style="margin-top: 10px;">Payment Proof</b>
            <br>
           <img id="proof" style="max-width: 100%; height: auto;">
        
        <br>
        <br>
       
            <button id="confirmBooking" class="btn btn-primary btn-block">Accept Payment</button>
              <button id="rejectBooking" class="btn btn-warning btn-block">Reject Payment</button>
                <button id="cancelBooking" class="btn btn-danger btn-block">Cancel Pickup</button>
              <br>  <br>
          <button class="btn btn-info btn-block" id="dsa" >
            <i class="fas fa-map-marker-alt"></i> Get Directions
        </button>
        
        <br><br>
        <button class="btn btn-info btn-block" id="mlm" data-bs-toggle="modal" data-bs-target="#messageModal" data-toggle="modal" data-target="#messageModal">
    <i class="fas fa-inbox"></i> Message Passenger
</button>


<button class="btn btn-info btn-block" id="callDriverBtn">
  <i class="fas fa-phone"></i> Call Passenger
</button>

        </div>
  </div>
</div>


    <!-- end col -->
</div>


                       


 <div class="modal fade" id="messageModal" tabindex="-1" role="dialog">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <!-- Modal Header -->
      <div class="modal-header  text-white">
        <h5 class="modal-title"><i class="fas fa-comments"></i> Chat</h5>
        <button type="button btn-link btn-outline-danger" class="close text-white" data-bs-dismiss="modal" data-dismiss="modal" aria-label="Close">
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
      
<!-- Include Bootstrap JS -->
<!-- Include Leaflet JS -->
<script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
<script>
  $(document).ready(function () {
    $(document).on("click", "#mlm, [data-bs-target=\"#messageModal\"]", function (e) {
    e.preventDefault();
    var modalEl = document.getElementById("messageModal");
    if (modalEl) {
        if (typeof bootstrap !== "undefined" && bootstrap.Modal) {
            bootstrap.Modal.getOrCreateInstance(modalEl).show();
        } else {
            $("#messageModal").modal("show");
        }
    }
});
$(document).on("keypress", "#messageInput", function (e) {
    if (e.which === 13) {
        e.preventDefault();
        $("#sendMessageButton").click();
    }
});
      
          const userId = <?=$_SESSION['user_id']?>;
    // Fetch booking details
    $.ajax({
      url: '../php/get-payment-details.php?id=<?=$_SESSION['user_id']?>',
      method: 'GET',
      dataType: 'json',
      success: function (response) {
        if (response.status === 'success') {
          const booking = response.data;
          const passId = booking.user_id; 
          
          
          $('#proof').attr('src', 'uploads/' + booking.proof);
          
              const driverId = booking.driver_id; // Getting the driver ID from the input field wit
  const bookId = booking.id; // Getting the booking ID from the input field with ID 'bkid'

    
          
          $('#pickupLocation').text(`Pickup Location: ${booking.pickup_location}`);
          $('#dropoffLocation').text(`Drop-off Location: ${booking.dropoff_location}`);

          // Initialize Leaflet map centered at the pickup location
          const map = L.map('map').setView([booking.pickup_lat, booking.pickup_lng], 13);
          L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 16,
          }).addTo(map);

          // Add markers for pickup and drop-off locations
          L.marker([booking.pickup_lat, booking.pickup_lng]).addTo(map)
            .bindPopup('Pickup Location').openPopup();
          L.marker([booking.dropoff_lat, booking.dropoff_lng]).addTo(map)
            .bindPopup('Drop-off Location').openPopup();

          // Calculate distance using the Haversine formula
          const R = 6371; // Radius of Earth in km
          const dLat = degreesToRadians(booking.dropoff_lat - booking.pickup_lat);
          const dLon = degreesToRadians(booking.dropoff_lng - booking.pickup_lng);
          const a = Math.sin(dLat / 2) ** 2 + Math.cos(degreesToRadians(booking.pickup_lat)) * Math.cos(degreesToRadians(booking.dropoff_lat)) * Math.sin(dLon / 2) ** 2;
          const c = 2 * Math.atan2(Math.sqrt(a), Math.sqrt(1 - a));
          const distance = R * c; // Distance in km

          // Calculate estimated price
          const boardingFee = 50;
          const perKmRate = 15;
              // const price = boardingFee + (perKmRate * distance);

              const price = Number(booking.price) || 0; // Default to 0 if conversion fails
$('#price').text(`Estimated Price: â‚±${price.toFixed(2)}`);
          $('#prc').val(price.toFixed(2));
          
          
      
// Fetch the driver details from the PHP script
fetch('../php/fetch_driver_details.php', {
  method: 'POST',
  body: new URLSearchParams({
    'driver_id': passId
  }),
  headers: {
    'Content-Type': 'application/x-www-form-urlencoded'
  }
})
.then(response => response.json())
.then(data => {
  // Check if data is returned successfully
  if (data.success) {
    document.getElementById('driverName').innerText = `Passenger Name: ${data.fullname}`;
    document.getElementById('driverContact').innerText = `Contact: ${data.contact}`;
    document.getElementById('callDriverBtn').onclick = function() {
  window.location.href = `tel:${data.contact}`;
};  } 
  
  else {
    document.getElementById('driverName').innerText = 'Passenger not found.';
    document.getElementById('driverContact').innerText = '';
  }
})
.catch(error => console.error('Error fetching driver details:', error));
    
          
          


     $('#dsa').click(function () {
    getDirections(booking.pickup_lat, booking.pickup_lng);
  });

          // Confirm Booking
          $('#confirmBooking').on('click', function () {
            const paymentMethod = $('#paymentMethod').val();
            const price = $('#prc').val();

            // SweetAlert2 confirmation
            Swal.fire({
              title: 'Accept Payment',
              text: 'Do you want to accept the payment?',
              icon: 'warning',
              showCancelButton: true,
              confirmButtonColor: '#3085d6',
              cancelButtonColor: '#d33',
              confirmButtonText: 'Yes, confirm it!',
              cancelButtonText: 'No, cancel!',
            }).then((result) => {
              if (result.isConfirmed) {
                $.ajax({
                  url: '../php/confirm-payment.php',
                  method: 'POST',
                  data: { bookingId: booking.id, paymentMethod, price },
                  dataType: 'json',
                  success: function (confirmResponse) {
                    if (confirmResponse.status === 'success') {
                      Swal.fire('Confirmed!', confirmResponse.message, 'success')
                        .then(() => {
                          window.location.href = `driver-4pickup.php?id=${booking.id}`;
                        });
                    } else {
                      Swal.fire('Error!', confirmResponse.message, 'error');
                    }
                  },
                  error: function () {
                    Swal.fire('Error!', 'Error confirming booking. Please try again.', 'error');
                  },
                });
              }
            });
          });
          
          
          
          
         // Reject Payment
$('#rejectBooking').on('click', function () {
    const paymentMethod = $('#paymentMethod').val();
    const price = $('#prc').val();

    // SweetAlert2 confirmation with input for remarks
    Swal.fire({
        title: 'Reject Payment',
        text: 'Please provide remarks before rejecting the payment.',
        input: 'textarea',
        inputPlaceholder: 'Enter your remarks here...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'No, cancel!',
        inputValidator: (value) => {
            if (!value) {
                return 'Remarks are required!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const remarks = result.value; // Retrieve remarks input

            $.ajax({
                url: '../php/confirm-reject-payment.php',
                method: 'POST',
                data: { bookingId: booking.id, paymentMethod, price, remarks },
                dataType: 'json',
                success: function (confirmResponse) {
                    if (confirmResponse.status === 'success') {
                        Swal.fire('Confirmed!', confirmResponse.message, 'success')
                            .then(() => {
                                window.location.href = `driver-2acceptpayment.php?id=${booking.id}`;
                            });
                    } else {
                        Swal.fire('Error!', confirmResponse.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Error confirming booking. Please try again.', 'error');
                }
            });
        }
    });
});

// Cancel Pickup
$('#cancelBooking').on('click', function () {
    const paymentMethod = $('#paymentMethod').val();
    const price = $('#prc').val();

    // SweetAlert2 confirmation with input for remarks
    Swal.fire({
        title: 'Cancel Pickup',
        text: 'Please provide remarks before canceling the pickup.',
        input: 'textarea',
        inputPlaceholder: 'Enter your remarks here...',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Yes, confirm it!',
        cancelButtonText: 'No, cancel!',
        inputValidator: (value) => {
            if (!value) {
                return 'Remarks are required!';
            }
        }
    }).then((result) => {
        if (result.isConfirmed) {
            const remarks = result.value; // Retrieve remarks input

            $.ajax({
                url: '../php/confirm-cancel-payment.php',
                method: 'POST',
                data: { bookingId: booking.id, paymentMethod, price, remarks },
                dataType: 'json',
                success: function (confirmResponse) {
                    if (confirmResponse.status === 'success') {
                        Swal.fire('Confirmed!', confirmResponse.message, 'success')
                            .then(() => {
                                window.location.href = `driver-dashboard?id=${booking.id}`;
                            });
                    } else {
                        Swal.fire('Error!', confirmResponse.message, 'error');
                    }
                },
                error: function () {
                    Swal.fire('Error!', 'Error confirming booking. Please try again.', 'error');
                }
            });
        }
    });
});

          
          
          
          
                  
  // Log the values to verify
  console.log('Driver ID:', driverId);
  console.log('User ID:', passId);
  console.log('Booking ID:', bookId);

  let fetchMessagesInterval;

  // Function to fetch messages
  function fetchMessages() {
    $.ajax({
      url: '../php/fetch_message11.php',
      method: 'POST',
      data: { driver_id: bookId, book_id: bookId, user_id: passId },
      success: function (response) {
        $('#messageContainer').html(response);
        // Scroll to the bottom of the message container
        $('#messageContainer').scrollTop($('#messageContainer')[0].scrollHeight);
      },
    });
  }

  // Open modal and start fetching messages
  $('#messageModal').on('show.bs.modal', function () {
    fetchMessages(); // Initial fetch
    fetchMessagesInterval = setInterval(fetchMessages, 3000); // Auto-fetch every 3 seconds
  });

  // Stop fetching messages when modal is closed
  $('#messageModal').on('hidden.bs.modal', function () {
    clearInterval(fetchMessagesInterval);
  });

  // Send message
  $('#sendMessageButton').click(function () {
    const message = $('#messageInput').val().trim();
    if (message !== '') {
      $.ajax({
        url: '../php/send_message.php',
        method: 'POST',
        data: {
          driver_id: passId,
          user_id: driverId,
          book_id: bookId,
          message: message,
        },
        success: function (response) {
          $('#messageInput').val(''); // Clear input field
          fetchMessages(); // Refresh messages
        },
      });
    } else {
      Swal.fire('Message cannot be empty!', '', 'warning');
    }
  });
         
          
          
          
          
          
          
          
        } else {
          alert('Error fetching booking: ' + response.message);
        }
      },
      error: function () {
        alert('Error fetching booking. Please try again.');
      },
      
      
      
      
      
      
      
      
    });
    
 
 
 
    
 
 
    
    
  });

  // Helper function to convert degrees to radians
  function degreesToRadians(degrees) {
    return degrees * (Math.PI / 180);
  }

  // Get Directions using Google Maps
function getDirections(pickupLat, pickupLng) {
  window.open(`https://www.google.com/maps/dir/?api=1&destination=${pickupLat},${pickupLng}`, '_blank');
}
</script>


    </script>

    </body>
</html>

