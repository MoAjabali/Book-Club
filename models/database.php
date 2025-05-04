<?php
  require realpath(dirname(__DIR__) . "/../vendor/autoload.php");
  $dotenv = Dotenv\Dotenv::createImmutable(dirname(__DIR__));
  $dotenv->load();
  // echo realpath(dirname(__DIR__) . "/../");
  // echo "<br>";
  // echo dirname(__DIR__) . "/../";
  class theDatabase {
    private $conn;
    private $username, $password, $dbname, $host;
    private $dsn;

    function __construct() {
      // $env
      $this->username = $_ENV['DB_USERNAME'];
      $this->password = $_ENV['DB_PASSWORD'];
      $this->dbname = $_ENV['DB_NAME'];
      $this->host =$_ENV['DB_HOST'];
      $this->dsn = 'mysql:dbname='. $this->dbname.';host='. $this->host;
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