<?php
session_start();
require "../connection.php";

$Categoryid = $_POST["CateId"];
$Brandid = $_POST["BrdId"];
$ModelName = $_POST["Model"];
$CatTrue = 0;
$BrdTrue = 0;
$CatHasBrand = 0;

if(isset($_SESSION["admin"])){
    if((!empty($Categoryid)) && (!empty($Brandid)) && (!empty($ModelName))){
        $Category = Database::search("SELECT `id` FROM `category` WHERE `id` = '".$Categoryid."';");
        $CatNum = $Category->num_rows;
        for($i = 0; $i < $CatNum; $i++){
            $CatData = $Category->fetch_assoc();
            if($CatData["id"] == $Categoryid){
                $CatTrue = 1;
                $Brand = Database::search("SELECT * FROM `category_has_brand` WHERE `category_id` = '".$CatData["id"]."' AND `brand_id` = '".$Brandid."';");
                $BrdNum = $Brand->num_rows;
                for($i = 0; $i < $BrdNum; $i++){
                    $BrdData = $Brand->fetch_assoc();
                    if($BrdData["brand_id"] == $Brandid){
                        $BrdTrue = 1;
                        $CatHasBrand = $BrdData["id"];
                        if($CatTrue == 0){
                            echo "Your Category Not Matched";
                        }elseif($BrdTrue == 0){
                            echo "Your Brand Not Matched with Catagory";
                        }elseif($CatHasBrand != 0){
                            Database::iud("INSERT INTO `model`(`name`,`category_has_brand_id`) VALUES ('".$ModelName."','".$CatHasBrand."');");
                            echo "SA1";                
                        }else{
                            echo "Brand not matched with Category !";
                        }    
                    }
                }
            }
        }
    }else{
        echo "Your Fields are Empty !";
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}
?>