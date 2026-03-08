<?php include_once "menu.html"; ?>
  
<?php
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
require 'settings.php';
include_once "connection.php";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $Ein_Pswd = $_POST["Ein_Pswd"];
    $userMessage = $_POST["message"]; // Get custom message from form

    $employeeDetails = generateEmailBody($Ein_Pswd); // HTML string with employee info

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = MAILHOST;
        $mail->SMTPAuth = true;
        $mail->Username = USERNAME;
        $mail->Password = PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Disable SSL certificate verification (optional, for testing)
        $mail->SMTPOptions = array(
            'ssl' => array(
                'verify_peer' => false,
                'verify_peer_name' => false,
                'allow_self_signed' => true
            )
        );

        $mail->setFrom(USERNAME, SEND_FROM_NAME);
        $mail->addAddress($to);
        $mail->addReplyTo(REPLY_TO, REPLY_TO_NAME);

        // Build email body: employee details + custom message
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body = "<div style='background-color: #444; color: #fff; padding: 20px; border-radius: 5px;'>";
        $mail->Body .= $employeeDetails;                       // Employee info first
        $mail->Body .= "<hr>";                                 // Separator
        $mail->Body .= "<p><strong>Your message:</strong></p>";
        $mail->Body .= "<p>" . nl2br(htmlspecialchars($userMessage)) . "</p>"; // Custom message, escaped
        $mail->Body .= "</div>";

        $mail->send();
        echo "<div class='message success'>Message sent successfully</div>";
    } catch (Exception $e) {
        echo "<div class='message error'>Message could not be sent. Mailer Error: {$mail->ErrorInfo}</div>";
    }
}

// Function to generate email body with user's credentials
function generateEmailBody($Ein_Pswd) {
    global $conn;
    // Use prepared statement to prevent SQL injection
    $stmt = $conn->prepare("SELECT * FROM employees WHERE EIN = ?");
    $stmt->bind_param("s", $Ein_Pswd);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $body = "<p><strong>Name:</strong> " . htmlspecialchars($row["name"]) . "</p>";
        $body .= "<p><strong>TRN:</strong> " . htmlspecialchars($row["TRN"]) . "</p>";
        $body .= "<p><strong>Qualifications:</strong> " . htmlspecialchars($row["qualification"]) . "</p>";
        $body .= "<p><strong>Salary:</strong> $" . htmlspecialchars($row["salary"]) . "</p>";
        $body .= "<p><strong>Deductions:</strong> $" . htmlspecialchars($row["deductions"]) . "</p>";
        $body .= "<p><strong>Bank Branch:</strong> " . htmlspecialchars($row["bank_branch"]) . "</p>";
        $body .= "<p><strong>BAN:</strong> " . htmlspecialchars($row["BAN"]) . "</p>";
        return $body;
    } else {
        return "<div class='message error'>Invalid EIN</div>";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Sending Email Using PHP</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #222;
            color: #fff;
            margin: 0;
            padding: 0;
        }

        form {
            width: 50%;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
            background-color: #333;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }

        label,
        input[type="email"],
        input[type="text"],
        textarea {
            display: block;
            width: 100%;
            padding: 10px;
            margin: 5px 0;
            border: 1px solid #555;
            border-radius: 5px;
            box-sizing: border-box;
            background-color: #444;
            color: #fff;
        }

        textarea {
            height: 150px;
        }

        input[type="submit"] {
            width: 100%;
            background-color: #4CAF50;
            color: white;
            padding: 14px 20px;
            margin: 8px 0;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #45a049;
        }

        .message {
            width: 50%;
            margin: 20px auto;
            padding: 10px;
            border-radius: 5px;
            text-align: center;
        }

        .success {
            background-color: #4CAF50;
        }

        .error {
            background-color: #f44336;
        }
    </style>
</head>
<body>
<form method="post" action="">
    <label for="Ein_Pswd">Enter EIN:</label>
    <input type="text" name="Ein_Pswd" id="Ein_Pswd" required placeholder="Enter Your Ein">
    <br>
    <label for="to">Please enter the email address</label>
    <input type="email" name="to" placeholder="recipient@example.com" required>
    <label for="subject">Kindly enter the subject</label>
    <input type="text" name="subject" placeholder="Requesting all information" required>
    <label for="message">Kindly enter your message (will appear after employee details)</label>
    <textarea name="message" id="message" placeholder=""></textarea>
    <input type="submit" value="Send">
</form>

</body>
</html>