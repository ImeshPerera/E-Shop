<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
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
    $TotalValue = 0;
    $Shipping = 0;
    $ItemsNum = 0;
?>

<!DOCTYPE html>
<html>

<head>
    <title>eShop | Cart Page</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body class="bg-primary" <?php if($UserNum == 0){echo "onload='ProfileMsg();'";} ?>>
    <?php require "alert.php"; ?>
    <div class="container-fluid">
        <?php require "header.php"; ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 border border-1 border-secondary">
                <div class="row">
                    <!-- topic start -->
                    <div class="col-12 bg-white">
                        <label class="form-label  fs-1 fw-bolder">Basket<i class="bi bi-cart-fill ps-3"></i></label>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- topic close -->

                    <div class="col-12 <?php if($CartNum < 1){echo "bg-white";}?>">
                        <div class="row justify-content-center">
                            <!-- Search and button start -->

                            <div class="col-12 bg-white">   
                                <div class="row justify-content-center">
                                    <div class="col-10">
                                    <div class="d-flex justify-content-center">
                                        <input type="text" class="form-control" id="cartSearch" placeholder="Search in Basket" />
                                        <button onclick="UserCartSearch();" class="btn btn-outline-primary ms-2-5">Search</button>
                                    </div>
                                    </div>
                                </div>    
                                <hr class="hrbreak1" />         
                            </div>
                            <!-- Search and button close -->
                            <div class="col-12 <?php if($CartNum < 1){echo "col-lg-2 border-end border-2 border-primary mb-2";} ?> bg-white pb-2">

                                <!-- breadcrumb and  title -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb ps-3 <?php if($CartNum >= 1){echo "mb-0";} ?>">
                                        <li class="breadcrumb-item"><a class="nav-link p-0" href="home.php">Home</a></li>
                                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Cart</li>
                                    </ol>
                                </nav>
                                <nav class="nav <?php if($CartNum < 1){echo "justify-content-center flex-lg-column";} ?>">
                                    <a class="nav-link active point-none" aria-current="page" >My Cart</a>
                                    <a class="nav-link" href="watchlist.php">My Watchlist</a>
                                    <a class="nav-link" href="recent.php">Recently Viewed</a>
                                    <a class="nav-link" href="purchasehistory.php">Perchased</a>
                                </nav>
                            </div>
                            <?php
                            if($CartNum < 1){
                            ?>
                            <!-- without items  start-->

                            <div class="col-12 col-lg-9 d-flex justify-content-center bg-white" id="UserCartFill">
                                <div class="row text-center" style="height: 300px;">
                                    <i class="col-12 text-center fs-1 bi bi-bag-x m-0 pb-4 d-flex justify-content-center align-items-end"></i>
                                    <label class="form-label fs-1 mb-3 fw-bolder">You have no items in your Basket</label>
                                    <div class="col-12">
                                        <a class="btn btn-primary btn-lg" href="home.php">Start Shopping</a>
                                    </div>
                                </div>
                            </div>
                            <!-- without items  close-->

                            <!--items card start -->
                            <?php
                            }elseif($CartNum >= 1){
                            ?>
                            <div class="col-12 col-lg-8 ps-lg-0 my-2" id="UserCartFill">
                                <div class="row g-2">
                                <?php 
                                for($n = 0; $n < $CartNum; $n++){
                                    $CartData = $Cartresult->fetch_assoc();
                                    $ProductResult =  Database::search("SELECT * FROM `product_view` WHERE `id` = '".$CartData["product_id"]."';");
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
                                    }   
                                    ?>
                                </div>
                            </div>
                            <div class="col-12 col-lg-4 my-2 bg-light rounded">
                                <div class="row px-2">
                                    <div class="col-11 ms-4 d-flex align-items-center mt-3">
                                        <span class="fw-bold text-black-50 fs-4">Summary</span>
                                    </div>
                                    <div class="col-12">
                                        <hr class="hrbreak0" />
                                    </div>
                                    <div class="col-12">
                                        <div id="CheckoutFill" class="card-body row-gap">
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
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php 
                            }else{
                                ?>
                                <div class="d-none" id="UserCartFill"></div>
                                <?php
                            }
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
        <?php require "footer.php"; ?>
        </div>
    </div>
    <script>
        var exampleEl = document.getElementById('example12');
        function GoPop(){
            new bootstrap.Popover(exampleEl);
        }
    </script>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>
<?php
}else{
    ?>
<script>
window.location = "index.php?Sign_In";
</script>
    <?php
}
?>