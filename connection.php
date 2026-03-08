<?php
// =============================================
// DATABASE CONNECTION - UPDATE WITH YOUR CREDENTIALS
// =============================================
$servername = "localhost";          // Usually localhost
$db_username = "root";              // Your MySQL username
$db_password = "";                  // Your MySQL password (empty in XAMPP by default)
$db_name = "AWH_salaries";          // Database name

$conn = mysqli_connect($servername, $db_username, $db_password, $db_name);
if (!$conn) {
    die("Connection failed: " . mysqli_connect_error());
}
?>