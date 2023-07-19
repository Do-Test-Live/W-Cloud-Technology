<?php
require 'PHPMailer.php';
require 'SMTP.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$mail = new PHPMailer();

date_default_timezone_set("Asia/Hong_Kong");
require_once("include/dbController.php");
$db_handle = new DBController();
$today = date("F d, Y");
$inserted_at = date("Y-m-d H:i:s");


$name = $db_handle->checkValue($_POST['name']);
$telephone = $db_handle->checkValue($_POST['telephone']);
$email = $db_handle->checkValue($_POST['email']);
$message = $db_handle->checkValue($_POST['message']);

$insert_query = $db_handle->insertQuery("INSERT INTO `contact`(`name`, `telephone`, `email`, `message`, `inserted_at`) VALUES ('$name','$telephone','$email','$message','$inserted_at')");

if($insert_query){
    $email_to = 'cloud@cthlnet.com';
    $mail->isSMTP();
    $mail->Host = 'mail.ngt.hk';  // Specify your SMTP server
    $mail->SMTPAuth = true;
    $mail->Username = 'notice@ngt.hk';
    $mail->Password = '3@d2-5)|_~^1';
    $mail->Port = 465;  // Specify the SMTP port
    $mail->SMTPSecure = 'ssl';  // Enable encryption, 'ssl' also possible

    // Email content
    $mail->setFrom('notice@ngt.hk', 'Cloud Technology');
    $mail->addAddress($email_to);  // Add recipient email
    $mail->Subject = 'New Contact Information';
    $mail->isHTML(true);
    $mail->Body = "
            <html>
                <body style='background-color: #eee; font-size: 16px;'>
                <div style='max-width: 600px; min-width: 200px; background-color: #ffffff; padding: 20px; margin: auto;'>
                
                    <p style='text-align: center;color:green;font-weight:bold'>New contact data arrived!</p>
                    <p style='text-align: center;color:black;font-weight:bold'>Name: $name</p>
                    <p style='text-align: center;color:black;font-weight:bold'>Telephone: $telephone</p>
                    <p style='text-align: center;color:black;font-weight:bold'>Email: $email</p>
                    <p style='text-align: center;color:black;font-weight:bold'>Message: $message</p>
                    <p style='text-align: center;color:black;font-weight:bold'>Time: $today</p>
                </div>
                </body>
            </html>";

    // Send the email
    if ($mail->send()) {
        echo "<script>
                alert('Your data is submitted successfully!');
                window.location.href='index.html';
                </script>";
    } else {
        echo "<script>
                alert('Sorry something went wrong!');
                window.location.href='index.html';
                </script>";
    }
} else{
    echo "<script>
                alert('Sorry something went wrong!');
                window.location.href='index.html';
                </script>";
}

