<?php
  include_once "database.php";
  class UserDB {
    // todo: Security & better & Error
    private $db;
    function __construct() {
      $this->db = new theDatabase();
    }

    function addUser($user_fullname, $user_email, $user_password){
      $hashedPassword = hash_hmac('sha256', $user_password, 'secret_key');
      $sqlStatement = "INSERT INTO users (user_fullname, user_email, user_password) VALUES ( ?, ?, ?)";
      $stmt = $this->db->getConnection()->prepare($sqlStatement);
      $stmt->bindParam(1, $user_fullname, PDO::PARAM_STR);
      $stmt->bindParam(2, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(3, $hashedPassword, PDO::PARAM_STR);
      $stmt->execute();
      $this->db->close();
      return [ "user_fullname"=>$user_fullname, "user_email"=>$user_email ];
    }

    function search($user_email, $user_password){
      $hashedPassword = hash_hmac('sha256', $user_password, 'secret_key');
      $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE user_email=? && user_password=?");
      $stmt->bindParam(1, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      if($result) // userFound
        return [ "user_fullname"=>$result[0]["user_fullname"], "user_email"=>$result[0]["user_email"] ];
      else
        throw new Exception("the account is not exist, check from the email or the password", 2);
        
    }

    function updateToken($user_token, $user_expire, $user_email){
      $hashedToken = hash_hmac('sha256', $user_token, 'secret_key');
      $sql = "UPDATE users SET remember_token = :token, token_expiry = :expiry WHERE user_email = :id";
      $stmt = $this->db->getConnection()->prepare($sql);
      $stmt->bindParam(':token', $hashedToken);
      $stmt->bindParam(':expiry', $user_expire);
      $stmt->bindParam(':id', $user_email);
      $stmt->execute();
      $this->db->close();
      return $user_token;
    }


    function checkUser($user_token ,$user_email){
      $hashedToken = hash_hmac('sha256', $user_token, 'secret_key');
      $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE user_email=? && remember_token=? && token_expiry > NOW()");
      $stmt->bindParam(1, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(2, $hashedToken, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      $this->db->close();
      return ($result)? true : false;
    }

    function updateUserInfo($current_email, $new_fullname, $new_email, $token) {
        // Verify token first
        if (!$this->checkUser($token, $current_email)) {
          throw new Exception("Invalid session, please login again");
        }
        $sql = "UPDATE users SET user_fullname = ?, user_email = ? WHERE user_email = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(1, $new_fullname, PDO::PARAM_STR);
        $stmt->bindParam(2, $new_email, PDO::PARAM_STR);
        $stmt->bindParam(3, $current_email, PDO::PARAM_STR);
        $result = $stmt->execute();
        $this->db->close();
        if(!$result) throw new Exception("Failed to update user information");
        return ["user_fullname" => $new_fullname, "user_email" => $new_email];
    }

    function updatePassword($email, $current_password, $new_password, $token) {
        // Verify token first
        if (!$this->checkUser($token, $email)) {
            throw new Exception("Invalid session, please login again");
        }

        // Verify current password
        $hashedCurrentPassword = hash_hmac('sha256', $current_password, 'secret_key');
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM users WHERE user_email = ? AND user_password = ?");
        $stmt->bindParam(1, $email, PDO::PARAM_STR);
        $stmt->bindParam(2, $hashedCurrentPassword, PDO::PARAM_STR);
        $stmt->execute();
        if (!$stmt->fetch()) {
            throw new Exception("Current password is incorrect");
        }

        // Update to new password
        $hashedNewPassword = hash_hmac('sha256', $new_password, 'secret_key');
        $sql = "UPDATE users SET user_password = ? WHERE user_email = ?";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(1, $hashedNewPassword, PDO::PARAM_STR);
        $stmt->bindParam(2, $email, PDO::PARAM_STR);
        $result = $stmt->execute();
        $this->db->close();
        if(!$result) throw new Exception("Failed to update password");
        return true;
    }
  }