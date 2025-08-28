<?php
namespace app\controller;
require 'vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\IOFactory;
use PDO;
use PDOException;
class AuthController
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
            $examName = $_POST['exam_name'];
            $tagline = $_POST['tagline'] ?? '';
            $duration = $_POST['duration'];
            $startTime = $_POST['start_time'];
            $categoryId = $_POST['category'];
            $loginRequired = isset($_POST['login_required']) ? 1 : 0;

            // Handle file upload
            if (isset($_FILES['excel_file']) && $_FILES['excel_file']['error'] === UPLOAD_ERR_OK) {
                $tmpName = $_FILES['excel_file']['tmp_name'];

                // Insert exam into database
                //$stmt = $this->conn->prepare("INSERT INTO exams (name, tagline, duration, start_time, category_id, is_login_required) 
                              //VALUES (?, ?, ?, ?, ?, ?)");
                //$stmt->execute([$examName, $tagline, $duration, $startTime, $categoryId, $loginRequired]);
               // $examId = $this->conn->lastInsertId();

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
                        //$stmt = $pdo->prepare("INSERT INTO exam_questions (exam_id, question, marks) VALUES (?, ?, ?)");
                        $stmt->execute([$examId, $question, $marks]);
                        $questionId = $pdo->lastInsertId();

                        // Insert options
                        $options = [$option1, $option2, $option3, $option4];
                        foreach ($options as $index => $optionText) {
                            $isCorrect = ($index + 1 == $correctAnswer) ? 1 : 0;
                           // $stmt = $pdo->prepare("INSERT INTO question_options (question_id, option_text, is_correct) 
                                         // VALUES (?, ?, ?)");
                            $stmt->execute([$questionId, $optionText, $isCorrect]);
                        }
                    }
                }

                echo json_encode(['success' => true, 'message' => 'Exam created successfully!', 'exam_id' => $examId]);
            } else {
                throw new Exception('Please upload a valid Excel file.');
            }
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['success' => false, 'message' => 'Error: ' . $e->getMessage()]);
        }
    }
}
?>