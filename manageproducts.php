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
                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Manage Products</li>
                    </ol>
                </nav>
                <nav class="nav flex-column row-gap-1 mb-3">
                    <a class="btn btn-primary text-white nav-link" href="adminpanel.php">Dashboard</a>
                    <a class="btn btn-primary text-white nav-link" href="manageusers.php">Manage Users</a>
                    <a class="btn btn-primary text-white nav-link" href="sellinghistory.php">Sellings</a>
                    <a class="btn btn-primary text-white nav-link" href="newapply.php">Develops</a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10 mb-3">
                <div class="row pt-md-3 g-1">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0 text-white">Products</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">Product Management</h4>
                                <div class="d-flex justify-content-center my-2">
                                    <input type="text" class="form-control" id="AdminProductSearch" placeholder="Search Products" />
                                    <button onclick="AdminProductSearch();" class="btn btn-outline-primary ms-2-5">Search</button>
                                </div>
                                <div class="table-responsive mt-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Product Image</th>
                                                <th>Title</th>
                                                <th>Price</th>
                                                <th>Quantity</th>
                                                <th>Listed Date</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="AdminProductFill">
                                            <?php
                                            $AllProduct = Database::search("SELECT * FROM `product_view`;");
                                            $AllPNum = $AllProduct->num_rows;
                                            for($i = 1; $i <= $AllPNum; $i++){
                                                $AllPData = $AllProduct->fetch_assoc();
                                                $PImages = Database::search("SELECT `code` FROM `images_view` WHERE `product_id` = '".$AllPData["id"]."' LIMIT 1;");
                                                $PImg = $PImages->fetch_assoc();                        
                                            ?>
                                                <tr <?php if($AllPData["status_id"] == 4){echo "class='bg-danger'";}else{}?>>
                                                    <td><?php if($i < 10){ echo "0".$i ;}else{echo $i ;} ?></td>
                                                    <td class="admin-sp-flex">
                                                        <img onclick="AdminProductView(<?php echo $AllPData['id'] ?>);" class="round-image2" src="<?php echo $PImg["code"];?>" height="50px" alt="image" />
                                                    </td>
                                                    <td><?php echo mb_strimwidth($AllPData["title"], 0, 30, "..."); ?></td>
                                                    <td>Rs. <?php echo number_format($AllPData["price"]); ?>.00</td>
                                                    <td><?php echo $AllPData["qty"]; ?></td>
                                                    <td><?php echo $AllPData["datetime_added"]; ?></td>
                                                    <td><button class="btn d-flex align-items-center <?php if($AllPData["status_id"] == 4){echo "btn-success";}else{echo "btn-danger";}?>" onclick="AdminProductStatus('<?php echo $AllPData['id'] ?>');">
                                                        <i class="bi bi-exclamation-diamond fs-5"></i><span><?php if($AllPData["status_id"] == 4){echo "Unblock";}else{echo "Block";}?></span></button></td>
                                                </tr>
                                                <div class="col-12">
                                                    <div class="modal" id="AdminProductModel<?php echo $AllPData["id"]; ?>" tabindex="-1">
                                                        <div  class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h5 class="modal-title"><?php echo $AllPData["title"] ?></h5>
                                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                            </div>
                                                            <div class="modal-body">
                                                                <div class="d-flex  align-items-center justify-content-center p-0 pe-2">
                                                                    <img src="<?php echo $PImg["code"] ?>" height="250px" class="max-w-100 round-image2" />
                                                                </div>
                                                            </div>
                                                            <div class="modal-body text-center">
                                                                <p class="card-title justify-content-center text-orange">Rs. <?php echo number_format($AllPData["price"]); ?>.00</p>
                                                                <p class="card-title justify-content-center text-info"><?php echo $AllPData["qty"]; ?> Items Left</p>
                                                                <p class="card-title justify-content-center text-primary"><?php echo $AllPData["seller_email"] ?></p>
                                                                <p class="card-title justify-content-center"><?php echo $AllPData["description"] ?></p>
                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                                            </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
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