<?php 
session_start();
require "../connection.php";

$SearchVal = $_POST["SearchVal"];

$ProductResults = Database::search("SELECT * FROM `watchlist` INNER JOIN `product_view` ON `product_view`.`id`= `watchlist`.`product_id` WHERE `watchlist`.`user_email` = '".$_SESSION["user"]["email"]."' AND `product_view`.`title` LIKE '"."%".$SearchVal."%"."';");
$WishNum = $ProductResults->num_rows;

if($WishNum >= 1){

    for($n = 0; $n < $WishNum; $n++){
        $ProductData = $ProductResults->fetch_assoc();                                
        $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$ProductData["product_id"]."' LIMIT 1;");
        $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$ProductData["condition_id"]."';");
        $StatUs = Database::search("SELECT `name` FROM `status` WHERE `id`='".$ProductData["status_id"]."';");
        $Seller = Database::search("SELECT `fname`,`lname` FROM `user` WHERE `email` = '".$ProductData["seller_email"]."';");
        $PColor = Database::search("SELECT `name` FROM `color_view` WHERE `product_id`='".$ProductData["product_id"]."';");
        $Selldata = $Seller->fetch_assoc();
        $imgrow = $pimage->fetch_assoc();
        $Condid = $Condit->fetch_assoc();
        $ProStatus = $StatUs->fetch_assoc();
        $ProColor = $PColor->fetch_assoc();                                
    ?>
    <!-- card -->
    <div class="card mb-3 my-3 col-12 border border-1 border-secondary rounded">
        <div class="row g-0">
            <div class="col-sm-4 d-flex align-items-center justify-content-center py-3">
                <img src="<?php echo $imgrow['code']; ?>" height="325px" class="round-image2 max-w-100" />
            </div>
            <div class="col-sm-5 col-lg-4 d-flex align-items-center">
                <div class="card-body row-gap">
                    <div class="col-12">
                        <h3 class="card-title"><?php echo mb_strimwidth($ProductData["title"], 0, 38, "..."); ?></h3>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold text-black-50">Colour : <?php echo $ProColor['name']; ?></span>
                        <br />
                        <span class="fw-bold text-black-50">Condition : <?php echo $Condid['name']; ?></span>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold text-black-50 fs-4">Price :&nbsp;</span>
                        <br />
                        <span class="fw-bold text-black fs-5">Rs: <?php echo $ProductData['price']; ?>.00</span>
                    </div>
                    <div class="col-12">
                        <span class="fw-bold text-black-50 fs-4">Seller : </span>
                        <br />
                        <span
                            class="fw-bold text-black fs-5"><?php echo $Selldata['fname']."&nbsp;".$Selldata['lname']; ?></span>
                        <br />
                        <span class="fw-bold text-black fs-5"><?php echo $ProductData["seller_email"]; ?></span>
                    </div>
                </div>
            </div>
            <div class="col-sm-3 mt-4 d-flex align-items-center bg-light">
                <div class="card-body d-flex row-gap">
                    <button class="btn btn-outline-success fw-bold">Buy Now</button>
                    <button onclick="AddToCart(<?php echo $ProductData['product_id']; ?>, 1);"
                        class="btn btn-outline-warning fw-bold">Add Cart</button>
                    <button onclick="MoveToRecent(<?php echo $ProductData['product_id']; ?>);"
                        class="btn btn-outline-danger fw-bold">Remove</button>
                </div>
            </div>
        </div>
    </div>
    <!--items card close-->
    <?php 
    }   
}else{
    ?>
    <div class="col-12 d-flex justify-content-center">
        <div class="row text-center" style="height: 300px;">
            <i class="col-12 text-center bi bi-emoji-frown fs-1 m-0 d-flex justify-content-center align-items-end pb-4"></i>
            <label class="form-label fs-1 mb-3 fw-bolder">You have no Result in your Searching</label>
        </div>
    </div>
<?php
}
?>