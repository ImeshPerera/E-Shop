<?php
session_start();
require "../connection.php";

$Type = $_POST["Type"];
$Name = $_POST["Name"];

if(isset($_SESSION["admin"])){
    if(!empty($Name)){
        if($Type == "Category"){
            Database::iud("INSERT INTO `category`(`name`) VALUES ('".$Name."');");
            echo "SA1";
        }elseif($Type == "Brand"){
            Database::iud("INSERT INTO `brand`(`name`) VALUES ('".$Name."');");
            echo "SA1";
        }elseif($Type == "Color"){
            Database::iud("INSERT INTO `color`(`name`) VALUES ('".$Name."');");
            echo "SA1";
        }else{
            echo "Error With Uploading Area !";
        }
    }else{
        echo "Input Field is Empty !";
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}
?>