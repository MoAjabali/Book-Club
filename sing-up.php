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
      <div class="row align-items-center justify-content-center">
        <div class="col-md-6 order-up">
          <img src="assets/images/undraw_file_sync_ot38.svg" alt="Image" class="img-fluid">
        </div>
        <div class="col-md-6 contents">
          <div class="row justify-content-center">
            <div class="col-md-8">
              <div class="mb-4">
                <h3>Sign Up to <strong>Book Club</strong></h3>
                <p class="mb-4">The Reader Club, Where you can share Books read them and even download them and more.</p>
              </div>
              <form action="" method="post">
                <div class="form-floating mb-3">
                  <input type="text" class="form-control p-2" id="fullname" name="user_fullname" placeholder="John Doe" required>
                  <label for="fullname">Full Name</label>
                </div>
                <div class="form-floating mb-3">
                  <input type="email" class="form-control p-2" id="username" name="user_email" placeholder="name@example.com" required>
                  <label for="username">Email address</label>
                </div>
                <div class="form-floating mb-4">
                  <input type="password" class="form-control p-2" id="password" name="user_password" placeholder="Password" required>
                  <label for="password">Password</label>
                </div>
                
                <div class="d-flex mb-4 align-items-center">
                  <div class="form-check">
                    <input class="form-check-input" type="checkbox" checked name="remember_me_btn" id="remember">
                    <label class="form-check-label" for="remember">Remember me</label>
                  </div>
                  <span class="ms-auto"><a href="./login.php" class="text-decoration-none">or sign in</a></span> 
                </div>

                <button type="submit" class="btn w-100 py-3">Sign Up</button>
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
    $myDB = new UserDB();
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
