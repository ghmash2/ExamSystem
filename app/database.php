<?php 
namespace app\database;
use PDO;
use PDOException;

function DataConnection()
{
     try{
        $pdo = new PDO("mysql:host = localhost; dbname=exam_system", "root", "");
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
     }
     catch(PDOException $e)
     {
        die("DB Connection Failed: ". $e->getMessage());
     }
}

function closeDataConnection(&$conn)
{
     $conn= null;
}

?>