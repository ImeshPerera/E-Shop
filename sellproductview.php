<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){

    $page = 1;
    $offset = 0;
    if(isset($_GET["page"])){
        if(empty($_GET["page"])){
            $page = 1;
        }else{
            $page = $_GET["page"];
            $offset = 2*($page-1);
        }
    }
    $allProductRows =  Database::search("SELECT * FROM `product_view` WHERE `seller_email` = '".$_SESSION["user"]['email']."';");
    $allProductnm = $allProductRows->num_rows;
    $DividedNumber = $allProductnm/2 ;
    $PageNumbers = intval($DividedNumber);
    if($allProductnm%2 != 0){
        $PageNumbers = $PageNumbers+1;
    }
    if($page > $PageNumbers){
        $page = 1;
    }
    $resultsetofmyproduct = Database::search("SELECT * FROM `product_view` WHERE `seller_email` = '".$_SESSION["user"]['email'] ."' LIMIT 2 OFFSET ".$offset.";");
?>
<!DOCTYPE html>
<html>

<head>
    <title>eShop Seller's Product View</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body class="bg-light">
    <!-- Alert -->
    <?php require "alert.php"; ?>
    <!-- Alert -->
    <div class="container-fluid bg-smoke">
        <!-- head start -->
        <div class="row">
            <div class="col-12 bg-primary">
                <div class="row justify-content-md-center">
                    <div class="col-12 my-1">
                        <div class="row">
                            <div class="d-flex overflow-scroll head-scroll">
                                <?php
                                $UImageCheck = Database::search("SELECT `user_code` FROM user_image WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                                $CheckImg = $UImageCheck->fetch_assoc();
                                ?>
                                <div class="d-flex pe-2">
                                    <img class="rounded-circle round-image" src="<?php if(isset($CheckImg["user_code"])){echo $CheckImg["user_code"];}else{echo "User_img/demoProfileImg.jpg";}?>"
                                        width="90px" height="90px" />
                                </div>
                                <div class="d-flex ps-2">
                                    <div class="d-flex flex-column align-items-center justify-content-center">
                                        <span class="fw-bold h5 text-capitalize text-white-50"><?php echo $_SESSION["user"]["fname"]."&nbsp;".$_SESSION["user"]["lname"]; ?></span>
                                        <span class="text-white"><?php echo $_SESSION["user"]["email"]; ?></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-xl-4 Product-row">
                        <div class="row text-center align-items-center">
                            <label class="h1 fw-bold text-white">My Products</label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- head End -->
        <!-- Filter Start -->
        <div class="row">
        </div>
        <!-- Filter End -->
        <!-- Products End -->
        <div class="row">
            <div class="col-12 col-lg-3 my-lg-3 bg-white border">
                <div class="row">
                    <div class="col-12 my-2">
                        <nav>
                            <ol class="d-flex flex-wrap mb-0 list-unstyled bg-white rounded">
                                <li class="breadcrumb-item"><a href="home.php"
                                        class="text-decoration-none text-black-50">Home</a></li>
                                <li class="breadcrumb-item"><a
                                        class="text-decoration-none text-black-50 point-none">My Products</a></li>
                            </ol>
                        </nav>
                    </div>
                    <div class="col-12 text-center pt-3">
                        <label class="form-label">Filtering</label>
                    </div>
                    <div class="col-12">
                        <div class="input-group mb-3">
                            <input type="text" class="form-control" placeholder="Search Here" id="SellerSearchInput" aria-label="Search Here"
                                aria-describedby="Search">
                            <button class="btn btn-primary fs-6 bi bi-search" type="button" onclick="SellerSearch();"></button>
                        </div>
                    </div>
                </div>
                <hr class="hrbreak1" />
                <div class="row justify-content-center">
                    <div
                        class="col-12 col-sm-6 col-md-4 col-lg-12 ps-3 d-sm-flex d-md-block flex-sm-column justify-content-sm-center">
                        <div class="row ps-3">
                            <label class="form-label">Active Time</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByDate" id="ProNeOl" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="ProNeOl">
                                Newest to Oldest
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByDate" id="ProOlNe" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="ProOlNe">
                                Oldest to Newest
                            </label>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <div
                        class="col-12 col-sm-6 col-md-4 col-lg-12 ps-3 d-sm-flex d-md-block flex-sm-column justify-content-sm-center">
                        <div class="row ps-3">
                            <label class="form-label">By Quantity</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByQty" id="QtyLoHi" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="QtyLoHi">
                                Qty Low to High
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByQty" id="QtyHiLo" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="QtyHiLo">
                                Qty High to Low
                            </label>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <div class="col-12 col-sm-6 col-md-4 col-lg-12 ps-3 d-sm-flex d-md-block flex-sm-column justify-content-sm-center">
                        <div class="row ps-3">
                            <label class="form-label">By Condition</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByCond" id="CondNew" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="CondNew">
                                Brand New
                            </label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="SearchByCond" id="CondUse" onclick="SellerSearch();"/>
                            <label class="form-check-label" for="CondUse">
                                Used
                            </label>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <div class="col-12 col-md-4 col-lg-12 ps-3 d-sm-flex d-md-block flex-sm-column justify-content-sm-center">
                        <div class="row mb-3">
                            <div class="col-12 d-flex justify-content-center">
                                <button onclick="ResetSorting();" class="btn btn-primary">Reset</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div id="SearchProductFill" class="col-12 col-lg-9">
                <div class="row justify-content-evenly">
                    <?php 
                    for($Value = 0; $Value < 2; $Value++){
                    $dataofproduct = $resultsetofmyproduct->fetch_assoc(); 
                    if($dataofproduct != null){
                        $pimage = Database::search("SELECT * FROM `images_view` WHERE `product_id` = '".$dataofproduct["id"]."' LIMIT 1;");
                        $imgrow = $pimage->fetch_assoc();
                        $Pstatus = Database::search("SELECT * FROM `status` WHERE `id`='".$dataofproduct["status_id"]."';");
                        $Prodstatus = $Pstatus->fetch_assoc();
                        ?>
                    <div class="col-11 col-md-5-5 bg-white border border-2 mt-3">
                        <div class="card m-3">
                            <div class="row g-0 overflow-hidden">
                                <div class="col-12 col-xl-4 d-flex justify-content-center overflow-hidden">
                                    <img src="<?php echo $imgrow['code']; ?>" class="round-image2 product-img">
                                </div>
                                <div class="col-12 col-xl-8">
                                    <div class="card-body">
                                        <div class="d-flex flex-column g-1 align-items-center">
                                            <h5 class="card-title"><?php echo $dataofproduct["title"]; ?></h5>
                                            <span class="card-text text-primary">Rs: <?php echo $dataofproduct['price']; ?>.00</span>
                                            <span class="card-text text-warning"><?php echo $dataofproduct['qty']; ?> Items Left</span>
                                            <label class="form-label text-center"><b
                                                    class="text-dark">Product Status : </b><span id="StsNow<?php echo $dataofproduct["id"]; ?>" class="text-bold <?php if($Prodstatus['id'] == 1){echo "text-green";}else if($Prodstatus['id'] == 3){echo "text-warning";}else{echo "text-danger";} ?>"><?php echo $Prodstatus['name']; ?></span></label>
                                            <div class="row form-check form-switch">
                                                <input onclick="ChangeStatus('ChangPSts<?php echo $dataofproduct['id']; ?>');" id="ChangPSts<?php echo $dataofproduct["id"]; ?>" class="form-check-input" type="checkbox" role="switch" <?php if($Prodstatus['id'] != 1){echo "checked";}else{}  ?> value="<?php echo $dataofproduct["id"]; ?>">
                                                <label class="form-check-label" for="ChangPSts<?php echo $dataofproduct["id"]; ?>">Change
                                                    Product Status</label>
                                            </div>
                                        </div>
                                        <form action="addproduct.php?Update" method="POST">
                                            <div class="row justify-content-between Prodbtn mt-3 mb-3">
                                                <input type="text" value="<?php echo $dataofproduct["id"]; ?>" class="d-none" name="FromViewid"/>
                                                <div
                                                    class="col-6 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0 my-lg-1 my-xl-0 p-0 d-flex justify-content-center">
                                                    <button type="submit" class="btn btn-success w-90">Update</button>
                                                </div>
                                                <div class="col-6 col-lg-8 offset-lg-2 col-xl-6 offset-xl-0 my-lg-1 my-xl-0 p-0 d-flex justify-content-center">
                                                    <button class="btn btn-danger w-90">Delete</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
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
                    <nav aria-label="Page navigation example">
                        <ul class="pagination justify-content-center col-gap">
                            <li class="page-item <?php if($page == 1){echo "disabled";}else{} ?> "><a href="?page=<?php echo $page-1; ?>" class="page-link">&laquo;</a></li>
                            <?php if((isset($backFPage)) && $page > 4){?><li class="page-item page-item-xs-none"><a class="page-link" href="?page=1">1</a></li>
                                <li class="page-item disabled page-item-xs-none"><a class="page-link">...</a></li><?php } ?>
                            <?php for($Pgn = $PgnStart; $Pgn <= $Pgnlimit; $Pgn++){ ?>
                            <li class="page-item <?php if($Pgn == $page){echo "active point-none";} ?>"><a href="?page=<?php echo $Pgn; ?>" class="page-link"><?php echo $Pgn; ?></a></li>
                            <?php } ?>
                            <li class="page-item <?php if($page == $PageNumbers){echo "disabled";}else{} ?>"><a href="?page=<?php echo $page+1; ?>" class="page-link">&raquo;</a></li>
                        </ul>
                    </nav>
                </div>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <?php
            require "footer.php";
            ?>
        </div>
    </div>
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