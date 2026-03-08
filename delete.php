<?php include_once "menu.html"; ?>

<?php
session_start();
include_once "connection.php";

// Check if session is not verified
if (!isset($_SESSION['verified']) || $_SESSION['verified'] !== true) {
    header("Location: login.php"); // Redirect to login.php if not verified
    exit();
}

// Fetch EIN from the session
if (isset($_SESSION['EIN'])) {
    $EIN = $_SESSION['EIN'];
} else {
    echo "EIN is not set in the session.";
    exit();
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Get EIN from request
    $input_EIN = filter_input(INPUT_POST, 'EIN', FILTER_SANITIZE_STRING);

    if ($input_EIN !== $EIN) {
        $error = "You are not authorized to delete this record.";
    } else {
        // Prepare SQL statement to delete a record
        $sql = "DELETE FROM employees WHERE EIN = ?";

        // Prepare and bind parameters
        $stmt = $conn->prepare($sql);

        if (!$stmt) {
            $error = "Prepare failed: " . $conn->error;
        } else {
            $stmt->bind_param("s", $EIN);

            // Execute the statement
            if ($stmt->execute()) {
                $message = "Record deleted successfully";
                // Redirect to registration page after 2 seconds
                header("refresh:2;url=register.php");
            } else {
                $error = "Record NOT deleted. Try again: " . $stmt->error;
            }

            // Close the statement
            $stmt->close();
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Employee Record</title>
    <style>
        body {
            background-image: url('DBbackground.Jpeg');
            font-family: Arial, sans-serif;
            color: #fff;
        }

        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }

        input[type="text"], input[type="submit"] {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            margin-bottom: 20px;
            background-color: #555;
            color: #fff;
        }

        input[type="submit"] {
            background-color: #007bff;
            cursor: pointer;
            transition: background-color 0.3s ease;
        }

        input[type="submit"]:hover {
            background-color: #0056b3;
        }

        .success {
            background-color: #28a745;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }

        .error {
            background-color: #dc3545;
            color: #fff;
            padding: 10px;
            border-radius: 5px;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
<div class="container">
        <h2>Delete Employee Record</h2>

        <?php if(isset($message)) : ?>
            <div class="success">
                <?php echo $message; ?>
            </div>
        <?php endif; ?>

        <?php if(isset($error)) : ?>
            <div class="error">
                <?php echo $error; ?>
            </div>
        <?php endif; ?>

        <form action="" method="post">
            <label for="EIN">Employee EIN:</label><br>
            <input type="text" id="EIN" name="EIN" placeholder="Enter Your EIN "><br><br>
            <input type="submit" name="delete" value="Delete Record">
        </form>
</div>
</body>
</html>
