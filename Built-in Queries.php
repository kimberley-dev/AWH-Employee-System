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

    // Fetch employee information from the database
    $sql = "SELECT * FROM employees WHERE EIN = '$EIN'";
    $result = mysqli_query($conn, $sql);

    // Initialize variables
    $name = "";
    $qualification = "";
    $salary = "";
    $deductions = "";
    $TRN = "";
    $bank_branch = "";
    $BAN = "";

    if (mysqli_num_rows($result) > 0) {
        $row = mysqli_fetch_assoc($result);
        $name = $row['name'];
        $qualification = $row['qualification'];
        $salary = $row['salary'];
        $deductions = $row['deductions'];
        $TRN = $row['TRN'];
        $bank_branch = $row['bank_branch'];
        $BAN = $row['BAN'];
    } else {
        echo "0 results";
    }

    // Function to calculate net pay
    function calculateNetPay($salary, $deductions) {
        return $salary - $deductions;
    }

} else {
    echo "EIN is not set in the session.";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Built-in Queries</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-image: url('DBbackground.Jpeg'); /* Background image path */
            margin: 0;
            padding: 0;
        }
        .container {
            max-width: 800px;
            margin: 50px auto;
            padding: 20px;
            background-color: #333;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            color: #fff;
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        .query-form {
            margin-bottom: 20px;
        }
        label {
            display: block;
            margin-bottom: 10px;
            font-weight: bold;
        }
        select {
            width: 100%;
            padding: 10px;
            border-radius: 5px;
            border: none;
            background-color: #555;
            color: #fff;
            font-size: 16px;
            margin-bottom: 20px;
        }
        button {
            background-color: #007bff;
            color: #fff;
            border: none;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            font-size: 16px;
            transition: background-color 0.3s ease;
        }
        button:hover {
            background-color: #0056b3;
        }
        .query-result {
            margin-bottom: 30px;
            background-color: #555;
            padding: 10px;
            border-radius: 5px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
        }
        td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
            color: #000;
        }
        th {
            background-color: #f2f2f2;
            color: #000;
            padding: 8px;
            text-align: left;
        }
        h3 {
            color: #fff;
        }
    </style>
</head>
<body>
    
<div class="container">
    <h2>Built-in Queries</h2>
    
    <!-- Form to select queries -->
    <form class="query-form" method="post">
        <label for="query">Select a query:</label>
        <select id="query" name="query">
            <option value="BAN">Show the current BAN</option>
            <option value="bank_branch">Bank Branch</option>
            <option value="net_pay">Total monies to be received for net pay</option>
            <option value="highest_qualification">Show the current highest qualification</option>
        </select>
        <button type="submit">Execute</button>
    </form>
    <!-- PHP code to execute selected query -->
    <?php
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['query'])) {
        $query = $_POST['query'];

        include_once "connection.php"; // Re-establish database connection

        switch ($query) {
            case 'BAN':
                $sql = "SELECT BAN FROM employees WHERE EIN = '$EIN'";
                break;
            case 'bank_branch':
                $sql = "SELECT bank_branch FROM employees WHERE EIN = '$EIN'";
                break;
            case 'net_pay':
                $netPay = calculateNetPay($salary, $deductions);
                break;
            case 'highest_qualification':
                $sql = "SELECT MAX(qualification) AS highest_qualification FROM employees WHERE EIN = '$EIN'";
                break;
            default:
                echo "Invalid query";
                break;
        }

        if (isset($sql)) {
            $result = mysqli_query($conn, $sql);
            if ($result) {
                if ($query == "net_pay") {
                    echo "<div class='query-result'><h3>Total monies to be received for net pay</h3><table><tr><td>$netPay</td></tr></table></div>";
                } else {
                    $row = mysqli_fetch_assoc($result);
                    echo "<div class='query-result'><h3>$query</h3><table><tr><td>{$row[$query]}</td></tr></table></div>";
                }
            } else {
                echo "Error executing query: " . mysqli_error($conn);
            }
        }
    }
    ?>
</div>
</body>
</html>
