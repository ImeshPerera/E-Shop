<?php

require "../connection.php";
use PHPMailer\PHPMailer\PHPMailer; 
 
require 'Exception.php'; 
require 'PHPMailer.php'; 
require 'SMTP.php'; 

if(isset($_POST["AdminEmail"])){
    $email = $_POST["AdminEmail"];

    if(empty($email)){
        echo "Please enter your email address";
    }else{
        $rs = Database::search("SELECT * FROM `admin` WHERE `email` = '".$email."';");

        if($rs->num_rows == 1){
            $code = uniqid();
            Database::iud("UPDATE `admin` SET `verify` = '".$code."' WHERE `email` = '".$email."';");
            $mail = new PHPMailer; 
            $mail->IsSMTP();
            $mail->Host = 'smtp.gmail.com'; 
            $mail->SMTPAuth = true; 
            $mail->Username = 'education.imeshdilshan@gmail.com'; 
            $mail->Password = 'Dilshan@1234';
            $mail->SMTPSecure = 'ssl';
            $mail->Port = 465;
            $mail->setFrom('education.imeshdilshan@gmail.com', 'e-Shop'); 
            $mail->addReplyTo('education.imeshdilshan@gmail.com', 'e-Shop'); 
            $mail->addAddress($email); 
            $mail->isHTML(true); 
            $mail->Subject = 'eShop Verification Code For Admin Log In '; 
            $bodyContent = '<h1 style="color:red;">Admin Log In Verification Code : '.$code.'</h1>';
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
?>