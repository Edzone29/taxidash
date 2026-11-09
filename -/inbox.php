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
            
            .avatar {
                position: relative;
                width: 3.5rem;
                height: 3.5rem;
                cursor: pointer;
            }
            
            .avatar.avatar-online:after {
                background-color: #28c76f;
            }
            
            .avatar.avatar-online:after, .avatar.avatar-offline:after, .avatar.avatar-away:after, .avatar.avatar-busy:after {
                content: "";
                position: absolute;
                bottom: 0;
                right: 3px;
                width: 8px;
                height: 8px;
                border-radius: 100%;
                box-shadow: 0 0 0 2px #fff;
            }
            
            .chat-messages {
  height: calc(100vh - 300px);
  overflow-y: auto;
}

.card {
  max-width: 70%;
}

.list-group-item.active {
  /*background-color: #6610f2 !important;*/
  /*border-color: #6610f2 !important;*/
}

.btn-primary, .bg-primary {
  background-color: #6610f2 !important;
  border-color: #6610f2 !important;
}

.text-primary {
  color: #6610f2 !important;
}


            
        </style>

    </head>

    <body data-topbar="colored">

        <!-- Begin page -->
        <div id="layout-wrapper">

        <?php include 'partials/menu.php'; ?>

            <!-- ============================================================== -->
            <!-- Start right Content here -->
            <!-- ============================================================== -->
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">

                        <?php includeFileWithVariables('partials/page-title.php', array('pagetitle' => 'Home' , 'title' => 'Inbox')); ?>
                        <div class="row">
                            
                            
                            <div class="col-md-4 border-end border-end-2">
                              <!--<div class="p-3">-->
                                <!--<h5 class="text-primary">Chats</h5>-->
                                <div class="list-group">
                                  <a href="#" class="list-group-item list-group-item-action p-3" style="color: black;">
                                      <div class="d-flex w-100 justify-content-between align-items-start">
                                        <div class="d-flex">
                                          <img src="https://via.placeholder.com/100x100" class="rounded-circle me-3" width="50" height="50" alt="Waldemar Mannering">
                                          <div class="gap-2">
                                            <h6 class="mb-0">Waldemar Mannering</h6>
                                            <p>Refer friends. Get rewar...</p>
                                          </div>
                                        </div>
                                        <small>5 Minutes</small>
                                      </div>
                                    </a>
                                  <!-- More chat items... -->
                                </div>
                                
                                <!--<h5 class="text-primary mt-4">Contacts</h5>-->
                                <!--<div class="list-group">-->
                                <!--  <a href="#" class="list-group-item list-group-item-action">-->
                                <!--    <div class="d-flex align-items-center">-->
                                <!--      <img src="avatar2.jpg" class="rounded-circle me-2" width="40" height="40">-->
                                <!--      <div>-->
                                <!--        <strong>Natalie Maxwell</strong>-->
                                <!--        <br>-->
                                <!--        <small>UI/UX Designer</small>-->
                                <!--      </div>-->
                                <!--    </div>-->
                                <!--  </a>-->
                                  <!-- More contact items... -->
                                <!--</div>-->
                              <!--</div>-->
                            </div>
                            
                            <div class="col-md-8 p-0">
                                
                                <div class="card job-card mb-3">
                                    <div class="card-body">
                                        <div class="chat-messages">
                                  <!-- Receiver message -->
                                  <div class="d-flex mb-3">
                                    <img src="avatar3.jpg" class="rounded-circle me-2 align-self-end" width="30" height="30">
                                    <div class="card">
                                      <div class="card-body">
                                        <p class="mb-0">Hey John, I am looking for the best admin template. Could you please help me to find it out? 🤔</p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="text-muted small mb-3">10:02 AM</div>
                                  
                                  <!-- Sender message -->
                                  <div class="d-flex flex-row-reverse mb-3">
                                    <img src="avatar4.jpg" class="rounded-circle ms-2 align-self-end" width="30" height="30">
                                    <div class="card bg-primary text-white">
                                      <div class="card-body">
                                        <p class="mb-0">Vuexy has all the components you'll ever need in a app.</p>
                                      </div>
                                    </div>
                                  </div>
                                  <div class="text-muted small text-end mb-3">10:03 AM</div>
                                  
                                  <!-- More messages... -->
                                </div>
                                
                                <!-- Message input -->
                                <div class="mt-3">
                                  <div class="input-group">
                                    <input type="text" class="form-control" placeholder="Type your message here">
                                    <button class="btn btn-primary" type="button">Send</button>
                                  </div>
                                </div>
                                    </div>
                                </div>
                              <!--<div class="p-3">-->
                                
                              <!--</div>-->
                            </div>
                            
                        </div>
                        
                        <!-- Right column: Chat window -->
                        




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
