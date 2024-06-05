<?php 
session_start();
require "../connection.php";

$UpdateSearch = $_POST["UpdateSearch"];

$UpdateSearchResult = Database::search("SELECT * FROM `product_view` WHERE `seller_email` = '".$_SESSION["user"]['email']."' AND `title` LIKE '"."%".$UpdateSearch."%"."'; ");
$num = $UpdateSearchResult->num_rows;
 
    for($n = 0; $n<$num; $n++){
        $data = $UpdateSearchResult->fetch_assoc();
        ?>
        <li><button onclick="UpdateThisItem('UpItem<?php echo $data['id'];?>');" id="UpItem<?php echo $data['id'];?>" value="<?php echo $data['id'];?>" class="dropdown-item"><?php echo $data["title"]; ?></button></li>
        <?php
    }
?>