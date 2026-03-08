<?php
session_start();

// Check if the logout button is clicked
if (isset($_POST['logout'])) {
    // Check if the session is set
    if (isset($_SESSION)) {
        // Clear all session variables
        session_unset();
        
        // Destroy the session
        session_destroy();
    }
    
    // Redirect to the login page
    header('Location: home.html');
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Logout</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #1f1f1f;
            text-align: center;
            margin: 0;
            padding: 0;
            color: #fff;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h2 {
            margin-bottom: 20px;
        }
        p {
            margin-bottom: 20px;
        }
        .btn-group {
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 20px;
        }
        input[type="submit"], input[type="button"] {
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            width: 100px;
        }
        .yes-btn {
            background-color: #007bff;
        }
        .no-btn {
            background-color: #dc3545;
        }
    </style>
</head>
<body>
    <div class="container">
        <h2>Logout</h2>
        <p>Are you sure you want to logout?</p>
        <form action="logout.php" method="post" class="btn-group">
            <input type="submit" name="logout" value="Yes" class="yes-btn">
            <input type="button" value="No" class="no-btn" onclick="goBack()">
        </form>
    </div>

    <script>
        function goBack() {
            window.history.back();
        }
    </script>
</body>
</html>
