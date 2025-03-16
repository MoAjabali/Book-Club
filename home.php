<?php
  include "controllers/redirect_to_login.php";
  session_start();
  echo "Hello " . $_COOKIE['user_fullname'] . ", Your email is " . $_COOKIE['user_email'];