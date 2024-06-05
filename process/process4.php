<?php

require "../connection.php";
    
    $email = $_POST["email4"];
    $password1 = $_POST["pass1"];
    $password2 = $_POST["pass2"];
    $vcode = $_POST["vcode"];
    
if(empty($email)){
    echo "Missing Email Address";
}elseif(empty($password1)){
    echo "Please Enter Your New Password";
}elseif(strlen($password1) < 5 || strlen($password1) > 20){
    echo "Password length must between 5 to 20";
}elseif(empty($password2)){
    echo "Please Re-type your New Password";
}elseif($password1 != $password2){
    echo "Password and Re-type password does not match";
}elseif(empty($vcode)){
    echo "Please enter your Verification Code";
}else{
    $result = Database::search("SELECT * FROM user WHERE `email` = '".$email."' AND `verification_code` = '".$vcode."';");

    if($result->num_rows == 1){
        $resultset = Database::iud("UPDATE user SET `password` = '".$password1."' WHERE `email` = '".$email."';");
        echo "Success";
    }else{
        echo "Verification Code does not matched";
    }
}