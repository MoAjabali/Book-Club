<?php
  include "controllers/redirect_to_home.php";
  function popupMsg($msg){
    echo <<<"msg"
    <div class="alert popup alert-danger alert-dismissible fade show" role="alert">
      $msg
      <button 
        type="button" class="btn-close" 
        data-bs-dismiss="alert" 
        id= "msgCancel"
        onclick="msgCancel.parentElement.remove();" 
        aria-label="Close"
        style="background:none; outline:none; color:inherit; border:none;"
      >
      X
      </button>
    </div>
    msg;
  }
?>

<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css?family=Roboto:300,400&display=swap" rel="stylesheet">
    
    <link rel="stylesheet" href="assets/fonts/icomoon/style.css">

    <link rel="stylesheet" href="assets/css/owl.carousel.min.css">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    
    <!-- Style -->
    <link rel="stylesheet" href="assets/css/style.css">
    <link rel="stylesheet" href="assets/css/master.css">

    <title>Sing Up</title>
  </head>
  <body>
  <div class="content">
    <div class="container">
      <div class="row">
        <div class="col-md-6 order-md-2">
          <img src="assets/images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
              <h3>Sign Up to <strong></strong></h3>
              <p class="mb-4">The Reader Club, Where you can share Books read them and even download them and more.</p>
            </div>
            <form action="" method="post">
              <div class="form-group first">
                <label for="fullname">Full Name</label>
                <input type="text" class="form-control" id="fullname" name="user_fullname" required>
              </div>
              <div class="form-group first">
                <label for="username">Email</label>
                <input type="email" class="form-control" id="username" name="user_email" required>
              </div>
              <div class="form-group last mb-4">
                <label for="password">Password</label>
                <input type="password" class="form-control" id="password" name="user_password" required>
                
              </div>
              
              <div class="d-flex mb-5 align-items-center">
                <label class="control control--checkbox mb-0"><span class="caption">Remember me</span>
                  <input type="checkbox" checked="checked" name="remember_me_btn"/>
                  <div class="control__indicator"></div>
                </label>
                <span class="ml-auto"><a href="./login.php" class="forgot-pass">or sing in</a></span> 
              </div>

              <input type="submit" value="Sing Up" class="btn text-white btn-block btn-primary">

              <!-- <span class="d-block text-left my-4 text-muted"> or sign up with</span>
              
              <div class="social-login" align="center">
                <a href="#" class="facebook">
                  <span class="icon-facebook mr-3"></span> 
                </a>
                <a href="#" class="twitter">
                  <span class="icon-twitter mr-3"></span> 
                </a>
                <a href="#" class="google">
                  <span class="icon-google mr-3"></span> 
                </a> -->
              </div>
            </form>
            </div>
          </div>
          
        </div>
      </div>
    </div>
  
  </div>
    <script src="assets/js/jquery-3.3.1.min.js"></script>
    <script src="assets/js/popper.min.js"></script>
    <script src="assets/js/bootstrap.min.js"></script>
    <script src="assets/js/main.js"></script>
  </body>
</html>

<?php
  try {
    include_once "models/model_user.php";
    session_start();
    $myDB = new UserDB("book_club", "root");
    if($_POST){
      $remember_me = isset($_POST['remember_me_btn']) ? true : false;
      $user = $myDB->addUser($_REQUEST['user_fullname'], $_REQUEST['user_email'], $_REQUEST['user_password']);
      setcookie("user_fullname", $user["user_fullname"], ['expires' => time() + (30 * 24 * 60 * 60)]);
      setcookie("user_email", $user["user_email"], ['expires' => time() + (30 * 24 * 60 * 60)]);
      if ($remember_me) {
        $token = bin2hex(random_bytes(32));
        $expire = date('Y-m-d H:i:s', strtotime('+30 days'));
        setcookie('remember_me', $myDB->updateToken($token, $expire, $user["user_email"]), [
          'expires' => time() + (30 * 24 * 60 * 60), // Valid for 30 days only
          'path' => '/',
          'secure' => true, // HTTPS only
          'httponly' => true, // JavaScript not allowed
          'samesite' => 'Strict', // stop CSRF
        ]);
      }
      header("location: home.php");
      exit();
    }
  } catch (\Throwable $th) {
    popupMsg($th->getMessage()); 
  }
