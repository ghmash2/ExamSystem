<?php
namespace app\controller;
use PDO;
class ResultController
{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    function saveUserAnswer($user_id, $exam_id, $question_id, $user_answer, $actual_answer)
    {
        $user_answer = $user_answer ?? NULL;
        $stmt = $this->conn->prepare("SELECT user_id, exam_id FROM user_answer WHERE question_id = :question_id");
        $stmt->execute([":question_id" => $question_id]);
        $list = $stmt->fetchAll(PDO::FETCH_ASSOC);
        $flag = false;
        foreach ($list as $li) {
            if ($li['user_id'] == $user_id && $li['exam_id'] == $exam_id)
                $flag = true;
        }
        if (!$flag) {
            $stmt = $this->conn->prepare("
                INSERT INTO user_answer 
                (user_id, exam_id, question_id, user_answer, correct_answer) 
                VALUES (?, ?, ?, ?, ?)
            ");
            $stmt->execute([$user_id, $exam_id, $question_id, $user_answer, $actual_answer]);
        } else {
            $stmt = $this->conn->prepare("
                UPDATE user_answer 
                SET user_answer = :user_answer
                WHERE user_id = :user_id AND exam_id = :exam_id AND question_id = :question_id;
            ");
            $stmt->execute([":user_id" => $user_id, ":exam_id" => $exam_id, ":question_id" => $question_id, ":user_answer" => $user_answer]);
        }
    }
}
?>