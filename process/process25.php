<?php
session_start();
require "../connection.php";
$UserPersonal = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
$UserNum = $UserPersonal->num_rows;
$Colombo = 0;
$TotalValue = 0;
$Shipping = 0;
$ItemsNum = 0;

if($UserNum == 1){
    $UserData = $UserPersonal->fetch_assoc();
    if($UserData["city_id"] == 1){
        $Colombo = 1;
    }
}

?>

                                            <div class="col-12">
                                                <?php
                                                $CartResult = Database::search("SELECT * FROM `cart` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                                                $Cartnum = $CartResult->num_rows;                                                
                                                for($n = 0; $n < $Cartnum; $n++){
                                                    $CartData = $CartResult->fetch_assoc();
                                                    $ProductResult =  Database::search("SELECT * FROM `product_view` WHERE `id` = '".$CartData["product_id"]."';");
                                                    $ProductData = $ProductResult->fetch_assoc();                                           
                                                    $CartProductModel = Database::search("SELECT * FROM `model` WHERE `id` = '".$ProductData['model_id']."';");
                                                    $CartModelData = $CartProductModel->fetch_assoc();
                                                    if($ProductData["qty"] >= 1){
                                                        $ItemsNum++;
                                                        $TotalValue = $TotalValue + ($ProductData['price'] * $CartData["buy_qty"]);
                                                        if($Colombo == 1){
                                                            $Shipping = $Shipping + $ProductData['delivery_fee_colombo'];
                                                        }else{
                                                            $Shipping = $Shipping + $ProductData['delivery_fee_other'];
                                                        }
                                                    }                                                           
                                                ?>
                                                <h3 class="card-title"><?php echo mb_strimwidth($CartModelData["name"], 0, 15, "...")."&nbsp;&#40;".$CartData["buy_qty"]."&#41;" ?></h3>
                                                <div class="text-end">
                                                    <p><?php echo number_format($ProductData["price"])."&nbsp;&#42;&nbsp;".$CartData["buy_qty"]."&nbsp;&#61;&nbsp;".number_format($ProductData["price"] * $CartData["buy_qty"]) ?></p>
                                                </div>
                                                <?php
                                                }
                                                ?>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <span class="fs-5">Items (<?php echo $ItemsNum; ?>)</span>
                                                <br/>
                                                <span class="fs-5">Rs: <?php echo number_format($TotalValue); ?>.00</span>
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <span class="fs-5">Shipping</span>
                                                <br/>
                                                <span class="fs-5">Rs: <?php echo number_format($Shipping); ?>.00</span>
                                            </div>
                                            <div class="col-12">
                                                <hr class="hrbreak0" />
                                            </div>
                                            <div class="col-12 d-flex justify-content-between">
                                                <span class="fs-5">Total</span>
                                                <br/>
                                                <span class="fs-5">Rs: <?php echo number_format($TotalValue + $Shipping); ?>.00</span>
                                            </div>
                                            <div class="col-12">
                                                <hr class="hrbreak0" />
                                            </div>
                                            <div class="col-12 d-flex align-items-center">
                                                <div class="card-body d-flex row-gap">
                                                    <button type="submit" id="payhere-payment" onclick="PayCartHere();" class="btn btn-primary fw-bold">Checkout</button>
                                                </div>
                                            </div>
