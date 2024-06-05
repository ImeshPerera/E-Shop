<?php
session_start();
require "../connection.php";

if(isset($_SESSION["admin"])){
    $Product = $_POST["Product"];
    $AllProduct = Database::search("SELECT * FROM `product_view` WHERE `title` LIKE '%".$Product."%' OR `description` LIKE '%".$Product."%';");
    $AllPNum = $AllProduct->num_rows;
    for($i = 1; $i <= $AllPNum; $i++){
        $AllPData = $AllProduct->fetch_assoc();
        $PImages = Database::search("SELECT `code` FROM `images_view` WHERE `product_id` = '".$AllPData["id"]."' LIMIT 1;");
        $PImg = $PImages->fetch_assoc();                        
    ?>
        <tr <?php if($AllPData["status_id"] == 4){echo "class='bg-danger'";}else{}?>>
            <td><?php if($i < 10){ echo "0".$i ;}else{echo $i ;} ?></td>
            <td class="admin-sp-flex">
                <img onclick="AdminProductView(<?php echo $AllPData['id'] ?>);" class="round-image2" src="<?php echo $PImg["code"];?>" height="50px" alt="image" />
            </td>
            <td><?php echo mb_strimwidth($AllPData["title"], 0, 30, "..."); ?></td>
            <td>Rs. <?php echo number_format($AllPData["price"]); ?>.00</td>
            <td><?php echo $AllPData["qty"]; ?></td>
            <td><?php echo $AllPData["datetime_added"]; ?></td>
            <td><button class="btn d-flex align-items-center <?php if($AllPData["status_id"] == 4){echo "btn-success";}else{echo "btn-danger";}?>" onclick="AdminProductStatus('<?php echo $AllPData['id'] ?>');">
                <i class="bi bi-exclamation-diamond fs-5"></i><span><?php if($AllPData["status_id"] == 4){echo "Unblock";}else{echo "Block";}?></span></button></td>
        </tr>
        <div class="col-12">
            <div class="modal" id="AdminProductModel<?php echo $AllPData["id"]; ?>" tabindex="-1">
                <div  class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                    <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title"><?php echo $AllPData["title"] ?></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="d-flex  align-items-center justify-content-center p-0 pe-2">
                            <img src="<?php echo $PImg["code"] ?>" height="250px" class="max-w-100 round-image2" />
                        </div>
                    </div>
                    <div class="modal-body text-center">
                        <p class="card-title justify-content-center text-orange">Rs. <?php echo number_format($AllPData["price"]); ?>.00</p>
                        <p class="card-title justify-content-center text-info"><?php echo $AllPData["qty"]; ?> Items Left</p>
                        <p class="card-title justify-content-center text-primary"><?php echo $AllPData["seller_email"] ?></p>
                        <p class="card-title justify-content-center"><?php echo $AllPData["description"] ?></p>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                    </div>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
}else{
    echo "Unauthorized Activity. Admin Not Found !";
}