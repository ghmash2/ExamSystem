<?php
namespace app\controller;

use PDO;
use PDOException;
class AuthController
{
  private PDO $conn;
  public function __construct($conn)
  {
    $this->conn = $conn;
  }
  function login() 
  {
    $username = htmlspecialchars($_POST["uname"]);
    $password = htmlspecialchars($_POST["psw"]);
    $stmt = $this->conn->prepare("SELECT * FROM users WHERE username = :username");
    $stmt->execute([":username" => $username]);
    $user = $stmt->fetch();
    
    // $role = $this->adminController->getRoleId($user["id"]);
    if ($user) {
      if ($user && password_verify($password, $user["password"])) {

        $_SESSION['user'] = [
          'id' => $user['id'],
          'username' => $user['username'],
          'image' => $user['photo'],
          'email' => $user['email'],
          // 'role' => $role,
          'message' => ""
        ];
        // die("Successfully Login!!!");
        $_SESSION['user']['message'] = "Successfully Logged in!";
        //var_dump($_SESSION["user"]);
        header("Location: ..");
        exit();
      } else {
         die("Password Incorrect!!!");
        // $_SESSION['user']['message'] = "Incorrect password!";
        // header("Location: login.php");
        // exit();

      }
    } else {
          die("Not Registered Yet!!!");
      // $_SESSION['user']['message'] = "Not Registered Yet!!!";

      // header("Location: login.php");
      // exit();
    }

  }

  function logout()
  {
    session_destroy();
    header("Location: home.php");
  }


  function register()
  {
    $name = htmlspecialchars($_POST["name"]);
    $password = htmlspecialchars($_POST["psw"]);
    $email = htmlspecialchars($_POST["email"]);
    $contact = htmlspecialchars($_POST["contact"]);
    $username = htmlspecialchars($_POST["username"]);
    $repassword = htmlspecialchars($_POST["psw-repeat"]);
    try {
      $stmt = $this->conn->prepare("SELECT username FROM users WHERE username = :username");
      $stmt->execute([":username" => $username]);
      $result = $stmt->fetchAll();
    } catch (PDOException $e) {
      return "PDO Error: " . $e;
    }
    if ($result) {
      die("Username Already Exist!!!");
    }
    if ($password != $repassword) {
      die("Password Does not match!!");
    }
    $password = password_hash($password, PASSWORD_DEFAULT);
    // if (!isset($_FILES['image']) || $_FILES['image']['error'] === UPLOAD_ERR_NO_FILE) {
    //   die('No file was uploaded');
    // }

    // // Verify upload success
    // if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
    //   die('Upload failed with error code: ' . $_FILES['image']['error']);
    // }
    $targetDir = $_SERVER['DOCUMENT_ROOT'] . "/uploads/user_img/";
    $imageName = basename($_FILES["image"]["name"]);
    $targetPath = $targetDir . $imageName;
    move_uploaded_file($_FILES["image"]["tmp_name"], $targetPath);



    $stmt = $this->conn->prepare("INSERT INTO users(name, username, email, photo, contact, password) 
                                                 VALUES (:name, :username, :email, :photo, :contact, :password)");
    $stmt->execute([
      ":name" => $name,
      ":email" => $email,
      ":photo" => $imageName,
      ":password" => $password,
      ":username" => $username,
      ":contact" => $contact
    ]);

    // $id = $this->conn->lastInsertId();
    // $roleId = $roleId ?? 2;
    // $stmt = $this->conn->prepare("INSERT INTO user_roles(user_id, role_id)
    //                                              VALUES (:user_id, :role_id)");
    // $stmt->execute([
    //   ":user_id" => $id,
    //   ":role_id" => $roleId
    // ]);
    header("Location: /home.php");
    exit();
  }

}
?>