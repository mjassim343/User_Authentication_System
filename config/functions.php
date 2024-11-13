<?php

require 'vendor/autoload.php'; // PHPMailer
use PHPMailer\PHPMailer\PHPMailer;

function sanitize($input){
    return htmlspecialchars(trim($input));
}

function generate_token(){
    return bin2hex(random_bytes(16));
}

function generate_csrf_token(){
    if (empty($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }
    return $_SESSION['csrf_token'];
}

function verify_csrf_token($token){
    if($_SESSION['csrf_token'] === $token){
        return true;
    }
}

function send_verification_email($email, $token){
    // Load email credentials
    $emailConfig = require 'config/email.php';

    $mail = new PHPMailer();
    $mail->isSMTP();
    $mail->Host = $emailConfig['host'];  // SMTP host
    $mail->SMTPAuth = true;
    $mail->Username = $emailConfig['username'];  // SMTP username
    $mail->Password = $emailConfig['password'];  // SMTP password
    $mail->SMTPSecure = $emailConfig['encryption'];  // SMTP secure
    $mail->Port = $emailConfig['port'];   // SMTP port
    $mail->setFrom($emailConfig['from_email'], $emailConfig['from_name']);  // From address
    
    $mail->addAddress($email);  // To address
    $mail->Subject = 'Verify your email address';  // Mail Subject
    $verification_link = "http://".BASE_URL."/".BASE_PATH."/verify_email.php?token=$token"; // Verification link
    $mail->Body = "Click this link to verify your email: $verification_link";  // Body message
    if($mail->send()){
        return true;  // Email sent successfully
    }
    else{
        return false;  // Failed to send email
    }
}

?>