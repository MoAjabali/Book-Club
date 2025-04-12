<?php
  class theDatabase {
    private $conn;
    private $username, $password, $dsn;

    function __construct($dbname, $username, $password="") {
      $this->username = $username;
      $this->password = $password;
      $servername="127.0.0.1";
      $this->dsn = 'mysql:dbname='. $dbname.';host='. $servername;
    }

    function getConnection(){
      $this->conn = new PDO($this->dsn, $this->username, $this->password);
      $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
      return $this->conn;
    }
    function close(){
      $this->conn = null;
    }
  }