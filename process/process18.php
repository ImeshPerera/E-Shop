<?php
session_start();
require "../connection.php";

$ProductId = $_POST["ProductId"];
$BuyQty = $_POST["BuyQty"];

if(isset($_SESSION["user"])){
    $Cartlistresult = Database::search("SELECT * FROM `cart` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$ProductId."';");
    $CartlistNum = $Cartlistresult->num_rows;
    $cartdata = $Cartlistresult->fetch_assoc();
    $ProdQty = Database::search("SELECT `qty` FROM `product` WHERE `id` = '".$ProductId."';");
    $qtydata = $ProdQty->fetch_assoc();
    
    if($CartlistNum == 0){
        if($qtydata["qty"] >= $BuyQty){
        Database::iud("INSERT INTO `cart`(`user_email`,`product_id`) VALUES ('".$_SESSION["user"]['email']."','".$ProductId."');");
        echo "SA1" ;
        }else{
            echo "Request was rejected due to quantity.";
        }
    }elseif($CartlistNum == 1){
        if($cartdata["buy_qty"] == $BuyQty){
            echo "You Already Added This Product To Cart";
        }else{
            if($qtydata["qty"] >= $BuyQty){
                Database::iud("UPDATE `cart` SET `buy_qty` = '".$BuyQty."' WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$ProductId."';");
                echo "SA1" ;
            }else{
                echo "Request was rejected due to quantity.";
            }
        }
    }else{
        echo "Your Request Cannot to Proceed.";
    }
}else{
    echo "ER1";
}
?>