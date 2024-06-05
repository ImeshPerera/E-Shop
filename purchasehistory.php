<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $invoicers = Database::search("SELECT * FROM `invoice` WHERE `user_email` = '" .$_SESSION["user"]["email"]. "' AND `status_level` = '1';");
    $in = $invoicers->num_rows;
?>

<!DOCTYPE html>

<html>

<head>
    <title>eShop | Transaction History</title>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body>
    <?php require "alert.php" ?>
    <div class="container-fluid">
        <?php require "header.php" ?>
    </div>
    <div class="container-fluid">
        <div class="row text-center align-items-center mt-lg-3">
            <label class="h1 fw-bold text-warning">Transaction History</label>
        </div>
        <div class="row">

            <?php
            if ($in == 0) {
            ?>
            <!-- breadcrumb and  title -->
            <div class="col-12 col-md-3 col-lg-2 border-end border-2 border-primary mb-2">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb ps-3 <?php if($CartNum >= 1){echo "mb-0";} ?>">
                        <li class="breadcrumb-item"><a class="nav-link p-0" href="home.php">Home</a></li>
                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Purchased</li>
                    </ol>
                </nav>
                <nav class="nav <?php if($CartNum < 1){echo "justify-content-center flex-lg-column";} ?>">
                    <a class="nav-link active point-none" aria-current="page">Purchased</a>
                    <a class="nav-link" href="watchlist.php">My Watchlist</a>                    
                    <a class="nav-link" href="cart.php">My Cart</a>
                    <a class="nav-link" href="recent.php">Recently Viewed</a>
                </nav>
            </div>
            <!-- without items  start-->

            <div class="col-12 col-md-9 col-lg-10 d-flex justify-content-center bg-white">
                <div class="row text-center" style="height: 300px;">
                    <i
                        class="col-12 text-center fs-1 bi bi-bag-x m-0 pb-4 d-flex justify-content-center align-items-end"></i>
                    <label class="form-label fs-1 mb-3 fw-bolder">You have no recently purchased items</label>
                    <div class="col-12">
                        <a class="btn btn-primary btn-lg" href="home.php">Start Shopping</a>
                    </div>
                </div>
            </div>
            <!-- without items  close-->
            <?php
            } else {
            ?>

            <div class="col-12 mt-lg-3">
                <div class="row">
                    <div class="col-12 d-none d-lg-block">
                        <div class="row">

                            <div class="col-1 text-center">
                                <label class="form-label text-primary fst-italic fw-bold">#</label>
                            </div>

                            <div class="col-3 text-center">
                                <label class="form-label text-primary fst-italic fw-bold">Order details</label>
                            </div>

                            <div class="col-1 text-center">
                                <label class="form-label text-primary fst-italic fw-bold">Quanity</label>
                            </div>

                            <div class="col-2 text-center">
                                <label class="form-label text-primary fst-italic fw-bold">Amount</label>
                            </div>

                            <div class="col-2 text-center">
                                <label class="form-label text-primary fst-italic fw-bold">Purchase Date & Time</label>
                            </div>

                            <div class="col-3 bg-light"></div>

                            <div class="col-12">
                                <hr class="border border-2 border-primary">
                            </div>

                        </div>
                    </div>

                    <?php
                                            
                    for ($i = 1; $i <= $in; $i++) {
                        $ir = $invoicers->fetch_assoc();
                        $imagers = Database::search("SELECT * FROM `images_view` WHERE `product_id`='".$ir["product_id"]."' LIMIT 1;");
                        $productrs = Database::search("SELECT * FROM `product_view` WHERE `id` = '" .$ir["product_id"]. "';");
                        $product = $productrs->fetch_assoc();
                        $sellers = Database::search("SELECT `fname`,`lname` FROM `user` WHERE `email` = '".$product["seller_email"]. "';");
                        $codeimg = $imagers->fetch_assoc();
                        $seller = $sellers->fetch_assoc();
                        
                    ?>
                    <div class="col-12">
                        <div class="row g-2">
                            <div class="col-12 col-lg-1 bg-info d-flex align-items-center">
                                <label class="form-label text-white fs-6 m-auto"><?php echo $ir["order_id"] ?></label>
                            </div>
                            <div class="col-12 col-lg-3">
                                <div class="row ms-lg-2">
                                    <div class="col-md-4 d-flex align-items-center">
                                        <img src="<?php echo $codeimg["code"] ?>" class="img-fluid rounded-start">
                                    </div>
                                    <div class="col-md-8 d-flex align-items-center">
                                        <div class="card-body">
                                            <p class=" h5 card-title">
                                                <?php echo mb_strimwidth($product["title"], 0, 30, "..."); ?>
                                            </p>
                                            <p class="card-text mb-1"><b>Seller :</b>
                                                <?php echo $seller["fname"]." ".$seller["lname"] ?>
                                            </p>
                                            <p class="card-text"><b>Price :</b>
                                                Rs.&nbsp;<?php echo number_format($product["price"]) ?>.00 + delivery
                                                fee</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-lg-1 text-start text-lg-center d-flex align-items-center">
                                <label class="form-label m-0 fs-4 m-auto d-lg-none">Quanity</label>
                                <label class="form-label m-0 fs-4 m-auto"><?php echo $ir["buy_qty"] ?></label>
                            </div>
                            <div class="col-12 col-lg-2 text-start text-lg-center bg-info d-flex align-items-center">
                                <label
                                    class="form-label text-white fs-5 m-auto">Rs.&nbsp;<?php echo $ir["total"] ?>.00</label>
                            </div>
                            <div class="col-12 col-lg-2 text-start text-lg-center d-flex align-items-center">
                                <label id="DatePurcased<?php echo $i?>"
                                    class="form-label fs-5 m-auto"><?php echo $ir["datetime_purchased"] ?></label>
                            </div>
                            <div class="col-12 col-lg-3 d-flex align-items-center justify-content-center">
                                <div class="row">
                                    <div class="col-6 d-grid">
                                        <button class="btn btn-outline-success"
                                            onclick="addfeedback(<?php echo $i?>);"><i
                                                class='bi bi-info-circle bi-flashing'><br /></i>Feedback</button>
                                    </div>
                                    <div class="col-6 d-grid">
                                        <button class="btn btn-outline-primary" onclick="clearinvoice(<?php echo $product['id']?>);"><i
                                                class='bi bi-trash bi-flashing'><br /></i>Delete</button>
                                    </div>
                                </div>
                            </div>

                            <div class="col-12">
                                <hr class="border border-2 border-primary">
                            </div>
                            <!-- Modal -->
                            <div class="modal fade" id="feedbackmodal<?php echo $i; ?>" tabindex="-1"
                                aria-labelledby="exampleModalLabel" aria-hidden="true">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title" id="exampleModalLabel">
                                                <?php echo mb_strimwidth($product["title"], 0, 33, "...") ?>
                                            </h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                aria-label="Close"></button>
                                        </div>
                                        <div class="modal-body">
                                            <textarea id="feedtxt<?php echo $i; ?>" cols="30" rows="10" class="form-control fs-5"
                                                placeholder="Please submit your Response to this Product."></textarea>
                                        </div>
                                        <div class="modal-footer">
                                            <button type="button" class="btn btn-secondary"
                                                data-bs-dismiss="modal">Close</button>
                                            <button type="button" class="btn btn-primary"
                                                onclick="savefeedback('<?php echo $i; ?>','<?php echo $product['id']?>');">Send Feedback</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <?php
                            }
                            ?>
                            <div class="col-12 mb-3">
                                <div class="row">
                                    <div class="col-lg-9 d-none d-lg-block"></div>
                                    <div class="col-12 col-lg-3 d-grid">
                                        <button class="btn btn-outline-danger fs-4" onclick="clearinvoice();"><i
                                                class='bi bi-trash bi-flashing'></i>Clear all records</button>
                                    </div>
                                </div>
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
    <div class="container-fluid">
        <div class="row">
            <?php require "footer.php" ?>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
</body>

</html>
<?php
}else{
?>
<script>window.location = "index.php?Sign_In";</script>
<?php
}
?>