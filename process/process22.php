<?php

require "../connection.php";
    
    $BrdId = $_POST["BrdId"];

        $ResultSet = Database::search("SELECT model.`id`,`name` FROM `model` INNER JOIN `category_has_brand` ON category_has_brand.`id` = model.`category_has_brand_id` WHERE `brand_id` = '".$BrdId."';");
        $Num = $ResultSet->num_rows;
        if($Num == 0){
            echo "100";
        } else{   
            for($i = 0; $i < $Num; $i++){
                $bd = $ResultSet->fetch_assoc();
                ?>
                <li><button onclick="showmodel('mod<?php echo $bd['id'];?>');"
                        id="mod<?php echo $bd['id'];?>" class="dropdown-item"
                        value="<?php echo $bd['id'];?>"><?php echo $bd['name'];?></button>
                </li>
            <?php
            }
        }
            ?>               
