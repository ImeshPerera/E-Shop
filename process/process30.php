<?php
session_start();
require "../connection.php";
    
    $email = $_POST["AdminEmail"];
    $vcode = $_POST["VerifyId"];
    $RememberId = $_POST["RememberId"];

    if(empty($email)){
    echo "Missing Email Address";
    }elseif(empty($vcode)){
        echo "Please enter your Verification Code";
    }else{
        $result = Database::search("SELECT * FROM `admin` WHERE `email` = '".$email."' AND `verify` = '".$vcode."';");

        if($result->num_rows == 1){
            if($RememberId == 1){
                setcookie("admin",$email,time()+(60*60*24*365),"/");
            }else{
                setcookie("admin","",-1,"/");
            }
            $_SESSION["admin"] = $email;
            echo "SA1";
        }else{
            echo "Verification Code does not matched";
        }
    }

?>