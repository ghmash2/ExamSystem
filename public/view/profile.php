<?php 
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/userController.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/resultController.php';
use app\controller\ResultController;
use app\controller\UserController;
use function app\database\DataConnection;
  $conn = DataConnection();
  $userController = new UserController($conn);
  $resultController = new ResultController($conn);
  $user = $userController->getUserById(htmlspecialchars($_GET['id']));
  $exams = $resultController->getExamByUserId($user['id']);
//   var_dump($exams);
//   die();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/userDetails.css">
    <title>Profile</title>
</head>
<body>
    <div class="container">
        <!-- Left Sidebar - Profile Section -->
        <aside class="profile-sidebar">
            <div class="profile-header">
                <img src="../uploads/user_img/<?=$user['photo'] ?: 'default.png'?>" alt="Profile Image" class="profile-image">
                <h2 class="profile-name"><?=$user['name']?></h2>
                <p class="profile-username"><?="@".$user['name']?></p>
            </div>
            
            <div class="profile-details">
                <div class="detail-item">
                    <div class="detail-icon">✉︎</div>
                    <div><?=$user['email']?></div>
                </div>
                <div class="detail-item">
                    <div class="detail-icon">🕻</div>
                    <div><?=$user['contact']?></div>
                </div>
                <!-- <div class="detail-item">
                    <div class="detail-icon"></div>
                    <div>Software Developer</div>
                </div> -->
                <div class="detail-item">
                    <div class="detail-icon">🏠︎</div>
                    <div>Address</div>
                </div>
                <div class="detail-item">
                    <div class="detail-icon">🗓</div>
                    <div>Member since: Jan 2025</div>
                </div>
            </div>
        </aside>
        
        <!-- Main Content Area -->
        <main class="main-content">
            <h2 class="section-title">Exam History</h2>
            
            <!-- Exam History Cards -->
            <div class="exam-cards">
                <?php foreach($exams as $exam): ?>
                    <a href="/resultHistory?user_id=<?=$user['id']?>&exam_id=<?=$exam['id']?>" style="text-decoration: none">
                <div class="exam-card">
                    <h3 class="exam-name"><?=$exam['title']?></h3>
                    <!-- <div class="exam-detail">
                        <span class="label">Join Date:</span>
                        <span class="value">Oct 15, 2023</span>
                    </div> -->
                    <div class="exam-detail">
                        <span class="label">Duration:</span>
                        <span class="value"><?=$exam['duration']." minutes"?></span>
                    </div>
                    <div class="exam-detail">
                        <span class="label">Mark:</span>
                        <span class="value"><span class="score score-high"><?=$exam['full_mark']?></span></span>
                    </div>
                </div>
                </a>
                <?php endforeach; ?>
            </div>
            
        </main>
    </div>
</body>
</html>