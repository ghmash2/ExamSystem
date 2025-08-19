<?php
session_start();
use app\controller\AuthController;
use function app\database\DataConnection;

require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/database.php';
require_once $_SERVER['DOCUMENT_ROOT'] . '/../app/controller/authController.php';

$conn = DataConnection();
$authController = new AuthController($conn);
if (isset($_POST['login']) && $_SERVER['REQUEST_METHOD'] == 'POST') {
  $authController->login();
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
  <h2>Modal Login Form</h2>
  <?php if (isset($_SESSION['user']['message'])): ?>
    <div
      style="color: red; padding: 10px; margin-bottom: 15px; border: 1px solid #ff9999; border-radius: 5px; background: #ffeeee;">
      <?= $_SESSION['user']['message'] ?>
    </div>
    <?php unset($_SESSION['user']['message']); ?>
  <?php endif; ?>
  <!-- <button onclick="document.getElementById('id01').style.display='block'" style="width:auto;">Login</button> -->
  <div id="id01" class="modal">
    <form class="modal-content animate" action="<?= htmlspecialchars($_SERVER['PHP_SELF']) ?>" method="POST">
      <div class="imgcontainer">
        <span onclick="document.getElementById('id01').style.display='none'" class="close"
          title="Close Modal">&times;</span>
        <!-- <img src="img_avatar2.png" alt="Avatar" class="avatar"> -->
      </div>
      <div class="container">
        <label for="uname"><b>Username</b></label>
        <input type="text" placeholder="Enter Username" name="uname" required>

        <label for="psw"><b>Password</b></label>
        <input type="password" placeholder="Enter Password" name="psw" required>

        <button type="submit" name="login">Login</button>
        <label>
          <input type="checkbox" checked="checked" name="remember"> Remember me
        </label>
      </div>
      <div class="clearfix" style="background-color:#f1f1f1">
        <button type="button" onclick="document.getElementById('id01').style.display='none'"
          class="cancelbtn">Cancel</button>
        <span class="psw">Forgot <a href="#">password?</a></span>
      </div>
    </form>
  </div>

  <!-- <script>
    // Get the modal
    var modal = document.getElementById('id01');

    // When the user clicks anywhere outside of the modal, close it
    window.onclick = function (event) {
      if (event.target == modal) {
        modal.style.display = "none";
      }
    }
  </script> -->

</body>

</html>