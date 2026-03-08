<?php include_once "menu.html"; ?>

<?php
session_start();
include_once "connection.php";

$error_msg = ""; // Initialize error message
$success_msg = ""; // Initialize success message

// Check if session is not verified
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header("Location: login.php"); // Redirect to login.php if not verified
    exit();
}

// Fetch EIN from the session
$EIN = $_SESSION['EIN'];

// Check if form submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $name = $_POST["name"];
    $qualification = $_POST["qualification"];
    $salary = $_POST["salary"];
    $deductions = $_POST["deductions"];
    $TRN = $_POST["TRN"];
    $bank_branch = $_POST["bank_branch"];
    $BAN = $_POST["BAN"];

    // Validate form data
    if (empty($name) || empty($qualification) || empty($salary) || empty($deductions) || empty($TRN) || empty($bank_branch) || empty($BAN)) {
        $error_msg = "All fields are required.";
    } else {
        // Update employee record
        $sql = "UPDATE employees SET name='$name', qualification='$qualification', salary='$salary', deductions='$deductions', TRN='$TRN', bank_branch='$bank_branch', BAN='$BAN' WHERE EIN='$EIN'";
        if (mysqli_query($conn, $sql)) {
            $success_msg = "Record updated successfully.";
        } else {
            $error_msg = "Error updating record: " . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Information</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('DBbackground.Jpeg'); /* Background image path */
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
            background-color: rgba(255, 255, 255, 0.8); /* Light gray background */
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            text-align: center;
        }
        h1 {
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
        .input-group input[readonly] {
            background-color: #f2f2f2;
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
        .error-msg {
            color: #dc3545; /* Red color for error message */
            margin-top: 5px;
        }
        .success-msg {
            color: #28a745; /* Green color for success message */
        }
    </style>
</head>
<body>
    <div class="container">
        <h1>Update Information</h1>
        <form action="updateprocess.php" method="post">
             <div class="input-group">
               <label for="EIN">EIN:</label>
               <input type="text" id="EIN" name="EIN" value="<?php echo isset($EIN) ? $EIN : ''; ?>" readonly>
            </div>
            <div class="input-group">
                <label for="name">Name:</label>
                <input type="text" id="name" name="name" value="<?php echo isset($name) ? $name : ''; ?>">
            </div>
            <div class="input-group">
                <label for="qualification">Qualification:</label>
                <input type="text" id="qualification" name="qualification" value="<?php echo isset($qualification) ? $qualification : ''; ?>">
            </div>
            <div class="input-group">
                <label for="salary">Salary:</label>
                <input type="text" id="salary" name="salary" value="<?php echo isset($salary) ? $salary : ''; ?>">
            </div>
            <div class="input-group">
                <label for="deductions">Deductions:</label>
                <input type="text" id="deductions" name="deductions" value="<?php echo isset($deductions) ? $deductions : ''; ?>">
            </div>
            <div class="input-group">
                <label for="TRN">TRN:</label>
                <input type="text" id="TRN" name="TRN" value="<?php echo isset($TRN) ? $TRN : ''; ?>">
            </div>
            <div class="input-group">
                <label for="bank_branch">Bank Branch:</label>
                <input type="text" id="bank_branch" name="bank_branch" value="<?php echo isset($bank_branch) ? $bank_branch : ''; ?>">
            </div>
            <div class="input-group">
                <label for="BAN">BAN:</label>
                <input type="text" id="BAN" name="BAN" value="<?php echo isset($BAN) ? $BAN : ''; ?>">
            </div>
            <?php if(!empty($error_msg)): ?>
                <p class="error-msg"><?php echo $error_msg; ?></p>
            <?php endif; ?>
            <?php if(!empty($success_msg)): ?>
                <p class="success-msg"><?php echo $success_msg; ?></p>
            <?php endif; ?>
            <div class="input-group">
                <button type="submit" class="button">Update</button>
            </div>
        </form>
    </div>
</body>
</html>
