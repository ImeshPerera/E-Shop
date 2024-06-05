<?php
session_start();
require "connection.php";
if(isset($_GET["Level"])){
    $DecryId = $_GET["Level"];
    $ProductId = ((((($DecryId-58319)/4873)-9731)/1738)-8736);
    //For Encryption $EncryId = ((((($ProdId+8736)*1738)+9731)*4873)+58319);
}else{
    $ProductId = 1;
}
if(isset($_SESSION["user"])){
    $UserResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$ProductId."';");
    $WishData = $UserResult->fetch_assoc();
}
    $Resultset = Database::search("SELECT * FROM `product_view` WHERE `id` = '".$ProductId."';");
    $PData = $Resultset->fetch_assoc();
if(isset($PData["id"])){
    $productimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$ProductId."';");
    $imagesnumrow = $productimage->num_rows;
    for($ns = 1; $ns <= $imagesnumrow; $ns++){
        $imagesrow = $productimage->fetch_assoc();
        $PData["image".$ns] = $imagesrow["code"];
    }
    $PCondition = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$PData["condition_id"]."';");
    $PCondidData = $PCondition->fetch_assoc();
    $PData["Condition"] = $PCondidData["name"];
    $Stat = Database::search("SELECT `name` FROM `status` WHERE `id`='".$PData["status_id"]."';");
    $Stats = $Stat->fetch_assoc();
    $PData["Status"] = $Stats["name"];
    $Seller = Database::search("SELECT * FROM `user` WHERE `email` = '".$PData["seller_email"]."';");
    $Selldata = $Seller->fetch_assoc();
    $PData["SeFname"] = $Selldata["fname"];
    $PData["SeLname"] = $Selldata["lname"];
    $PData["price_2"] = (($PData["price"]/100)*105) ;
    $Mores = Database::search("SELECT * FROM `product_view` WHERE `seller_email` = '".$PData["seller_email"]."' AND `model_id` = '".$PData["model_id"]."' ;");
    $MoreNum = $Mores->num_rows;
    $protocol = ((!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] != 'off') || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://";  
    $CurPageURL = $protocol . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];  
?>     
<!DOCTYPE html>

<html>

<head>
    <title>Eshop Product View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body class="bg-primary">
    <?php require "alert.php"; ?>
    <div class="container-fluid">
    <?php require "header.php";?>
    </div>
    <div class="container-fluid">
        <div class="row my-1">
            <div class="bg-white py-3">
                <div class="row">
                    <div class="col-12 col-sm-5 col-md-4 col-lg-2 order-2 order-sm-1 d-flex ">
                        <ul class="p-0 d-flex flex-sm-column justify-content-center m-auto list-unstyled align-items-center ">
                            <li><img onclick="SetMainImg('SingleImg1');" id="SingleImg1" src="<?php echo $PData["image1"] ?>" height="150px"
                                    class="mt-1 mb-1 round-image2 max-w-100" /></li>
                            <li><img onclick="SetMainImg('SingleImg2');" id="SingleImg2" src="<?php if(!empty($PData["image2"])){ echo $PData["image2"];}else{echo $PData["image1"];} ?>" height="150px"
                                    class="mt-1 mb-1 round-image2 max-w-100" /></li>
                            <li><img onclick="SetMainImg('SingleImg3');" id="SingleImg3" src="<?php if(!empty($PData["image3"])){ echo $PData["image3"];}else{echo $PData["image1"];} ?>" height="150px"
                                    class="mt-1 mb-1 round-image2 max-w-100" /></li>
                        </ul>
                    </div>
                    <div class="col-sm-7 col-md-8 col-lg-4 order-2 order-lg-1 d-none d-sm-flex align-items-center justify-content-center">
                        <img id="MainImg" src="<?php echo $PData["image1"] ?>" height="450px" class="max-w-100 round-image2" />
                    </div>
                    <div class="col-lg-6 order-3">
                        <div class="row">
                            <div class="col-12 my-2">
                                <nav>
                                    <ol class="d-flex flex-wrap mb-0 list-unstyled bg-white rounded">
                                        <li class="breadcrumb-item"><a href="home.php"
                                                class="text-decoration-none text-black-50">Home</a></li>
                                        <li class="breadcrumb-item"><a href="#"
                                                class="text-decoration-none text-black-50">Product</a></li>
                                        <li class="breadcrumb-item"><a
                                                class="text-decoration-none text-black-50 point-none">Single Product View</a></li>
                                    </ol>
                                </nav>
                            </div>
                            <div class="col-12">
                                <label class="form-label fw-bold fs-4 m-0"><?php echo mb_strimwidth($PData["title"], 0, 30, "..."); ?></label>
                            </div>
                            <div class="col-12 mt-1">
                                <span class="badge badge-success">
                                    <ul class="star-box p-0">
                                        <i class="bi bi-star-fill mt-1 text-warning fs-6"></i>
                                        <i class="bi bi-star-fill mt-1 text-warning fs-6"></i>
                                        <i class="bi bi-star-fill mt-1 text-warning fs-6"></i>
                                        <i class="bi bi-star-fill mt-1 text-warning fs-6"></i>
                                        <i class="bi bi-star-half mt-1 text-warning fs-6"></i>
                                    </ul>
                                    <label class="text-dark fs-6"> 4.5 Ratings & 45 Reviews</label>
                                </span>
                            </div>
                            <div class="col-12 d-inline-block">
                                <label class="d-inline-block fw-bold mt-1 fs-4">Rs <?php echo number_format($PData["price"]); ?>.00 &nbsp;</label>
                                <label class=" fw-bold mt-1 fs-6 text-danger"><del>Rs <?php echo number_format($PData["price_2"]); ?>.00</del></label>
                                <hr class="hrbreak0">
                            </div>
                            <div class="col-12">
                                <label class="text-primary fs-6"><b> Warrenty :</b> 6 months Warrenty</label>
                                <br>
                                <label class="text-primary fs-6"><b>Return Policy :</b> 1 month Return Policy
                                </label><br>
                                <label class="text-primary fs-6"><b> In Stock : </b><?php echo number_format($PData["qty"]); ?> itemes left</label>
                                <hr class="hrbreak0">
                            </div>
                            <div class="col-12">
                                <label class="text-dark fs-4 fw-bold"> Seller Details</label><br>
                                <label class="text-success fs-6"><b>Seller's name : </b><?php echo $PData["SeFname"]."&nbsp;".$PData["SeLname"]; ?>
                                </label><br>
                                <label class="text-success fs-6"><b>Seller's email : </b><?php echo $PData["seller_email"] ?></label>
                                <hr class="hrbreak0">
                            </div>
                            <div class="col-lg-9 col-12">
                                <div class="row border border-1 border-success ms-2-5 me-3">
                                    <div class="col-md-9 col-sm-9 pe-3 col-lg-11 d-flex align-items-center">
                                        <label class="bi bi-tags-fill text-warning"></label>
                                        <label class="text-black-50 ps-2">Stand a Chance to get instant discount with
                                            using VISA</label>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 my-2">
                                <label class="fs-5 mt-1 fw-bold mb-2">Your Colour Option</label><br>
                                <?php
                                for($nx = 0; $nx < $MoreNum; $nx++){
                                    $MoreData = $Mores->fetch_assoc();
                                    $MoreColor = Database::search("SELECT * FROM `color_view` WHERE `product_id` = '".$MoreData['id']."';");
                                    $MoreCData = $MoreColor->fetch_assoc();
                                    $EncryId = ((((($MoreData['id']+8736)*1738)+9731)*4873)+58319);
                                    ?>
                                    <a href="singleproductview.php?Product=<?php echo $MoreData["title"]."&Level=".$EncryId; ?>"
                                     class="btn btn-sm <?php if($PData["color_id"] == $MoreCData["color_id"]){echo "btn-primary";}else{echo "btn-light";} ?>"><?php echo $MoreCData["name"]; ?></a>
                                    <?php
                                }
                                ?>
                            </div>
                            <div class="col-12">
                                <hr class="hrbreak0" />
                                <div class="d-flex align-items-center">
                                    <span>QTY :</span>
                                    <div class="wrapper">
                                        <span onclick="QtyMinus()" class="minus">-</span>
                                        <input type="text" step="01" class="wrapper-num" id="QtyNum" value="<?php if($PData["qty"] == 0){echo "00";}else{echo "01";} ?>"/>
                                        <span id="QtyMax" class=" num d-none"><?php echo $PData["qty"]; ?></span>
                                        <span onclick="QtyPlus();" class="plus">+</span>
                                    </div>
                                </div>
                                <hr class="hrbreak0" />
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-4 col-md-3 col-xl-2 d-grid">
                                    <button class="btn btn-primary" onclick="AddToCart('<?php echo $PData['id']; ?>')">Add Cart</button>
                                </div>
                                <div class="col-4 col-md-3 col-xl-2 d-grid">
                                    <button type="submit" onclick="PayNowHere('<?php echo $PData['id']; ?>');" id="payhere-payment" class="btn btn-success">Buy Now</button>
                                </div>
                                <div class="d-grid align-items-center width-fit pe-0">
                                    <div onclick="AddWishList('<?php echo $PData['id']; ?>');" id="HeartWish<?php echo $PData['id']; ?>" 
                                    class="bg-white bi bi-heart-fill fs-4 text-secondary <?php if(isset($_SESSION["user"])){ if(isset($WishData["product_id"])){echo "text-warning";}}else{} ?>"></div>
                                </div>
                                <div class="d-grid align-items-center width-fit pe-0">
                                    <div onclick="CopytoShere('<?php echo $CurPageURL; ?>');" id="ShereProduct" class="bg-white bi bi-share-fill fs-4 text-secondary"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="bg-white col-12">
                <?php
            $resultset = Database::search("SELECT * FROM `product_view` WHERE `id` NOT IN ('".$PData['id']."') AND `status_id` IN (1,3) AND `brand_id` = '".$PData["brand_id"]."' ORDER BY `datetime_added` DESC LIMIT 4");
            ?>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 mt-2">
                        <span class="fs-3 fw-bold py-lg-3">Related items</span>
                    </div>
                    <div class=" col-12 col-md-11 mb-3">
                        <div class="row justify-content-center">
                            <?php
                            $nr = $resultset->num_rows;
                            if($nr == 0){
                                $resultset = Database::search("SELECT * FROM `product_view` WHERE `id` NOT IN ('".$PData['id']."') AND `status_id` IN (1,3) AND `category_id` = '".$PData["category_id"]."' ORDER BY `datetime_added` DESC LIMIT 4");
                                $nr = $resultset->num_rows;
                                if($nr == 0){
                                    $resultset = Database::search("SELECT * FROM `product_view` WHERE `id` NOT IN ('".$PData['id']."') AND `status_id` IN (1,3) ORDER BY `datetime_added` DESC LIMIT 4");
                                    $nr = $resultset->num_rows;
                                }
                            }
                            for ($y = 0; $y < $nr; $y++) {
                                $prod = $resultset->fetch_assoc();
                                $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$prod["id"]."' LIMIT 1;");
                                $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$prod["condition_id"]."';");
                                $StatUs = Database::search("SELECT `name` FROM `status` WHERE `id`='".$prod["status_id"]."';");
                                $imgrow = $pimage->fetch_assoc();
                                $Condid = $Condit->fetch_assoc();
                                $ProStatus = $StatUs->fetch_assoc();                            
                                $EncryId = ((((($prod['id']+8736)*1738)+9731)*4873)+58319);
                                if(isset($_SESSION["user"])){
                                    $ReUserResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$prod["id"]."';");
                                    $ReWishData = $ReUserResult->fetch_assoc();
                                }                                
                            ?>
                            <div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3  mb-3">
                                <img src="<?php echo $imgrow['code']; ?>"
                                    class="card-img-top cardTopImg product-img mt-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo mb_strimwidth($prod["title"], 0, 18, "..."); ?><span
                                            class="badge bg-info"><?php echo $Condid["name"]; ?></span>
                                    </h5>
                                    <div class="row justify-content-between my-2">
                                        <div class="d-flex justify-content-between col-gap mb-2">
                                            <div class="d-flex flex-column col-gap">
                                                <span class="card-text text-primary">Rs: <?php echo $prod['price']; ?>.00</span>
                                                <span class="card-text text-orange h5"><?php echo $ProStatus["name"]; ?></span>
                                            </div>
                                            <div class="bi bi-heart-fill text-secondary d-flex align-items-center 
                                            <?php if(isset($_SESSION["user"])){if($ReWishData["product_id"] == $prod["id"]){ echo "text-warning";}} ?>"
                                            onclick="AddWishList('<?php echo $prod['id']; ?>');" id="HeartWish<?php echo $prod["id"]; ?>" 
                                            ></div>
                                        </div>
                                        <div class="d-flex justify-content-between col-gap my-2">
                                            <div class="col-6 p-p-0 d-flex justify-content-center">
                                                <a href="singleproductview.php?Product=<?php echo $prod["title"]."&Level=".$EncryId; ?>" class="btn btn-success <?php if($prod['qty'] == 0){echo "point-none";} ?>">Buy Now</a>
                                            </div>
                                            <div class="col-6 p-0 d-flex justify-content-center">
                                                <button class="btn btn-danger" onclick="AddToCart(<?php echo $prod['id']; ?>,1);">Add Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="bg-white col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 my-2">
                        <span class="fs-3 fw-bold py-lg-3">FeedBacks</span>
                        <?php
                        $FeedBack = Database::search("SELECT * FROM `feedback` WHERE `product_id` = '".$PData['id']."';");
                        $FeedBackNum = $FeedBack->num_rows;
                        for($n = 1; $n <= $FeedBackNum; $n++){
                        $FeedbackData = $FeedBack->fetch_assoc();
                        $FeedUser = Database::search("SELECT `fname`,`lname` FROM `user` WHERE `email` = '".$FeedbackData["user_email"]."';");
                        $FeedUserdata = $FeedUser->fetch_assoc();                    
                        ?>
                        <div class="col-12">
                            <div class="d-flex">
                                <label class="h5"><?php if($n <10){echo "0".$n.".&nbsp;";}else{echo $n.".&nbsp;";} ?></label>
                                <label class="h5"><?php echo $FeedbackData["feedback_msg"]; ?></label>
                            </div>
                            <p class="fs-8"><?php echo $FeedUserdata["fname"]." ".$FeedUserdata["lname"]." ".$FeedbackData["datetime_add"]; ?></p>
                        </div>
                        <?php
                        }
                        if($FeedBackNum == 0){
                            ?>
                            <div class="col-12">
                                <label>There has no feedback massages yet !</label>
                            </div>
                            <?php
                            }
                        ?>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="bg-white col-12">
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 my-2">
                        <span class="fs-3 fw-bold py-lg-3">Product Details</span>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3 col-md-2">
                                    <label>Brand</label>
                                </div>
                                <?php 
                                    $Br = Database::search("SELECT `name` FROM `brand` WHERE `id` = '".$PData['brand_id']."';"); 
                                    $BrData = $Br->fetch_assoc();        
                                ?>
                                <div class="col-9 col-md-10">
                                    <label><?php echo  $BrData['name']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12">
                            <div class="row">
                                <div class="col-3 col-md-2">
                                    <label>Model</label>
                                </div>
                                <?php 
                                    $Md = Database::search("SELECT `name` FROM `model` WHERE `id` = '".$PData['model_id']."';"); 
                                    $MdData = $Md->fetch_assoc();        
                                ?>
                                <div class="col-9 col-md-10">
                                    <label><?php echo  $MdData['name']; ?></label>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <div class="row">
                                <div class="col-12 col-md-2">
                                    <label>Descripction</label>
                                </div>
                                <div class="col-12 col-md-8">
                                    <label><?php echo $PData['description']; ?></label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid p-0">
    <?php
    require "footer.php";
    ?>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script type="text/javascript" src="https://www.payhere.lk/lib/payhere.js"></script>
</body>

</html>
<?php
}else{
?>
<!DOCTYPE html>

<html>

<head>
    <title>Eshop Product View</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>
<body>
<?php require "alert.php"; ?>
    <div class="container-fluid">
        <?php require "header.php"; ?>
        <div class="row">
            <div class="col-12 d-flex justify-content-center">
                <div class="row text-center" style="height: 250px;">
                    <i class="col-12 text-center bi bi-emoji-frown fs-1 m-0 d-flex justify-content-center align-items-end pb-4"></i>
                    <label class="form-label fs-1 mb-3 fw-bolder">Something went wrong with your link</label>
                </div>
            </div>
        </div>
        <div class="row mt-1">
            <div class="bg-white col-12">
                <?php
                $resultset = Database::search("SELECT * FROM `product` WHERE `status_id` IN (1,3) ORDER BY `datetime_added` DESC LIMIT 4");
                ?>
                <div class="row justify-content-center">
                    <div class="col-12 col-md-11 mt-2">
                        <span class="fs-3 fw-bold py-lg-3">Suggestions</span>
                    </div>
                    <div class=" col-12 col-md-11 mb-3">
                        <div class="row justify-content-center">
                            <?php
                            $nr = $resultset->num_rows;
                            for ($y = 0; $y < $nr; $y++) {
                                $prod = $resultset->fetch_assoc();
                                $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$prod["id"]."' LIMIT 1;");
                                $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$prod["condition_id"]."';");
                                $StatUs = Database::search("SELECT `name` FROM `status` WHERE `id`='".$prod["status_id"]."';");
                                $imgrow = $pimage->fetch_assoc();
                                $Condid = $Condit->fetch_assoc();
                                $ProStatus = $StatUs->fetch_assoc();                            
                                $EncryId = ((((($prod['id']+8736)*1738)+9731)*4873)+58319);
                                if(isset($_SESSION["user"])){
                                    $ReUserResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id` = '".$prod["id"]."';");
                                    $ReWishData = $ReUserResult->fetch_assoc();
                                }                                
                            ?>
                            <div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3  mb-3">
                                <img src="<?php echo $imgrow['code']; ?>"
                                    class="card-img-top cardTopImg product-img mt-3">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo mb_strimwidth($prod["title"], 0, 28, "..."); ?><span
                                            class="badge bg-info"><?php echo $Condid["name"]; ?></span>
                                    </h5>
                                    <div class="row justify-content-between my-2">
                                        <div class="d-flex justify-content-between col-gap mb-2">
                                            <div class="d-flex flex-column col-gap">
                                                <span class="card-text text-primary">Rs: <?php echo $prod['price']; ?>.00</span>
                                                <span class="card-text text-orange h5"><?php echo $ProStatus["name"]; ?></span>
                                            </div>
                                            <div class="bi bi-heart-fill text-secondary d-flex align-items-center 
                                            <?php if(isset($_SESSION["user"])){if($ReWishData["product_id"] == $prod["id"]){ echo "text-warning";}} ?>"
                                            onclick="AddWishList('<?php echo $prod['id']; ?>');" id="HeartWish<?php echo $prod["id"]; ?>" 
                                            ></div>
                                        </div>
                                        <div class="d-flex justify-content-between col-gap my-2">
                                            <div class="col-6 p-p-0 d-flex justify-content-center">
                                                <a href="singleproductview.php?Product=<?php echo $prod["title"]."&Level=".$EncryId; ?>" class="btn btn-success <?php if($prod['qty'] == 0){echo "point-none";} ?>">Buy Now</a>
                                            </div>
                                            <div class="col-6 p-0 d-flex justify-content-center">
                                                <button class="btn btn-danger" onclick="AddToCart(<?php echo $prod['id']; ?>,1);">Add Cart</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php } ?>
                        </div>
                    </div>  
                </div>
            </div>
        </div>
        <div class="row">
            <?php require "footer.php" ?>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
</body>

<?php
}
?>