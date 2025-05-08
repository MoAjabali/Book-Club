<?php
  define('BASE_PATH', realpath(__DIR__));
  include BASE_PATH  . "/../app/Controllers/redirect_to_login.php";
?>

<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
    <meta name="description" content="">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- icon file css -->
    <link rel="stylesheet" href="assets/css/all.min.css">
    <!-- render file css -->
    <link rel="stylesheet" href="assets/css/normalize.css">
    <!-- main file css --> 
    <link rel="stylesheet" href="assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="assets/css/master.css">
    <link rel="stylesheet" href="assets/css/main-master.css">
    <title>Profile - Book Club</title>
  </head>
  <body class="profile">
    <div class="nav">
      <nav class="container">
          <div class="logo">
            <a href="home.php" style="all:inherit; cursor:pointer;">Book Club</a>
          </div>
          <div class="links">
            <a href="/home.php" class="btn"><i class="fas fa-book-reader"></i><span>Browse</span></a>
            <a href="/upload.php" class="btn"><i class="fas fa-cloud-upload-alt"></i><span>Upload</span></a>
            <a href="/profile.php"><img src="./assets/images/avater.svg" alt="" srcset=""></a>
          </div>
      </nav>
    </div>

    <div class="main">
      <div class="container">
        <div class="settings-container">
          <!-- Profile Header -->
          <div class="profile-header">
            <div class="profile-avatar">
              <img src="./assets/images/avater.svg" alt="Profile Picture">
              <h2>Profile Settings</h2>
            </div>
          </div>
          <?php
            session_start();
            if (isset($_SESSION['error'])) {
              if ($_SESSION['error']==0) { #no_error
                $msg = $_SESSION['msg'];
                echo<<<"succuss"
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                  <strong>$msg</strong>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>      
                succuss;
              }else{
                $msg = $_SESSION['error_msg'];
                echo<<<"failed"
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                  <strong>We Have face Exception: </strong> $msg
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
                failed;
              }
            }
          ?>
          <!-- Personal Information Form -->
          <div class="settings-section">
            <h3><i class="fas fa-user"></i> Personal Information</h3>
            <form action="/profile/update_Info.php" method="post" class="settings-form">
              <div class="form-group">
                <label>Full Name</label>
                <input type="text" name="fullname" class="form-control" placeholder="Your Full Name">
              </div>
              <div class="form-group">
                <label>Email Address</label>
                <input type="email" name="email" class="form-control" placeholder="your@email.com">
              </div>
              <button type="submit" class="btn">Update Information</button>
            </form>
          </div>

          <!-- Password Change Form -->
          <div class="settings-section">
            <h3><i class="fas fa-lock"></i> Change Password</h3>
            <form action="/profile/change_password.php" method="post" class="settings-form">
              <div class="form-group">
                <label>Current Password</label>
                <input type="password" name="current_password" class="form-control" required>
              </div>
              <div class="form-group">
                <label>New Password</label>
                <input type="password" name="new_password" class="form-control" required>
              </div>
              <div class="form-group">
                <label>Confirm New Password</label>
                <input type="password" name="confirm_password" class="form-control" required>
              </div>
              <button type="submit" class="btn">Change Password</button>
            </form>
          </div>

          <!-- Logout Button -->
          <div class="settings-section">
            <form action="/profile/logout.php" method="post" class="logout-form d-flex justify-content-center align-items-center">
              <button type="submit" name="logout" class="btn">
                <i class="fas fa-sign-out-alt"></i> Logout
              </button>
            </form>
          </div>
        </div>
      </div>
    </div>

    <footer class="container">
      <div>
        All Right Receved for <span>Book Club ®</span>
      </div>
    </footer>
    <script src="./assets/js/bootstrap.bundle.min.js"></script>
  </body>
</html>