<?php
  define('BASE_PATH', realpath(dirname(__DIR__)));
  require_once BASE_PATH . "/../app/Controllers/user_controller.php";
  session_start();
  
  try {
    if($_POST){
      if ( isset($_POST['current_password']) && isset($_POST['new_password']) && isset($_POST['confirm_password']) ) 
        $userController->updatePassword($_POST['current_password'], $_POST['new_password'], $_POST['confirm_password']);
      else
        throw new Exception("Pleas Enter Data");
    }else
      throw new Exception("Error Processing Request");
    $_SESSION['error'] = 0;
    $_SESSION['msg'] = "You Change Your Password successfully.";
    header("location: " . BASE_PATH . "/profile.php");
    exit();
  } catch (\Throwable $th) {
    $_SESSION['error'] = 1;
    $_SESSION['error_msg'] = $th->getMessage();
    header("location: " . BASE_PATH . "/profile.php");
    exit();
  }