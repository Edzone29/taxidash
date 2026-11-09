<?php include 'partials/session.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
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
            align-items: center;
            gap: 10px;
        }
        
        .job-card ul li i {
            width: 24px;
            height: 24px;
            text-align: center;
            font-size: 1.2rem;
            line-height: 24px;
        }
        
        .action-icons {
            display: flex;
            gap: 8px;
        }
        
        .update-icon i,
        .delete-icon i {
            font-size: 1.2rem;
            color: #ccc;
        }
        
        .update-icon i:hover {
            color: #3498db; /* Blue color for update */
        }
        
        .delete-icon i:hover {
            color: #e74c3c; /* Red color for delete */
        }
        
        .badge {
            font-size: 0.85rem;
        }
        
        .list-unstyled {
            line-height: 1.8;
        }
        
        .cursor-pointer i {
            cursor: pointer;
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

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Client' , 'title' => 'Task Posted')); ?>
                        
                        <div class="row task-posted-list">
                           <div class="col-lg-4 col-sm-6 col-xs-12">
                                <a href="client-approve-applicant" class="text-decoration-none task-posted">
                                    <div class="card job-card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title mb-1">Company Driver</h5>
                                                    <p class="company-name text-muted mb-2">GOLDMÜNZEN, INC.</p>
                                                </div>
                                            </div>
                                            <div class="company-logo mb-3">
                                                <img src="https://via.placeholder.com/100x100" alt="GOLDMÜNZEN, INC. Logo" class="img-fluid">
                                            </div>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-map-marker-alt"></i> Quezon, Philippines</li>
                                                <li><i class="fas fa-money-bill-wave"></i> Salary Undisclosed</li>
                                                <li><i class="fas fa-clock"></i> Full time</li>
                                                <li><i class="fas fa-search"></i> Recruiter was hiring 5 days ago</li>
                                            </ul>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted">Apply before 1 Nov</small>
                                                <span class="badge bg-secondary">Entry Level / Junior, Apprentice</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Modified Job 2 -->
                            <div class="col-lg-4 col-sm-6 col-xs-12">
                                <a href="client-approve-applicant" class="text-decoration-none">
                                    <div class="card job-card mb-3">
                                        <div class="card-body">
                                            <div class="d-flex justify-content-between">
                                                <div>
                                                    <h5 class="card-title mb-1">Software Engineer</h5>
                                                    <p class="company-name text-muted mb-2">Tech Innovators, LLC</p>
                                                </div>
                                            </div>
                                            <div class="company-logo mb-3">
                                                <img src="https://via.placeholder.com/100x100" alt="Tech Innovators, LLC Logo" class="img-fluid">
                                            </div>
                                            <ul class="list-unstyled">
                                                <li><i class="fas fa-map-marker-alt"></i> Makati, Philippines</li>
                                                <li><i class="fas fa-money-bill-wave"></i> ₱50,000 - ₱80,000</li>
                                                <li><i class="fas fa-clock"></i> Full time</li>
                                                <li><i class="fas fa-search"></i> Hiring 3 days ago</li>
                                            </ul>
                                            <div class="d-flex justify-content-between align-items-center mt-3">
                                                <small class="text-muted">Apply before 15 Nov</small>
                                                <span class="badge bg-primary">Mid-Senior Level</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </div>
                            
                            <!-- Continue similarly for other job cards -->

                            
                            <!-- Modified Job 3 -->
                            <!-- Modified Job 3 -->
<div class="col-lg-4 col-sm-6 col-xs-12">
    <a href="client-approve-applicant" class="text-decoration-none">
        <div class="card job-card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">Marketing Manager</h5>
                        <p class="company-name text-muted mb-2">Bright Future Co.</p>
                    </div>
                </div>
                <div class="company-logo mb-3">
                    <img src="https://via.placeholder.com/100x100" alt="Bright Future Co. Logo" class="img-fluid">
                </div>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> Manila, Philippines</li>
                    <li><i class="fas fa-money-bill-wave"></i> ₱70,000 - ₱100,000</li>
                    <li><i class="fas fa-clock"></i> Full time</li>
                    <li><i class="fas fa-search"></i> Hiring 1 week ago</li>
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">Apply before 20 Nov</small>
                    <span class="badge bg-success">Manager</span>
                </div>
            </div>
        </div>
    </a>
</div>

<!-- Modified Job 4 -->
<div class="col-lg-4 col-sm-6 col-xs-12">
    <a href="client-approve-applicant" class="text-decoration-none">
        <div class="card job-card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">HR Specialist</h5>
                        <p class="company-name text-muted mb-2">Human Solutions</p>
                    </div>
                </div>
                <div class="company-logo mb-3">
                    <img src="https://via.placeholder.com/100x100" alt="Human Solutions Logo" class="img-fluid">
                </div>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> Taguig, Philippines</li>
                    <li><i class="fas fa-money-bill-wave"></i> ₱40,000 - ₱60,000</li>
                    <li><i class="fas fa-clock"></i> Full time</li>
                    <li><i class="fas fa-search"></i> Hiring 2 weeks ago</li>
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">Apply before 30 Oct</small>
                    <span class="badge bg-info">Entry Level</span>
                </div>
            </div>
        </div>
    </a>
</div>

<!-- Modified Job 5 -->
<div class="col-lg-4 col-sm-6 col-xs-12">
    <a href="client-approve-applicant" class="text-decoration-none">
        <div class="card job-card mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h5 class="card-title mb-1">IT Support Specialist</h5>
                        <p class="company-name text-muted mb-2">Digital Ventures</p>
                    </div>
                </div>
                <div class="company-logo mb-3">
                    <img src="https://via.placeholder.com/100x100" alt="Digital Ventures Logo" class="img-fluid">
                </div>
                <ul class="list-unstyled">
                    <li><i class="fas fa-map-marker-alt"></i> Cebu, Philippines</li>
                    <li><i class="fas fa-money-bill-wave"></i> ₱30,000 - ₱50,000</li>
                    <li><i class="fas fa-clock"></i> Full time</li>
                    <li><i class="fas fa-search"></i> Hiring 3 days ago</li>
                </ul>
                <div class="d-flex justify-content-between align-items-center mt-3">
                    <small class="text-muted">Apply before 10 Nov</small>
                    <span class="badge bg-warning">Mid Level</span>
                </div>
            </div>
        </div>
    </a>
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
                        title: 'Task Posted List',
                        text: 'This shows your existing task posted',
                        attachTo: {
                            element: '.task-posted-list',
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
                        title: 'Task Posted',
                        text: 'This show you the details of your posted task ',
                        attachTo: {
                            element: '.task-posted',
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
