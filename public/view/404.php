<!DOCTYPE html>
<html>
<head>
    <title>Page Not Found</title>
    <style>
        body { 
            font-family: Arial, sans-serif; 
            text-align: center; 
            padding: 50px; 
            background: #f7f7f7ff;
        }
        .error-container {
            max-width: 600px;
            margin: 0 auto;
            background: white;
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        h1 { 
            color: #dc3545; 
            font-size: 48px; 
        }
    </style>
</head>
<body>
    <div class="error-container">
        <h1>404</h1>
        <h2>Page Not Found</h2>
        <p>The page you were looking for doesn't exist.</p>
        <p>You tried to access: <strong><?php echo htmlspecialchars($_SERVER['REQUEST_URI'] ?? ''); ?></strong></p>
        <a href="/">Return to Homepage</a>
    </div>
</body>
</html>