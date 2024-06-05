<?php

require "../connection.php";

$provinceid = $_POST["provinceid"];
$Darray = Database::search("SELECT * FROM district WHERE `province_id` = '".$provinceid."';");
$Dnum = $Darray->num_rows;
for($Dn = 0; $Dn < $Dnum; $Dn ++){
$Ddata = $Darray->fetch_assoc();
?>
    <li><button onclick="showDistrict('Distric<?php echo $Ddata['id'];?>');" id="Distric<?php echo $Ddata["id"];?>" value="<?php echo $Ddata["id"];?>" class="dropdown-item"><?php echo $Ddata["name"];?></button></li>
<?php
}
?>