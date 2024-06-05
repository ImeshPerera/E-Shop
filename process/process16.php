<?php

session_start();
require "../connection.php";

if(isset($_SESSION["user"])){

    $ProductId = $_POST["ProductId"];
    $resultset = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$ProductId."';");
    $num = $resultset->num_rows;

    if($num == 1){
        Database::iud("DELETE FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `product_id` = '".$ProductId."';");
        echo "DE1";
    }elseif($num == 0){
        Database::iud("INSERT INTO `watchlist`(`user_email`,`product_id`) VALUES ('".$_SESSION["user"]["email"]."','".$ProductId."');");
        echo "SA1";
    }else{
        echo "Your Request Cannot to Proceed.";
    }
}else{
    echo "ER1";
}
?>