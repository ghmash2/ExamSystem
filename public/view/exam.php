<?php 
use app\controller\ExamController;
use app\controller\OptionController;
use app\controller\QuestionController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/questionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/optionController.php';
$conn = DataConnection();
$questionController = new QuestionController($conn);
$questions = $questionController->getQuestionByExamId($examid);
$optionController = new OptionController($conn);
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/exam.css">
</head>
<body>
  <h1>All Questions Show Here</h1>
  
</body>
</html>