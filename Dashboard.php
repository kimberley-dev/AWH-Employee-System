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

    // Close the database connection
    mysqli_close($conn);
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
    <title>Dashboard</title>
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
            max-width: 800px;
            margin: 100px auto;
            padding: 20px;
            background-color: rgba(0, 0, 0, 0.8); /* Dark gray background */
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
            text-align: center;
            color: #fff; /* White text */
        }
        h1 {
            margin-bottom: 20px;
            color: #f2f2f2; /* Light gray text */
        }
        table {
            width: 100%;
            margin-bottom: 20px;
            border-collapse: collapse;
            background-color: #333; /* Dark gray background */
            color: #fff; /* White text */
        }
        th, td {
            padding: 10px;
            border-bottom: 1px solid #ddd;
            border-right: 1px solid #ddd; /* Add border to the right of each cell */
        }
        th {
            background-color: #666; /* Medium gray background */
        }
        th:last-child,
        td:last-child {
            border-right: none; /* Remove border from the right of the last column */
        }
       
    </style>
</head>
<body>
<div class="container">
    <h1>Welcome , <?php echo $name; ?></h1>
    <table>
        <tr>
            <th>EIN</th>
            <td><?php echo $EIN; ?></td>
        </tr>
        <tr>
            <th>Name</th>
            <td><?php echo $name; ?></td>
        </tr>
        <tr>
            <th>Qualification</th>
            <td><?php echo $qualification; ?></td>
        </tr>
        <tr>
            <th>Salary</th>
            <td><?php echo $salary; ?></td>
        </tr>
        <tr>
            <th>Deductions</th>
            <td><?php echo $deductions; ?></td>
        </tr>
        <tr>
            <th>TRN</th>
            <td><?php echo $TRN; ?></td>
        </tr>
        <tr>
            <th>Bank Branch</th>
            <td><?php echo $bank_branch; ?></td>
        </tr>
        <tr>
            <th>BAN</th>
            <td><?php echo $BAN; ?></td>
        </tr>
    </table>
</div>
</body>
</html>
