<?php
session_start();

require "../connection.php";

if(isset($_SESSION["user"])){

    $OrderId = uniqid();
    $Colombo = 0;
    $TotalValue = 0;
    $Shipping = 0;
    $ItemsNum = 0;
    
    $UserPersonal = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
    $UserNum = $UserPersonal->num_rows;
    if($UserNum == 1){
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
                $ItemsNum++;
                $TotalValue = $TotalValue + ($ProductData['price'] * $CartData["buy_qty"]);
                if($Colombo == 1){
                    $Shipping = $Shipping + $ProductData['delivery_fee_colombo'];
                }else{
                    $Shipping = $Shipping + $ProductData['delivery_fee_other'];
                }
            }                                                           
        }
    
        $BuyerDistrict = Database::search("SELECT * FROM `city` WHERE `id` = '".$UserData["city_id"]."';");
        $DistrictData = $BuyerDistrict->fetch_assoc();

                    $item = $_SESSION["user"]["fname"]."&nbsp;".$_SESSION["user"]["lname"]."&nbsp;".$_SESSION["user"]["email"];
                    $amount = (int)$TotalValue + $Shipping;
                    $fname = $_SESSION["user"]["fname"];
                    $lname = $_SESSION["user"]["lname"];
                    $email = $_SESSION["user"]["email"];
                    $mobile = $_SESSION["user"]["mobile"];
                    $address = $UserData["line1"].",".$UserData["line2"];
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
                    $array['payproductid'] = "AllCart";
                    $array['product_qty'] = "AllCart";    

                    echo json_encode($array);
                
    }else{
        echo "ER3";
    }
}else{
    echo "ER1";
}
?>