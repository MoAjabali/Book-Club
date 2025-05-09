<?php
  session_start();
  require_once realpath($_SERVER['DOCUMENT_ROOT'] . "/../app/models/model_user.php");

  class UserController{
    private $userModel;
    public function __construct(){
      $this->userModel = new UserDB();
    }
    private function getRememberToken(){
      if (!isset($_COOKIE['remember_me']))
        throw new Exception("No valid session found");
      return $_COOKIE['remember_me'];
    }

    public function updateProfile($fullname, $new_email){
      try {
        if (empty($fullname) || empty($new_email))
          throw new Exception("All fields are required");
        if (!filter_var($new_email, FILTER_VALIDATE_EMAIL))
          throw new Exception("Invalid email format");

        $current_email = $_COOKIE['user_email'];
        $token = $this->getRememberToken();
        $result = $this->userModel->updateUserInfo($current_email, $fullname, $new_email, $token);
        if ($result) {
          return ["user_fullname"=> $fullname, "user_email"=>$new_email];
        }
      } catch (Exception $e) {
        throw $e;
      }
    }

    public function updatePassword($current_password, $new_password, $confirm_password){
      try {
        // Errors
        if (empty($current_password) || empty($new_password) || empty($confirm_password))
          throw new Exception("All password fields are required");
        if ($new_password !== $confirm_password)
          throw new Exception("New passwords do not match");
        if (strlen($new_password) < 8)
          throw new Exception("Password must be at least 8 characters long");
        if (!preg_match("/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d).+$/", $new_password))
          throw new Exception("Password must contain at least one uppercase letter, one lowercase letter, and one number");

        $email = $_SESSION['user_email'];
        $token = $this->getRememberToken();

        $result = $this->userModel->updatePassword($email, $current_password, $new_password, $token);
        if ($result) 
          return "Password updated successfully";
      } catch (Exception $e) {
        throw $e;
      }
    }
  }
  $userController = new UserController();
