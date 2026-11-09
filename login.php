<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaxiDash – Login</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
  <style>
    *, *::before, *::after { box-sizing: border-box; }
    body {
      background: linear-gradient(135deg, #1e3c72 0%, #2a5298 50%, #3bafda 100%);
      min-height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
      padding: 20px;
      font-family: 'Segoe UI', sans-serif;
      animation: fadeInPage 0.5s ease both;
    }
    @keyframes fadeInPage { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
    .login-wrapper {
      width: 100%;
      max-width: 420px;
    }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover {
      transform: translateY(-3px);
      box-shadow: 0 28px 70px rgba(0,0,0,0.3);
    }
    .card-header-custom {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      padding: 30px 24px 20px;
      text-align: center;
    }
    .card-header-custom img {
      width: 90px;
      height: 90px;
      object-fit: cover;
      border-radius: 18px;
      border: 3px solid rgba(255,255,255,0.4);
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      margin-bottom: 12px;
      transition: transform 0.3s ease;
    }
    .card-header-custom img:hover { transform: scale(1.05); }
    .card-header-custom h4 {
      color: #fff;
      font-weight: 700;
      margin: 0;
      letter-spacing: 1px;
      font-size: 1.3rem;
    }
    .card-header-custom p {
      color: rgba(255,255,255,0.75);
      font-size: 0.85rem;
      margin: 4px 0 0;
    }
    .card-body { padding: 30px 28px; background: #fff; }
    .form-label { font-weight: 600; font-size: 0.88rem; color: #374151; margin-bottom: 6px; }
    .input-group-text {
      background: #f3f4f6;
      border-right: none;
      border-radius: 10px 0 0 10px !important;
      color: #6b7280;
    }
    .form-control {
      border-left: none;
      border-radius: 0 10px 10px 0 !important;
      padding: 10px 14px;
      font-size: 0.95rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus {
      border-color: #3bafda;
      box-shadow: 0 0 0 3px rgba(59,175,218,0.18);
      z-index: 1;
    }
    .btn-login {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-weight: 700;
      font-size: 1rem;
      letter-spacing: 0.5px;
      color: #fff;
      width: 100%;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(30,60,114,0.35);
    }
    .btn-login:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(30,60,114,0.45);
      background: linear-gradient(135deg, #2a4f9e, #3bafda);
    }
    .btn-login:active { transform: translateY(0); }
    .divider { border-top: 1px solid #e5e7eb; margin: 20px 0; }
    .link-primary { color: #1e3c72; font-weight: 600; text-decoration: none; transition: color 0.2s; }
    .link-primary:hover { color: #3bafda; text-decoration: underline; }
    .btn-about {
      border: 2px solid #3bafda;
      color: #1e3c72;
      border-radius: 10px;
      padding: 8px 20px;
      font-weight: 600;
      transition: all 0.2s ease;
      background: transparent;
      width: 100%;
    }
    .btn-about:hover { background: #3bafda; color: #fff; }
    .brand-footer { text-align: center; margin-top: 20px; color: rgba(255,255,255,0.65); font-size: 0.82rem; }
    @media (max-width: 480px) {
      .card-body { padding: 22px 18px; }
      .card-header-custom { padding: 22px 18px 16px; }
    }
  </style>
</head>
<body>
<div class="nav-loading-bar" id="navBar"></div>

<div class="login-wrapper">
  <div class="card">
    <div class="card-header-custom">
      <img src="taxi.jpg" alt="TaxiDash Logo">
      <h4>TAXIDASH</h4>
      <p>Sign in to your account</p>
    </div>
    <div class="card-body">
      <form id="loginForm">
        <div class="mb-3">
          <label for="email" class="form-label">Email Address</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
          </div>
        </div>
        <div class="mb-4">
          <label for="password" class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="••••••••" required>
            <button class="btn btn-outline-secondary border-start-0" type="button" id="togglePwd" tabindex="-1" style="border-radius:0 10px 10px 0!important;">
              <i class="bi bi-eye" id="eyeIcon"></i>
            </button>
          </div>
        </div>
        <button type="submit" class="btn-login" id="loginBtn">
          <span id="loginText"><i class="bi bi-box-arrow-in-right me-2"></i>Sign In</span>
          <span id="loginSpinner" class="d-none">
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>Signing in...
          </span>
        </button>
      </form>

      <div class="divider"></div>

      <div class="text-center mb-2">
        <span class="text-muted small">Don't have an account?</span><br>
        <a href="register.php" class="link-primary">Create an account</a>
      </div>
      <div class="text-center mb-3">
        <a href="forgot.php" class="link-primary small">Forgot password?</a>
      </div>

      <button class="btn-about" data-bs-toggle="modal" data-bs-target="#aboutUsModal">
        <i class="bi bi-info-circle me-2"></i>About TaxiDash
      </button>
    </div>
  </div>
  <div class="brand-footer">© 2025 TaxiDash · Ride smarter</div>
</div>

<!-- About Modal -->
<div class="modal fade" id="aboutUsModal" tabindex="-1" aria-hidden="true">
  <div class="modal-dialog modal-md">
    <div class="modal-content" style="border-radius:16px; overflow:hidden;">
      <div class="modal-header" style="background:linear-gradient(135deg,#1e3c72,#3bafda);">
        <h5 class="modal-title text-white fw-bold"><i class="bi bi-taxi-front me-2"></i>About TAXIDASH</h5>
        <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"></button>
      </div>
      <div class="modal-body p-4">
        <p>Welcome to <strong>TAXIDASH</strong>, your go-to ride-booking app for fast, affordable, and hassle-free transportation.</p>
        <p>With a base fare of just <strong>₱50</strong> and an additional charge of <strong>₱50 per kilometer</strong>, we offer transparent and budget-friendly pricing.</p>
        <p>Pay conveniently with <strong>GCash</strong> — smooth and cashless every time.</p>
        <p>Real-time tracking, multiple payment options, and 24/7 customer support.</p>
        <p class="mb-0 fw-bold text-primary">Ride smarter — book with TAXIDASH today!</p>
      </div>
      <div class="modal-footer border-0">
        <button type="button" class="btn btn-secondary rounded-pill" data-bs-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  // Toggle password visibility
  document.getElementById('togglePwd').addEventListener('click', function() {
    const pwd = document.getElementById('password');
    const icon = document.getElementById('eyeIcon');
    if (pwd.type === 'password') {
      pwd.type = 'text';
      icon.className = 'bi bi-eye-slash';
    } else {
      pwd.type = 'password';
      icon.className = 'bi bi-eye';
    }
  });

  $(document).ready(function() {
    $('#loginForm').on('submit', function(event) {
      event.preventDefault();
      // Show spinner
      $('#loginText').addClass('d-none');
      $('#loginSpinner').removeClass('d-none');
      $('#loginBtn').prop('disabled', true);

      var formData = $(this).serialize();
      $.ajax({
        type: 'POST',
        url: 'php/auth.php',
        data: formData,
        success: function(response) {
          $('#loginText').removeClass('d-none');
          $('#loginSpinner').addClass('d-none');
          $('#loginBtn').prop('disabled', false);

          response = (response || '').trim();

          if (response === 'driver') {
            Swal.fire({ title: 'Welcome, Driver!', icon: 'success', timer: 1500, timerProgressBar: true, showConfirmButton: false });
            setTimeout(function() { window.location.href = '-/driver-dashboard.php'; }, 1200);
          } else if (response === 'user') {
            Swal.fire({ title: 'Welcome!', icon: 'success', timer: 1500, timerProgressBar: true, showConfirmButton: false });
            setTimeout(function() { window.location.href = '-/client-dashboard.php'; }, 1200);
          } else if (response === 'admin') {
            Swal.fire({ title: 'Welcome, Admin!', icon: 'success', timer: 1500, timerProgressBar: true, showConfirmButton: false });
            setTimeout(function() { window.location.href = '-/admin-dashboard.php'; }, 1200);
          } else {
            Swal.fire({ title: 'Login Failed', text: response, icon: 'error', confirmButtonText: 'Try Again' });
          }
        },
        error: function() {
          $('#loginText').removeClass('d-none');
          $('#loginSpinner').addClass('d-none');
          $('#loginBtn').prop('disabled', false);
          Swal.fire({ title: 'Error', text: 'An error occurred. Please try again.', icon: 'error' });
        }
      });
    });
  });
</script>
<style>
.nav-loading-bar { position:fixed; top:0; left:0; height:3px; width:0%; background:linear-gradient(90deg,#3bafda,#1e3c72); z-index:99999; transition:width 0.3s ease; }
.nav-loading-bar.loading { width:70%; }
.nav-loading-bar.done { width:100%; opacity:0; transition:width 0.2s ease, opacity 0.3s ease 0.1s; }
</style>
<script>
const bar = document.getElementById('navBar');
if (bar) {
  bar.classList.add('loading');
  window.addEventListener('load', () => {
    bar.classList.remove('loading');
    bar.classList.add('done');
    setTimeout(() => bar.remove(), 400);
  });
}
</script>
</body>
</html>
