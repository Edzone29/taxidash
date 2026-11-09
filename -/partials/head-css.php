<!-- Bootstrap Css -->
<link href="assets/css/bootstrap.min.css" id="bootstrap-style" rel="stylesheet" type="text/css" />
<!-- Icons Css -->
<link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
<!-- App Css-->
<link href="assets/css/app.min.css" id="app-style" rel="stylesheet" type="text/css" />

<link href="assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/datatables.net-buttons-bs4/css/buttons.bootstrap4.min.css" rel="stylesheet" type="text/css" />
<link href="assets/libs/shepherd/shepherd.css" rel="stylesheet" type="text/css" />

<!-- Responsive datatable examples -->
<link href="assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css" rel="stylesheet" type="text/css" />

<!-- Font Awesome icons CDN -->
<script src="https://kit.fontawesome.com/a076d05399.js"></script>

<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

<!-- TaxiDash Enhancements -->
<link href="assets/css/taxidash-enhance.css" rel="stylesheet" type="text/css" />

<style>
    #side-menu { font-weight: bold !important; }
    color: #212529;

    @font-face {
        font-family: 'AvenirNext';
        src: url('assets/fonts/Avenir.ttf') format('opentype');
    }

    body {
        overflow-x: hidden;
        font-family: 'AvenirNext', 'Segoe UI', sans-serif !important;
        color: #212529;
    }

    * { font-family: 'AvenirNext', 'Segoe UI', sans-serif; }

    .card-title { color: #343a40; font-weight: 600; }
    .card-text { color: #6c757d; }
</style>

<!-- Nav progress bar injected on every inner page -->
<script>
(function() {
    const bar = document.createElement('div');
    bar.className = 'nav-loading-bar';
    document.addEventListener('DOMContentLoaded', function() {
        document.body.prepend(bar);
        bar.classList.add('loading');
    });
    window.addEventListener('load', function() {
        bar.classList.remove('loading');
        bar.classList.add('done');
        setTimeout(() => bar.remove && bar.remove(), 500);
    });
})();
</script>
