<?php
session_start();
include_once "connection.php";

if (!isset($_SESSION['attempts'])) {
    $_SESSION['attempts'] = 0;
}

$error_msg = ""; // Initialize error message
$success_msg = ""; // Initialize success message
$show_links = false; // Initialize flag to show links

if ($_SERVER["REQUEST_METHOD"] == "POST")  { 
     $Uname = $_POST["Uname"];
    $Ein_Pswd = $_POST["Ein_Pswd"]; 
    $Dbasename = $_POST["Dbasename"];
    
    $_SESSION['attempts']++; // Increment attempts count
    
    if($_SESSION['attempts'] > 3) {
        session_destroy();
        $error_msg = "You have exceeded the maximum number of attempts. Please try again later.";
        $show_links = true; // Show links if attempts exceeded
    } else {
        // Check if the provided database name is correct
        if ($Dbasename !== 'AWH_salaries') {
            $error_msg = "Incorrect database name. Please try again with the correct database name. You have ".$_SESSION['attempts']."/3 attempts left.";
        } else {
            // Check if the provided username exists in the employees table
            $sql = "SELECT * FROM employees WHERE name = '$Uname'";
            $result = mysqli_query($conn, $sql);
            
            if (mysqli_num_rows($result) > 0) {
                $row = mysqli_fetch_assoc($result);
                $db_ein = $row["EIN"];
                
                if ($Ein_Pswd == $db_ein) { 
                    $_SESSION['verified'] = true; 
                    $_SESSION['EIN'] = $db_ein; // Set the EIN session variable
                    $success_msg = "You have successfully verified yourself. You are being redirected...";
                    header("refresh:2;url=dashboard.php");
                } else {
                    $error_msg = "Invalid EIN. You have ".$_SESSION['attempts']."/3 attempts left.";
                }
            } else {
                $error_msg = "User does not exist. You have ".$_SESSION['attempts']."/3 attempts left.";
            }
        }
    }
}

// Save session data
session_write_close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('loginbg.jpg'); /* Background image path */
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }
        .container {
            width: 400px;
            padding: 20px;
            background-color: #f8f9fa;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            position: relative;
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
            background-color: #007bff;
            color: #fff;
            border: none;
            border-radius: 5px;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }
        .button:hover {
            background-color: #0056b3;
        }
        .error-message, .success-message {
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 10px;
            text-align: center;
        }
        .error-message {
            background-color: #dc3545; /* Red background */
        }
        .success-message {
            background-color: #28a745; /* Green background */
        }
        .links {
            text-align: center;
            margin-top: 10px;
        }
        .links a {
            color: #007bff;
            text-decoration: none;
            margin: 0 10px;
        }
        .welcome-container {
            width: 400px;
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            padding: 20px;
            background-color: #f8f9fa; 
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            margin-bottom: 20px;
            text-align: center;
        }
        .welcome-message {
            font-size: 24px;
            margin-bottom: 20px;
        }
        .login-heading {
            text-align: center;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="welcome-container">
    <div class="welcome-message">Welcome to AW & H</div>
</div>
<div class="container">
    <h2 class="login-heading">Login</h2>
    <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
        <div class="input-group">
            <label for="Uname">Name</label>
            <input type="text" id="Uname" name="Uname" required>
        </div>
        <div class="input-group">
            <label for="Ein_Pswd">EIN</label>
            <input type="text" id="Ein_Pswd" name="Ein_Pswd" required>
        </div>
        <div class="input-group">
            <label for="Dbasename">Database Name</label>
            <input type="text" id="Dbasename" name="Dbasename" required>
        </div>
        <button type="submit" class="button">Login</button>
        <?php
            if($error_msg) {
                echo '<div class="error-message">' . $error_msg . '</div>';
            }
            if($success_msg) {
                echo '<div class="success-message">' . $success_msg . '</div>';
            }
        ?>
        <?php if ($show_links) { ?>
            <div class="links">
                <a href="index.php">Home</a>
                <a href="register.php">Register</a>
            </div>
        <?php } ?>
    </form>
</div>
