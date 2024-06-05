<?php

session_start();
require "connection.php";

if (isset($_SESSION["user"])) {
    $LastInvoice = Database::search("SELECT * FROM `invoice` WHERE `user_email` = '".$_SESSION["user"]["email"]."' ORDER BY `datetime_purchased` DESC LIMIT 1;");
    $LastDate = $LastInvoice->fetch_assoc();
    $invoicers = Database::search("SELECT * FROM `invoice` WHERE `user_email` = '".$_SESSION["user"]["email"]."' AND `datetime_purchased` = '".$LastDate["datetime_purchased"]."';");
    $in = $invoicers->num_rows;

    $User = Database::search("SELECT * FROM `user` WHERE `email` = '".$_SESSION["user"]["email"]."';");
    $Userdata = $User->fetch_assoc();
    $UserCityAll = Database::search("SELECT * FROM `user_has_address` WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
    $UserCityid = $UserCityAll->fetch_assoc();
    $UserCityName = Database::search("SELECT * FROM `city` WHERE `id` = '".$UserCityid["city_id"]."';");
    $UserCityData = $UserCityName->fetch_assoc();
?>

<!DOCTYPE html>

<html>

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

    <title>eShop | Invoice</title>
    <style>
        tr{
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <!-- Alert -->
    <?php require "alert.php"; ?>
    <!-- Alert -->
    <div class="container-fluid">
        <!-- header -->
        <?php require "header.php"; ?>
        <!-- header -->
        <div class="row">
            <div class="col-12 my-3 btn-toolbar justify-content-end">
                <button class="btn btn-dark me-2 shadow-none d-flex align-items-center"><i
                onclick="printinvoice();" class="bi bi-printer-fill"></i> Print</button>
                <button class="btn btn-danger me-2 shadow-none d-flex align-items-center"><i
                        class="bi bi-file-earmark-pdf-fill"></i> Save as PDF</button>
            </div>
            <hr class="hrbreak0">
        </div>
    </div>
    <div id="Printpage" class="container-fluid">
        <div class="row d-flex justify-content-between">
            <div class="col-3 col-sm-2 col-md-1 d-flex">
                <img src="resources/logo.svg" class="img-fluid mx-auto d-block">
            </div>
            <div class="col-8 text-end pe-lg-4">
                <label class="text-primary h3 text-decoration-underline">eShop</label><br>
                <span>Maradhana, Colombo&nbsp;10, Sri&nbsp;Lanka</span><br>
                <span>+94112546978</span><br>
                <span>eshop@gmail.com</span>
            </div>
        </div>
        <hr class="bg-primary">
        <div class="row flex-column flex-sm-row row-gap justify-content-between">
            <div class="col">
                <span class="h5">INVOICE TO:</span><br>
                <span><?php echo $Userdata["fname"]." ".$Userdata["lname"]; ?></span><br>
                <span><?php echo $UserCityData["name"]; ?></span><br>
                <span class="text-primary"><?php echo $Userdata["email"]; ?></span>
            </div>
            <div class="col text-sm-end pe-lg-4">
                <lable class="text-primary h4">INVOICE <?php echo $LastDate["id"] ?></lable><br/>
                <span>Date&nbsp;and&nbsp;Time&nbsp;of&nbsp;Invoice:</span> <span><?php echo $LastDate["datetime_purchased"] ?></span>
            </div>
        </div>
        <div class="row My-Invoice">
            <div class="col-12 mt-4">
                <table class="table">
                    <thead class="table-light">
                        <tr>
                        <th scope="col">#</th>
                        <th scope="col">Order&nbsp;id & Product</th>
                        <th scope="col">Unit Price</th>
                        <th scope="col">Quantity</th>
                        <th scope="col">Total (with Shipping)</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $SUBTOTAL = 0;
                        for($n = 1; $n <= $in; $n++){
                            $id = $invoicers->fetch_assoc();
                            $productrs = Database::search("SELECT * FROM `product_view` WHERE `id` = '" .$id["product_id"]. "';");
                            $product = $productrs->fetch_assoc();
                            $SUBTOTAL = $SUBTOTAL + $id["total"]; 
                        ?>
                        <tr>
                            <th scope="row"><?php if($n<10){ echo "0".$n ;}else{echo $n ;} ?></th>
                            <td class="text-primary"><?php echo $id["order_id"] ?> <br> <?php echo mb_strimwidth($product["title"], 0, 33, "..."); ?></td>
                            <td class="bg-secondary text-white text-end">Rs. <?php echo $product["price"] ?>.00</td>
                            <td class="text-end"><?php echo $id["buy_qty"] ?></td>
                            <td class="bg-primary text-white text-end">Rs. <?php echo $id["total"] ?>.00</td>
                        </tr>
                        <?php
                        }
                        ?>
                        <tr>
                            <td colspan="2" class="border-0"></td>
                            <td></td>
                            <td class="">SUBTOTAL</td>
                            <td class="table-light">Rs. <?php echo $SUBTOTAL; ?>.00</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-0"></td>
                            <td class="border-primary"></td>
                            <td class="border-primary">Discount</td>
                            <td class="table-light border-primary">Rs.00.00</td>
                        </tr>
                        <tr>
                            <td colspan="2" class="border-0 fs-5 fw-bolder">Thank You!</td>
                            <td colspan="2" class="border-0 text-primary text-end fs-6">GRAND TOTAL</td>
                            <td class="border-0 text-primary fs-6">Rs. <?php echo $SUBTOTAL; ?>.00</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="rounded p-2">
                    <span class="fw-bold">NOTICE:</span><br>
                    <span>Purchased items can be return before 7 days delivery</span>
                </div>
            </div>
        </div>
        <hr class="hrbreak0">
        <div class="row">
            <div class="col-12 mb-3 text-center">
                <label class="form-label fs-6 text-black-50">
                    The invoice is computer generated and is valid without signatures and seals.
                </label>
            </div>
        </div>
    </div>
    <!-- footer -->
    <?php require "footer.php"; ?>
    <!-- footer -->

    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
}else{
?>
<script>window.location = "index.php?Sign_In";</script>
<?php
}
?>