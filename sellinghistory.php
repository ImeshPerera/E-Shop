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
    <!-- Alert -->
    <?php require "alert.php"; ?>
    <!-- Alert -->
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
                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Sellings</li>
                    </ol>
                </nav>
                <nav class="nav flex-column row-gap-1 mb-3">
                    <a class="btn btn-primary text-white nav-link" href="adminpanel.php">Dashboard</a>
                    <a class="btn btn-primary text-white nav-link" href="manageusers.php">Manage Users</a>
                    <a class="btn btn-primary text-white nav-link" href="manageproducts.php">Manage Products</a>
                    <a class="btn btn-primary text-white nav-link" href="newapply.php">Develops</a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10 mb-3">
                <div class="row pt-md-3 g-1">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0 text-white">Sellings</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Products sold</h4>
                                <div class="d-flex justify-content-center flex-column flex-sm-row row-gap-1 my-2 align-items-center">
                                    <label class="form-label mb-0">From</label>
                                    <input type="date" class="form-control" id="AdminsellSearchon" />
                                    <label class="form-label mb-0 ms-sm-2">To</label>
                                    <input type="date" class="form-control" id="AdminsellSearchto"/>
                                    <button onclick="SearchinSellad();" class="btn btn-outline-primary ms-sm-2">Search</button>
                                </div>
                                <div class="table-responsive mt-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>Order Id</th>
                                                <th>Product</th>
                                                <th>Buyer</th>
                                                <th>Total Pay</th>
                                                <th>Quantity</th>
                                                <th>Purchase date</th>
                                            </tr>
                                        </thead>
                                        <tbody id="SellBodyFill">
                                            <?php
                                            $AllinInvoice = Database::search("SELECT * FROM `invoice`;");
                                            $AllINum = $AllinInvoice->num_rows;
                                            for($i = 1; $i <= $AllINum; $i++){
                                                $AlliData = $AllinInvoice->fetch_assoc();
                                                $AllProduct = Database::search("SELECT * FROM `product_view` WHERE `id` = '".$AlliData["product_id"]."';");
                                                $AllPData = $AllProduct->fetch_assoc();
                                                $PImages = Database::search("SELECT `code` FROM `images_view` WHERE `product_id` = '".$AllPData["id"]."' LIMIT 1;");
                                                $PImg = $PImages->fetch_assoc();  
                                                $AllUsers = Database::search("SELECT * FROM `user` WHERE `email` = '".$AlliData["user_email"]."';");
                                                $AllUdata = $AllUsers->fetch_assoc();                          
                                            ?>
                                                <tr <?php if($AllPData["status_id"] == 4){echo "class='bg-danger'";}else{}?>>
                                                    <td><?php echo $AlliData["order_id"]?></td>
                                                    <td><img class="round-image2" src="<?php echo $PImg["code"];?>" height="50px" alt="image" />
                                                    <?php echo mb_strimwidth($AllPData["title"], 0, 30, "..."); ?></td>
                                                    <td><?php echo mb_strimwidth($AllUdata["fname"]." ".$AllUdata["lname"], 0, 25, "..."); ?></td>
                                                    <td>Rs. <?php echo number_format($AlliData["total"]); ?>.00</td>
                                                    <td><?php echo $AlliData["buy_qty"]; ?></td>
                                                    <td><?php echo $AlliData["datetime_purchased"]; ?></td>
                                                </tr>
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
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