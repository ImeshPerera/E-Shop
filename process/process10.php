<?php

require "../connection.php";

$productid = $_POST["ChangeProduct"];
$changeto = $_POST["ChangeMeto"];

$ProductStaus = Database::search("SELECT `status_id` FROM product WHERE `id` = '".$productid."';");
$StatusNow = $ProductStaus->fetch_assoc();

if($StatusNow["status_id"] > 3){
    echo "Your Product is Restricted by Admin";
}elseif($StatusNow["status_id"] == 3){
    echo "Your Product is Out of Stock";
}else{
    if($StatusNow["status_id"] == 1){
        if($changeto == 2){
            Database::iud("UPDATE product SET `status_id` = '2' WHERE `id` = '".$productid."';");
            echo "SUD";
        }
        if($changeto == 1){
            echo "Your Product Already Listed";
        }
    }else if($StatusNow["status_id"] == 2){
        if($changeto == 1){
            Database::iud("UPDATE product SET `status_id` = '1' WHERE `id` = '".$productid."';");
            echo "SUL";
        }
        if($changeto == 2){
            echo "Your Product Already Disabled";
        }
    }else{
        echo "Your Product is Restricted";
    }
}
?>