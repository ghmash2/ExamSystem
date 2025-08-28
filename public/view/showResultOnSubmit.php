<?php

use app\controller\OptionController;
use app\controller\QuestionController;
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
$questionController = new QuestionController($conn);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $user_id = $_POST['user_id'];
    $exam_id = $_POST['exam_id'];
    $login_required = $_POST['is_login_required'];
    $answers = [];
    $total = 0;
    foreach ($_POST as $key => $value) {
        if (strpos($key, 'option_') === 0) {
            $question_id = (int) substr($key, 7);
            $user_answer = (int) $value;

            $actual_answer = $optionController->getAnswerByQuestionId($question_id);
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
    if ($login_required) {
        $resultController->saveUserAnswer($user_id, $exam_id, $answers, $total, $correct);
    }
}
else{
    header("Location: ..");
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
    <div class="questions-container">
        <?php foreach ($answers as $answer): ?>
            <?php $options = $optionController->getOptionByQuestionId($answer['question_id']); ?>
            <div class="question">
                <div class="question-header">
                    <h3 class="question-title">
                        <?= $questionController->getQuestionTitleByQuestionId($answer['question_id']) ?>
                    </h3>
                    <span class="question-type">Multiple Choice</span>
                </div>

                <div class="options-container">
                    <?php foreach ($options as $index => $option): ?>
                        <?php if ($answer['user_answer'] != null && $option['id'] == $answer['user_answer'] && $answer['actual_answer'] == $answer['user_answer'] ): ?>
                            <div class="option" style="border-color: green"><span><?= htmlspecialchars($option['title']) ?></span>
                                <span style="color: green;">Correct✔️</span>
                            </div>
                        <?php elseif ($answer['user_answer'] != null && $option['id'] == $answer['user_answer'] && $answer['actual_answer'] != $answer['user_answer']): ?>
                            <div class="option" style="border-color: red"><span><?= htmlspecialchars($option['title']) ?></span>
                                <span style="color: red;">Not Correct❌</span>
                            </div>
                        <?php elseif ($option['id'] == $answer['actual_answer'] && $answer['user_answer'] == null): ?>
                            <div class="option" style="border-color: green"><span><?= htmlspecialchars($option['title']) ?></span>
                              <span style="color: grey">Not Answered✖</span>
                            </div>
                        <?php else: ?>
                            <div class="option"><?= $option['title'] ?></div>
                        <?php endif; ?>
                    <?php endforeach; ?>
                </div>

                <div class="question-footer">
                    <!-- <span>Question ID: 102</span> -->
                    <!-- <span class="status status-active">Active</span> -->
                </div>
            </div>
        <?php endforeach; ?>
    </div>
</body>

</html>