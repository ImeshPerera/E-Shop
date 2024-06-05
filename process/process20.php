<?php
session_start();

require "../connection.php";

if(isset($_SESSION["user"])){
    $ProductId = (int) $_POST["ProductId"];
    $ProductQty = (int) $_POST["ProductQty"];
    $OrderId = uniqid();

    $ProductResult = Database::search("SELECT * FROM `product_view` WHERE `id` = '".$ProductId."';");
    $ProductData = $ProductResult->fetch_assoc();

    if($ProductData["qty"] >= $ProductQty && $ProductQty != 0){

        $BuyerAddress = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
        $AddressData = $BuyerAddress->fetch_assoc();
        $AddressNum = $BuyerAddress->num_rows;
        if($AddressNum >= 1){

            if(isset($AddressData["city_id"])){

                $BuyerDistrict = Database::search("SELECT * FROM `city` WHERE `id` = '".$AddressData["city_id"]."';");
                $DistrictData = $BuyerDistrict->fetch_assoc();

                $DelivaryFinal = 1000;

                if($DistrictData["district_id"] == 1){
                    $DelivaryFinal = $ProductData["delivery_fee_colombo"];
                }else{
                    $DelivaryFinal = $ProductData["delivery_fee_other"];
                }

                $ProductId = $ProductData["id"];
                $item = $ProductData["title"];
                $amount = (int)$ProductData["price"] * $ProductQty + (int)$DelivaryFinal;
                $fname = $_SESSION["user"]["fname"];
                $lname = $_SESSION["user"]["lname"];
                $email = $_SESSION["user"]["email"];
                $mobile = $_SESSION["user"]["mobile"];
                $address = $AddressData["line1"].",".$AddressData["line2"];
                $city = $DistrictData["name"];

                $array['id'] = $OrderId;
                $array['item'] = $item;
                $array['amount'] = $amount;
                $array['fname'] = $fname;
                $array['lname'] = $lname;
                $array['email'] = $email;
                $array['mobile'] = $mobile;
                $array['address'] = $address;
                $array['city'] = $city;
                $array['payproductid'] = $ProductId;
                $array['product_qty'] = $ProductQty;

                echo json_encode($array);
            
            }else{
                echo "ER3";
            }
        }else{
            echo "ER3";
        }
    }else{
        echo "ER2";
    }
}else{
    echo "ER1";
}