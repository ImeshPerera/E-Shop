<?php

session_start();
require "../connection.php";

$UserEmail = $_SESSION["user"]["email"];

if(isset($_FILES["UserImage"])){
    if($_FILES["UserImage"] != ""){
        $allowed_img_extension = array("image/jpg","image/jpeg","image/png","image/svg");
        $filex = $_FILES["UserImage"]["type"];
        if(in_array($filex,$allowed_img_extension)){
            $file = $_FILES["UserImage"]["name"];
            $Imagetemp = $_FILES["UserImage"]["tmp_name"];
            $today = microtime(true);
            $Imagename = "User_img//$today.$file";
            $ImageLocation = "../".$Imagename;
            move_uploaded_file($Imagetemp,$ImageLocation);
            $ImageCheck = Database::search("SELECT `user_code` FROM user_image WHERE `user_email` = '".$UserEmail."';");
            if($ImageCheck->num_rows == 1){
                Database::iud("UPDATE user_image SET  `user_code` = '".$Imagename."' WHERE `user_email` = '".$UserEmail."';");
                $imageCode = $ImageCheck->fetch_assoc();
                unlink($imageCode["user_code"]);
                echo "SA1";
            }else{
                Database::iud("INSERT INTO user_image(`user_email`,`user_code`) VALUES ('".$UserEmail."','".$Imagename."');");
                echo "SA1";
                }
        }else{
            echo "Your Image must be jpg / jpeg / png or svg ";
        }
    }else{
        echo "Upload Image for your Profile";
    }
}if(!isset($_FILES["UserImage"])){
    echo "Your User Image is Empty";
}

?>
