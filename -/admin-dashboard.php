<?php include 'partials/session.php'; ?>
<?php include 'partials/guard-admin.php'; ?>
<?php include 'partials/main.php'; ?>

    <head>
    <?php includeFileWithVariables('partials/title-meta.php', array('title' => 'TaxiDash – Admin')); ?>
        <?php include 'partials/head-css.php'; ?>
        <style>
            .stat-card { border-radius: 18px; border: none; overflow: hidden; transition: transform 0.25s ease, box-shadow 0.25s ease; cursor: default; }
            .stat-card:hover { transform: translateY(-5px); box-shadow: 0 16px 32px rgba(0,0,0,0.2) !important; }
            .stat-icon-wrap { width: 64px; height: 64px; border-radius: 50%; background: rgba(255,255,255,0.2); display:flex; align-items:center; justify-content:center; margin: 0 auto 14px; }
            .stat-number { font-size: 2.2rem; font-weight: 800; }
            .stat-label { font-size: 0.9rem; opacity: 0.9; font-weight: 500; }
            .welcome-banner { background: linear-gradient(135deg, #1e3c72, #3bafda); border-radius: 18px; padding: 24px 28px; color: #fff; margin-bottom: 24px; }
            .welcome-banner h4 { font-weight: 700; font-size: 1.4rem; }
            .welcome-banner p { opacity: 0.85; margin: 0; font-size: 0.92rem; }
        </style>
    </head>

    <body data-topbar="colored">
        <div id="layout-wrapper">
        <?php include 'partials/admin-menu.php'; ?>

            <div class="main-content">
                <div class="page-content">
                    <div class="container-fluid">

                        <!-- Welcome Banner -->
                        <div class="welcome-banner d-flex align-items-center justify-content-between flex-wrap gap-3">
                            <div>
                                <h4><i class="bi bi-speedometer2 me-2"></i>Admin Dashboard</h4>
                                <p>Welcome back, <strong><?php echo htmlspecialchars($_SESSION['firstname']); ?></strong>! Here's your system overview.</p>
                            </div>
                            <div class="text-end d-none d-md-block">
                                <span style="font-size:0.82rem; opacity:0.8;" id="admin-date"></span>
                            </div>
                        </div>

                        <!-- Stats Row -->
                        <?php
                        include '../php/conn.php';
                        $driverCount      = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM tbl_users WHERE user_type='driver' AND status=1"))['c'];
                        $userCount        = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM tbl_users WHERE user_type='user' AND status=1"))['c'];
                        $successBookings  = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM temp_ride_bookings WHERE status=7"))['c'];
                        $pendingTickets   = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) c FROM tickets WHERE status IN (0,1)"))['c'];
                        ?>

                        <div class="row g-3 mb-4">
                            <div class="col-xl-3 col-sm-6">
                                <div class="card stat-card text-white" style="background:linear-gradient(135deg,#3bafda,#1e3c72); box-shadow:0 6px 20px rgba(59,175,218,0.35);">
                                    <div class="card-body text-center py-4">
                                        <div class="stat-icon-wrap"><i class="fas fa-taxi fa-2x text-white"></i></div>
                                        <div class="stat-number"><?php echo $driverCount; ?></div>
                                        <div class="stat-label">Active Drivers</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card stat-card text-white" style="background:linear-gradient(135deg,#42a5f5,#283593); box-shadow:0 6px 20px rgba(66,165,245,0.35);">
                                    <div class="card-body text-center py-4">
                                        <div class="stat-icon-wrap"><i class="fas fa-users fa-2x text-white"></i></div>
                                        <div class="stat-number"><?php echo $userCount; ?></div>
                                        <div class="stat-label">Active Passengers</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card stat-card text-white" style="background:linear-gradient(135deg,#10b981,#065f46); box-shadow:0 6px 20px rgba(16,185,129,0.35);">
                                    <div class="card-body text-center py-4">
                                        <div class="stat-icon-wrap"><i class="fas fa-check-circle fa-2x text-white"></i></div>
                                        <div class="stat-number"><?php echo $successBookings; ?></div>
                                        <div class="stat-label">Successful Rides</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-3 col-sm-6">
                                <div class="card stat-card text-white" style="background:linear-gradient(135deg,#f59e0b,#b45309); box-shadow:0 6px 20px rgba(245,158,11,0.35);">
                                    <div class="card-body text-center py-4">
                                        <div class="stat-icon-wrap"><i class="fas fa-headset fa-2x text-white"></i></div>
                                        <div class="stat-number"><?php echo $pendingTickets; ?></div>
                                        <div class="stat-label">Pending Concerns</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Quick Links -->
                        <div class="row g-3">
                            <div class="col-12">
                                <h5 class="fw-bold text-secondary mb-3"><i class="bi bi-grid me-2"></i>Quick Actions</h5>
                            </div>
                            <?php
                            $links = [
                                ['href'=>'admin-driver.php',  'icon'=>'fas fa-user-tie',    'label'=>'Driver Accounts',    'color'=>'#3bafda'],
                                ['href'=>'admin-pass.php',    'icon'=>'fas fa-users',        'label'=>'Passenger Accounts', 'color'=>'#42a5f5'],
                                ['href'=>'admin-block.php',   'icon'=>'fas fa-user-shield',  'label'=>'Unblock Accounts',   'color'=>'#f59e0b'],
                                ['href'=>'admin-report.php',  'icon'=>'fas fa-chart-bar',    'label'=>'Reports',            'color'=>'#10b981'],
                                ['href'=>'admin-support.php', 'icon'=>'fas fa-headset',      'label'=>'Support Tickets',    'color'=>'#8b5cf6'],
                            ];
                            foreach($links as $l): ?>
                            <div class="col-xl-2 col-md-3 col-sm-4 col-6">
                                <a href="<?php echo $l['href']; ?>" class="card text-decoration-none hoverable" style="border-radius:14px; border:1px solid #f0f0f0;">
                                    <div class="card-body text-center py-3">
                                        <i class="<?php echo $l['icon']; ?> fa-lg mb-2" style="color:<?php echo $l['color']; ?>;"></i>
                                        <div style="font-size:0.78rem; font-weight:600; color:#374151;"><?php echo $l['label']; ?></div>
                                    </div>
                                </a>
                            </div>
                            <?php endforeach; ?>
                        </div>

                    </div><!-- container-fluid -->
                </div><!-- page-content -->

                <?php include 'partials/footer.php'; ?>
            </div><!-- main-content -->
        </div><!-- layout-wrapper -->

        <?php include 'partials/right-sidebar.php'; ?>
        <?php include 'partials/vendor-scripts.php'; ?>
        <script src="assets/js/app.js"></script>
        <script>
            // Display date in welcome banner
            const d = new Date();
            document.getElementById('admin-date').textContent = d.toLocaleDateString('en-PH',{weekday:'long',year:'numeric',month:'long',day:'numeric'});
        </script>
    </body>
</html>
