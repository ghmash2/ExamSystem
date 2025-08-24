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
    function saveUserAnswer($user_id, $exam_id, $answers, $total, $correct)
    {
        $not_answered = 0;
        foreach ($answers as $answer) {
            if (empty($answer['user_answer']))
                $not_answered++;
        }
        $stmt = $this->conn->prepare("INSERT INTO user_answer
                (user_id, exam_id, correct_answer, not_answered) 
                VALUES (:user_id, :exam_id, :correct_answer, :not_answered)");
        $stmt->execute([":user_id" => $user_id, ":exam_id" => $exam_id, ":correct_answer" => $correct, ":not_answered" => $not_answered]);

        $id = $this->conn->lastInsertId();
        $stmt = $this->conn->prepare("
                INSERT INTO user_answer_option 
                (user_answer_id, question_id, solution_no, user_answer) 
                VALUES (?, ?, ?, ?)
            ");
        foreach ($answers as $answer) {
            $stmt->execute([$id, $answer['question_id'], $answer['actual_answer'], $answer['user_answer']]);
        }



        //     $stmt = $this->conn->prepare("
        //         UPDATE user_answer_option 
        //         SET user_answer = :user_answer
        //         WHERE question_id = :question_id AND user_answer_id IN (SELECT id FROM user_answer WHERE user_id = :user_id AND exam_id= :exam_id);
        //     ");
        //     $stmt->execute([":user_id" => $user_id, ":exam_id" => $exam_id,":question_id"=> $question_id, ":user_answer" => $user_answer]);
        // 
    }
}
?>