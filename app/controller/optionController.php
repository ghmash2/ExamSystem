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
        $stmt = $this->conn->prepare("SELECT * FROM options WHERE question_id = :id");
        $stmt->execute([":id" => $id]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
    function getAnswerByQuestionId($id)
    {
        $stmt = $this->conn->prepare("
                SELECT id FROM options 
                WHERE question_id = ? AND is_correct = 1
            ");
        $stmt->execute([$id]);
        return $stmt->fetchColumn();
    }
    function getTitleByOptionId($option_id)
    {
        $stmt = $this->conn->prepare("SELECT title FROM options WHERE id = :option_id");
        $stmt->execute([":option_id"=> $option_id]);
        return $stmt->fetchColumn();
    }
}
?>