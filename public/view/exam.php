<?php
use app\controller\ExamController;
use app\controller\OptionController;
use app\controller\QuestionController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/questionController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/optionController.php';
$exam_id = "";

if (isset($_GET['id']) && !empty($_GET['id'])) {
  $exam_id = (int) $_GET['id'];
} else {
  die("No exam is selected");
}
$conn = DataConnection();
$questionController = new QuestionController($conn);
$questions = $questionController->getQuestionByExamId($exam_id);
$optionController = new OptionController($conn);
?>
<!DOCTYPE html>
<html>

<head>
  <title>Exam</title>
  <link rel="stylesheet" href="../css/exam.css">
</head>

<body>
  <div class="timer">
    <h3>Time: <span id="time">60:00</span></h3>
  </div>

  <div class="exam-container">

    <div class="exam-header">
      <h1 class="exam-title">Exam Title</h1>
      <p>Answer all questions to the best of your ability</p>
      <div class="exam-info">
        <div class="info-item">
          <span>Total Questions: (countQuestion)</span>
        </div>
        <div class="info-item">
          <span>Time Limit: (exam_duration)</span>
        </div>
      </div>
    </div>
    <div class="questions-container">
      <?php foreach ($questions as $question): ?>
        <?php $options = $optionController->getOptionByQuestionId($question['id']); ?>
        <div class="question">
          <div class="question-header">
            <h3 class="question-title"><?= $question['title'] ?></h3>
            <span class="question-type">Multiple Choice</span>
          </div>

          <div class="options-container">
            <?php foreach ($options as $index => $option): ?>
              <div class="option"> <!-- <div class="option correct-answer"></div> -->
                <input type="radio" id="option_<?=$question['id']?>_<?=$index?>" name="option_<?=$question['id']?>">
                <label for="option_<?=$question['id']?>_<?=$index?>"><?= $option['title'] ?></label>
              </div>
            <?php endforeach; ?>
          </div>

          <div class="question-footer">
            <!-- <span>Question ID: 102</span> -->
            <!-- <span class="status status-active">Active</span> -->
          </div>
        </div>
      <?php endforeach; ?>
    </div>
    <div class="navigation">
      <button class="btn btn-prev">Previous</button>
      <button class="btn btn-next">Next</button>
      <button class="btn btn-submit">Submit Exam</button>
    </div>
  </div>
  <script>
    document.addEventListener('click', function(e){
      const optionDiv = e.target.closest('.option');
      if(optionDiv){
        const container = optionDiv.closest('.options-container');
        container.querySelectorAll('.option').forEach(element => {
          element.classList.remove('correct-answer');
        });
        optionDiv.classList.add('correct-answer');
      }
    const radio = element.querySelector('input[type="radio"]');
    radio.checked = true;
    });
  </script>
</body>

</html>