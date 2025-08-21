<?php

use app\controller\OptionController;
use app\controller\ResultController;
use function app\database\DataConnection;
session_start();
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/questionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/optionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/resultController.php';
$conn = DataConnection();
$optionController = new OptionController($conn);
$resultController = new ResultController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_POST['user_id'];
    $exam_id = $_POST['exam_id'];
    $answers = [];
    $total = 0;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'option_') === 0) {
            $question_id = (int) substr($key, 7);
            $user_answer = (int) $value;

            $actual_answer = $optionController->getAnswerByQuestionId($question_id);
            $resultController->saveUserAnswer($user_id, $exam_id, $question_id, $user_answer, $actual_answer);
            $answers[] = [
                'question_id' => $question_id,
                'user_answer' => $user_answer,
                'actual_answer' => $actual_answer
            ];
            $total++;
        }

    }
    $correct = 0;
    foreach ($answers as $answer) {
        if ($answer['user_answer'] == $answer['actual_answer'])
            $correct++;
    }

}
// if (!isset($_SESSION['user_id'])) {
//     throw new Exception('User not logged in');
// }
// if (!$exam_id) {
//     throw new Exception('Exam ID not provided');
// }
// Verify user has access to this exam
// $stmt = $pdo->prepare("SELECT id FROM exams WHERE id = ?");
// $stmt->execute([$exam_id]);
// if (!$stmt->fetch()) {
//     throw new Exception('Invalid exam');
require 'topnavigation.php';
?>

<!DOCTYPE html>
<html>

<head>
    <title>Exam</title>
    <link rel="stylesheet" href="../css/showResultOnSubmit.css">
</head>

<body>
    <h1>Result</h1>
    <div>Correct Answer: <?= $correct ?> / <?= $total ?></div>
    <div>
        <table>
            <thead>
                <th>Question</th>
                <th>Correct Answer</th>
                <th>Your Answer</th>
            </thead>
            <tbody>
                <?php foreach ($answers as $answer): ?>
                    
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>

</html>