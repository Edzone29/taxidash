<?php include 'partials/session.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
        
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'GWork')); ?>

        <!-- jvectormap -->
        <link href="assets/libs/jqvmap/jqvmap.min.css" rel="stylesheet" />

        <?php include 'partials/head-css.php'; ?>
        
        <style>
            
            .job-card {
                border: 1px solid #dee2e6;
                border-radius: 8px;
                padding: 20px;
                box-shadow: 0 4px 8px rgba(0,0,0,0.1);
                background-color: #ffffff;
            }
            .job-title {
                font-size: 1.75rem;
                font-weight: 600;
                color: #343a40;
            }
            .company-name {
                font-size: 1.25rem;
                color: #6c757d;
            }
            .location, .job-type, .experience {
                font-size: 1rem;
                color: #495057;
            }
            .description-title {
                font-weight: 600;
            }
            .apply-btn {
                background-color: #007bff;
                color: #fff;
                font-weight: 500;
                padding: 10px 20px;
                border-radius: 4px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .apply-btn:hover {
                background-color: #0056b3;
            }
            .tags {
                background-color: #e9ecef;
                padding: 5px 10px;
                border-radius: 20px;
                margin-right: 10px;
            }
            
            .company-logo {
                width: 80px;
                height: 80px;
                object-fit: cover;
                border-radius: 50%;
                margin-right: 20px;
            }
             .update-btn, .delete-btn {
                font-weight: 500;
                padding: 10px 20px;
                border-radius: 4px;
                text-transform: uppercase;
                letter-spacing: 0.5px;
            }
            .update-btn {
                background-color: #28a745;
                color: #fff;
            }
            .update-btn:hover {
                background-color: #218838;
            }
            .delete-btn {
                background-color: #dc3545;
                color: #fff;
            }
            .delete-btn:hover {
                background-color: #c82333;
            }
            .btn-action {
            font-size: 0.875rem; /* Small Text */
            font-weight: 500;
            padding: 8px 15px;
            border-radius: 4px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            display: inline-flex;
            align-items: center;
            margin-bottom: 10px;
        }
        .btn-action i {
            margin-right: 5px; /* Space between icon and text */
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
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Admin' , 'title' => 'Dashboard')); ?>
                        
                        <div class="job-card p-4 mb-3">
                            <div class="d-flex justify-content-between align-items-center">
                                <div class="d-flex align-items-center">
                                    <img src="https://via.placeholder.com/100x100" alt="Company Logo" class="company-logo">
                                    <div>
                                        <h2 class="job-title">Full Stack Developer</h2>
                                        <p class="company-name">Tech Innovators Inc.</p>
                                    </div>
                                </div>
                                <div>
                                    <a href="admin-update-task" class="btn-action btn btn-sm btn-primary me-2">
                                        <i class="fas fa-pencil-alt"></i>
                                    </a>
                                    <button class="btn-action btn btn-sm btn-danger delete-btn">
                                        <i class="fas fa-trash-alt"></i>
                                    </button>
                                </div>
                                <!--<div>-->
                                <!--    <a href="admin-update-task" class="update-btn me-2">Update</a>-->
                                <!--    <button class="delete-btn">Delete</button>-->
                                <!--</div>-->
                            </div>
                            
                            <hr>
                            
                            <p class="location mb-1"><strong>Location:</strong> Remote</p>
                            <p class="job-type mb-1"><strong>Job Type:</strong> Full-time</p>
                            <p class="experience mb-4"><strong>Experience Level:</strong> Mid-level</p>
                            
                            <h5 class="description-title">Job Description</h5>
                            <p>
                                We are looking for a skilled Full Stack Developer to join our growing team. You will be responsible 
                                for building and maintaining web applications, collaborating with cross-functional teams, and delivering 
                                high-quality code.
                            </p>
                            
                            <h5 class="description-title">Responsibilities</h5>
                            <ul>
                                <li>Develop and maintain web applications using modern technologies.</li>
                                <li>Collaborate with designers and product managers to ensure a great user experience.</li>
                                <li>Write clean, efficient, and scalable code.</li>
                                <li>Fix bugs and improve application performance.</li>
                            </ul>
                            
                            <h5 class="description-title">Required Qualifications</h5>
                            <ul>
                                <li>Bachelor's degree in Computer Science or related field.</li>
                                <li>Proficiency in HTML, CSS, JavaScript, React, and Node.js.</li>
                                <li>Experience with RESTful APIs and database systems like MySQL.</li>
                                <li>Strong problem-solving skills and attention to detail.</li>
                            </ul>
                            
                            <h5 class="description-title">Preferred Skills</h5>
                            <ul>
                                <li>Experience with Docker and CI/CD pipelines.</li>
                                <li>Familiarity with cloud platforms like AWS or Azure.</li>
                                <li>Knowledge of agile development methodologies.</li>
                            </ul>
                            
                            <h5 class="description-title">Salary & Benefits</h5>
                            <p>
                                Competitive salary based on experience. Additional benefits include remote work flexibility, health insurance, and professional development opportunities.
                            </p>
                            
                            <hr>
                            
                            <h5 class="description-title">Tags</h5>
                            <span class="tags">Full Stack</span>
                            <span class="tags">Remote</span>
                            <span class="tags">JavaScript</span>
                            <span class="tags">Node.js</span>
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
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
        <script>
    // Trigger SweetAlert on click
    $(document).on('click', '.delete-btn', function(e) {
        e.preventDefault(); // Prevent default form submission or button action
        
        Swal.fire({
            title: 'Are you sure?',
            text: 'You won\'t be able to undo this action!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#002623',
            cancelButtonColor: '#3085d6',
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel'
        }).then((result) => {
            if (result.isConfirmed) {
                // Handle delete task action here, e.g., make an API call or submit a form
                Swal.fire(
                    'Deleted!',
                    'Your task post has been deleted.',
                    'success'
                );
            }
        });
    });
</script>

    </body>
</html>
