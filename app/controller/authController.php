<?php 
namespace app\controller;

use PDO;
class AuthController{
  private PDO $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }
}
?>