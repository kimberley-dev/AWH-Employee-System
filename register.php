<?php
session_start();
include_once "connection.php";

$error_msg = ""; // Initialize error message

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $EIN = $_POST["EIN"];
    $name = $_POST["name"];
    $qualification = $_POST["qualification"];
    $salary = $_POST["salary"];
    $deductions = $_POST["deductions"];
    $TRN = $_POST["TRN"];
    $bank_branch = $_POST["bank_branch"];
    $BAN = $_POST["BAN"];
    
    // Validate form data (you can add more validation if needed)
    if (empty($EIN) || empty($name) || empty($qualification) || empty($salary) || empty($deductions) || empty($TRN) || empty($bank_branch) || empty($BAN)) {
        $error_msg = "All fields are required.";
    } else {
        // Insert data into employees table
        $sql = "INSERT INTO employees (EIN, name, qualification, salary, deductions, TRN, bank_branch, BAN) 
                VALUES ('$EIN', '$name', '$qualification', '$salary', '$deductions', '$TRN', '$bank_branch', '$BAN')";
        
        if (mysqli_query($conn, $sql)) {
            // Registration successful, redirect to login page
            header("Location: login.php");
            exit();
        } else {
            $error_msg = "Error: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('registerbg.png'); /* Background image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 400px;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Adjust the opacity of the background */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        h1 {
            text-align: center;
            margin-bottom: 20px;
        }
        .input-group {
            margin-bottom: 20px;
        }
        .input-group label {
            display: block;
            font-weight: bold;
            margin-bottom: 5px;
        }
        .input-group input {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: 1px solid #ccc;
            box-sizing: border-box;
        }
        .button {
            width: 100%;
            padding: 10px;
            background-color: #007bff; /* Blue button */
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3; /* Darker blue on hover */
        }
        .error-message {
            color: #721c24;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            background-color: #f8d7da; /* Light red background */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Registration</h1>
        <form action="register.php" method="post">
            <div class="input-group">
                <label for="EIN">EIN:</label>
                <input type="text" id="EIN" name="EIN">
            </div>
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name">
            </div>
            <div class="input-group">
                <label for="qualification">Qualification:</label>
                <input type="text" id="qualification" name="qualification">
            </div>
            <div class="input-group">
                <label for="salary">Salary:</label>
                <input type="text" id="salary" name="salary">
            </div>
            <div class="input-group">
                <label for="deductions">Deductions:</label>
                <input type="text" id="deductions" name="deductions">
            </div>
            <div class="input-group">
                <label for="TRN">TRN:</label>
                <input type="text" id="TRN" name="TRN">
            </div>
            <div class="input-group">
                <label for="bank_branch">Bank Branch:</label>
                <input type="text" id="bank_branch" name="bank_branch">
            </div>
            <div class="input-group">
                <label for="BAN">BAN:</label>
                <input type="text" id="BAN" name="BAN">
            </div>
            <div class="input-group">
                <button type="submit" class="button">Register</button>
            </div>
            <?php if(!empty($error_msg)): ?>
            <div class="error-message">
                <?php echo $error_msg; ?>
            </div>
            <?php endif; ?>
        </form>
    </div>
</body>
</html>