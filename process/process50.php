<?php 

session_start();
require "../connection.php";

$orderId = $_POST["orderId"];
$ProductId = $_POST["productId"];
$ProductQty = $_POST["ProductQty"];
$Total = $_POST["Total"];

$d = new DateTime();
$tz = new DateTimeZone("Asia/Colombo");
$d->setTimezone($tz);
$date = $d->format("Y-m-d H:i:s");

if($ProductId == "AllCart" && $ProductQty == "AllCart"){

    $Colombo = 0;
    
    $UserPersonal = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
    $UserData = $UserPersonal->fetch_assoc();
        
        if($UserData["city_id"] == 1){
            $Colombo = 1;
        }
        $CartResult = Database::search("SELECT * FROM `cart` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
        $Cartnum = $CartResult->num_rows;                                                
        for($n = 0; $n<$Cartnum; $n++){

            $CartData = $CartResult->fetch_assoc();
            $ProductResult =  Database::search("SELECT * FROM `product_view` WHERE `id` = '".$CartData["product_id"]."';");
            $ProductData = $ProductResult->fetch_assoc();                                           
            $CartProductModel = Database::search("SELECT * FROM `model` WHERE `id` = '".$ProductData['model_id']."';");
            $CartModelData = $CartProductModel->fetch_assoc();
            if($ProductData["qty"] >= 1){
                $TotalValue;
                $Shipping;
                if($Colombo == 1){
                    $Shipping = $ProductData['delivery_fee_colombo'];
                }else{
                    $Shipping = $ProductData['delivery_fee_other'];
                }
                $TotalValue = ($ProductData['price'] * $CartData["buy_qty"]) + $Shipping;
                Database::iud("INSERT INTO invoice(`order_id`,`product_id`,`buy_qty`,`user_email`,`total`,`datetime_purchased`,`status_level`) VALUES('".$orderId."','".$ProductData['id']."','".$CartData["buy_qty"]."','".$_SESSION["user"]["email"]."','".$TotalValue."','".$date."','1');"); 
                $ProductinDb = Database::search("SELECT * FROM `product` WHERE `id` = '".$ProductData["id"]."';");
                $PdinDb = $ProductinDb->fetch_assoc();
                $newqty = $PdinDb["qty"] - $CartData["buy_qty"];
                if($newqty == 0){
                    Database::iud("UPDATE `product` SET `qty` ='".$newqty."' AND `status_id` = '3' WHERE `id` = '".$ProductData["id"]."';"); 
                }else{
                    Database::iud("UPDATE `product` SET `qty` ='".$newqty."' WHERE `id` = '".$ProductData["id"]."';"); 
                }
            }
        }
        echo "SA1";
}else{
    Database::iud("INSERT INTO invoice(`order_id`,`product_id`,`buy_qty`,`user_email`,`total`,`datetime_purchased`,`status_level`) VALUES('".$orderId."','".$ProductId."','".$ProductQty."','".$_SESSION["user"]["email"]."','".$Total."','".$date."','1');"); 
    $ProductinDb = Database::search("SELECT * FROM `product` WHERE `id` = '".$ProductId."';");
    $PdinDb = $ProductinDb->fetch_assoc();
    $newqty = $PdinDb["qty"] - $ProductQty;
    if($newqty == 0){
        Database::iud("UPDATE `product` SET `qty` ='".$newqty."' AND `status_id` = '3' WHERE `id` = '".$ProductId."';"); 
    }else{
        Database::iud("UPDATE `product` SET `qty` ='".$newqty."' WHERE `id` = '".$ProductId."';"); 
    }
    echo "SA1";
}