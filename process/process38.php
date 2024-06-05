<?php
session_start();
require "../connection.php";

$Category = $_POST["CateId"];
$Brand = $_POST["BrdId"];

if(isset($_SESSION["admin"])){
    if((!empty($Category)) && (!empty($Brand))){
            Database::iud("INSERT INTO `category_has_brand`(`category_id`,`brand_id`) VALUES ('".$Category."','".$Brand."');");
            echo "SA1";
    }else{
        echo "Select Fields are Empty !";
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}
?>