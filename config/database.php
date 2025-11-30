<?php

/**
 * Database Configuration - PDO Version
 * Provides a single, reusable database connection using PDO
 */

class Database
{
  private $host = 'localhost';
  private $db_name = 'campus_maintenance';
  private $username = 'root';
  private $password = 'walabalo';
  private $conn;

  /**
   * Get database connection
   * @return PDO Database connection object
   */
  public function getConnection()
  {
    $this->conn = null;

    try {
      $this->conn = new PDO(
        "mysql:host=" . $this->host . ";dbname=" . $this->db_name,
        $this->username,
        $this->password,
        array(
          PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
          PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
          PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8mb4"
        )
      );
    } catch (PDOException $e) {
      echo "Connection Error: " . $e->getMessage();
      exit;
    }

    return $this->conn;
  }
}
