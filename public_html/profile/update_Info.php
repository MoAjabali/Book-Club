<?php
  define('BASE_PATH', realpath(dirname(__DIR__)));
  require_once BASE_PATH . "/../app/Controllers/user_controller.php";
  session_start();
  
  try {
    print_r($_POST);
    print_r($_COOKIE);
    if($_POST){
      if (isset($_POST['fullname']) && isset($_POST['email'])) 
        $userController->updateProfile($_POST['fullname'], $_POST['email']);
      elseif (isset($_POST['fullname']))
        $userController->updateProfile($_POST['fullname'], $_COOKIE['user_email']);
      elseif (isset($_POST['email']))
        $userController->updateProfile($_COOKIE['user_fullname'], $_POST['email']);
      else
        throw new Exception("Error Processing Request");
    }else
      throw new Exception("Error Processing Request");
    $_SESSION['error'] = 0;
    $_SESSION['msg'] = "You Update Your Info successfully.";
    header("location: " . BASE_PATH . "/profile.php");
    exit();
  } catch (\Throwable $th) {
    $_SESSION['error'] = 1;
    $_SESSION['error_msg'] = $th->getMessage();
    header("location: " . BASE_PATH . "/profile.php");
    exit();
  }