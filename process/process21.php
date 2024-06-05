<?php

require "../connection.php";
    
    $CatId = $_POST["CatId"];

    $ResultSet = Database::search("SELECT `brand_id`,`name` FROM `category_has_brand` INNER JOIN `brand` ON category_has_brand.`brand_id` = brand.`id` WHERE `category_id` = '".$CatId."';");
    $Num = $ResultSet->num_rows;
    
    if($Num == 0){
        echo "100";
    }else{
        for($i = 0; $i < $Num; $i++){
            $bd = $ResultSet->fetch_assoc();
            ?>
            <li><button onclick="showbrand('brd<?php echo $bd['brand_id'];?>');"
                    id="brd<?php echo $bd['brand_id'];?>" class="dropdown-item"
                    value="<?php echo $bd['brand_id'];?>"><?php echo $bd['name'];?></button>
            </li>
        <?php
        }
    }
        ?>               
