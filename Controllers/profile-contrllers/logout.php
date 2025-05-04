<?php
  include_once "../../models/model_user.php";
  $logoutUserDB = new UserDB();

  session_start();
  try {
    setcookie("user_fullname", $_COOKIE['user_fullname'], ['expires' => time() - 1]);
    setcookie("remember_me", $_COOKIE['remember_me'], ['expires' => time() - 1]);
    $logoutUserDB->updateToken(null, null, $_COOKIE['user_email']);
    setcookie("user_email", $_COOKIE['user_email'], ['expires' => time() - 1]);
    $_SESSION['error'] = 0;
    header("location: ../../profile.php");
    exit();
  } catch (\Throwable $th) {
    $_SESSION['error'] = 1;
    $_SESSION['error_msg'] = $th->getMessage();
    exit();
  }
?>