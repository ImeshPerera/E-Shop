<?php
session_start();
require "../connection.php";

if(isset($_SESSION["user"])){
    $Recent = $_POST["Recent"];
    Database::iud("DELETE FROM `recent` WHERE `product_id` = '".$Recent."' AND `user_email` = '".$_SESSION["user"]["email"]."';");
}

?>