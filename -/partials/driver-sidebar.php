<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- Driver badge -->
                <li class="text-center py-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                             style="width:48px;height:48px;background:linear-gradient(135deg,#f59e0b,#d97706);">
                            <i class="mdi mdi-car text-white" style="font-size:1.4rem;"></i>
                        </div>
                        <span class="fw-bold text-warning" style="font-size:0.85rem;">
                            <?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname'].' '.$_SESSION['lastname']) : 'Driver'; ?>
                        </span>
                        <span class="badge rounded-pill mt-1" style="background:linear-gradient(135deg,#f59e0b,#d97706);font-size:0.7rem;">Driver</span>
                    </div>
                </li>
                <hr class="my-1">

                <li>
                    <a href="driver-dashboard.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='driver-dashboard.php')?'active':''; ?>">
                        <i class="mdi mdi-home-variant-outline"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="driver-book.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='driver-book.php')?'active':''; ?>">
                        <i class="mdi mdi-clipboard-text-outline"></i>
                        <span>Pickup Booking</span>
                    </a>
                </li>

                <li>
                    <a href="driver-history.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='driver-history.php')?'active':''; ?>">
                        <i class="mdi mdi-history"></i>
                        <span>Passenger History</span>
                    </a>
                </li>

                <li>
                    <a href="driver-profile.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='driver-profile.php')?'active':''; ?>">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                <li>
                    <a href="driver-customer-support.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='driver-customer-support.php')?'active':''; ?>">
                        <i class="far fa-comments"></i>
                        <span>Customer Support</span>
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
