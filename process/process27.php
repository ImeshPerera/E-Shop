<?php

session_start();
require "../connection.php";

$ProdId = $_POST["Feedbackid"];
$Feedback = $_POST["Feedback"];
$DatePurchased = $_POST["DatePurchased"];
$datedata = new DateTime();
$timeZone = new DateTimeZone("Asia/Colombo");
$datedata->setTimezone($timeZone);
$dateadded = $datedata->format("Y-m-d H:i:s");

$BuyProduct = Database::search("SELECT * FROM `invoice` WHERE `product_id` = '".$ProdId."' AND `user_email` = '".$_SESSION["user"]["email"]."' AND `datetime_purchased` = '".$DatePurchased."';");
$BuyNum = $BuyProduct->num_rows;

if($BuyNum == 1){
    Database::iud("INSERT INTO `feedback`(`user_email`,`product_id`,`feedback_msg`,`datetime_add`) VALUES('".$_SESSION["user"]["email"]."','".$ProdId."','".$Feedback."','".$dateadded."');");
    echo "SA1";
}else{
    echo "ER1";
}