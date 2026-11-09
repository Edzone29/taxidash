<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-driver.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

        <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'Trip Completed - TaxiDash')); ?>
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />
        <?php include 'partials/head-css.php'; ?>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
            <?php include 'partials/driver-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">
                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Driver' , 'title' => 'Trip Completed')); ?>

                        <div class="row mb-4">
                            <div class="col-xl-6 col-lg-8 col-md-10 mx-auto my-5">
                                <div id="bookingCard" class="card border-0 shadow-sm" style="border-radius: 20px; overflow: hidden;">
                                    <div class="card-header text-center text-white py-4" style="background: linear-gradient(135deg, #10b981, #059669);">
                                        <div class="rounded-circle bg-white bg-opacity-25 d-flex align-items-center justify-content-center mx-auto mb-2" style="width:64px; height:64px;">
                                            <i class="fas fa-check-circle fa-2x text-white"></i>
                                        </div>
                                        <h3 class="card-title text-white mb-0 fw-bold">Trip Completed!</h3>
                                    </div>
                                    <div class="card-body text-center p-5">
                                        <h4 class="text-dark fw-bold mb-2">Great Job!</h4>
                                        <p class="text-muted mb-4">You have safely dropped off the passenger at their destination.</p>

                                        <button onclick="window.location.href='driver-dashboard.php'" class="btn btn-primary btn-lg rounded-pill px-4 fw-bold shadow-sm">
                                            <i class="fas fa-home me-2"></i> Return to Dashboard
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <?php include 'partials/footer.php'; ?>
            </div>
        </div>

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>
        <script src="assets/js/app.js"></script>
    </body>
</html>
