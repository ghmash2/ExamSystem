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
}
?>