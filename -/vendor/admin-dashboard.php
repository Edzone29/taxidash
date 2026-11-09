<?php include 'partials/session.php'; ?>
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Dashboard')); ?>
                        
            <div class="row mb-3">
                            <div class="col-xl-3 col-sm-6">
                                <div class="card card1">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div id="radialchart-1" class="apex-charts" dir="ltr"></div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Job Postings</p>
                                                <h5 class="mb-3">120</h5>
                                                <p class="text-truncate mb-0"><span class="text-success me-2"> 1.5% <i class="ri-arrow-right-up-line align-bottom ms-1"></i></span> From previous month</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        
                            <div class="col-xl-3 col-sm-6">
                                <div class="card card2">
                                    <div class="card-body">
                                        <div class="d-flex">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div id="radialchart-2" class="apex-charts" dir="ltr"></div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Applications Submitted</p>
                                                <h5 class="mb-3">550</h5>
                                                <p class="text-truncate mb-0"><span class="text-success me-2"> 2.3% <i class="ri-arrow-right-up-line align-bottom ms-1"></i></span> From previous week</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        
                            <div class="col-xl-3 col-sm-6">
                                <div class="card card3">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div id="radialchart-3" class="apex-charts" dir="ltr"></div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">Jobs Filled</p>
                                                <h5 class="mb-3">78</h5>
                                                <p class="text-truncate mb-0"><span class="text-danger me-2"> 0.5% <i class="ri-arrow-right-down-line align-bottom ms-1"></i></span> From previous month</p>
                                            </div>
                                        </div>                                        
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
                            </div>
                            <!-- end col -->
                        
                            <div class="col-xl-3 col-sm-6">
                                <div class="card card4">
                                    <div class="card-body">
                                        <div class="d-flex text-muted">
                                            <div class="flex-shrink-0 me-3 align-self-center">
                                                <div class="avatar-sm">
                                                    <div class="avatar-title bg-light rounded-circle text-primary font-size-20">
                                                        <i class="ri-group-line"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="flex-grow-1 overflow-hidden">
                                                <p class="mb-1">New Applications</p>
                                                <h5 class="mb-3">125</h5>
                                                <p class="text-truncate mb-0"><span class="text-success me-2"> 0.8% <i class="ri-arrow-right-up-line align-bottom ms-1"></i></span> From previous day</p>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- end card-body -->
                                </div>
                                <!-- end card -->
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
        <!-- END layout-wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>

        <?php include 'partials/vendor-scripts.php'; ?>

        <!-- jquery.vectormap map -->
        <script src="assets/libs/jqvmap/jquery.vmap.min.js"></script>
        <script src="assets/libs/jqvmap/maps/jquery.vmap.usa.js"></script>

        <script src="assets/js/app.js"></script>
        
        <script>
           $(document).ready(function() {
               
                // if (!localStorage.getItem('tourCompleted')) {
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
                        title: 'Job Posting',
                        text: 'This shows the total of available job posting',
                        attachTo: {
                            element: '.card1',
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
                        title: 'Application Submitted',
                        text: 'This shows current total application submitted',
                        attachTo: {
                            element: '.card2',
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
                        title: 'Jobs filled',
                        text: 'This shows your total jobs filled',
                        attachTo: {
                            element: '.card3',
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
                        title: 'New Application',
                        text: 'This shows the total count of new application',
                        attachTo: {
                            element: '.card4',
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
                        id: 'add-filter-step'
                    });
                    
                    tour.start();
                    
                //      tour.on('complete', function() {
                //         localStorage.setItem('tourCompleted', 'true');
                //     });
                    
                // }
                    
                   
                    
                
                    // Mark the tour as completed after finishing
                    // tour.on('complete', function() {
                    //     localStorage.setItem('tourCompleted', 'true');
                    // });
                
                    // Add an event listener to the button inside the step
                    // tour.on('show', function() {
                    //     const button = document.getElementById('tour-next-button');
                    //     if (button) {
                    //         button.addEventListener('click', function() {
                    //             tour.next();  // Trigger the next step when the button is clicked
                    //         });
                    //     }
                    // });
                
                    // If the user cancels the tour, you can also mark it as completed or leave it as is
                    // tour.on('cancel', function() {
                    //     localStorage.setItem('tourCompleted', 'true');
                    // });
                // }
               
               
           });
        </script>
    </body>
</html>
