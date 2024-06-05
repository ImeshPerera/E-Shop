<?php

session_start();
require "connection.php";

?>
<!DOCTYPE html>
<html>

<head>
    <title>eShop Home</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php require "alert.php"; ?>
    <!-- header Start-->
    <div class="container-fluid">
        <?php require "header.php"; ?>
    </div>
    <!-- header End-->
    <div class="container-fluid">
        <div class="row">
            <!-- searchbar -->
            <div class="col-12">
                <div class="row">
                    <div class="col-lg-2 col-12 mb-3 ">
                        <div class="row">
                            <div class="d-flex justify-content-center">
                                <img class="logoimg" src="resources/logo.svg" />
                            </div>
                        </div>
                    </div>
                    <div class="col-7 col-sm-6 col-md-8 col-lg-6">
                        <div class="input-group input-group-lg mt-3 mb-3">
                            <input type="text" class="form-control d-none d-sm-inline" id="SearchItems"
                                aria-label="Text input with dropdown button">
                            <button class="btn btn-outline-primary dropdown-toggle" type="button" id="BasicSearchCategory" value="0"
                                data-bs-toggle="dropdown" aria-expanded="false">Category</button>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <?php
                                $rs = Database::search("SELECT * FROM `category`");
                                $n = $rs->num_rows;

                                for ($i = 0; $i < $n; $i++) {
                                    $cat = $rs->fetch_assoc();
                                ?>
                                <li><button class="dropdown-item" href="#" id="ShowCat<?php echo $cat["id"]; ?>"  onclick="ShowCatItem('ShowCat<?php echo $cat['id'];?>');"
                                        value="<?php echo $cat["id"]; ?>"><?php echo $cat["name"]; ?></button></li>
                                <?php
                                }

                                ?>
                                <!-- <li><a class="dropdown-item" href="#">Cell Phones & Accessories</a></li>
                                <li><a class="dropdown-item" href="#">Video Game Consoles</a></li> -->
                            </ul>
                        </div>
                    </div>
                    <div class="col-5 col-sm-2 m-auto d-flex m-auto">
                        <button class="btn btn-primary m-auto searchbtn" onclick="BasicSearch();">Search</button>
                    </div>
                    <div class="col-2 m-auto d-none d-sm-inline">
                        <a href="advancedsearch.php" class="link-secondary link1">Advanced</a>
                    </div>
                </div>
            </div>
        </div>
        <!-- searchbar -->
        <hr class="hrbreak1" />
        <div id="BasicSearchFill" class="row">                        
        <!-- carausel -->
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
                    </div>
                </div>
            </div>
            <?php
                }
                ?>
            <!-- product view End -->
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
        <!-- footer Start -->
        <?php require "footer.php"; ?>
        <!-- footer End -->
        </div>
    </div>


    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>