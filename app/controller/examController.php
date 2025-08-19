<?php 
namespace app\controller;
use PDO;
class ExamController{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    function getAllExam()
    {
        $stmt = $this->conn->prepare("SELECT * FROM exams");
        $stmt->execute();
        return $stmt->fetchAll();
    }

}
?>