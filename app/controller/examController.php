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
    function getAttemptOfExam($user_id, $exam_id)
    {
        $stmt =  $this->conn->prepare("SELECT COUNT(*) FROM user_answer WHERE exam_id = :exam_id AND user_id = :user_id");
        $stmt->execute([":exam_id" => $exam_id, ":user_id" => $user_id]);
        return $stmt->fetchAll();
    }
    function isLoginRequired($exam_id)
    {
        $stmt = $this->conn->prepare("SELECT is_login_required FROM exams WHERE id=:exam_id");
        $stmt->execute([":exam_id"=> $exam_id]);
        return $stmt->fetchColumn();
    }

}
?>