<?php
include('db.php');
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendemail_verification($name, $email, $verify_token)
{
    $mail = new PHPMailer(true);
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';        
        $mail->SMTPAuth   = true;
        $mail->Username   = 'ar5587995@gmail.com';
        $mail->Password   = 'yjmo dctg alvg nhto';      
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS; 
        $mail->Port       = 587;                          
   
        $mail->setFrom('ar5587995@gmail.com', 'MD MAHIN ISLAM');
        $mail->addAddress($email);

        $mail->isHTML(true);
        $mail->Subject = 'Email Verification for Your Account';
        $mail->Body    = "<h2>Hello $name,</h2>
                          <p>You have registered with us. Please click the link below to verify your email address.</p>
                          <a href='http://localhost/my_website/verify-email.php?token=$verify_token'>Verify Now</a>";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        
        // echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
        return false;
    }
}
if(isset($_POST['register_btn']))
{
    $name  = mysqli_real_escape_string($con, $_POST['name']);
    $phone = mysqli_real_escape_string($con, $_POST['phone']);
    $email = mysqli_real_escape_string($con, $_POST['email']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $verify_token = bin2hex(random_bytes(16)); // More secure than md5(rand())

    // 1. Check if email exists using Prepared Statements
    $check_email = "SELECT email FROM users WHERE email=? LIMIT 1";
    $stmt = mysqli_prepare($con, $check_email);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    mysqli_stmt_store_result($stmt);

    if(mysqli_stmt_num_rows($stmt) > 0)
    {
        $_SESSION['status'] = "Email Already Exists";
        header("Location: register.php");
        exit(0);
    }
    else
    {
        // 2. Insert User
        $query = "INSERT INTO users (name, phone, email, password, verify_token) VALUES (?, ?, ?, ?, ?)";
        $stmt = mysqli_prepare($con, $query);
        mysqli_stmt_bind_param($stmt, "sssss", $name, $phone, $email, $password, $verify_token);
        
        if(mysqli_stmt_execute($stmt))
        {
            sendemail_verification($name, $email, $verify_token);
            $_SESSION['status'] = "Registration successful! Check your email.";
            header("Location: register.php");
        }
        else
        {
            $_SESSION['status'] = "Registration Failed";
            header("Location: register.php");
        }
    }
}
?>
