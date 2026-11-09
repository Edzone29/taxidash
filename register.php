<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaxiDash – Register</title>
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
      padding: 24px 16px;
      font-family: 'Segoe UI', sans-serif;
      animation: fadeInPage 0.5s ease both;
    }
    @keyframes fadeInPage { from { opacity:0; transform:translateY(10px); } to { opacity:1; transform:translateY(0); } }
    .register-wrapper { width: 100%; max-width: 460px; }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
      overflow: hidden;
    }
    .card-header-custom {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      padding: 26px 24px 18px;
      text-align: center;
    }
    .card-header-custom img {
      width: 76px; height: 76px; object-fit: cover;
      border-radius: 16px;
      border: 3px solid rgba(255,255,255,0.4);
      box-shadow: 0 6px 20px rgba(0,0,0,0.2);
      margin-bottom: 10px;
    }
    .card-header-custom h4 { color:#fff; font-weight:700; font-size:1.2rem; margin:0; letter-spacing:1px; }
    .card-header-custom p { color:rgba(255,255,255,0.75); font-size:0.84rem; margin:3px 0 0; }
    .card-body { padding: 26px 28px; background: #fff; }
    .form-label { font-weight:600; font-size:0.88rem; color:#374151; margin-bottom:5px; }
    .input-group-text {
      background:#f3f4f6; border-right:none;
      border-radius:10px 0 0 10px !important; color:#6b7280;
    }
    .form-control {
      border-left:none; border-radius:0 10px 10px 0 !important;
      padding:10px 14px; font-size:0.93rem;
      transition: border-color 0.2s, box-shadow 0.2s;
    }
    .form-control:focus { border-color:#3bafda; box-shadow:0 0 0 3px rgba(59,175,218,0.18); z-index:1; }
    .password-toggle {
      border-radius: 0 10px 10px 0 !important;
      border-left: none;
    }
    .btn-register {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      border: none; border-radius:12px;
      padding: 12px; font-weight:700; font-size:1rem;
      color:#fff; width:100%;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(30,60,114,0.35);
    }
    .btn-register:hover { transform:translateY(-2px); box-shadow:0 8px 20px rgba(30,60,114,0.45); }
    .btn-register:active { transform:translateY(0); }
    .divider { border-top:1px solid #e5e7eb; margin:18px 0; }
    .link-primary { color:#1e3c72; font-weight:600; text-decoration:none; transition:color 0.2s; }
    .link-primary:hover { color:#3bafda; text-decoration:underline; }
    .strength-bar { height:4px; border-radius:10px; transition:width 0.3s, background 0.3s; width:0%; background:#e5e7eb; }
    .brand-footer { text-align:center; margin-top:18px; color:rgba(255,255,255,0.65); font-size:0.82rem; }
    @media (max-width:480px) { .card-body { padding:20px 16px; } }
  </style>
</head>
<body>
<div class="nav-loading-bar" id="navBar"></div>
<div class="register-wrapper">
  <div class="card">
    <div class="card-header-custom">
      <img src="taxi.jpg" alt="TaxiDash">
      <h4>TAXIDASH</h4>
      <p>Create your account</p>
    </div>
    <div class="card-body">
      <form id="registrationForm" method="POST" enctype="multipart/form-data">

        <div class="row g-3 mb-3">
          <div class="col-6">
            <label class="form-label">First Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="fullname_first" placeholder="Juan" required>
            </div>
          </div>
          <div class="col-6">
            <label class="form-label">Last Name</label>
            <div class="input-group">
              <span class="input-group-text"><i class="bi bi-person"></i></span>
              <input type="text" class="form-control" name="fullname_last" placeholder="Dela Cruz" required>
            </div>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Email Address</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" name="email" placeholder="you@example.com" required>
          </div>
        </div>

        <div class="mb-3">
          <label class="form-label">Phone Number</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-phone"></i></span>
            <input type="tel" class="form-control" name="phone" placeholder="09XX XXX XXXX" required>
          </div>
        </div>

        <div class="mb-2">
          <label class="form-label">Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-lock"></i></span>
            <input type="password" class="form-control" id="password" name="password" placeholder="Min. 6 characters" required>
            <button class="btn btn-outline-secondary password-toggle border-start-0" type="button" onclick="togglePassword('password','eye1')">
              <i class="bi bi-eye" id="eye1"></i>
            </button>
          </div>
          <div class="mt-1"><div class="strength-bar" id="strengthBar"></div></div>
          <small class="text-muted" id="strengthText"></small>
        </div>

        <div class="mb-4">
          <label class="form-label">Confirm Password</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-shield-lock"></i></span>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password" placeholder="Repeat password" required>
            <button class="btn btn-outline-secondary password-toggle border-start-0" type="button" onclick="togglePassword('confirm_password','eye2')">
              <i class="bi bi-eye" id="eye2"></i>
            </button>
          </div>
        </div>

        <button type="submit" class="btn-register" id="regBtn">
          <span id="regText"><i class="bi bi-person-plus me-2"></i>Create Account</span>
          <span id="regSpinner" class="d-none">
            <span class="spinner-border spinner-border-sm me-2"></span>Creating...
          </span>
        </button>
      </form>

      <div class="divider"></div>
      <div class="text-center">
        <span class="text-muted small">Already have an account?</span><br>
        <a href="login.php" class="link-primary">Sign in here</a>
      </div>
    </div>
  </div>
  <div class="brand-footer">© 2025 TaxiDash · Ride smarter</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  function togglePassword(id, iconId) {
    const input = document.getElementById(id);
    const icon = document.getElementById(iconId);
    if (input.type === 'password') { input.type = 'text'; icon.className = 'bi bi-eye-slash'; }
    else { input.type = 'password'; icon.className = 'bi bi-eye'; }
  }

  // Password strength
  document.getElementById('password').addEventListener('input', function() {
    const val = this.value;
    const bar = document.getElementById('strengthBar');
    const txt = document.getElementById('strengthText');
    let strength = 0;
    if (val.length >= 6) strength++;
    if (/[A-Z]/.test(val)) strength++;
    if (/[0-9]/.test(val)) strength++;
    if (/[^A-Za-z0-9]/.test(val)) strength++;
    const levels = [
      { w:'25%', bg:'#ef4444', t:'Weak' },
      { w:'50%', bg:'#f59e0b', t:'Fair' },
      { w:'75%', bg:'#3b82f6', t:'Good' },
      { w:'100%', bg:'#10b981', t:'Strong' }
    ];
    if (val.length === 0) { bar.style.width='0%'; txt.textContent=''; return; }
    const lvl = levels[Math.min(strength-1, 3)];
    bar.style.width = lvl.w;
    bar.style.background = lvl.bg;
    txt.textContent = lvl.t;
    txt.style.color = lvl.bg;
  });

  $(document).ready(function() {
    $('#registrationForm').on('submit', function(event) {
      event.preventDefault();
      const pw = $('#password').val();
      const cpw = $('#confirm_password').val();
      if (pw !== cpw) {
        Swal.fire({ icon:'error', title:'Passwords do not match', confirmButtonText:'OK' });
        return;
      }
      $('#regText').addClass('d-none');
      $('#regSpinner').removeClass('d-none');
      $('#regBtn').prop('disabled', true);

      $.ajax({
        url: 'php/register.php', type: 'POST',
        data: $(this).serialize(), dataType: 'json',
        success: function(response) {
          $('#regText').removeClass('d-none'); $('#regSpinner').addClass('d-none'); $('#regBtn').prop('disabled', false);
          if (response.status === 'success') {
            Swal.fire({ icon:'success', title:'Account Created!', text:response.message, confirmButtonText:'Go to Login' })
              .then(() => { window.location.href = 'login.php'; });
          } else {
            Swal.fire({ icon:'error', title:'Registration Failed', text:response.message, confirmButtonText:'OK' });
          }
        },
        error: function() {
          $('#regText').removeClass('d-none'); $('#regSpinner').addClass('d-none'); $('#regBtn').prop('disabled', false);
          Swal.fire({ icon:'error', title:'Error', text:'Please try again.', confirmButtonText:'OK' });
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
