<?php

require "../connection.php";

$UpdateProductId = $_POST["UpdateProductId"];
$UpdatingTitle = $_POST["UpdatingTitle"];
$UpdatingQty = $_POST["UpdatingQty"];
$UpdatingDeliveryIn = $_POST["UpdatingDeliveryIn"];
$UpdatingDeliveryOut = $_POST["UpdatingDeliveryOut"];
$UpdatingDescription = $_POST["UpdatingDescription"];

if(empty($UpdateProductId)){
    echo "Please Select Product to Update";
}elseif(empty($UpdatingTitle)){
    echo "Please Fill Product Title";
}elseif(strlen($UpdatingTitle) > 100){
    echo "Product Title exeeded the Limit";
}elseif(empty($UpdatingQty)){
    echo "Please add Quantity for Product";
}elseif((!mb_ereg_match('^[0-9]+$', $UpdatingQty)) || (substr($UpdatingQty, 0, 1) == 0) || ($UpdatingQty > 100000)){
    echo "Product Quantity not matched";
}elseif(empty($UpdatingDeliveryIn)){
    echo "Please add Delivery fees in Colombo";
}elseif((!mb_ereg_match('^[0-9]+$', $UpdatingDeliveryIn)) || (substr($UpdatingDeliveryIn, 0, 1) == 0)){
    echo "Delivery fees in Colombo not matched";
}elseif(empty($UpdatingDeliveryOut)){
    echo "Please add Delivery fees out of Colombo";
}elseif((!mb_ereg_match('^[0-9]+$', $UpdatingDeliveryOut)) || (substr($UpdatingDeliveryOut, 0, 1) == 0)){
    echo "Delivery fees out of Colombo not matched";
}elseif(empty($UpdatingDescription)){
    echo "Please add Description for Product";
}else{
    $ProductImg = Database::search("SELECT * FROM `images_view` WHERE `product_id` = '".$UpdateProductId."';");
    $productImgNum = $ProductImg->num_rows;

        if((isset($_FILES["imgreuploaded1"])) || ($productImgNum >= 1)){

            for($nu = 1; $nu <= $productImgNum; $nu++){
                $ProductImgdata = $ProductImg->fetch_assoc();
                $ImgUpName = "imgreuploaded".$nu;
                if(isset($_FILES[$ImgUpName])){
                    $allowed_img_extension = array("image/jpg","image/jpeg","image/png","image/svg");
                    $filex = $_FILES[$ImgUpName]["type"];
                    if(in_array($filex,$allowed_img_extension)){
                        $file = $_FILES[$ImgUpName]["name"];
                        $Imagetemp = $_FILES[$ImgUpName]["tmp_name"];
                        $today = microtime(true);
                        $Imagename = "product_img//$today.$file";
                        $ImageLocation = "../".$Imagename;
                        move_uploaded_file($Imagetemp,$ImageLocation);
                        unlink("../".$ProductImgdata["code"]);
                        Database::iud("UPDATE `images` SET `code` = '".$Imagename."' WHERE `id` = '".$ProductImgdata["images_id"]."' ;");
                    }else{
                        echo "Your Image must be jpg / jpeg / png or svg ";
                    }
                }
            }
            Database::iud("UPDATE `product` SET `title` = '".$UpdatingTitle."',`qty` = '".$UpdatingQty."',`description` = '".$UpdatingDescription."',`delivery_fee_colombo` = '".$UpdatingDeliveryIn."',`delivery_fee_other` = '".$UpdatingDeliveryOut."' WHERE `id` = '".$UpdateProductId."';");
            echo "SA1";
        }else{
            echo "Upload 1st Image for your Product";
        }
}
?>