<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/Exception.php';
require 'PHPMailer/PHPMailer.php';
require 'PHPMailer/SMTP.php';

if (isset($_POST["send"])) {
    $to = $_POST["to"];
    $subject = $_POST["subject"];
    $message = $_POST["message"];
    $from = $_POST["from"];
    $name = $_POST["name"];

    if (!(filter_var($to, FILTER_VALIDATE_EMAIL) && filter_var($from, FILTER_VALIDATE_EMAIL))) {
        echo "Email address inputs invalid";
        die();
    }

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp-relay.brevo.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'x@gmail.com';
        $mail->Password = 'PUThdkzgvA23Lsb';
        $mail->SMTPSecure = 'tls';
        $mail->Port = 587;

        $mail->setFrom($from, $name);
        $mail->addAddress($to);

        $mail->Subject = $subject;
        $mail->Body = $message;

        $mail->send();
        echo "Email sent.";
    } catch (Exception $e) {
        echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
    }
} else {
    echo '
    <html>
        <head>
            <style> 
                input[type=submit] {
                    background-color: #4CAF50;
                    border: none;
                    color: white;
                    padding: 14px 32px;
                    text-decoration: none;
                    margin: 4px 2px;
                    cursor: pointer;
                    font-size: 16px;
                }
            </style>
        </head>
        <body>

            <h2>Spoof Email</h2>

            <form action="/send.php" method="post" id="emailform">
                <label for="to">To:</label><br>
                <input type="text" id="to" name="to"><br><br>
                <label for="from">From:</label><br>
                <input type="text" id="from" name="from"><br><br>
                <label for="name">Name (optional):</label><br>
                <input type="text" id="name" name="name"><br><br>
                <label for="subject">Subject:</label><br>
                <input type="text" id="subject" name="subject"><br><br>
                <label for="message">Message [HTML is supported]:</label><br>
                <textarea rows="6" cols="50" name="message" form="emailform"></textarea><br><br>
                <input type="hidden" id="send" name="send" value="true">
                <input type="submit" value="Submit">
            </form> 

            <p>An e-mail will be sent to the desired target with a spoofed From header when you click Submit.</p>

        </body>
    </html>';
}
?>
