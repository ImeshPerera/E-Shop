<?php
session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
?>

<!DOCTYPE html>
<html>

<head>
    <title>eShop | Admin Sign In</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
    <style>
        td{
            vertical-align: middle;
        }
    </style>
</head>

<body>
<?php require "alert.php"; ?>
    <div class="container-fluid bg-primary">
        <div class="row">
            <div class="col-12 col-md-3 col-lg-2 bg-white">
                <div class="row mt-md-3">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0">ADMIN</p>
                    </div>
                    <div class="col-12">
                        <hr/>
                    </div>
                </div>
                <!-- breadcrumb and  title -->
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb bg-white ps-3">
                        <li class="breadcrumb-item"><a class="nav-link p-0" href="home.php">Admin </a></li>
                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Dashboard</li>
                    </ol>
                </nav>
                <nav class="nav flex-column row-gap-1">
                    <a class="btn btn-primary text-white nav-link" href="manageusers.php">Manage Users</a>
                    <a class="btn btn-primary text-white nav-link" href="manageproducts.php">Manage Products</a>
                    <a class="btn btn-primary text-white nav-link" href="sellinghistory.php">Sellings</a>
                    <a class="btn btn-primary text-white nav-link" href="newapply.php">Develops</a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10 mb-3">
                <div class="row pt-md-3 g-1">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0 text-white">Dashboard</p>
                    </div>
                </div>
                <div class="row my-1 ">
                    <div class="col-12">
                        <div class="row gx-1">
                            <div class="col-12 p-2 pt-3 d-flex rounded justify-content-between align-items-center bg-white">
                                <span class="fw-bold h4">Beautiful Today :</span>
                                <?php
                                $datedata = new DateTime();
                                $timeZone = new DateTimeZone("Asia/Colombo");
                                $datedata->setTimezone($timeZone);
                                $date = $datedata->format("Y-m-d");                               
                                ?>
                                <span class="fw-bold h4"><?php echo $date; ?></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row my-1 ">
                    <div class="col-12">
                        <div class="row gx-1">
                            <div class="col-12 p-2 pt-3 d-flex rounded justify-content-between align-items-center bg-white">
                                <span class="fw-bold h4">We are Online :</span>
                                <?php
                                $DateStart = Database::search("SELECT * FROM `application`;");
                                $DateData = $DateStart->fetch_assoc();
                                $dateTimeNow = $datedata->format("Y-m-d H:i:s");
                                $date1 = strtotime($DateData["datestart"]); 
                                $date2 = strtotime($dateTimeNow); 
                                $diff = abs($date2 - $date1); 
                                $years = floor($diff / (365*60*60*24)); 
                                $months = floor(($diff - $years * 365*60*60*24) / (30*60*60*24)); 
                                $days = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24)/ (60*60*24));
                                $hours = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24) / (60*60)); 
                                $minutes = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60)/ 60); 
                                $seconds = floor(($diff - $years * 365*60*60*24 - $months*30*60*60*24 - $days*60*60*24 - $hours*60*60 - $minutes*60)); 
                                    ?>
                                <span class="fw-bold h4"><?php printf("%d years, %d months, %d days, %d hours, %d minutes, %d seconds", $years, $months, $days, $hours, $minutes, $seconds); ?></span>
                                <!-- <span class="fw-bold h4">&nbsp;01&nbsp;Y&nbsp;:&nbsp;02&nbsp;M&nbsp;:&nbsp;25&nbsp;D :&nbsp;05&nbsp;H&nbsp;:&nbsp;45&nbsp;M&nbsp;:&nbsp;55&nbsp;S</span> -->
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-1">
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Daily Earnings</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $DailyRevenue = Database::search("SELECT SUM(`total`) AS `day_total` FROM `invoice` WHERE `datetime_purchased` LIKE '".$date."%' ;");
                                    $DailyReData = $DailyRevenue->fetch_assoc();
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rs. <?php echo number_format($DailyReData["day_total"]); ?>.00</h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-graph-up"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger"><?php echo $date; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Monthly Earnings</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $Month = $datedata->format("Y-m");                               
                                    $MonthRevenue = Database::search("SELECT SUM(`total`) AS `month_total` FROM `invoice` WHERE `datetime_purchased` LIKE '".$Month."%' ;");
                                    $MonthReData = $MonthRevenue->fetch_assoc();
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rs. <?php echo number_format($MonthReData["month_total"]); ?>.00</h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-graph-up"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger"><?php echo $Month; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Total Engagements</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $AllRevenue = Database::search("SELECT SUM(`total`) AS `sum_total` FROM `invoice`;");
                                    $AllReData = $AllRevenue->fetch_assoc();                                    
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0">Rs. <?php echo number_format($AllReData["sum_total"]); ?>.00</h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-graph-up"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger">All Time</p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Today Sellings</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $DailySum = Database::search("SELECT SUM(`buy_qty`) AS `day_sum` FROM `invoice` WHERE `datetime_purchased` LIKE '".$date."%' ;");
                                    $DailySumData = $DailySum->fetch_assoc();
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo number_format($DailySumData["day_sum"]); ?></h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-collection"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger"><?php echo $date; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Monthly Sellings</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $MonthSum = Database::search("SELECT SUM(`buy_qty`) AS `month_sum` FROM `invoice` WHERE `datetime_purchased` LIKE '".$Month."%' ;");
                                    $MonthSumData = $MonthSum->fetch_assoc();
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo number_format($MonthSumData["month_sum"]); ?></h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-collection"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger"><?php echo $Month; ?></p>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card pale-gold">
                            <div class="card-body">
                                <p class="card-title text-md-center text-xl-left">Total Sellings</p>
                                <div class="d-flex flex-wrap justify-content-between justify-content-md-center justify-content-xl-between align-items-center">
                                    <?php
                                    $AllSum = Database::search("SELECT SUM(`buy_qty`) AS `all_sum` FROM `invoice`;");
                                    $AllSumData = $AllSum->fetch_assoc();                                    
                                    ?>
                                    <h3 class="mb-0 mb-md-2 mb-xl-0 order-md-1 order-xl-0"><?php echo number_format($AllSumData["all_sum"]); ?></h3>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-collection"></i>
                                </div>
                                <p class="mb-0 mt-2 text-danger">All Time</p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php
                $BestSell = Database::search("SELECT `product_id`,SUM(`buy_qty`) AS `sum_qty` FROM `invoice` WHERE `datetime_purchased` LIKE '".$date."%' GROUP BY `product_id` ORDER BY `sum_qty` DESC LIMIT 1;");
                $BestNum = $BestSell->num_rows;
                
                if($BestNum > 0){
                    $BestData = $BestSell->fetch_assoc();
                    $Resultset = Database::search("SELECT * FROM `product_view` WHERE `id` = '".$BestData["product_id"]."';");
                    $PData = $Resultset->fetch_assoc();
                    $productimage = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$BestData["product_id"]."' LIMIT 1;");
                    $imagesdata = $productimage->fetch_assoc();
                    $UImageCheck = Database::search("SELECT `user_code` FROM user_image WHERE `user_email` = '".$PData["seller_email"]."';");
                    $CheckImg = $UImageCheck->fetch_assoc();
                    $Seller = Database::search("SELECT * FROM `user` WHERE `email` = '".$PData["seller_email"]."';");
                    $Sellerdata = $Seller->fetch_assoc();                
                ?>
                    <div class="row row-gap-1 mt-1">
                        <div class="col-lg-6 pe-lg-1">
                            <div class="card h-100">
                                <div class="card-body h-100 justify-content-start">
                                    <p class="card-title h4 bi bi-trophy flex-row-reverse pb-3">Best Seller</p>
                                    <div class="d-flex align-items-center justify-content-center p-0 pe-2">
                                        <img src="<?php if(isset($CheckImg["user_code"])){echo $CheckImg["user_code"];}else{echo "User_img/demoProfileImg.jpg";}?>" height="250px" width="250px" class="rounded-circle round-image me-2">
                                    </div>
                                    <div class="d-flex align-items-center flex-column pt-3">
                                        <p class="card-title"><?php echo $Sellerdata["fname"]." ".$Sellerdata["lname"]; ?></p>
                                        <p class="card-title"><?php echo $Sellerdata["email"]; ?></p>
                                        <p class="card-title"><?php echo $Sellerdata["mobile"]; ?></p>
                                        <p class="card-title">Joined : <?php echo $Sellerdata["register_date"]; ?></p>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-6 ps-lg-0">
                            <div class="card">
                                <div class="card-body">
                                    <p class="card-title h4 bi bi-trophy flex-row-reverse pb-3">Best Product</p>
                                    <div class="d-flex  align-items-center justify-content-center p-0 pe-2">
                                        <img src="<?php echo $imagesdata["code"] ?>" height="250px" class="max-w-100 round-image2" />
                                    </div>
                                    <div class="d-flex align-items-center flex-column pt-3">
                                        <p class="card-title"><?php echo $PData["title"] ?></p>
                                        <p class="card-title">Sold : <?php echo $BestData["sum_qty"] ?></p>
                                        <p class="card-title">Rs. <?php echo $PData["price"] ?>.00</p>
                                        <p class="card-title">Qty Left : <?php echo $PData["qty"] ?></p>
                                        <p class="card-title px-lg-5"><?php echo $PData["description"] ?></p>
                                    </div>
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
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>
<?php
}else{
?>
<script>window.location="admin.php";</script>
<?php
}
