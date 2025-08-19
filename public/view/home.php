<?php
use app\controller\AuthController;
use app\controller\ExamController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/questionController.php';

$conn = DataConnection();
$examController = new ExamController($conn);
$exams = $examController->getAllExam();
require 'topnavigation.php';
?>
<!DOCTYPE html>
<html>

<head>
    <title>Home</title>
    <link rel="stylesheet" href="css/home.css">
</head>

<body>
    <h2>Exam List</h2>

    <div class="exam-page">
        <!-- Left Sidebar -->
        <div class="sidebar">
            <h3>Search & Filter</h3>

            <div class="search-box">
                <input type="text" placeholder="Search exams...">
            </div>

            <div class="filter-section">
                <div class="filter-group">
                    <h4>Categories</h4>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="category" value="mathematics"> Mathematics
                        </label>
                    </div>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="category" value="science"> Science
                        </label>
                    </div>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="category" value="history"> History
                        </label>
                    </div>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="category" value="language"> Language
                        </label>
                    </div>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="category" value="technology"> Technology
                        </label>
                    </div>
                </div>

                <div class="filter-group">
                    <h4>Requirements</h4>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="requirement" value="login"> Login Required
                        </label>
                    </div>

                    <div class="filter-option">
                        <label>
                            <input type="checkbox" name="requirement" value="free"> Free Access
                        </label>
                    </div>
                </div>
            </div>
        </div>

        <!-- Exam List -->
        <div class="exam-list">
            <?php foreach ($exams as $exam): ?>
                <div class="exam-card">
                    <div class="exam-header">
                        <h3 class="exam-title"><?=$exam['title'] ? htmlspecialchars($exam['title']) : '' ?></h3>
                        <p class="exam-tagline"><?=$exam['tagline'] ? htmlspecialchars($exam['tagline']) : '' ?></p>
                    </div>

                    <div class="exam-body">
                        <div class="exam-meta">
                            <span class="exam-date">
                                <?= $exam['exam_date'] ? htmlspecialchars($exam['exam_date']) : 'Not scheduled' ?>
                            </span>
                            <span class="exam-time">
                                <?= $exam['exam_start_time'] ? date('h:i A', strtotime($exam['exam_start_time'])) : '' ?>
                            </span>
                            </span>
                        </div>

                        <p class="exam-instruction"><?= $exam['instruction'] ? nl2br(htmlspecialchars($exam['instruction'])) : '' ?></p>
                    </div>

                    <div class="exam-footer">
                        <span class="exam-category"><?=$exam['category_id'] ? htmlspecialchars($exam['category_id']) : '' ?></span>
                        <div>
                            <?php if ($exam['is_login_required']): ?>
                                <span class="login-required">Login Required</span>
                            <?php endif; ?>
                            <a href="../view/exam.php">
                                <button class="exam-button">Start Exam</button>
                            </a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>

    <script>
        // Basic search functionality
        document.querySelector('.search-box input').addEventListener('input', function (e) {
            const searchTerm = e.target.value.toLowerCase();
            document.querySelectorAll('.exam-card').forEach(card => {
                const title = card.querySelector('.exam-title').textContent.toLowerCase();
                const tagline = card.querySelector('.exam-tagline').textContent.toLowerCase();
                if (title.includes(searchTerm) || tagline.includes(searchTerm)) {
                    card.style.display = 'block';
                } else {
                    card.style.display = 'none';
                }
            });
        });

        // Basic filter functionality
        document.querySelectorAll('.filter-option input').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const category = this.value;
                const isChecked = this.checked;

                // This is a basic implementation - you'll need to enhance it
                // based on your actual filtering requirements
                document.querySelectorAll('.exam-card').forEach(card => {
                    const cardCategory = card.querySelector('.exam-category').textContent.toLowerCase();
                    if (cardCategory.includes(category.toLowerCase())) {
                        card.style.display = isChecked ? 'block' : 'none';
                    }
                });
            });
        });
    </script>

</body>

</html>