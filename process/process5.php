<?php
session_start();
require "../connection.php";

$Catagoryid = $_POST["Catagoryid"];
$Brandid = $_POST["Brandid"];
$Modelid = $_POST["Modelid"];
$ListingTitle = $_POST["ListingTitle"];
$ConditionId = $_POST["ConditionId"];
$ProductColorId = $_POST["ProductColorId"];
$ListingQty = $_POST["ListingQty"];
$ListingPrice = $_POST["ListingPrice"];
$ListingDeliveryIn = $_POST["ListingDeliveryIn"];
$ListingDeliveryOut = $_POST["ListingDeliveryOut"];
$ListingDescription = $_POST["ListingDescription"];
$Imagename;
$datedata = new DateTime();
$timeZone = new DateTimeZone("Asia/Colombo");
$datedata->setTimezone($timeZone);
$dateadded = $datedata->format("Y-m-d H:i:s");

$state = 1;
$useremail = $_SESSION["user"]["email"];

if((empty($Catagoryid)) || ($Catagoryid == 0)){
    echo "Please Select a Catagory";
}elseif((empty($Brandid)) || ($Brandid == 0)){
    echo "Please Select a Brand";
}elseif((empty($Modelid)) || ($Modelid == 0)){
    echo "Please Select a Model";
}else{
    
    $CatTrue = 0;
    $BrdTrue = 0;
    $ModTrue = 0;
    $Category = Database::search("SELECT `id` FROM `category` WHERE `id` = '".$Catagoryid."';");
    $CatNum = $Category->num_rows;
    for($i = 0; $i < $CatNum; $i++){
        $CatData = $Category->fetch_assoc();
        if($CatData["id"] == $Catagoryid){
            $CatTrue = 1;
            $Brand = Database::search("SELECT * FROM `category_has_brand` WHERE `category_id` = '".$CatData["id"]."' AND `brand_id` = '".$Brandid."';");
            $BrdNum = $Brand->num_rows;
            for($i = 0; $i < $BrdNum; $i++){
                $BrdData = $Brand->fetch_assoc();
                if($BrdData["brand_id"] == $Brandid){
                    $BrdTrue = 1;
                    $Model = Database::search("SELECT `id` FROM `model` WHERE `category_has_brand_id` = '".$BrdData["id"]."';");
                    $ModNum = $Model->num_rows;
                    for($i = 0; $i < $ModNum; $i++){
                        $ModData = $Model->fetch_assoc();
                        if($ModData["id"] == $Modelid){
                            $ModTrue = 1;
                        }
                    }                
                }
            }        
        }
    }
    if($CatTrue == 0){
        echo "Your Category Not Matched";
    }elseif($BrdTrue == 0){
        echo "Your Brand Not Matched with Catagory";
    }elseif($ModTrue == 0){
        echo "Your Model Not Matched with Brand";
    }elseif(empty($ListingTitle)){
        echo "Please Fill Product Title";
    }elseif(strlen($ListingTitle) > 100){
        echo "Product Title exeeded the Limit";
    }elseif((empty($ConditionId)) || ($ConditionId == 0)){
        echo "Please Select a Condition";
    }elseif((empty($ProductColorId)) || ($ProductColorId == 0)){
        echo "Please Select Product Color";
    }elseif(empty($ListingQty)){
        echo "Please add Quantity for Product";
    }elseif((!mb_ereg_match('^[0-9]+$', $ListingQty)) || (substr($ListingQty, 0, 1) == 0) || ($ListingQty > 100000)){
        echo "Product Quantity not matched";
    }elseif(empty($ListingPrice)){
        echo "Please add Price for Product";
    }elseif((!mb_ereg_match('^[0-9]+$', $ListingPrice)) || (substr($ListingPrice, 0, 1) == 0)){
        echo "Product Price not matched";
    }elseif(empty($ListingDeliveryIn)){
        echo "Please add Delivery fees in Colombo";
    }elseif((!mb_ereg_match('^[0-9]+$', $ListingDeliveryIn)) || (substr($ListingDeliveryIn, 0, 1) == 0)){
        echo "Delivery fees in Colombo not matched";
    }elseif(empty($ListingDeliveryOut)){
        echo "Please add Delivery fees out of Colombo";
    }elseif((!mb_ereg_match('^[0-9]+$', $ListingDeliveryOut)) || (substr($ListingDeliveryOut, 0, 1) == 0)){
        echo "Delivery fees out of Colombo not matched";
    }elseif(empty($ListingDescription)){
        echo "Please add Description for Product";
    }elseif((!mb_ereg_match('^[0-9]+$', $Catagoryid)) || (substr($Catagoryid, 0, 1) == 0) || (!mb_ereg_match('^[0-9]+$', $Brandid)) || (substr($Brandid, 0, 1) == 0) || (!mb_ereg_match('^[0-9]+$', $Modelid)) || (substr($Modelid, 0, 1) == 0) || (!mb_ereg_match('^[0-9]+$', $ConditionId)) || (substr($ConditionId, 0, 1) == 0) || ($ConditionId > 3) || (!mb_ereg_match('^[0-9]+$', $ProductColorId)) || (substr($ProductColorId, 0, 1) == 0)){
        echo "Unauthorized activity. You can be banned";
    }else{
        if(isset($_FILES["TheImage"])){
            if($_FILES["TheImage"] != ""){
                $allowed_img_extension = array("image/jpg","image/jpeg","image/png","image/svg");
                $filex = $_FILES["TheImage"]["type"];
                if(in_array($filex,$allowed_img_extension)){
                    $file = $_FILES["TheImage"]["name"];
                    $Imagetemp = $_FILES["TheImage"]["tmp_name"];
                    $today = microtime(true);
                    $Imagename = "product_img//$today.$file";
                    $ImageLocation = "../".$Imagename;
                    
                    Database::iud("INSERT INTO `product`(`title`,`price`,`qty`,`description`,`condition_id`,`status_id`,`user_email`,`model_id`,`datetime_added`,`delivery_fee_colombo`,`delivery_fee_other`,`color_id`) VALUES('".$ListingTitle."','".$ListingPrice."','".$ListingQty."','".$ListingDescription."','".$ConditionId."','".$state."','".$useremail."','".$Modelid."','".$dateadded."','".$ListingDeliveryIn."','".$ListingDeliveryOut."','".$ProductColorId."');");
                    $GetProductId = Database::search("SELECT `id` FROM product WHERE `datetime_added` = '".$dateadded."' AND `user_email` = '".$useremail."';");
                    $GetData = $GetProductId->fetch_assoc();
                    
                    if(($GetProductId->num_rows) == 1){

                        move_uploaded_file($Imagetemp,$ImageLocation);
                        Database::iud("INSERT INTO `images`(`code`) VALUES ('".$Imagename."');");
                        $UpImg1 = Database::search("SELECT `id` FROM `images` WHERE `code` = '".$Imagename."';");    
                        $Img1Data = $UpImg1->fetch_assoc();

                        if(($UpImg1->num_rows) == 1){
                            
                            echo "SA1";
                            Database::iud("INSERT INTO `product_has_images`(`product_id`,`images_id`) VALUES ('".$GetData["id"]."','".$Img1Data["id"]."');");

                            if(isset($_FILES["TheImage2"])){
                                if(in_array($filex,$allowed_img_extension)){
                                    $file2 = $_FILES["TheImage2"]["name"];
                                    $Imagetemp2 = $_FILES["TheImage2"]["tmp_name"];
                                    $today2 = microtime(true);
                                    $Imagename2 = "product_img//$today2.$file2";
                                    $ImageLocation2 = "../".$Imagename2;
                                    move_uploaded_file($Imagetemp2,$ImageLocation2);
                                    Database::iud("INSERT INTO `images`(`code`) VALUES ('".$Imagename2."');");
                                    $UpImg2 = Database::search("SELECT `id` FROM `images` WHERE `code` = '".$Imagename2."';");    
                                    $Img2Data = $UpImg2->fetch_assoc();
                                    Database::iud("INSERT INTO `product_has_images`(`product_id`,`images_id`) VALUES ('".$GetData["id"]."','".$Img2Data["id"]."');");
                                }}

                            if(isset($_FILES["TheImage3"])){
                                if(in_array($filex,$allowed_img_extension)){
                                    $file3 = $_FILES["TheImage3"]["name"];
                                    $Imagetemp3 = $_FILES["TheImage3"]["tmp_name"];
                                    $today3 = microtime(true);
                                    $Imagename3 = "product_img//$today3.$file3";
                                    $ImageLocation3 = "../".$Imagename3;
                                    move_uploaded_file($Imagetemp3,$ImageLocation3);
                                    Database::iud("INSERT INTO `images`(`code`) VALUES ('".$Imagename3."');");
                                    $UpImg3 = Database::search("SELECT `id` FROM `images` WHERE `code` = '".$Imagename3."';");    
                                    $Img3Data = $UpImg3->fetch_assoc();
                                    Database::iud("INSERT INTO `product_has_images`(`product_id`,`images_id`) VALUES ('".$GetData["id"]."','".$Img3Data["id"]."');");
                                }} 
                        }else{
                            echo "ER2";
                        }
                    }else{
                        echo "ER1";
                    }
                }else{
                    echo "Your Image must be jpg / jpeg / png or svg ";
                }
            }else{
                echo "Upload Image for your Product";
            }
        }if(!isset($_FILES["TheImage"])){
            echo "Your Product Image is Empty";
        }
    }
}

?>