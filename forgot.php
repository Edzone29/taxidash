<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaxiDash – Forgot Password</title>
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
    .forgot-wrapper { width: 100%; max-width: 420px; }
    .card {
      border: none;
      border-radius: 20px;
      box-shadow: 0 20px 60px rgba(0,0,0,0.25);
      overflow: hidden;
      transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card:hover { transform: translateY(-3px); box-shadow: 0 28px 70px rgba(0,0,0,0.3); }
    .card-header-custom {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      padding: 30px 24px 20px;
      text-align: center;
    }
    .card-header-custom img {
      width: 80px; height: 80px; object-fit: cover;
      border-radius: 18px;
      border: 3px solid rgba(255,255,255,0.4);
      box-shadow: 0 8px 24px rgba(0,0,0,0.2);
      margin-bottom: 12px;
    }
    .card-header-custom h4 { color: #fff; font-weight: 700; margin: 0; letter-spacing: 1px; font-size: 1.3rem; }
    .card-header-custom p { color: rgba(255,255,255,0.75); font-size: 0.85rem; margin: 4px 0 0; }
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
    .btn-submit {
      background: linear-gradient(135deg, #1e3c72, #3bafda);
      border: none;
      border-radius: 12px;
      padding: 12px;
      font-weight: 700;
      font-size: 1rem;
      color: #fff;
      width: 100%;
      transition: all 0.25s ease;
      box-shadow: 0 4px 14px rgba(30,60,114,0.35);
    }
    .btn-submit:hover {
      transform: translateY(-2px);
      box-shadow: 0 8px 20px rgba(30,60,114,0.45);
    }
    .btn-submit:active { transform: translateY(0); }
    .divider { border-top: 1px solid #e5e7eb; margin: 20px 0; }
    .link-primary { color: #1e3c72; font-weight: 600; text-decoration: none; transition: color 0.2s; }
    .link-primary:hover { color: #3bafda; text-decoration: underline; }
    .brand-footer { text-align: center; margin-top: 20px; color: rgba(255,255,255,0.65); font-size: 0.82rem; }
    @media (max-width: 480px) {
      .card-body { padding: 22px 18px; }
      .card-header-custom { padding: 22px 18px 16px; }
    }
  </style>
</head>
<body>

<div class="forgot-wrapper">
  <div class="card">
    <div class="card-header-custom">
      <img src="taxi.jpg" alt="TaxiDash Logo">
      <h4>TAXIDASH</h4>
      <p>Reset your account password</p>
    </div>
    <div class="card-body">
      <form id="forgotForm">
        <div class="mb-4">
          <label for="email" class="form-label">Email Address</label>
          <div class="input-group">
            <span class="input-group-text"><i class="bi bi-envelope"></i></span>
            <input type="email" class="form-control" id="email" name="email" placeholder="you@example.com" required>
          </div>
        </div>
        <button type="submit" class="btn-submit" id="submitBtn">
          <span id="submitText"><i class="bi bi-send me-2"></i>Send Reset Link</span>
          <span id="submitSpinner" class="d-none">
            <span class="spinner-border spinner-border-sm me-2" role="status"></span>Sending...
          </span>
        </button>
      </form>

      <div class="divider"></div>

      <div class="text-center mb-2">
        <span class="text-muted small">Remember your password?</span><br>
        <a href="login.php" class="link-primary">Back to Login</a>
      </div>
      <div class="text-center">
        <a href="register.php" class="link-primary small">Create a new account</a>
      </div>
    </div>
  </div>
  <div class="brand-footer">© 2025 TaxiDash · Ride smarter</div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
  $(document).ready(function() {
    $('#forgotForm').on('submit', function(event) {
      event.preventDefault();

      $('#submitText').addClass('d-none');
      $('#submitSpinner').removeClass('d-none');
      $('#submitBtn').prop('disabled', true);

      var formData = $(this).serialize();

      $.ajax({
        type: 'POST',
        url: 'php/forgot.php',
        data: formData,
        success: function(response) {
          $('#submitText').removeClass('d-none');
          $('#submitSpinner').addClass('d-none');
          $('#submitBtn').prop('disabled', false);

          try {
            var responseData = typeof response === 'object' ? response : JSON.parse(response);
            if (responseData.status === 'success') {
              Swal.fire({
                title: 'Success!',
                text: responseData.message,
                icon: 'success',
                timer: 2500,
                timerProgressBar: true,
                showConfirmButton: true
              }).then(() => {
                window.location.href = 'login.php';
              });
            } else {
              Swal.fire({
                title: 'Error!',
                text: responseData.message || 'Unable to find an account with that email.',
                icon: 'error',
                confirmButtonText: 'Try Again'
              });
            }
          } catch(e) {
            Swal.fire({
              title: 'Notice',
              text: response,
              icon: 'info'
            });
          }
        },
        error: function() {
          $('#submitText').removeClass('d-none');
          $('#submitSpinner').addClass('d-none');
          $('#submitBtn').prop('disabled', false);
          Swal.fire({
            title: 'Error!',
            text: 'An error occurred while processing your request.',
            icon: 'error',
            confirmButtonText: 'Try Again'
          });
        }
      });
    });
  });
</script>
</body>
</html>