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
                        
                        <div class="card">
                            <div class="card-body">
                            <h2 class="form-header">Update Job Posting</h2>
                            
                            <form action="/update-job" method="POST">
                                <div class="mb-3">
                                    <label for="jobTitle" class="form-label">Job Title</label>
                                    <input type="text" class="form-control" id="jobTitle" name="jobTitle" value="Full Stack Developer" required>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="companyName" class="form-label">Company Name</label>
                                    <input type="text" class="form-control" id="companyName" name="companyName" value="Tech Innovators Inc." required>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="location" class="form-label">Location</label>
                                    <input type="text" class="form-control" id="location" name="location" value="Remote" required>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="jobType" class="form-label">Job Type</label>
                                    <select class="form-select" id="jobType" name="jobType" required>
                                        <option value="Full-time" selected>Full-time</option>
                                        <option value="Part-time">Part-time</option>
                                        <option value="Contract">Contract</option>
                                        <option value="Freelance">Freelance</option>
                                        <option value="Internship">Internship</option>
                                    </select>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="experienceLevel" class="form-label">Experience Level</label>
                                    <select class="form-select" id="experienceLevel" name="experienceLevel" required>
                                        <option value="Entry-level">Entry-level</option>
                                        <option value="Mid-level" selected>Mid-level</option>
                                        <option value="Senior-level">Senior-level</option>
                                        <option value="Director">Director</option>
                                        <option value="Executive">Executive</option>
                                    </select>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="jobDescription" class="form-label">Job Description</label>
                                    <textarea class="form-control" id="jobDescription" name="jobDescription" rows="4" required>We are looking for a skilled Full Stack Developer to join our growing team. You will be responsible for building and maintaining web applications, collaborating with cross-functional teams, and delivering high-quality code.
                                    </textarea>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="responsibilities" class="form-label">Responsibilities</label>
                                    <textarea class="form-control" id="responsibilities" name="responsibilities" rows="4" required>Develop and maintain web applications using modern technologies. Collaborate with designers and product managers to ensure a great user experience. Write clean, efficient, and scalable code. Fix bugs and improve application performance.
                                    </textarea>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="qualifications" class="form-label">Required Qualifications</label>
                                    <textarea class="form-control" id="qualifications" name="qualifications" rows="4" required>Bachelor's degree in Computer Science or related field. Proficiency in HTML, CSS, JavaScript, React, and Node.js. Experience with RESTful APIs and database systems like MySQL. Strong problem-solving skills and attention to detail.
                                    </textarea>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="preferredSkills" class="form-label">Preferred Skills</label>
                                    <textarea class="form-control" id="preferredSkills" name="preferredSkills" rows="3">Experience with Docker and CI/CD pipelines. Familiarity with cloud platforms like AWS or Azure. Knowledge of agile development methodologies.
                                    </textarea>
                                </div>
                    
                                <div class="mb-3">
                                    <label for="salaryBenefits" class="form-label">Salary & Benefits</label>
                                    <textarea class="form-control" id="salaryBenefits" name="salaryBenefits" rows="3">Competitive salary based on experience. Additional benefits include remote work flexibility, health insurance, and professional development opportunities.
                                    </textarea>
                                </div>
                    
                                <div class="text-end">
                                    <a type="submit" class="btn btn-primary me-2">Update</button>
                                    <a href="admin-view-task.php" class="btn btn-danger">Cancel</a>
                                </div>
                            </form>
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

    </body>
</html>
