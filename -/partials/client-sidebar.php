<!-- ========== Left Sidebar Start ========== -->
<div class="vertical-menu">
    <div data-simplebar class="h-100">
        <div id="sidebar-menu">
            <ul class="metismenu list-unstyled" id="side-menu">

                <!-- User badge -->
                <li class="text-center py-3">
                    <div class="d-flex flex-column align-items-center">
                        <div class="rounded-circle d-flex align-items-center justify-content-center mb-2"
                             style="width:48px;height:48px;background:linear-gradient(135deg,#3bafda,#1e3c72);">
                            <i class="mdi mdi-account text-white" style="font-size:1.4rem;"></i>
                        </div>
                        <span class="fw-bold text-primary" style="font-size:0.85rem;">
                            <?php echo isset($_SESSION['firstname']) ? htmlspecialchars($_SESSION['firstname'].' '.$_SESSION['lastname']) : 'Passenger'; ?>
                        </span>
                        <span class="badge rounded-pill mt-1" style="background:linear-gradient(135deg,#3bafda,#1e3c72);font-size:0.7rem;">Passenger</span>
                    </div>
                </li>
                <hr class="my-1">

                <li>
                    <a href="client-dashboard.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='client-dashboard.php')?'active':''; ?>">
                        <i class="mdi mdi-home-variant-outline"></i>
                        <span>Dashboard</span>
                    </a>
                </li>

                <li>
                    <a href="client-1book.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='client-1book.php')?'active':''; ?>">
                        <i class="mdi mdi-taxi"></i>
                        <span>Book a Ride</span>
                    </a>
                </li>

                <li>
                    <a href="client-history.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='client-history.php')?'active':''; ?>">
                        <i class="mdi mdi-history"></i>
                        <span>Booking History</span>
                    </a>
                </li>

                <li>
                    <a href="client-profile.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='client-profile.php')?'active':''; ?>">
                        <i class="mdi mdi-account-circle-outline"></i>
                        <span>My Profile</span>
                    </a>
                </li>

                <li>
                    <a href="client-customer-support.php" class="waves-effect <?php echo (basename($_SERVER['PHP_SELF'])=='client-customer-support.php')?'active':''; ?>">
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
