<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../css/addExam.css">
    <title>Exam Creation System</title>

</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Create New Exam</h1>
            <p>Fill in the exam details and upload questions</p>
        </div>

        <div class="instructions">
            <h3>How to prepare your Excel file:</h3>
            <div class="step">
                <span class="step-number">1</span>
                <span>Create an Excel file with these columns: <strong>Question, Option1, Option2, Option3, Option4, CorrectAnswer, Marks</strong></span>
            </div>
            <div class="step">
                <span class="step-number">2</span>
                <span>The CorrectAnswer should be a number between 1-4 (1 for Option1, 2 for Option2, etc.)</span>
            </div>
            <div class="step">
                <span class="step-number">3</span>
                <span>Save your file as .xlsx, .xls format</span>
            </div>
        </div>

        <form id="examForm" action="" method="POST" enctype="multipart/form-data">
            <!-- Basic Exam Information -->
            <div class="form-section">
                <h2 class="section-title">Exam Information</h2>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="examName" class="required-field">Exam Name</label>
                        <input type="text" id="examName" name="exam_name" required>
                    </div>
                    <div class="form-col">
                        <label for="tagline">Tagline</label>
                        <input type="text" id="tagline" name="tagline">
                    </div>
                </div>
                
                <div class="form-row">
                    <div class="form-col">
                        <label for="duration" class="required-field">Duration (minutes)</label>
                        <input type="number" id="duration" name="duration" min="1" required>
                    </div>
                    <div class="form-col">
                        <label for="startTime" class="required-field">Start Time</label>
                        <input type="datetime-local" id="startTime" name="start_time" required>
                    </div>
                    <div class="form-col">
                        <label for="category" class="required-field">Category</label>
                        <select id="category" name="category" required>
                            <option value="">Select Category</option>
                            <option value="1">Mathematics</option>
                            <option value="2">English</option>
                            <option value="3">Science</option>
                            <option value="4">History</option>
                            <option value="5">Technology</option>
                        </select>
                    </div>
                </div>
                
                <div class="form-group">
                    <div class="checkbox-group">
                        <input type="checkbox" id="loginRequired" name="login_required" value="1">
                        <label for="loginRequired">Login required to take this exam</label>
                    </div>
                </div>
            </div>

            <!-- Questions Upload Section -->
            <div class="form-section">
                <h2 class="section-title">Exam Questions</h2>
                
                <div class="form-group">
                    <label for="excelFile" class="required-field">Upload Questions Excel File</label>
                    <div class="file-upload">
                        <div class="file-upload-btn">Choose File</div>
                        <input type="file" id="excelFile" name="excel_file" accept=".xlsx, .xls" required>
                    </div>
                    <div id="fileLabel" class="file-name">No file chosen</div>
                </div>
                
                <div id="filePreview" class="preview-table">
                    <h4>Preview (First 5 questions):</h4>
                    <div class="table-container">
                        <table>
                            <thead>
                                <tr>
                                    <th>Question</th>
                                    <th>Option 1</th>
                                    <th>Option 2</th>
                                    <th>Option 3</th>
                                    <th>Option 4</th>
                                    <th>Correct Answer</th>
                                    <th>Marks</th>
                                </tr>
                            </thead>
                            <tbody id="previewBody">
                                <!-- Preview will be inserted here by JavaScript -->
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>

            <button type="submit" class="submit-btn">Create Exam</button>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const fileInput = document.getElementById('excelFile');
            const fileLabel = document.getElementById('fileLabel');
            const previewSection = document.getElementById('filePreview');
            const previewBody = document.getElementById('previewBody');
            
            // Update file label when a file is selected
            fileInput.addEventListener('change', function() {
                if (this.files.length > 0) {
                    fileLabel.textContent = this.files[0].name;
                    // In a real application, you would parse the Excel file here
                    // and show a preview. For this example, we'll simulate it.
                    simulateExcelPreview();
                } else {
                    fileLabel.textContent = 'No file chosen';
                    previewSection.style.display = 'none';
                }
            });
            
            // Form validation
            document.getElementById('examForm').addEventListener('submit', function(e) {
                const examName = document.getElementById('examName').value;
                const duration = document.getElementById('duration').value;
                const startTime = document.getElementById('startTime').value;
                const category = document.getElementById('category').value;
                const excelFile = document.getElementById('excelFile').files[0];
                
                if (!examName || !duration || !startTime || !category || !excelFile) {
                    e.preventDefault();
                    alert('Please fill in all required fields.');
                }
            });
            
            // Simulate Excel file preview (in a real app, you would use a library like SheetJS)
            function simulateExcelPreview() {
                previewBody.innerHTML = '';
                
                // Sample data for demonstration
                const sampleData = [
                    ['What is 2 + 2?', '3', '4', '5', '6', '2', '1'],
                    ['Capital of France?', 'London', 'Berlin', 'Paris', 'Madrid', '3', '1'],
                    ['Largest planet?', 'Earth', 'Mars', 'Jupiter', 'Saturn', '3', '1'],
                    ['2 × 3 = ?', '4', '5', '6', '7', '3', '1'],
                    ['HTML stands for?', 'Hyperlinks', 'Hypertext Markup Language', 'Home Tool', 'Hyper Text', '2', '1']
                ];
                
                sampleData.forEach(row => {
                    const tr = document.createElement('tr');
                    row.forEach(cell => {
                        const td = document.createElement('td');
                        td.textContent = cell;
                        tr.appendChild(td);
                    });
                    previewBody.appendChild(tr);
                });
                
                previewSection.style.display = 'block';
            }
        });
    </script>
</body>
</html>