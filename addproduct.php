<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){
?>

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Product Listing</title>
    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body <?php if(isset($_POST['FromViewid'])){?> onload="UpdateThisItemEx('<?php echo $_POST['FromViewid'] ?>');"<?php }?>>
    <?php require "alert.php"; ?>
    <div class="container-fluid">
        <?php require "header.php"; ?>
    </div>
    <div class="container">
        <div class="row">
            <!-- Add Product Box Start -->
            <div id="addProductBox" <?php if(isset($_GET["Update"])){echo "class='d-none'";} ?>>
                <!-- header start -->
                <div class="col-12 mt-3 mb-3">
                    <h3 class="h1 text-center text-primary">Product Listing</h3>
                </div>
                <!-- header End -->
                <!-- Catagory Brand Model Start -->
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Select Product Catagory</label>
                                </div>
                                <div class="col-12">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle w-100" type="button" value="0"
                                            id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                            All Catagories
                                        </button>
                                        <ul class="dropdown-menu w-100" aria-labelledby="dropdownMenuButton1">
                                            <?php
                                        $cat = Database::search("SELECT * FROM `category`;");
                                        $n = $cat->num_rows;
                                        for ($i = 0; $i < $n; $i++) {
                                            $d = $cat->fetch_assoc();
                                            $catid = $d['id'];
                                        ?>
                                            <li><button onclick="showcatagory('cat<?php echo $catid;?>');"
                                                    id="cat<?php echo $catid;?>" class="dropdown-item"
                                                    value="<?php echo $catid;?>"><?php echo $d['name'];?></button></li>
                                            <?php
                                        }
                                        ?>
                                            <!--<li><button onclick="showcatagory('cat5');" id="cat5" class="dropdown-item" value="5"
                                                >Video Game Consoles</button></li> -->
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label ">Select Product Brand</label>
                                </div>
                                <div class="col-12">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle w-100" type="button" value="0"
                                            id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                            All Brands
                                        </button>
                                        <ul id="BrdFillUp" class="dropdown-menu w-100"
                                            aria-labelledby="dropdownMenuButton2">
                                            <li><button class="dropdown-item point-none">Select Catagory First</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label ">Select Product Model</label>
                                </div>
                                <div class="col-12">
                                    <div class="dropdown">
                                        <button class="btn btn-light dropdown-toggle w-100" type="button" value="0"
                                            id="dropdownMenuButton3" data-bs-toggle="dropdown" aria-expanded="false">
                                            All Models
                                        </button>
                                        <ul id="ModFillUp" class="dropdown-menu w-100"
                                            aria-labelledby="dropdownMenuButton3">
                                            <li><button class="dropdown-item point-none">Select Brand First</button>
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Catagory Brand Model End -->
                <!-- Product Title Start-->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label ">Add a Title to your Product</label>
                        </div>
                        <div class="col-10 offset-1">
                            <div class="input-group">
                                <input id="ListingTitle" type="text" class="form-control" placeholder="Product Title"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Product Title End-->
                <!-- Condition Color Quantity Start-->
                <div class="col-12">
                    <div class="row g-3 justify-content-center">
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Select Product Condition</label>
                                </div>
                                <div class="col-12">
                                    <?php
                                $Condition = Database::search("SELECT * FROM `condition`");
                                $nCondition = $Condition->num_rows;

                                for ($i = 0; $i < $nCondition; $i++) {
                                    $dCondition = $Condition->fetch_assoc();
                                    $Conid = $dCondition['id'];
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            <?php if($i == 0){echo "checked";}?> id="ConditionRadio<?php echo $Conid;?>"
                                            value="<?php echo $Conid;?>">
                                        <label class="form-check-label"
                                            for="ConditionRadio<?php echo $Conid;?>"><?php echo $dCondition['name_full'];?></label>
                                    </div>
                                    <?php
                                }
                                ?>
                                    <!-- <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                            id="ConditionRadio2" value="2">
                                        <label class="form-check-label" for="ConditionRadio2">Used</label>
                                    </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="row">
                                <?php
                                $Color = Database::search("SELECT * FROM `color`");
                                $nColor = $Color->num_rows;
                                ?>
                                <div class="col-12">
                                    <label class="form-label">Select Product Color</label>
                                    <input type="number" class="d-none" value="<?php echo $nColor+1 ;?>"
                                        id="ColorBoxes" />
                                </div>
                                <div class="col-12 d-flex flex-wrap justify-content-between">
                                    <?php
                                for ($i = 0; $i < $nColor; $i++) {
                                    $dColor = $Color->fetch_assoc();
                                    $cloid = $dColor['id'];
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="ColorBox"
                                            value="<?php echo $cloid;?>" id="Colorbox<?php echo $cloid;?>"
                                            <?php if($i == 0){echo "checked";}?>>
                                        <label class="form-check-label label-color"
                                            for="Colorbox<?php echo $cloid;?>"><?php echo $dColor['name'];?></label>
                                    </div>
                                    <?php
                                }
                                ?>
                                    <!-- <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="radio" name="ColorBox" value="5" id="Colorbox5">
                                    <label class="form-check-label" for="Colorbox5">Jet Black</label>
                                </div> -->
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6 col-lg-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Select Product Quantity</label>
                                </div>
                                <div class="col-10 offset-1 col-md-12 offset-md-0">
                                    <div class="input-group">
                                        <input type="number" min="0" class="form-control" placeholder="Quantity"
                                            aria-describedby="basic-addon1" id="ListingQty"
                                            oninput="this.value= this.value.replace(/[^0-999]/);">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Condition Color Quantity End-->
                <!-- Cost and Payment Start -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12 col-lg-6">
                            <div class="col-12">
                                <label class="form-label">Select Product Price</label>
                            </div>
                            <div class="input-group mt-3 mb-3">
                                <span class="input-group-text">Rs.</span>
                                <input type="number" class="form-control" id="ListingPrice"
                                    oninput="this.value = this.value.replace(/[^0-999]/);"
                                    aria-label="Amount (to the nearest Rupees)">
                                <span class="input-group-text">.00</span>
                            </div>
                        </div>
                        <div class="col-12 col-lg-6">
                            <div class="col-12">
                                <label class="form-label">Our Payment Options</label>
                            </div>
                            <div class="row paymentbox">
                                <div class="col-3 payment"></div>
                                <div class="col-3 payment"></div>
                                <div class="col-3 payment"></div>
                                <div class="col-3 payment"></div>
                            </div>

                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Cost and Payment End -->
                <!-- Delivary Fee Start -->
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12">
                            <label class="form-label">Set Delivery Fees</label>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-lg-4 d-flex align-items-center">
                                    <label class="form-label m-0">Delivery Cost Within Colombo</label>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="number" class="form-control" id="ListingDeliveryIn"
                                            oninput="this.value = this.value.replace(/[^0-999]/);"
                                            aria-label="Amount (to the nearest Rupees)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-6">
                            <div class="row">
                                <div class="col-12 col-lg-4 d-flex align-items-center">
                                    <label class="form-label m-0">Delivery Cost Without Colombo</label>
                                </div>
                                <div class="col-12 col-lg-8">
                                    <div class="input-group mt-3 mb-3">
                                        <span class="input-group-text">Rs.</span>
                                        <input type="number" class="form-control" id="ListingDeliveryOut"
                                            oninput="this.value = this.value.replace(/[^0-999]/);"
                                            aria-label="Amount (to the nearest Rupees)">
                                        <span class="input-group-text">.00</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Delivary Fee End -->
                <!-- Product Description Start -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Product Description</label>
                        </div>
                        <div class="col-12">
                            <textarea class="form-control bg-light  w-100 descriptionarea"
                                id="ListingDescription"></textarea>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Product Description End -->
                <!-- Product Image Uploading Start -->
                <div class="col-12">
                    <div class="row row-gap">
                        <div class="col-12">
                            <label class="form-label">Upload Product Image</label>
                            <br />
                            <span class="text-black-50 h6">** You can add Up to 3 Images.. Select 1 and Start..</span>
                        </div>
                        <div class="col-xs-12 col col-lg-2 mx-2">
                            <div class="row addproduct ">
                                <img class="p-0" id="PrevImag" inputmode="file" src="resources/addproductimg.svg" />
                            </div>
                            <div class="row">
                                <input class="d-none" type="file" accept="img/*" id="imguploaded">
                                <label class="btn btn-primary" onclick="ChangeImage();" for="imguploaded">Upload</label>
                            </div>
                        </div>
                        <div id="imgBox2" class="col-xs-12 col col-lg-2 mx-2 d-none">
                            <div class="row addproduct ">
                                <img class="p-0" id="PrevImag2" inputmode="file" src="resources/addproductimg.svg" />
                            </div>
                            <div class="row">
                                <input class="d-none" type="file" accept="img/*" id="imguploaded2">
                                <label class="btn btn-primary" onclick="ChangeImage2();"
                                    for="imguploaded2">Upload</label>
                            </div>
                        </div>
                        <div id="imgBox3" class="col-xs-12 col col-lg-2 mx-2 d-none">
                            <div class="row addproduct ">
                                <img class="p-0" id="PrevImag3" inputmode="file" src="resources/addproductimg.svg" />
                            </div>
                            <div class="row">
                                <input class="d-none" type="file" accept="img/*" id="imguploaded3">
                                <label class="btn btn-primary" onclick="ChangeImage3();"
                                    for="imguploaded3">Upload</label>
                            </div>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Product Description End -->
                <!-- Notice Start -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Notice...</label>
                        </div>
                        <div class="col-12">
                            <span>We are takeing 5% of the product price from every product as a Service Charge</span>
                        </div>
                        <div class="col-12">
                            <span>What if you have alternate colors in the same product? Please list it as a new product. Products are grouped by our automation system.</span>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Notice End -->
                <!-- Submit Button Start -->
                <div class="col-12 mb-3">
                    <div class="row">
                        <div class="col-12 col-md-6 offset-md-1">
                            <button class="btn btn-success w-100" onclick="ListingProduct();">Add Product</button>
                        </div>
                        <div class="col-12 col-md-4">
                            <button class="btn btn-dark w-100" onclick="changeProductView();">Update Product</button>
                        </div>
                    </div>
                </div>
                <!-- Submit Button End -->
            </div>
            <!-- Add Product Box End -->

            <!-- Update Product Box Start -->
            <div id="updateProductBox" <?php if(isset($_GET["Update"])){}else{echo "class='d-none'";} ?>>
                <!-- header start -->
                <div class="col-12 mt-3 mb-3">
                    <h3 class="h1 text-center text-primary">Product Updating</h3>
                </div>
                <!-- header End -->
                <!-- search field -->

                <div class="col-12 mb-2 mt-4">
                    <div class="dropdown">
                        <div class="dropdown-toggle search-toggle w-100" type="button" id="dropdownMenuButton1"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            <div class="input-group mb-3">
                                <input id="UpdateProductSearch" onkeyup="SearchtoUpdate();"
                                    class="form-control control-search border text-center" type="text"
                                    placeholder="Search Your Product By Title" aria-label="Recipient's username"
                                    aria-describedby="button-addon2">
                                <input type="reset" id="resetUpdate" class="d-none" />
                                <label class="btn bg-white control-btn border-start-0 bi bi-x"
                                    onclick="UpdateSearchClear()" for="resetUpdate"></label>
                            </div>
                        </div>
                        <ul class="dropdown-menu w-100 bg-white p-0" id="UpdateProductsFill"
                            aria-labelledby="dropdownMenuButton1">
                        </ul>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- search field -->
                <div id="UpdateArea">
                    <!-- Catagory Brand Model Start -->
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Product Catagory</label>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light w-100 point-none" type="button"
                                            id="UpdateProductId" value="0" data-bs-toggle="dropdown"
                                            aria-expanded="false" disabled>
                                            Your Catagory
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label ">Product Brand</label>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light w-100" type="button" value="0"
                                            data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            Your Brand
                                        </button>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label ">Product Model</label>
                                    </div>
                                    <div class="col-12">
                                        <button class="btn btn-light w-100" type="button" value="0"
                                            data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                            Your Model
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Catagory Brand Model End -->
                    <!-- Product Title Start-->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label ">Update a Title to your Product</label>
                            </div>
                            <div class="col-10 offset-1">
                                <div class="input-group">
                                    <input id="UpdatingTitle" type="text" class="form-control"
                                        placeholder="Product Title" aria-describedby="basic-addon1">
                                </div>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Product Title End-->
                    <!-- Condition Color Quantity Start-->
                    <div class="col-12">
                        <div class="row g-3 justify-content-center">
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Product Condition</label>
                                    </div>
                                    <div class="col-12 d-flex justify-content-evenly">
                                        <?php
                                $Condition = Database::search("SELECT * FROM `condition`");
                                $nCondition = $Condition->num_rows;

                                for ($i = 0; $i < $nCondition; $i++) {
                                    $dCondition = $Condition->fetch_assoc();
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="inlineRadioOptions"
                                                value="0" disabled>
                                            <label class="form-check-label"><?php echo $dCondition['name']; ?></label>
                                        </div>
                                        <?php
                                }
                                ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="row">
                                    <?php
                                $Color = Database::search("SELECT * FROM `color`");
                                $nColor = $Color->num_rows;
                                ?>
                                    <div class="col-12">
                                        <label class="form-label">Product Color</label>
                                    </div>
                                    <div class="col-12 d-flex flex-wrap justify-content-between">
                                        <?php
                                for ($i = 0; $i < $nColor; $i++) {
                                    $dColor = $Color->fetch_assoc();
                                    $cloid = $dColor['id'];
                                    ?>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="ColorBox"
                                                value="<?php echo $cloid;?>" id="Colorbox<?php echo $cloid;?>" disabled>
                                            <label class="form-check-label label-color"
                                                for="Colorbox<?php echo $cloid;?>"><?php echo $dColor['name'];?></label>
                                        </div>
                                        <?php
                                }
                                ?>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6 col-lg-4">
                                <div class="row">
                                    <div class="col-12">
                                        <label class="form-label">Update Product Quantity</label>
                                    </div>
                                    <div class="col-10 offset-1 col-md-12 offset-md-0">
                                        <div class="input-group">
                                            <input type="number" min="0" class="form-control" placeholder="Quantity"
                                                aria-describedby="basic-addon1" id="UpdatingQty"
                                                oninput="this.value= this.value.replace(/[^0-999]/);">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Condition Color Quantity End-->
                    <!-- Cost and Payment Start -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12 col-lg-6">
                                <div class="col-12">
                                    <label class="form-label">Product Price</label>
                                </div>
                                <div class="input-group mt-3 mb-3">
                                    <span class="input-group-text">Rs.</span>
                                    <input type="number" class="form-control" id="UpdatingPrice" disabled
                                        oninput="this.value = this.value.replace(/[^0-999]/);"
                                        aria-label="Amount (to the nearest Rupees)">
                                    <span class="input-group-text">.00</span>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6">
                                <div class="col-12">
                                    <label class="form-label">Our Payment Options</label>
                                </div>
                                <div class="row paymentbox">
                                    <div class="col-3 payment"></div>
                                    <div class="col-3 payment"></div>
                                    <div class="col-3 payment"></div>
                                    <div class="col-3 payment"></div>
                                </div>

                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Cost and Payment End -->
                    <!-- Delivary Fee Start -->
                    <div class="col-12">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-label">Update Delivery Fees</label>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-lg-4 d-flex align-items-center">
                                        <label class="form-label m-0">Delivery Cost Within Colombo</label>
                                    </div>
                                    <div class="col-12 col-lg-8">
                                        <div class="input-group mt-3 mb-3">
                                            <span class="input-group-text">Rs.</span>
                                            <input type="number" class="form-control" id="UpdatingDeliveryIn"
                                                oninput="this.value = this.value.replace(/[^0-999]/);"
                                                aria-label="Amount (to the nearest Rupees)">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="row">
                                    <div class="col-12 col-lg-4 d-flex align-items-center">
                                        <label class="form-label m-0">Delivery Cost Without Colombo</label>
                                    </div>
                                    <div class="col-12 col-lg-8">
                                        <div class="input-group mt-3 mb-3">
                                            <span class="input-group-text">Rs.</span>
                                            <input type="number" class="form-control" id="UpdatingDeliveryOut"
                                                oninput="this.value = this.value.replace(/[^0-999]/);"
                                                aria-label="Amount (to the nearest Rupees)">
                                            <span class="input-group-text">.00</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Delivary Fee End -->
                    <!-- Product Description Start -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Update Product Description</label>
                            </div>
                            <div class="col-12">
                                <textarea class="form-control bg-light w-100 descriptionarea"
                                    id="UpdatingDescription"></textarea>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Product Description End -->
                    <!-- Product Description Start -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Update New Product Images</label>
                            </div>
                            <div class="col-6 col-sm-5 col-md-4 col-lg-2 mx-2">
                                <div class="row addproduct ">
                                    <img class="p-0" id="PrevImagUp" inputmode="file"
                                        src="resources/addproductimg.svg" />
                                </div>
                                <div class="row">
                                    <input class="d-none" type="file" accept="img/*" id="imgreuploaded">
                                    <label class="btn btn-primary" onclick="ChangeImageRe();"
                                        for="imgreuploaded">Upload</label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-5 col-md-4 col-lg-2 mx-2">
                                <div class="row addproduct ">
                                    <img class="p-0" id="PrevImagUp" inputmode="file"
                                        src="resources/addproductimg.svg" />
                                </div>
                                <div class="row">
                                    <input class="d-none" type="file" accept="img/*" id="imgreuploaded">
                                    <label class="btn btn-primary" onclick="ChangeImageRe();"
                                        for="imgreuploaded">Upload</label>
                                </div>
                            </div>
                            <div class="col-6 col-sm-5 col-md-4 col-lg-2 mx-2">
                                <div class="row addproduct ">
                                    <img class="p-0" id="PrevImagUp" inputmode="file"
                                        src="resources/addproductimg.svg" />
                                </div>
                                <div class="row">
                                    <input class="d-none" type="file" accept="img/*" id="imgreuploaded">
                                    <label class="btn btn-primary" onclick="ChangeImageRe();"
                                        for="imgreuploaded">Upload</label>
                                </div>
                            </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Product Description End -->
                    <!-- Notice Start -->
                    <div class="col-12">
                        <div class="row">
                            <div class="col-12">
                                <label class="form-label">Notice...</label>
                            </div>
                            <div class="col-12">
                                <span>We are takeing 5% of the product price from every product as a Service
                                    Charge</span>
                            </div>
                            <div class="col-12">
                                <span>What if you have alternate colors in the same product? Please list it as a new product. Products are grouped by our automation system.
                            </span>
                        </div>
                        </div>
                        <hr class="hrbreak1" />
                    </div>
                    <!-- Notice End -->
                    <!-- Submit Button Start -->
                    <div class="col-12 mb-3">
                        <div class="row">
                            <div class="col-12 col-md-6 offset-md-1">
                                <button class="btn btn-success w-100" onclick="UpdateSellerProduct();">Update
                                    Product</button>
                            </div>
                            <div class="col-12 col-md-4">
                                <button class="btn btn-dark w-100" onclick="changeProductView();">Add Product</button>
                            </div>
                        </div>
                    </div>
                    <!-- Submit Button End -->
                </div>
            </div>
            <!-- Update Product Box End -->

        </div>
    </div>
    <!-- footer Start -->
    <div class="container-fluid">
        <div class="row">
            <?php
            require "footer.php";
            ?>
        </div>
    </div>
    <!-- footer End -->

    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>

<?php
}else{
?>
<script>
window.location = "index.php?Sign_In";
</script>
<?php
}
?>