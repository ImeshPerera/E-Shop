<?php

session_start();
require "../connection.php";
if(isset($_SESSION["user"])){
    $Value = $_POST["Val"];
$ProdNumYes = 0;
?>
                                <div class="row g-2">
                                <?php 
                                    $Colombo = 0;
                                    $Cartresult = Database::search("SELECT * FROM `cart` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                                    $CartNum = $Cartresult->num_rows;
                                    $UserPersonal = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                                    $UserNum = $UserPersonal->num_rows;
                                    if($UserNum == 1){
                                        $UserData = $UserPersonal->fetch_assoc();
                                        if($UserData["city_id"] == 1){
                                            $Colombo = 1;
                                        }
                                    }
                                for($n = 0; $n < $CartNum; $n++){
                                    $CartData = $Cartresult->fetch_assoc();
                                    $ProductResult =  Database::search("SELECT * FROM `product_view` WHERE `id` = '".$CartData["product_id"]."'  AND `title` LIKE '%".$Value."%';");
                                    $ProdNum = $ProductResult->num_rows;
                                    if($ProdNum == 1){
                                        $ProdNumYes = 1;
                                    $ProductData = $ProductResult->fetch_assoc();                                
                                    $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$ProductData["id"]."' LIMIT 1;");
                                    $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$ProductData["condition_id"]."';");
                                    $StatUs = Database::search("SELECT `name` FROM `status` WHERE `id`='".$ProductData["status_id"]."';");
                                    $Seller = Database::search("SELECT `fname`,`lname` FROM `user` WHERE `email` = '".$ProductData["seller_email"]."';");
                                    $Sellerimg = Database::search("SELECT `user_code` FROM `user_image` WHERE `user_email` = '".$ProductData["seller_email"]."';");
                                    $PColor = Database::search("SELECT `name` FROM `color_view` WHERE `product_id` = '".$ProductData["id"]."';");
                                    $Selldata = $Seller->fetch_assoc();
                                    $sellimg = $Sellerimg->fetch_assoc();
                                    $imgrow = $pimage->fetch_assoc();
                                    $Condid = $Condit->fetch_assoc();
                                    $ProStatus = $StatUs->fetch_assoc();
                                    $ProColor = $PColor->fetch_assoc();
                                    $EncryId = ((((($ProductData['id']+8736)*1738)+9731)*4873)+58319);
                                ?>
                                <!-- card -->
                                    <div class="card col-12 border border-1 border-secondary rounded">
                                        <div class="row g-0">
                                            <div class="col-11 ms-4 d-flex align-items-center mt-3">
                                                <img class="rounded-circle round-image me-2" src="<?php if(isset($sellimg["user_code"])){echo $sellimg["user_code"];}else{echo "User_img/demoProfileImg.jpg";}?>"
                                                    width="34.5px" height="34.5px" />
                                                <span class="fw-bold text-black-50 fs-4">Seller : </span>
                                                <span class="fw-bold text-black fs-5">&nbsp;<?php echo $Selldata['fname']."&nbsp;".$Selldata['lname']; ?></span>
                                            </div>
                                            <div class="col-12">
                                                <hr class="hrbreak0" />
                                            </div>
                                            <div class="col-sm-4 d-flex align-items-center justify-content-center py-3">
                                                <img id="PopImg<?php echo $ProductData['id']; ?>" onmouseover="OpenCartPop('PopImg<?php echo $ProductData['id']; ?>');" src="<?php echo $imgrow['code']; ?>" height="325px" class="round-image2 max-w-100" 
                                                tabindex="0" data-bs-toggle="popover" data-bs-trigger="hover focus" title="<?php echo mb_strimwidth($ProductData["title"], 0, 28, "..."); ?>" data-bs-content="<?php echo $ProductData['description']; ?>">
                                            </div>
                                            <div class="col-sm-5 col-lg-4 d-flex align-items-center">
                                                <div class="card-body row-gap">
                                                    <div class="col-12">
                                                        <h3 class="card-title"><?php echo mb_strimwidth($ProductData["title"], 0, 28, "..."); ?></h3>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="fw-bold text-black-50">Colour : <?php echo $ProColor['name']; ?></span>
                                                        <br/>
                                                        <span class="fw-bold text-black-50">Condition :  <?php echo $Condid['name']; ?></span>
                                                    </div>
                                                    <div class="col-12">
                                                    <span class="fs-5">Price :</span>
                                                        <br/>
                                                        <span class="fw-bold text-black fs-6">Rs: <?php echo $ProductData['price']; ?>.00</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <div class="d-flex align-items-center">
                                                            <span>QTY :</span>
                                                            <div class="wrapper">
                                                                <span onclick="QtyMinusCart(<?php echo $ProductData['id']; ?>);" class="minus">-</span>
                                                                <input type="text" step="01" class="wrapper-num" id="QtyCartNum<?php echo $ProductData['id']; ?>"
                                                                value="<?php if($CartData["buy_qty"] == 0){echo "00";}elseif($CartData["buy_qty"] >= 10){echo $CartData["buy_qty"];}elseif($CartData["buy_qty"] > 0){echo "0".$CartData["buy_qty"];}else{echo "00";} ?>"/>
                                                                <span id="QtyCartMax<?php echo $ProductData['id']; ?>" class=" num d-none"><?php echo $ProductData["qty"]; ?></span>
                                                                <span onclick="QtyPlusCart(<?php echo $ProductData['id']; ?>);" class="plus">+</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="fs-5">Delivery Fee :</span>
                                                        <br/>
                                                        <span class="fw-bold text-black fs-6">Rs: <?php if($Colombo == 1){echo $ProductData['delivery_fee_colombo'];}else{echo $ProductData['delivery_fee_other'];} ?>.00</span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 col-lg-4 mt-4 d-flex align-items-center bg-light">
                                                <div class="card-body d-flex row-gap">
                                                    <a href="singleproductview.php?Product=<?php echo $ProductData["title"]."&Level=".$EncryId; ?>" class="btn btn-outline-success fw-bold">Pay For This</a>
                                                    <button onclick="MoveToRecentCart(<?php echo $ProductData['id']; ?>);" class="btn btn-outline-danger fw-bold">Remove</button>
                                                    <button onclick="AddCartPage(<?php echo $ProductData['id']; ?>);" class="btn btn-danger fw-bold visible-hidden" id="Visible<?php echo $ProductData['id']; ?>">Update Bill</button>
                                                </div>
                                            </div>
                                            <div class="col-12">
                                                <hr class="hrbreak0" />
                                            </div>
                                            <div class="col-11 ms-4 d-flex align-items-center mb-3">
                                                <span class="fw-bold text-black-50 fs-4">Requested Total <i class="bi bi-info-circle"></i></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!--items card close-->
                                    <?php 
                                }else{
                                }
                            } 
                            if($ProdNumYes == 0){
                                ?>
                                <div class="col-12 d-flex justify-content-center bg-light">
                                    <div class="row text-center" style="height: 300px;">
                                        <i class="col-12 text-center bi bi-emoji-frown fs-1 m-0 d-flex justify-content-center align-items-end pb-4"></i>
                                        <label class="form-label fs-1 mb-3 fw-bolder">You have no Result in your Searching</label>
                                    </div>
                                </div>
                            <?php
                            }

                                ?>
                                </div>
<?php
}
?>