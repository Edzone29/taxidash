<header id="page-topbar">
    <div class="navbar-header">
        <div class="d-flex align-items-center">
            <!-- LOGO -->
            <div class="navbar-brand-box text-center">
                <a href="#" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="../taxi.png" alt="TaxiDash" height="36" style="border-radius:8px;">
                    </span>
                    <span class="logo-lg">
                        <img src="../taxi.jpg" alt="TaxiDash" height="50" style="border-radius:8px; object-fit:cover;">
                    </span>
                </a>
                <a href="#" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="../taxi.jpg" alt="TaxiDash" height="36" style="border-radius:8px;">
                    </span>
                    <span class="logo-lg">
                        <img src="../taxi.jpg" alt="TaxiDash" height="50" style="border-radius:8px; object-fit:cover;">
                    </span>
                </a>
            </div>

            <button type="button" class="btn btn-sm px-3 font-size-24 header-item waves-effect" id="vertical-menu-btn">
                <i class="ri-menu-2-line align-middle"></i>
            </button>

            <span class="d-none d-md-inline-block ms-2 fw-semibold text-primary" style="font-size:1.05rem; letter-spacing:0.5px;">
                TAXIDASH
            </span>
        </div>

        <div class="d-flex align-items-center gap-2">
            <!-- Live Clock -->
            <div class="d-none d-sm-flex align-items-center px-3 py-1 rounded-pill" style="background:rgba(59,175,218,0.1); gap:6px;">
                <i class="bi bi-clock text-primary" style="font-size:0.85rem;"></i>
                <span id="live-clock" class="fw-semibold text-primary" style="font-size:0.85rem; min-width:80px;"></span>
            </div>
        </div>
    </div>
</header>

<script>
(function() {
    function updateClock() {
        const el = document.getElementById('live-clock');
        if (!el) return;
        const now = new Date();
        el.textContent = now.toLocaleTimeString('en-PH', { hour:'2-digit', minute:'2-digit', second:'2-digit', hour12:true });
    }
    updateClock();
    setInterval(updateClock, 1000);
})();
</script>
