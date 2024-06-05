<?php

session_start();
require "../connection.php";

$Productid = $_POST["Productid"];
if($Productid == 0){
    Database::iud("UPDATE `invoice` SET `status_level` = '2' WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
}else{
    Database::iud("UPDATE `invoice` SET `status_level` = '2' WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `product_id` = '".$Productid."';");
}