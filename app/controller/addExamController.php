<?php
namespace app\controller;
require_once __DIR__ . '/../../vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use Exception;
use PDO;
use PDOException;
class AddExamController
{
    private PDO $conn;
    public function __construct($conn)
    {
        $this->conn = $conn;
    }
    // process_exam.php

    function addExam()
    {
        try {

            // Process form data
            $examName = htmlspecialchars($_POST['exam_name']);
            $tagline = htmlspecialchars($_POST['tagline'] ?? '');
            $duration = htmlspecialchars($_POST['duration']);
            $categoryId = htmlspecialchars($_POST['category']);
            $loginRequired = isset($_POST['login_required']) ? 1 : 0;
             $startTime = htmlspecialchars($_POST['start_time']);
            [$date, $tmp] = explode("T", $startTime);
            $time = $date . " ". $tmp . ":00";
            // Handle file upload
            if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['excel_file']['tmp_name'];

                $stmt = $this->conn->prepare("INSERT INTO exams (title, tagline, duration, exam_date, exam_start_time, category_id, is_login_required) 
                VALUES (?, ?, ?, ?, ?, ?, ?)");
                $stmt->execute([$examName, $tagline, $duration, $date, $time, $categoryId, $loginRequired]);
                $examId = $this->conn->lastInsertId();

                // Load Excel file
                $spreadsheet = IOFactory::load($tmpName);
                $worksheet = $spreadsheet->getActiveSheet();
                $highestRow = $worksheet->getHighestRow();

                // Process questions
                for ($row = 2; $row <= $highestRow; $row++) { // Assuming row 1 is header
                    $question = $worksheet->getCell('A' . $row)->getValue();
                    $option1 = $worksheet->getCell('B' . $row)->getValue();
                    $option2 = $worksheet->getCell('C' . $row)->getValue();
                    $option3 = $worksheet->getCell('D' . $row)->getValue();
                    $option4 = $worksheet->getCell('E' . $row)->getValue();
                    $correctAnswer = $worksheet->getCell('F' . $row)->getValue();
                    $marks = $worksheet->getCell('G' . $row)->getValue();

                    if (!empty($question)) {
                        // Insert question
                        $stmt = $this->conn->prepare("INSERT INTO exam_question (exam_id, title) VALUES (?, ?)");
                        $stmt->execute([$examId, $question]);
                        $questionId = $this->conn->lastInsertId();

                        // Insert options
                        $options = [$option1, $option2, $option3, $option4];
                        foreach ($options as $index => $optionText) {
                            $isCorrect = ($optionText == $correctAnswer) ? 1 : 0;
                            $stmt = $this->conn->prepare("INSERT INTO options (question_id, title, is_correct) 
                            VALUES (?, ?, ?)");
                            $stmt->execute([$questionId, $optionText, $isCorrect]);
                        }
                    }
                }
            } else {
                throw new Exception('Please upload a valid Excel file.');
            }
        } catch (Exception $e) {
            http_response_code(500);
            var_dump($e);
            die();
        }
    }
}
?>