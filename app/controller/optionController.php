<?php 
namespace app\controller;
use PDO;
class OptionController{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    function getOptionByQuestionId($id)
    {
        
    }
}
?>