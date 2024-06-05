<?php 
session_start();
require "../connection.php";

$UpdateId = $_POST["UpdateProductId"];
$UpdateResult = Database::search("SELECT * FROM `product_view` WHERE `seller_email` = '".$_SESSION["user"]['email']."' AND `id` = '".$UpdateId."'; ");
$data = $UpdateResult->fetch_assoc();
$CatagoryResult = Database::search("SELECT * FROM `category` WHERE `id` = '".$data["category_id"]."';");
$Catdata = $CatagoryResult->fetch_assoc();
$Brandrs = Database::search("SELECT `name` FROM `brand` WHERE `id` = '".$data["brand_id"]."';");
$Brddata = $Brandrs->fetch_assoc();
$Modelrs = Database::search("SELECT `name` FROM `model` WHERE `id` = '".$data["model_id"]."';");
$Moddata = $Modelrs->fetch_assoc();
?>

<!-- Catagory Brand Model Start -->
                <div class="col-12">
                    <div class="row g-3">
                        <div class="col-12 col-md-4">
                            <div class="row">
                                <div class="col-12">
                                    <label class="form-label">Product Catagory</label>
                                </div>
                                <div class="col-12">
                                    <button class="btn btn-light w-100 point-none" type="button" id="UpdateProductId" value="<?php echo $data["id"]; ?>"
                                        data-bs-toggle="dropdown" aria-expanded="false" disabled>
                                        <?php echo $Catdata["name"] ?>
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
                                        <?php echo $Brddata["name"] ?>
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
                                        <?php echo $Moddata["name"] ?>
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
                                <input id="UpdatingTitle" type="text" class="form-control" placeholder="Product Title"
                                    aria-describedby="basic-addon1" value="<?php echo $data["title"] ?>">
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
                                        <input class="form-check-input" type="radio" name="inlineRadioOptions" value="0"
                                            disabled <?php if($dCondition["id"] == $data["condition_id"]){echo "checked";} ?>>
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
                                $ProdColor = Database::search("SELECT * FROM `color_view` WHERE `product_id` = '".$data["id"]."';");
                                $ProdD = $ProdColor->fetch_assoc();
                                ?>
                                <div class="col-12">
                                    <label class="form-label">Select Product Color</label>
                                </div>
                                <div class="col-12 d-flex flex-wrap justify-content-between">
                                    <?php
                                for ($i = 0; $i < $nColor; $i++) {
                                    $dColor = $Color->fetch_assoc();
                                    $cloid = $dColor['id'];
                                    ?>
                                    <div class="form-check form-check-inline">
                                        <input class="form-check-input" type="radio" name="UpColorBoxes"
                                            value="0" id="UpColorbox<?php echo $cloid;?>" 
                                            <?php if($cloid == $ProdD["color_id"]){echo "checked";} ?> disabled>
                                        <label class="form-check-label label-color"
                                            for="UpColorbox<?php echo $cloid;?>"><?php echo $dColor['name'];?></label>
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
                                            aria-describedby="basic-addon1" id="UpdatingQty" value="<?php echo $data["qty"] ?>"
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
                                    oninput="this.value = this.value.replace(/[^0-999]/);" value="<?php echo $data["price"] ?>" 
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
                                            oninput="this.value = this.value.replace(/[^0-999]/);" value="<?php echo $data["delivery_fee_colombo"] ?>"
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
                                            oninput="this.value = this.value.replace(/[^0-999]/);" value="<?php echo $data["delivery_fee_other"] ?>"
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
                                id="UpdatingDescription"><?php echo $data["description"] ?></textarea>
                        </div>
                    </div>
                    <hr class="hrbreak1" />
                </div>
                <!-- Product Description End -->
                <!-- Product Description Start -->
                <div class="col-12">
                    <div class="row">
                        <div class="col-12">
                            <label class="form-label">Update New Product Image</label>
                        </div>
                        <?php 
                        $ProductImage = Database::search("SELECT * FROM `images_view` WHERE `product_id` = '".$data["id"]."';");
                        $ImgNum = $ProductImage->num_rows;                        
                        for($n = 1; $n <= 3; $n++){
                            $Imgdata = $ProductImage->fetch_assoc();
                        ?>
                        <div class="col-xs-12 col col-lg-2 mx-2">
                            <div class="row addproduct ">
                                <img class="p-0" id="PrevreImag<?php echo $n; ?>" src="<?php if(isset($Imgdata['code'])){echo $Imgdata['code'];}else{echo "resources/addproductimg.svg";} ?>" />
                            </div>
                            <div class="row">
                                <input class="d-none" type="file" accept="img/*" id="imgreuploaded<?php echo $n; ?>">
                                <label class="btn btn-primary" onclick="ChangeImageRe('imgreuploaded<?php echo $n; ?>','PrevreImag<?php echo $n; ?>');"
                                 for="imgreuploaded<?php echo $n; ?>">Upload</label>
                            </div>
                        </div>
                        <?php }?>
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
                            <button class="btn btn-success w-100" onclick="UpdateSellerProduct();">Update Product</button>
                        </div>
                        <div class="col-12 col-md-4">
                            <button class="btn btn-dark w-100" onclick="changeProductView();">Add Product</button>
                        </div>
                    </div>
                </div>
