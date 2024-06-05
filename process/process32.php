<?php
session_start();
require "../connection.php";

$productid = $_POST["Product"];

if(isset($_SESSION["admin"])){
    if(!empty($productid)){
        $Product = Database::search("SELECT * FROM `product` WHERE `id` = '".$productid."';");
        $ProductData = $Product->fetch_assoc();
        if($ProductData["status_id"] == 4){
            Database::iud("UPDATE `product` SET `status_id` = '1'  WHERE `id` = '".$productid."';");
            echo "Process Success !";
        }elseif($ProductData["status_id"] < 5){
            Database::iud("UPDATE `product` SET `status_id` = '4'  WHERE `id` = '".$productid."';");
            echo "Process Success !";
        }else{
            echo "Product Not Found ! Deleted";
        }
    }else{
        echo "Product Not Found !";
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}
?>