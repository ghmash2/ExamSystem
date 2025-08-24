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
        $stmt = $this->conn->prepare("SELECT * FROM exam_question WHERE exam_id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getQuestionTitleByQuestionId($id)
    {
        $stmt = $this->conn->prepare("SELECT title FROM exam_question WHERE id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetchColumn();
    }
}
?>