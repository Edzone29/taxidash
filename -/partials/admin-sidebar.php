<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Admin badge -->
                <li class="text-center py-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                             style="width:48px;height:48px;background:linear-gradient(135deg,#ef4444,#b91c1c);">
                            <i class="mdi mdi-shield-account text-white" style="font-size:1.4rem;"></i>
                        </div>
                        <span class="fw-bold text-danger" style="font-size:0.85rem;">
                            <?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname'].' '.$_SESSION['lastname']) : 'Admin'; ?>
                        </span>
                        <span class="badge rounded-pill mt-1" style="background:linear-gradient(135deg,#ef4444,#b91c1c);font-size:0.7rem;">Administrator</span>
                    </div>
                </li>
                <hr class="my-1">

                <li>
                    <a href="admin-dashboard.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-dashboard.php')?'active':''; ?>">
                        <i class="mdi mdi-home-variant-outline"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="admin-driver.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-driver.php')?'active':''; ?>">
                        <i class="fas fa-user-tie"></i>
                        <span>Driver Accounts</span>
                    </a>
                </li>

                <li>
                    <a href="admin-pass.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-pass.php')?'active':''; ?>">
                        <i class="fas fa-users"></i>
                        <span>Passenger Accounts</span>
                    </a>
                </li>

                <li>
                    <a href="admin-block.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-block.php')?'active':''; ?>">
                        <i class="fas fa-user-shield"></i>
                        <span>Unblock Accounts</span>
                    </a>
                </li>

                <li>
                    <a href="admin-report.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-report.php')?'active':''; ?>">
                        <i class="fas fa-chart-bar"></i>
                        <span>Generate Reports</span>
                    </a>
                </li>

                <li>
                    <a href="admin-support.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='admin-support.php')?'active':''; ?>">
                        <i class="fas fa-headset"></i>
                        <span>Admin Support</span>
                    </a>
                </li>

                <hr class="my-1">

                <li>
                    <a href="logout.php" class="waves-effect text-danger">
                        <i class="mdi mdi-logout"></i>
                        <span>Logout</span>
                    </a>
                </li>

            </ul>
        </div>
    </div>
</div>
<!-- Left Sidebar End -->
