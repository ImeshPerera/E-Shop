<?php

session_start();
require "../connection.php";

$SearchItems = $_POST["SearchItems"];
$BasicSearchCategory = $_POST["BasicSearchCategory"];
$page = $_POST["pg"];
$offset = 4*($page-1);

if((empty($SearchItems)) && $BasicSearchCategory > 0){
    $AllResultset = Database::search("SELECT * FROM `product_view` WHERE `category_id` = '".$BasicSearchCategory."' AND `status_id` IN (1,3) ORDER BY `datetime_added` DESC;");
    $Resultset = Database::search("SELECT * FROM `product_view` WHERE `category_id` = '".$BasicSearchCategory."' AND `status_id` IN (1,3) ORDER BY `datetime_added` DESC LIMIT 4 OFFSET ".$offset.";");
}elseif((!empty($SearchItems)) && $BasicSearchCategory == 0){
    $AllResultset = Database::search("SELECT * FROM `product_view` WHERE `title` LIKE '"."%".$SearchItems."%"."' AND `status_id` IN (1,3) ORDER BY `datetime_added` DESC;");
    $Resultset = Database::search("SELECT * FROM `product_view` WHERE `title` LIKE '"."%".$SearchItems."%"."' AND `status_id` IN (1,3) ORDER BY `datetime_added` DESC LIMIT 4 OFFSET ".$offset.";");
}elseif((!empty($SearchItems)) && $BasicSearchCategory > 0){
    $AllResultset = Database::search("SELECT * FROM `product_view` WHERE `title` LIKE '"."%".$SearchItems."%"."' AND `status_id` IN (1,3) AND `category_id` = '".$BasicSearchCategory."' ORDER BY `datetime_added` DESC;");
    $Resultset = Database::search("SELECT * FROM `product_view` WHERE `title` LIKE '"."%".$SearchItems."%"."' AND `status_id` IN (1,3) AND `category_id` = '".$BasicSearchCategory."' ORDER BY `datetime_added` DESC LIMIT 4 OFFSET ".$offset.";");
}else{
    $AllResultset = Database::search("SELECT * FROM `product_view` ORDER BY `datetime_added` DESC;");
    $Resultset = Database::search("SELECT * FROM `product_view` ORDER BY `datetime_added` DESC LIMIT 4 OFFSET ".$offset.";");
}
$Number = $Resultset->num_rows;
if($Number > 0){
    $allProductnm = $AllResultset->num_rows;
    $DividedNumber = $allProductnm/4 ;
    $PageNumbers = intval($DividedNumber);
    if($allProductnm%4 != 0){
        $PageNumbers = $PageNumbers+1;
    }
    if($page > $PageNumbers){
        $page = 1;
    }
?>

<div class=" col-12 col-md-10 offset-md-1 mb-3">
    <div class="row justify-content-center border border-primary">
        <?php
        for ($y = 0; $y < $Number; $y++) {
        $prod = $Resultset->fetch_assoc();
        $EncryId = ((((($prod['id']+8736)*1738)+9731)*4873)+58319);
        $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$prod["id"]."' LIMIT 1;");
        $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$prod["condition_id"]."';");
        $Stat = Database::search("SELECT `name` FROM `status` WHERE `id`='".$prod["status_id"]."';");
        if(isset($_SESSION["user"])){
            $UserResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id`='".$prod["id"]."';");
            $WishData = $UserResult->fetch_assoc();
        }                            
        $imgrow = $pimage->fetch_assoc();
        $Condid = $Condit->fetch_assoc();
        $Stats = $Stat->fetch_assoc();
        ?>
        <div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3  mt-3 mb-3">
            <img src="<?php echo $imgrow['code']; ?>" class="card-img-top cardTopImg product-img">
            <div class="card-body">
                <h5 class="card-title"><?php echo mb_strimwidth($prod["title"], 0, 18, "..."); ?><span
                        class="badge bg-info"><?php echo $Condid["name"]; ?></span>
                </h5>
                <div class="d-flex flex-column gap-2">
                    <span class="card-text text-primary h4">Rs: <?php echo $prod['price']; ?>.00</span>
                    <div class="col-10 offset-1 text-center mt-2 mb-2">
                        <p class="card-text"><?php echo mb_strimwidth($prod['description'], 0, 60, "...") ; ?></p>
                        <span class="card-text text-orange h5"><?php echo $Stats["name"]; ?></span>
                    </div>
                </div>
                <div class="row justify-content-between mt-3 mb-3">
                    <div class="col-12 d-flex col-gap mb-3 px-4">
                        <input class="form-control bg-smoke" type="number" value="<?php echo $prod['qty']; ?>"
                            disabled />
                        <i  id="HeartWish<?php echo $prod['id']; ?>" onclick="AddWishList(<?php echo $prod['id']; ?>);" class="bi bi-heart-fill <?php if(isset($_SESSION["user"])){if($WishData["product_id"] == $prod['id']){ echo "text-warning";}} ?>"></i>
                    </div>
                    <div class="col p-0 d-flex justify-content-center">
                        <a href="singleproductview.php?Product=<?php echo $prod["title"]."&Level=".$EncryId; ?>" class="btn btn-success <?php if($prod['qty'] == 0){echo "point-none";} ?>">Buy Now</a>
                    </div>
                    <div class="col p-0 d-flex justify-content-center">
                        <button class="btn btn-danger" onclick="AddToCart(<?php echo $prod['id']; ?>, 1);">Add Cart</button>
                    </div>
                </div>
            </div>
        </div>
    <?php
    }
    ?>
    </div>
    <?php
                $PgnStart = 1;
                if($PageNumbers > 4){
                    if($page > $PageNumbers-4){
                        $PgnStart = $PageNumbers-4;
                        $backFPage = "on" ;
                    }
                    if($page <= $PageNumbers-4){
                        $PgnStart = $page;
                    }
                    $Pgnlimit = $PgnStart+4;
                }else{
                    $PgnStart = 1;
                    $Pgnlimit = $PageNumbers;
                }
                ?>  
                <div class="row my-3 mt-4">
                    <nav aria-label="Page navigation">
                        <ul class="pagination justify-content-center col-gap">
                            <li class="page-item <?php if($page == 1){echo "disabled";}else{} ?> "><button onclick="BasicSearch('<?php echo $page-1; ?>');" class="page-link">&laquo;</button></li>
                            <?php if((isset($backFPage)) && $page > 4){?><li class="page-item page-item-xs-none"><button class="page-link" onclick="BasicSearch('1');">1</button></li>
                                <li class="page-item disabled page-item-xs-none"><button class="page-link">...</button></li><?php } ?>
                            <?php for($Pgn = $PgnStart; $Pgn <= $Pgnlimit; $Pgn++){ ?>
                            <li class="page-item <?php if($Pgn == $page){echo "active point-none";} ?>"><button onclick="BasicSearch('<?php echo $Pgn; ?>');" class="page-link"><?php echo $Pgn; ?></a></li>
                            <?php } ?>
                            <li class="page-item <?php if($page == $PageNumbers){echo "disabled";}else{} ?>"><button onclick="BasicSearch('<?php echo $page+1; ?>');" class="page-link">&raquo;</button></li>
                        </ul>
                    </nav>
                </div>
</div>
<?php
}else{
?>
        <!-- carausel -->
        <div class="col-12 text-center">
            <div class="h4 mt-3 mb-5"><p class="bi bi-cart-x mb-1"></p>Sorry. There was no such product in our shop. Please try another</d>
        </div>
        <div class="col-10 offset-1 d-none d-lg-block">
                <div class="row">
                    <div id="carouselExampleCaptions" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-indicators">
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="0"
                                class="active" aria-current="true" aria-label="Slide 1"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="1"
                                aria-label="Slide 2"></button>
                            <button type="button" data-bs-target="#carouselExampleCaptions" data-bs-slide-to="2"
                                aria-label="Slide 3"></button>
                        </div>
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <img src="resources/slider images/posterimg.jpg" class="d-block posterimg1" alt="...">
                                <div class="carousel-caption d-none d-md-block postercaption">
                                    <h5 class="postertitle">Welcome to eShop</h5>
                                    <p class="postertext">The World's best online shopping store</p>
                                </div>
                            </div>
                            <div class="carousel-item">
                                <img src="resources/slider images/posterimg2.jpg" class="d-block posterimg1" alt="...">
                                <!-- <div class="carousel-caption d-none d-md-block">
                                    <h5>Second slide label</h5>
                                    <p>Some representative placeholder content for the second slide.</p>
                                </div> -->
                            </div>
                            <div class="carousel-item">
                                <img src="resources/slider images/posterimg3.jpg" class="d-block posterimg1" alt="...">
                                <div class="carousel-caption d-none d-md-block postercaption1">
                                    <h5 class="postertitle">Be Free...</h5>
                                    <p class="postertext">Experience the lowest delivery costs with us</p>
                                </div>
                            </div>
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleCaptions"
                            data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <!-- carausel End-->
            <?php
                $rs = Database::search("SELECT * FROM `category`");
                $n = $rs->num_rows;
                for ($x = 0; $x < $n; $x++) {
                    $c = $rs->fetch_assoc();
            ?>
            <div class="col-12">
                <!-- product title view Start-->
                <div class="row">
                    <div class="col-12 col-md-10 offset-md-1 mt-3 mb-3">
                        <a class="link-dark link2" href="#"><?php echo $c["name"]; ?></a>
                        <a class="link-dark link3" href="#">&nbsp;&nbsp; See All &rightarrow;</a>
                    </div>
                </div>
                <!-- product title view End -->
                <!-- product view Start -->
                <div class="row">
                    <div class=" col-12 col-md-10 offset-md-1 mb-3">
                        <div class="row justify-content-center border border-primary">
                            <?php
                                            
                            $resultset = Database::search("SELECT * FROM `product_view` WHERE `category_id` = '".$c["id"]."' AND `status_id` IN (1,3);");
                            $nr = $resultset->num_rows;
                            for ($y = 0; $y < $nr; $y++) {
                            $prod = $resultset->fetch_assoc();
                            $EncryId = ((((($prod['id']+8736)*1738)+9731)*4873)+58319);
                            $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$prod["id"]."' LIMIT 1;");
                            $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$prod["condition_id"]."';");
                            $Stat = Database::search("SELECT `name` FROM `status` WHERE `id`='".$prod["status_id"]."';");
                            if(isset($_SESSION["user"])){
                                $UserResult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]['email']."' AND `product_id`='".$prod["id"]."';");
                                $WishData = $UserResult->fetch_assoc();
                            }                            
                            $imgrow = $pimage->fetch_assoc();
                            $Condid = $Condit->fetch_assoc();
                            $Stats = $Stat->fetch_assoc();
                            ?>
                            <div class="card col-12 col-sm-6 col-md-4 col-lg-4 col-xl-3  mt-3 mb-3">
                                <img src="<?php echo $imgrow['code']; ?>" class="card-img-top cardTopImg product-img">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo mb_strimwidth($prod["title"], 0, 18, "..."); ?><span
                                            class="badge bg-info"><?php echo $Condid["name"]; ?></span>
                                    </h5>
                                    <div class="d-flex flex-column gap-2">
                                        <span class="card-text text-primary h4">Rs: <?php echo $prod['price']; ?>.00</span>
                                        <div class="col-10 offset-1 text-center mt-2 mb-2">
                                            <p class="card-text"><?php echo mb_strimwidth($prod['description'], 0, 50, "...") ; ?></p>
                                            <span class="card-text text-orange h5"><?php echo $Stats["name"]; ?></span>
                                        </div>
                                    </div>
                                    <div class="row justify-content-between mt-3 mb-3">
                                        <div class="col-12 d-flex col-gap mb-3 px-4">
                                            <input class="form-control bg-smoke" type="number" value="<?php echo $prod['qty']; ?>"
                                                disabled />
                                            <i  id="HeartWish<?php echo $prod['id']; ?>" onclick="AddWishList(<?php echo $prod['id']; ?>);" class="bi bi-heart-fill <?php if(isset($_SESSION["user"])){if($WishData["product_id"] == $prod['id']){ echo "text-warning";}} ?>"></i>
                                        </div>
                                        <div class="col p-0 d-flex justify-content-center">
                                            <a href="singleproductview.php?Product=<?php echo $prod["title"]."&Level=".$EncryId; ?>" class="btn btn-success <?php if($prod['qty'] == 0){echo "point-none";} ?>">Buy Now</a>
                                        </div>
                                        <div class="col p-0 d-flex justify-content-center">
                                            <button class="btn btn-danger" onclick="AddToCart(<?php echo $prod['id']; ?>, 1);">Add Cart</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php
                        }
                        ?>
                        </div>
                    </div>
                </div>
            </div>
            <?php
                }
                ?>
            <!-- product view End -->
<?php
}
?>