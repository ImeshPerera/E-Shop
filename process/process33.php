<?php

session_start();
require "../connection.php";

if(isset($_SESSION["user"])){

    $sender = $_SESSION["user"]["email"];
    $receiver = $_POST["receiver"];
    $msg = $_POST["massage"];
    if($receiver == "admin"){
        $receiver = "imeshdilshan2423@gmail.com";
    }
    
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if(empty($msg)){
        echo "Please enter a message to send";
    }else{
        Database::iud("INSERT INTO `chat` (`from`,`to`,`content`,`datetime_msg`,`status`) VALUES ('".$sender."','".$receiver."','".$msg."','".$date."','1')");
        echo "success";
    }

}elseif(isset($_SESSION["admin"])){

    $sender = "imeshdilshan2423@gmail.com";
    $receiver = $_POST["receiver"];
    $msg = $_POST["massage"];
    
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");

    if(empty($msg)){
        echo "Please enter a message to send";
    }else{
        Database::iud("INSERT INTO `chat` (`from`,`to`,`content`,`datetime_msg`,`status`) VALUES ('".$sender."','".$receiver."','".$msg."','".$date."','1')");
        echo "success";
    }

}

?>