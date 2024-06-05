<?php
session_start();
require "../connection.php";

$email = $_POST["Email"];

if(isset($_SESSION["admin"])){
    if(!empty($email)){
        $User = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."';");
        $UserData = $User->fetch_assoc();
        if($UserData["user_status_id"] == 1){
            Database::iud("UPDATE `user` SET `user_status_id` = '2'  WHERE `email` = '".$email."';");
            echo "Process Success !";
        }elseif($UserData["user_status_id"] == 2){
            Database::iud("UPDATE `user` SET `user_status_id` = '1'  WHERE `email` = '".$email."';");
            echo "Process Success !";
        }else{
            echo "Something went wrong! Check this Error";
        }
    }else{
        echo "User Not Found !";
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}
?>