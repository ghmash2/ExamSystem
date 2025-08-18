<?php 
namespace app\controller;
use PDO;
class UserController{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
}
?>