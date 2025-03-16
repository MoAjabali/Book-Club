<?php
  class UserDB {
    private $conn;
    private $username, $dbname, $password, $servername;

    function __construct($dbname, $username, $password="", $servername="127.0.0.1") {
      $this->username = $username;
      $this->dbname = $dbname;
      $this->password = $password;
      $this->servername = $servername;
      $dsn = 'mysql:dbname='. $this->dbname.';host='. $this->servername;
      
      $this->conn = new PDO($dsn, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      // if ($this->conn-)
      //   throw new Exception("Error: connection wrong", 1);
    }



    function addUser($user_fullname, $user_email, $user_password){
      // $this->conn = new PDO("mysql:host=($this->servername);dbname=($this->dbname)", $this->username, $this->password);
      $hashedPassword = hash_hmac('sha256', $user_password, 'secret_key');
      $sqlStatement = "INSERT INTO users (user_fullname, user_email, user_password) VALUES ( ?, ?, ?)";
      $stmt = $this->conn->prepare($sqlStatement);
      $stmt->bindParam(1, $user_fullname, PDO::PARAM_STR);
      $stmt->bindParam(2, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(3, $hashedPassword, PDO::PARAM_STR);
      $stmt->execute();
      return [ "user_fullname"=>$user_fullname, "user_email"=>$user_email ];
    }

    function search($user_email, $user_password){
      $hashedPassword = hash_hmac('sha256', $user_password, 'secret_key');
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_email=? && user_password=?");
      $stmt->bindParam(1, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(2, $hashedPassword, PDO::PARAM_STR);
      $stmt->execute();
      $result = $stmt->fetchAll();
      if($result) // userFound
        return [ "user_fullname"=>$result[0]["user_fullname"], "user_email"=>$result[0]["user_email"] ];
      else
        throw new Exception("the account is not exist, check from the email or the password", 2);
        
    }

    function updateToken($user_token, $user_expire, $user_email){
      $hashedToken = hash_hmac('sha256', $user_token, 'secret_key');
      $sql = "UPDATE users SET remember_token = :token, token_expiry = :expiry WHERE user_email = :id";
      $stmt = $this->conn->prepare($sql);
      $stmt->bindParam(':token', $hashedToken);
      $stmt->bindParam(':expiry', $user_expire);
      $stmt->bindParam(':id', $user_email);
      $stmt->execute();
      return $user_token;
    }


    function checkUser($user_token ,$user_email){
      $hashedToken = hash_hmac('sha256', $user_token, 'secret_key');
      
      $stmt = $this->conn->prepare("SELECT * FROM users WHERE user_email=? && remember_token=? && token_expiry > NOW()");
      $stmt->bindParam(1, $user_email, PDO::PARAM_STR);
      $stmt->bindParam(2, $hashedToken, PDO::PARAM_STR);
      $stmt->execute();
      
      $result = $stmt->fetchAll();
      return ($result)? true : false;
    }
  }