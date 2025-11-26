<?php
// Database configuration
define('DB_HOST', 'localhost');
define('DB_USER', 'root');
define('DB_PASS', 'walabalo');
define('DB_NAME', 'campus_maintenance');

class Database
{
  private $host = DB_HOST;
  private $user = DB_USER;
  private $pass = DB_PASS;
  private $dbname = DB_NAME;
  private $conn;

  // Connect to database
  public function connect()
  {
    $this->conn = null;

    try {
      $this->conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);

      if ($this->conn->connect_error) {
        throw new Exception("Connection failed: " . $this->conn->connect_error);
      }

      // Set charset to utf8mb4
      $this->conn->set_charset("utf8mb4");
    } catch (Exception $e) {
      die("Database Connection Error: " . $e->getMessage());
    }

    return $this->conn;
  }
}
