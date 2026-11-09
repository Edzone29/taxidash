<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-client.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
        
        <style>
            
             .card-logo {
            width: 40px;
            height: 25px;
            object-fit: contain;
        }
        .card-item {
            border: 1px solid #e0e0e0;
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 10px;
        }
        .btn-edit, .btn-delete {
            padding: 2px 10px;
            font-size: 0.8rem;
        }
        .btn-add-card {
            background-color: #7c3aed;
            color: white;
        }

            
        </style>

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
                        
                        

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Secure Payment')); ?>
                        
                        <div class="row p-0">
                            
                            <div class="col-xs-12 col-lg-4">
                                <div class="card">
                                    
                               <div class="card-body">
                                   
                                <button class="btn btn-primary btn-lg w-100 mb-3 add-new">Add New</button>
                                   
                                <div class="card-item card-details">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/2/2a/Mastercard-logo.svg/1280px-Mastercard-logo.svg.png" alt="Mastercard" class="card-logo me-2">
                    <div>
                        <div>Joseph Santos <span class="badge bg-info text-dark">Primary</span></div>
                        <div class="text-muted">**** **** **** 9856</div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-edit me-2 card-edit">Edit</button>
                    <button class="btn btn-outline-secondary btn-delete card-delete">Delete</button>
                </div>
            </div>
            <div class="text-muted mt-2">Card expires at 12/26</div>
        </div>

        <div class="card-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/5/5e/Visa_Inc._logo.svg/2560px-Visa_Inc._logo.svg.png" alt="Visa" class="card-logo me-2">
                    <div>
                        <div>Joseph Santos </div>
                        <div class="text-muted">**** **** **** 6542</div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-edit me-2">Edit</button>
                    <button class="btn btn-outline-secondary btn-delete">Delete</button>
                </div>
            </div>
            <div class="text-muted mt-2">Card expires at 10/24</div>
        </div>

        <div class="card-item">
            <div class="d-flex justify-content-between align-items-center">
                <div class="d-flex align-items-center">
                    <img src="https://upload.wikimedia.org/wikipedia/commons/thumb/f/fa/American_Express_logo_%282018%29.svg/1200px-American_Express_logo_%282018%29.svg.png" alt="American Express" class="card-logo me-2">
                    <div>
                        <div>Joseph Santos</div>
                        <div class="text-muted">**** **** **** 5896</div>
                    </div>
                </div>
                <div>
                    <button class="btn btn-outline-primary btn-edit me-2">Edit</button>
                    <button class="btn btn-outline-secondary btn-delete">Delete</button>
                </div>
            </div>
            <div class="text-muted mt-2">Card expires at 10/27</div>
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
        
        <script>
            $(document).ready(function() {
               
                // if (!localStorage.getItem('tour_viewTask')) {
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
                        title: 'Add Card',
                        text: 'For adding new payment method',
                        attachTo: {
                            element: '.add-new',
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
                        title: 'Existing Card',
                        text: 'Existing list of payment method',
                        attachTo: {
                            element: '.card-details',
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
                        title: 'Edit',
                        text: 'For updating payment method credentials',
                        attachTo: {
                            element: '.card-edit',
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
                        title: 'Delete',
                        text: 'For removing existing payment method',
                        attachTo: {
                            element: '.card-delete',
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
                    
                    
                    
                   
               
           });
           </script>

    </body>
</html>

