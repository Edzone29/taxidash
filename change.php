<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>TaxiDash</title>
  <!-- Bootstrap CSS -->
   <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.all.min.js"></script>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background: linear-gradient(135deg, #f0f4f8 0%, #d9e2ec 100%); /* Soft gradient */
      height: 100vh;
      display: flex;
      align-items: center;
      justify-content: center;
    }
    .card {
      border: none;
      border-radius: 10px;
      box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    }
    .btn-social {
      display: flex;
      align-items: center;
      justify-content: center;
      border-radius: 5px;
    }
    .btn-google {
      background-color: #db4437;
      color: white;
    }
    .btn-facebook {
      background-color: #4267B2;
      color: white;
    }
    .btn-social i {
      margin-right: 8px;
    }
  </style>
</head>
<body>

<div class="container">
  <div class="row justify-content-center">
    <div class="col-md-4">
      <div class="card p-4">
        <div class="card-body">
            <div class="text-center">
             <img src="taxi.jpg" alt="Logo"  style="height:110px; border-radius:15px">
             </div>
             <br>
          <!--<h3 class="card-title text-center mb-4">LOGIN</h3>-->

          <!-- Login Form -->
     <form id="loginForm">
            <div class="mb-3 collapse">
                <label for="email" class="form-label">Email address</label>
                <input type="text" class="form-control" id="email" value="<?=$_GET['email']?>" name="email" required>
            </div>
            
             <div class="mb-3">
                <label for="email" class="form-label">New Password</label>
                <input type="password" class="form-control" id="pass" name="pass" required>
            </div>
            
             <div class="mb-3">
                <label for="email" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" id="passConfirm" name="passConfirm" required>
            </div>
          
            <div class="d-grid gap-2">
                <button type="submit" class="btn btn-primary btn-block">Confirm</button>
            </div>
        </form>
 <div class="text-center mt-3">
            <span class="text-muted">Don't have an account? </span><br>
            <a href="register.php">Register here</a>
          </div>
          <!-- Divider -->
          <hr class="my-4">

          <!-- Social Login Buttons -->
          <!--<div class="d-grid gap-2">-->
            <!--<button class="btn btn-facebook btn-social">-->
            <!--  <i class="bi bi-facebook"></i> Login with Facebook-->
            <!--</button>-->
          <!--  <button class="btn btn-google btn-social">-->
          <!--    <i class="bi bi-google"></i> Login with Google-->
          <!--  </button>-->
          <!--</div>-->

          <!-- Forgot password link -->
          <div class="text-center mt-3">
            <a href="login" class="fw-bold">Login Here</a>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Bootstrap JS and dependencies -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
<!-- Bootstrap Icons -->
<link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
 <script>
    $(document).ready(function() {
        $('#loginForm').on('submit', function(event) {
            event.preventDefault(); // Prevent the default form submission

            // Get the email entered in the form
            var formData = $(this).serialize();

            // AJAX request to check if the email exists
            $.ajax({
                type: 'POST',
                url: 'php/change.php', // PHP script to check if email exists
                data: formData,
                success: function(response) {
                    // Assuming the response is JSON with 'status' and 'message'
                    var responseData = JSON.parse(response);

                    if (responseData.status === 'success') {
                        // Email exists, send the password reset email with link
                      Swal.fire({
    title: 'Success!',
    text: responseData.message, // success message from PHP
    icon: 'success',
    confirmButtonText: 'OK'
}).then((result) => {
    if (result.isConfirmed) {
        // Redirect after the user clicks "OK"
        window.location.href = 'login.php';
    } else {
        // Redirect after 2 seconds if the user doesn't interact
        setTimeout(() => {
            window.location.href = 'login.php';
        }, 2000); // 2000 milliseconds = 2 seconds
    }
});
                    } else {
                        // Email does not exist, show error
                        Swal.fire({
                            title: 'Error!',
                            text: responseData.message,
                            icon: 'error',
                            confirmButtonText: 'Try Again',
                            timer: 3000,
                            timerProgressBar: true
                        });
                    }
                },
                error: function() {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while processing your request.',
                        icon: 'error',
                        confirmButtonText: 'Try Again',
                        timer: 3000,
                        timerProgressBar: true
                    });
                }
            });
        });
    });
</script>



</body>
</html>
