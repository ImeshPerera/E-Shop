<?php

require "../connection.php";
use PHPMailer\PHPMailer\PHPMailer; 
 
require 'Exception.php'; 
require 'PHPMailer.php'; 
require 'SMTP.php'; 

if(isset($_GET["e"])){
    $email = $_GET["e"];

    if(empty($email)){
        echo "Please enter your email address";
    }else{
        $rs = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."';");

        if($rs->num_rows == 1){
            $code = uniqid();
            Database::iud("UPDATE `user` SET `verification_code` = '".$code."' WHERE `email` = '".$email."';");
            $mail = new PHPMailer; 
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true; 
            $mail->Username = '#Yourmail@gmail.com'; 
            $mail->Password = '#Your Password';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('#Yourmail@gmail.com', 'e-Shop'); 
            $mail->addReplyTo('#Yourmail@gmail.com', 'e-Shop'); 
            $mail->addAddress($email); 
            $mail->isHTML(true); 
            $mail->Subject = 'eShop Verification Code For Reset Password '; 
            $bodyContent = '<h1 style="color:red;">Your Verification Code : '.$code.'</h1>';
            $mail->Body    = $bodyContent; 
            
            if(!$mail->send()) { 
                echo 'Message could not be sent. Mailer Error: '.$mail->ErrorInfo; 
            } else { 
                echo 'Message has been sent.'; 
            }             
        }else{
            echo "Email address not found";
        }
    }
}else{
    echo "Please enter your email address";
}
