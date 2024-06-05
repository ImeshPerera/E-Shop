<?php

session_start();
require "../connection.php";

$ProductId = $_POST["ProductId"];
if(isset($_SESSION["user"])){
    
    $Wishlistresult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$ProductId."';");
    $WishlistNum = $Wishlistresult->num_rows;
    $wish = $Wishlistresult->fetch_assoc();

    if($WishlistNum == 0){
        echo "Your Product is Not in the Wishlist.";
    }elseif($WishlistNum == 1){
        Database::iud("DELETE FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$wish["product_id"]."';");
        Database::iud("INSERT INTO `recent`(`user_email`,`product_id`) VALUES ('".$_SESSION["user"]['email']."','".$wish["product_id"]."');");
        echo "SA1";
    }else{
        echo "Your Request Cannot to Proceed.";
    }
}else{
    echo "Please Sign In To Do this.";
}