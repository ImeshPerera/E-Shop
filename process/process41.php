<?php
session_start();
require "../connection.php";

if(isset($_SESSION["admin"])){
    $dayon = $_POST["dayon"];
    $dayto = $_POST["dayto"];

    if(empty($dayon)){
        $dayon = "2021-01-01 00:00:00";
    }else{
        $dayon = $dayon." "."00:00:00";
    }
    if(empty($dayto)){
        $dayto = "2300-01-01 00:00:00";
    }else{
        $dayto = $dayto." "."23:59:59";
    }

    $AllinInvoice = Database::search("SELECT * FROM `invoice` WHERE `datetime_purchased` BETWEEN '".$dayon."' AND '".$dayto."';");
    $AllINum = $AllinInvoice->num_rows;
    for($i = 1; $i <= $AllINum; $i++){
        $AlliData = $AllinInvoice->fetch_assoc();
        $AllProduct = Database::search("SELECT * FROM `product_view` WHERE `id` = '".$AlliData["product_id"]."';");
        $AllPData = $AllProduct->fetch_assoc();
        $PImages = Database::search("SELECT `code` FROM `images_view` WHERE `product_id` = '".$AllPData["id"]."' LIMIT 1;");
        $PImg = $PImages->fetch_assoc();  
        $AllUsers = Database::search("SELECT * FROM `user` WHERE `email` = '".$AlliData["user_email"]."';");
        $AllUdata = $AllUsers->fetch_assoc();                          
    ?>
    <tr <?php if($AllPData["status_id"] == 4){echo "class='bg-danger'";}else{}?>>
        <td><?php echo $AlliData["order_id"]?></td>
        <td><img class="round-image2" src="<?php echo $PImg["code"];?>" height="50px" alt="image" />
            <?php echo mb_strimwidth($AllPData["title"], 0, 30, "..."); ?></td>
        <td><?php echo mb_strimwidth($AllUdata["fname"]." ".$AllUdata["lname"], 0, 25, "..."); ?></td>
        <td>Rs. <?php echo number_format($AlliData["total"]); ?>.00</td>
        <td><?php echo $AlliData["buy_qty"]; ?></td>
        <td><?php echo $AlliData["datetime_purchased"]; ?></td>
    </tr>
    <?php
    }
}
?>