<?php
// session_start();

use app\controller\AuthController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/authController.php';

$conn = DataConnection();
$authController = new AuthController($conn);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">

    <link rel="stylesheet" href="css/topnavigation.css">
    <link rel="stylesheet" href="css/login.css">

</head>

<body>

    <div class="topnav">
        <div class="left-section">
            <a href="/" class="logo">ExamSYS</a>
            <a href="index.php" class="nav-link">Home</a>
            <!-- <?php if (isset($_SESSION['user']['id'])): ?> <a href="dashboard.php" class="nav-link">Dashboard</a> <?php endif; ?> -->
            <a href="contact.php" class="nav-link">Contact</a>
        </div>

        <?php if (isset($_SESSION['user']['id'])): ?>
            <div class="profile">
                <!--  -->

                <a href="\profile.php?id=<?= $_SESSION['user']['id'] ?>" style="color: #e5ecf3ff; text-decoration: none;">
                    <img src="/uploads/user_img/<?= $_SESSION['user']['image'] ?>" alt="Profile">
                    <!-- <span><?= $_SESSION['user']['username'] ?></span> -->
                </a>

                <form action="/" method="post">
                    <button class="btn" style=" background-color: green;" type="submit" name="logout"
                        value=logout>Logout</button>
                </form>
            </div>
        <?php else: ?>
            <div class="profile">

                <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;" class="btn">Login</button>

                <div id="id01" class="modal">
                    <span onclick="document.getElementById('id01').style.display='none'" class="close"
                        title="Close Modal">&times;</span>
                    <form class="modal-content" action="/action_page.php">
                        <div class="container">
                            <h1>Log In</h1>
                            <!-- <p>Please fill in this form to create an account.</p> -->
                            <hr>
                            <label for="email"><b>Email</b></label>
                            <input type="text" placeholder="Enter Email" name="email" required>

                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="psw" required>

                            <label>
                                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
                                Remember me
                            </label>

                            <div class="clearfix">
                                <button type="button" onclick="document.getElementById('id01').style.display='none'"
                                    class="cancelbtn">Cancel</button>
                                <button type="submit" class="signupbtn">Login</button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    // Get the modal
                    var modal = document.getElementById('id01');

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>

                <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="btn">Sign Up</button>

                <div id="id02" class="modal">
                    <span onclick="document.getElementById('id02').style.display='none'" class="close"
                        title="Close Modal">&times;</span>
                    <form class="modal-content" action="/action_page.php">
                        <div class="container">
                            <h1>Sign Up</h1>
                            <p>Please fill in this form to create an account.</p>
                            <hr>
                            <label for="name"><b>Name</b></label>
                            <input type="text" placeholder="Enter Name" name="name" required>

                            <label for="email"><b>Email</b></label>
                            <input type="email" placeholder="Enter Email" name="email" required>

                            <label for="contact"><b>Contact</b></label>
                            <input type="tel" placeholder="Enter Contact" name="contact" required>

                            <label for="username"><b>Username</b></label>
                            <input type="text" placeholder="Enter Username" name="username" required>

                            <label for="image"><b>Image</b></label>
                            <input type="image" placeholder="Upload Image" name="image" required>

                            <label for="psw"><b>Password</b></label>
                            <input type="password" placeholder="Enter Password" name="psw" required>

                            <label for="psw-repeat"><b>Repeat Password</b></label>
                            <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                            <label>
                                <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
                                Remember me
                            </label>

                            <p>By creating an account you agree to our <a href="#" style="color:dodgerblue">Terms &
                                    Privacy</a>.</p>

                            <div class="clearfix">
                                <button type="button" onclick="document.getElementById('id02').style.display='none'"
                                    class="cancelbtn">Cancel</button>
                                <button type="submit" class="signupbtn">Sign Up</button>
                            </div>
                        </div>
                    </form>
                </div>

                <script>
                    // Get the modal
                    var modal = document.getElementById('id02');

                    // When the user clicks anywhere outside of the modal, close it
                    window.onclick = function (event) {
                        if (event.target == modal) {
                            modal.style.display = "none";
                        }
                    }
                </script>

            </div>
        <?php endif; ?>
    </div>

</body>

</html>