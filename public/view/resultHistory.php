<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/resultController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/questionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/examController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/optionController.php';
use app\controller\ResultController;
use function app\database\DataConnection;
use app\controller\QuestionController;
use app\controller\ExamController;
use app\controller\OptionController;
$conn = DataConnection();
$resultController = new ResultController($conn);
$questionController = new QuestionController($conn);
$examController = new ExamController($conn);
$optionController = new OptionController($conn);
if (!isset($_SESSION['user']))
    header("Location: ..");
$exam_id = 0;
$user_id = 0;

if (isset($_GET['exam_id']))
    $exam_id = htmlspecialchars($_GET['exam_id']);
if (isset($_GET['user_id']))
    $user_id = htmlspecialchars($_GET['user_id']);

$attempts = $resultController->getExamsAttempts($user_id, $exam_id);
$count = count($attempts);
require 'topnavigation.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/resultHistory.css">
    <title>Result</title>

</head>

<body>
    <h2 class="section-title">Exam Details: <?= $examController->getExamNameById($exam_id) ?></h2>
    <?php foreach ($attempts as $attempt): ?>

        <?php $rows = $resultController->getResultOfEachQuestion($attempt['id']); ?>
        <div class="container">
            <div class="">Attempt No: <?= $count-- ?></div>
            <table class="questions-table">
                <thead>
                    <tr>
                        <th>Question</th>
                        <th>Your Answer</th>
                        <th>Correct Answer</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($rows as $row): ?>
                        <tr>
                            <td><?= $questionController->getQuestionTitleByQuestionId($row['question_id']) ?></td>
                            <td><?= $optionController->getTitleByOptionId($row['user_answer']) ?></td>
                            <td><?= $optionController->getTitleByOptionId($row['solution_no']) ?></td>
                            <?php if ($row['user_answer'] == $row['solution_no']): ?>
                                <td class="status-correct">Correct</td>
                            <?php else: ?>
                                <td class="status-incorrect">Incorrect</td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    <?php endforeach; ?>


</body>

</html>