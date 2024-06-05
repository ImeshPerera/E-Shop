<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
?>

<!DOCTYPE html>
<html>

<head>
    <title>eShop | Watch List</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body>
    <?php require "alert.php"; ?>
    <div class="container-fluid">
    <?php require "header.php"; ?>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-12 border border-1 border-secondary">
                <div class="row">
                    <!-- topic start -->
                    <div class="col-12">
                        <label class="form-label  fs-1 fw-bolder">Watchlist <i class="bi bi-heart-fill"></i></label>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- topic close -->

                    <div class="col-12">
                        <div class="row justify-content-center">
                            <!-- Search and button start -->

                            <div class="col-12 col-md-10">                
                                <div class="d-flex mb-3">
                                    <input type="text" class="form-control" id="WatchListSearch" placeholder="Search in Watchlist" />
                                    <button onclick="SearchInWatchlist();" class="btn btn-outline-primary ms-2-5">Search</button>
                                </div>
                            </div>
                            <hr class="hrbreak1" />

                            <!-- Search and button close -->
                            <div class="col-12 col-lg-2 border-2 border-lg-end border-primary mb-2">

                                <!-- breadcrumb and  title -->
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb ps-3">
                                        <li class="breadcrumb-item"><a class="nav-link p-0" href="home.php">Home</a></li>
                                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Watchlist</li>
                                    </ol>
                                </nav>
                                <nav class="nav justify-content-center flex-lg-column">
                                    <a class="nav-link active point-none" aria-current="page">My Watchlist</a>
                                    <a class="nav-link" href="cart.php">My Cart</a>
                                    <a class="nav-link" href="recent.php">Recently Viewed</a>
                                    <a class="nav-link" href="purchasehistory.php">Perchased</a>
                                </nav>
                            </div>
                            <?php
                            $WishListresult = Database::search("SELECT * FROM `watchlist` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                            $WishNum = $WishListresult->num_rows;
                            if($WishNum < 1){
                            ?>
                            <!-- without items  start-->

                            <div class="col-12 col-lg-9 d-flex justify-content-center" id="WatchListSearchFill">
                                <div class="row text-center" style="height: 300px;">
                                    <i class="col-12 text-center bi bi-emoji-frown fs-1 m-0 d-flex justify-content-center align-items-end pb-4"></i>
                                    <label class="form-label fs-1 mb-3 fw-bolder">You have no items in your Watchlist</label>
                                </div>
                            </div>
                            <!-- without items  close-->

                            <!--items Section start -->
                            <?php
                            }elseif($WishNum >= 1){
                            ?>
                            <div class="col-12 col-lg-10">
                                <div id="WatchListSearchFill" class="row g-2">
                                <?php 
                                for($n = 0; $n < $WishNum; $n++){
                                    $WishData = $WishListresult->fetch_assoc();
                                    $ProductResult =  Database::search("SELECT * FROM `product_view` WHERE `id` = '".$WishData["product_id"]."';");
                                    $ProductData = $ProductResult->fetch_assoc();                                
                                    $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$ProductData["id"]."' LIMIT 1;");
                                    $Condit = Database::search("SELECT `name` FROM `condition` WHERE `id`='".$ProductData["condition_id"]."';");
                                    $StatUs = Database::search("SELECT `name` FROM `status` WHERE `id`='".$ProductData["status_id"]."';");
                                    $Seller = Database::search("SELECT `fname`,`lname` FROM user WHERE `email` = '".$ProductData["seller_email"]."';");
                                    $PColor = Database::search("SELECT `name` FROM `color_view` WHERE `product_id`='".$ProductData["id"]."';");
                                    $EncryId = ((((($ProductData['id']+8736)*1738)+9731)*4873)+58319);
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
                                                        <h3 class="card-title"><?php echo mb_strimwidth($ProductData["title"], 0, 28, "..."); ?></h3>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="fw-bold text-black-50">Colour : <?php echo $ProColor['name']; ?></span>
                                                        <br/>
                                                        <span class="fw-bold text-black-50">Condition :  <?php echo $Condid['name']; ?></span>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="fw-bold text-black-50 fs-4">Price :&nbsp;</span>
                                                        <br/>
                                                        <span class="fw-bold text-black fs-5">Rs: <?php echo $ProductData['price']; ?>.00</span>
                                                    </div>
                                                    <div class="col-12">
                                                        <span class="fw-bold text-black-50 fs-4">Seller : </span>
                                                        <br/>
                                                        <span class="fw-bold text-black fs-6"><?php echo $Selldata['fname']."&nbsp;".$Selldata['lname']; ?></span>
                                                        <br/>
                                                        <span class="fw-bold text-black fs-6"><?php echo $ProductData["seller_email"]; ?></span>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-3 mt-4 d-flex align-items-center bg-light">
                                                <div class="card-body d-flex row-gap">
                                                    <a href="singleproductview.php?Product=<?php echo $ProductData["title"]."&Level=".$EncryId; ?>" class="btn btn-outline-success fw-bold">Buy Now</a>
                                                    <button onclick="AddToCart(<?php echo $ProductData['id']; ?>, 1);" class="btn btn-outline-warning fw-bold">Add Cart</button>
                                                    <button onclick="MoveToRecent(<?php echo $ProductData['id']; ?>);" class="btn btn-outline-danger fw-bold">Remove</button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!--items card close-->
                                    <?php 
                                    }   
                                    ?>
                                </div>
                            </div>
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

    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script src="script.js"></script>

</body>

</html>
<?php
}else{
?>
    <script>window.location="index.php?Sign_In";</script>
<?php
}
?>