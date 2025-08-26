<?php 
 use app\controller\AuthController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/authController.php';

$conn = DataConnection();
$authController = new AuthController($conn);
if (isset($_POST['register']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $authController->register();
}
require 'topnavigation.php';
?>
<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../css/login.css">
</head>

<body>

    <!-- <button onclick="document.getElementById('id02').style.display='block'" style="width:auto;" class="btn">Sign Up</button> -->

    <div id="id02" class="modal">
        <span onclick="document.getElementById('id02').style.display='none'" class="close"
            title="Close Modal">&times;</span>
        <form class="modal-content" action="<?= htmlspecialchars($_SERVER['REQUEST_URI']) ?>" method="POST" enctype="multipart/form-data">
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
                <input type="file" name="image" accept="image/*">

                <label for="psw"><b>Password</b></label>
                <input type="password" placeholder="Enter Password" name="psw" required>

                <label for="psw-repeat"><b>Repeat Password</b></label>
                <input type="password" placeholder="Repeat Password" name="psw-repeat" required>

                <label>
                    <input type="checkbox" checked="checked" name="remember" style="margin-bottom:15px">
                    Remember me
                </label>

                <p>By creating an account you agree to our <a href="/termsPrivacy" style="color:dodgerblue">Terms &
                        Privacy</a>.</p>

                <div class="clearfix">
                    <button type="button" onclick="document.getElementById('id02').style.display='none'"
                        class="cancelbtn">Cancel</button>
                    <button type="submit" class="signupbtn" name="register">Sign Up</button>
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
</body>

</html>