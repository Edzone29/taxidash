<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-admin.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
            <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.3.6/css/buttons.dataTables.min.css">
        
        <style>
            
            .job-card {
              /*max-width: 350px;*/
              border: 1px solid #e3e6ea;
              border-radius: 8px;
              box-shadow: 0px 4px 6px rgba(0, 0, 0, 0.1);
            }
            
            .job-card .card-title {
              font-size: 1.2rem;
              font-weight: bold;
            }
            
            .job-card .company-name {
              font-size: 0.9rem;
              font-weight: normal;
            }
            
            .job-card .company-logo {
              text-align: center;
            }
            
            .job-card ul {
              padding: 0;
              list-style-type: none;
            }
            
            .job-card ul li {
              font-size: 0.9rem;
              color: #495057;
              display: flex;
              align-items: center;  /* Ensures vertical alignment */
              gap: 10px;  /* Consistent spacing between icon and text */
            }
            
            .job-card ul li i {
              width: 24px; /* Set width of icon (1x1 size in px) */
              height: 24px; /* Set height of icon (1x1 size in px) */
              text-align: center;  /* Center icon */
              font-size: 1.2rem; /* Icon size */
              line-height: 24px;  /* Vertically center icon */
            }


            
            .heart-icon i {
              font-size: 1.2rem;
              color: #ccc;
            }
            
            .heart-icon i:hover {
              color: #e74c3c;
            }
            
            .badge {
              font-size: 0.85rem;
            }
            
            .list-unstyled {
              line-height: 1.8;
            }
            
            .cursor-pointer i{
                cursor:pointer;
            }
            
            .scrollable-job-list {
                max-height: 700; /* Adjust height as needed */
                overflow-y: auto;  /* Enable vertical scrolling */
                overflow-x: hidden; /* Prevent horizontal scrolling */
                padding-right: 15px; /* Optional: Add padding to prevent content from touching the scrollbar */
            }
            
            .dropdown-menu {
                width: auto; /* Use auto width to fit the content */
                min-width: 200px; /* Set a minimum width to maintain a standard appearance */
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
                    <div class="container">

                 <!-- start page title -->
<div class="row">
    <div class="col-12">
        <div class="page-title-box d-sm-flex align-items-center justify-content-between">
            <h4 class="mb-sm-0"><?php echo $_SESSION['firstname'].' '.$_SESSION['lastname'] ?></h4>

            <div class="page-title-right">
                <ol class="breadcrumb m-0">
                    <li class="breadcrumb-item"><a href="javascript: void(0);"><?= 'Admin' ?></a></li>
                    <li class="breadcrumb-item active"><?= 'Home' ?></li>
                </ol>
            </div>

        </div>
    </div>
</div>
<!-- end page title -->
                 
                 
                 
                       <?php
include '../php/conn.php'; // Database connection file


$sqlDrivers = "
SELECT 
    b.driver_id, 
    CONCAT(d.firstname, ' ', d.lastname) AS driver_name, 
    SUM(b.price) AS total_income, 
    COUNT(b.id) AS completed_bookings
FROM 
    temp_ride_bookings b
JOIN 
    tbl_users d ON b.driver_id = d.id
WHERE 
    b.status = 7
GROUP BY 
    b.driver_id
";
$resultDrivers = mysqli_query($conn, $sqlDrivers);




?>
                 <div class="row mb-3">
 
   <div class="container">
         <div class="card">
       <div class="card-body">
           <h2>Driver Income Summary</h2>
           <div class="table-responsive"> 
        <table id="driversTable" class="display nowrap" style="width:100%">
            <thead>
                <tr>
                    <th>Driver Name</th>
                    <th>Total Income</th>
                    <th>Completed Bookings</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($resultDrivers)): ?>
                <tr>
                    <td><?= $row['driver_name']; ?></td>
                    <td><?= number_format($row['total_income'], 2); ?></td>
                    <td><?= $row['completed_bookings']; ?></td>
                </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
        </div>
       </div>
</div>
       
       <br><br>
       
       
<div class="card">
    <div class="card-body">
        <h2>Successful Bookings</h2>
        
        <!-- Filter Dropdown -->
        <label for="filter">Filter:</label>
        <select id="filter" class="form-control mb-3">
            <option value="all">All</option>
            <option value="daily">Daily</option>
            <option value="weekly">Weekly</option>
            <option value="monthly">Monthly</option>
        </select>

        <div class="table-responsive">
            <table id="bookingsTable" class="display nowrap" style="width:100%">
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Passenger Name</th>
                        <th>Driver Name</th>
                        <th>Pickup Location</th>
                        <th>Dropoff Location</th>
                        <th>Pay Via</th>
                        <th>Price</th>
                        <th>Booking Date</th>
                    </tr>
                </thead>
                <tbody id="bookingsData">
                    <!-- Data will be loaded here via AJAX -->
                </tbody>
            </table>
        </div>
    </div>
</div>

<br><br>

    
    </div>



</div>


                       





                    </div> <!-- container-fluid -->
                </div>
                <!-- End Page-content -->
                
                <?php include 'partials/footer.php'; ?>

            </div>
            <!-- end main content-->

        </div>
        
        <div class="offcanvas offcanvas-end" data-bs-scroll="true" tabindex="-1"
            id="offcanvasWithBothOptions" aria-labelledby="offcanvasWithBothOptionsLabel">
            <div class="offcanvas-header border-bottom">
                <h2 class="offcanvas-title text-bold" id="offcanvasWithBothOptionsLabel">Filters
                </h2>
                <button type="button" class="btn-close text-reset" data-bs-dismiss="offcanvas"
                    aria-label="Close"></button>
            </div>
            <div class="offcanvas-body">
                <div class="row border-bottom g-2 mb-3">
                    <h3>Work Type</h3>
                    
                    <div class="row g-2 mb-3">
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Full Time
                                </label>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Part Time
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Contract
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-6">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Casual
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row border-bottom g-2">
                    
                    <h3>Location</h3>
                    
                    <input type="" placeholder="Location" class="form-control w-100">
                    
                    <div class="row g-2 mb-3">
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Manila
                                </label>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Makati
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Pasig
                                </label>
                            </div>
                        </div>
                        
                        <div class="col-12">
                            <div class="form-check mb-2">
                                <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
                                <label class="form-check-label" for="defaultCheck1">
                                    Quezon City
                                </label>
                            </div>
                        </div>
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
        
         <script>
        // $(document).ready(function() {
               
                
        //           const tour = new Shepherd.Tour({
        //                 defaultStepOptions: {
        //                     cancelIcon: {
        //                         enabled: true
        //                     },
        //                     classes: 'class-1 class-2',
        //                     scrollTo: { behavior: 'smooth', block: 'center' }
        //                 },
        //                 useModalOverlay: true
        //             });
                    
        //             tour.addStep({
        //                 title: 'Task Posted Count',
        //                 text: 'This shows your total task posted count',
        //                 attachTo: {
        //                     element: '.card1',
        //                     on: 'bottom'
        //                 },
        //                 buttons: [
        //                     {
        //                         action() {
        //                             return this.back();
        //                         },
        //                         classes: 'shepherd-button-secondary',
        //                         text: 'Back'
        //                     },
        //                     {
        //                         action() {
        //                             return this.next();
        //                         },
        //                         text: 'Next'
        //                     }
        //                 ],
        //                 id: 'add-filter-step'
        //             });
                    
        //             tour.addStep({
        //                 title: 'Applicant Hired',
        //                 text: 'This shows your total hired applicant',
        //                 attachTo: {
        //                     element: '.card2',
        //                     on: 'bottom'
        //                 },
        //                 buttons: [
        //                     {
        //                         action() {
        //                             return this.back();
        //                         },
        //                         classes: 'shepherd-button-secondary',
        //                         text: 'Back'
        //                     },
        //                     {
        //                         action() {
        //                             return this.next();
        //                         },
        //                         text: 'Next'
        //                     }
        //                 ],
        //                 id: 'add-filter-step'
        //             });

                    
                    
        //             tour.addStep({
        //                 title: 'Task Completion',
        //                 text: 'This shows the completion percentage of all your task',
        //                 attachTo: {
        //                     element: '.card3',
        //                     on: 'bottom'
        //                 },
        //                 buttons: [
        //                     {
        //                         action() {
        //                             return this.back();
        //                         },
        //                         classes: 'shepherd-button-secondary',
        //                         text: 'Back'
        //                     },
        //                     {
        //                         action() {
        //                             return this.next();
        //                         },
        //                         text: 'Next'
        //                     }
        //                 ],
        //                 id: 'add-filter-step'
        //             });
                    
        //             tour.addStep({
        //                 title: 'Total Paid',
        //                 text: 'This shows the total amount you paid',
        //                 attachTo: {
        //                     element: '.card4',
        //                     on: 'bottom'
        //                 },
        //                 buttons: [
        //                     {
        //                         action() {
        //                             return this.back();
        //                         },
        //                         classes: 'shepherd-button-secondary',
        //                         text: 'Back'
        //                     },
        //                     {
        //                         action() {
        //                             return this.complete();
        //                         },
        //                         text: 'Finish'
        //                     }
        //                 ],
        //                 id: 'add-filter-step'
        //             });
                    
        //             tour.start();
                    
                   

                    
                   
                    
                
                  
               
               
        //   });
        //   </script>
        
        
           <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.3.6/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
    <script>
        $(document).ready(function() {
            $('#bookingsTable').DataTable({
                dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'
                ],
                responsive: true
            });

            $('#driversTable').DataTable({
                  dom: 'Bfrtip',
                buttons: [
                    'excel', 'print'
                ],
                responsive: true,
                pageLength: 10
            });
        });
    </script>
    
    
    
    
    
<script>
$(document).ready(function () {
    function fetchBookings(filter = 'all') {
        $.ajax({
            url: '../php/fetch-successful-bookings.php',
            method: 'POST',
            data: { filter: filter },
            success: function (response) {
                $('#bookingsData').html(response);
            },
            error: function () {
                Swal.fire('Error!', 'Failed to load data.', 'error');
            }
        });
    }

    // Load all bookings on page load
    fetchBookings();

    // Fetch data when the filter changes
    $('#filter').change(function () {
        var filter = $(this).val();
        fetchBookings(filter);
    });
});
</script>

    </body>
</html>

