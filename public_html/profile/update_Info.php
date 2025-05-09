<?php
  require_once $_SERVER['DOCUMENT_ROOT'] . "/../app/Controllers/user_controller.php";
  session_start();
  
  try {
    if($_POST){
      if(isset($_POST['fullname']) && isset($_POST['email'])){
        if (!empty($_POST['fullname']) && !empty($_POST['email']))
          $myCookie = $userController->updateProfile($_POST['fullname'], $_POST['email']);
        elseif (!empty($_POST['fullname']))
          $myCookie = $userController->updateProfile($_POST['fullname'], $_COOKIE['user_email']);
        elseif (!empty($_POST['email']))
          $myCookie = $userController->updateProfile($_COOKIE['user_fullname'], $_POST['email']);
      }
      else
        throw new Exception("Error Processing Request");
    }else
      throw new Exception("Error Processing Request");
    
    echo '<pre>';
    print_r($myCookie);
    echo '</pre>';
    setcookie("user_fullname", $myCookie['user_fullname'], ['expires' => time() + (30 * 24 * 60 * 60), 'path'=> '/'], );
    setcookie("user_email", $myCookie['user_email'], ['expires' => time() + (30 * 24 * 60 * 60), 'path'=> '/']);
    
    $_SESSION['error'] = 0;
    $_SESSION['msg'] = "You Update Your Info successfully.";
    
    header("location: /profile.php");
    exit();
  } catch (\Throwable $th) {
    $_SESSION['error'] = 1;
    $_SESSION['error_msg'] = $th->getMessage();
    echo $th->getMessage();
    header("location: /profile.php");
    exit();
  }