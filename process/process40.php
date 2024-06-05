<?php
session_start();
require "../connection.php";

if(isset($_SESSION["admin"])){

    $AdminEmail = "imeshdilshan2423@gmail.com";
    $Email = $_POST["Email"];
    Database::iud("UPDATE `chat` SET `status` = '2' WHERE `from` = '".$Email."' AND `to` = '".$AdminEmail."';");
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}

?>