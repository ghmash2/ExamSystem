<?php 
session_start();
use function app\database\DataConnection;

require_once '../app/database.php';

// $conn = DataConnection();
// $stmt = $conn->query("SELECT * FROM users");
// $list = $stmt->fetchAll();
// foreach($list as $li) 
// {
//     echo $li['name'];
// }
echo "Inside index.php";
require_once '../public/view/home.php';
?>