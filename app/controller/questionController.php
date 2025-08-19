<?php 
namespace app\controller;
use PDO;
class QuestionController{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    function getQuestionByExamId($id)
    {

    }
}
?>