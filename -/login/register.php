<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="fonts/icomoon/style.css">

    <link rel="stylesheet" href="css/owl.carousel.min.css">
      <link rel="stylesheet" href="../assets/css/icons.min.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="css/style.css">

    <title>Login #3</title>
  </head>
  <body>
  

  <div class="half">
    <div class="bg order-1 order-md-2" style="background-image: url('images/bg_1.jpg');"></div>
    <div class="contents order-2 order-md-1">
<br><br> <br><br>
      <div class="container">
     
        <div class="row align-items-center justify-content-center">
          <div class="col-md-6">
            <div class="form-block">
              <div class="text-center mb-5">
                            <img src="gwork.jpg" height="40px" style="border-radius:100px; "> 
              <!-- <p class="mb-4">Lorem ipsum dolor sit amet elit. Sapiente sit aut eos consectetur adipisicing.</p> -->
              </div>
              <form action="index.php?url=<?= $_GET["url"]?>" method="post">
                  <div class="d-flex justify-content-between align-items-center ">
                                            <h5 class="card-title "><b>Sign Up</b></h5>
                                          
                                        </div>
                                          <p>Create an account to get started</p>
                <div class="form-group first">
                  <!--<label for="username">Username</label>-->
                  <input type="text" class="form-control" placeholder="Name" id="username">
                </div>
                    <div class="form-group first">
                  <!--<label for="username">Username</label>-->
                  <input type="text" class="form-control" placeholder="Email Address" id="username">
                </div>
                   
                <div class="form-group last mb-3">
                  <!--<label for="password">Password</label>-->
                  <input type="password" class="form-control" placeholder="Password" id="password">
                </div>
                
                  <div class="form-group last mb-3">
                  <!--<label for="password">Password</label>-->
                  <input type="password" class="form-control" placeholder="Confirm Password" id="password">
                </div>
                
                <div class="d-sm-flex mb-5 align-items-center">
                  <label class="control control--checkbox mb-3 mb-sm-0"><span class="caption">I've read and agree with the Terms and Conditions and the Privacy Policy.</span>
                    <input type="checkbox" checked="checked" />
                    <div class="control__indicator" style="background-color: #80C7BC; border-color: #80C7BC; color: white;"></div>
                  </label>
                  <!--<span class="ml-auto"><a href="#" class="forgot-pass">Forgot Password</a></span> -->
                </div>

           <input type="submit" value="Register" class="btn btn-block" style="background-color: #80C7BC; border-color: #80C7BC; color: white;">
           <div class="text-center mt-4">
                <p>Or sign up with:</p>
                
                    <button type="button" class="btn btn-outline-primary mb-2 w-100">
                        <i class="fab fa-google"></i> Google
                    </button>
                    <button type="button" class="btn btn-outline-primary mb-2 w-100">
                        <i class="fab fa-facebook-f"></i> Facebook
                    </button>
                    <button type="button" class="btn btn-outline-primary w-100">
                        <i class="fab fa-twitter"></i> Twitter
                    </button>
              </div>
  <div class="d-sm-flex mt-2 mb-2 align-items-center text-center">
      
                
                  <span class="">Already a member? <a href='index.php?url=<?= $_GET["url"]?>' class="text-info">Sign in here</a></span> 
                </div>

              </form>
            </div>
          </div>
        </div>
      </div>
    </div>

    
  </div>
    
    

    <script src="js/jquery-3.3.1.min.js"></script>
    <script src="js/popper.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/main.js"></script>
  </body>
</html>