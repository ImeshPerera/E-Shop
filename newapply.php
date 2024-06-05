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
        .height-100{
            height: 100%;
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
                        <li class="breadcrumb-item active nav-link p-0 point-none" aria-current="page">Manage Users</li>
                    </ol>
                </nav>
                <nav class="nav flex-column row-gap-1 mb-3">
                    <a class="btn btn-primary text-white nav-link" href="adminpanel.php">Dashboard</a>
                    <a class="btn btn-primary text-white nav-link" href="manageusers.php">Manage Users</a>
                    <a class="btn btn-primary text-white nav-link" href="manageproducts.php">Manage Products</a>
                    <a class="btn btn-primary text-white nav-link" href="sellinghistory.php">Sellings</a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10 mb-3">
                <div class="row pt-md-3 g-1">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0 text-white">Settings</p>
                    </div>
                </div>
                <div class="row g-1">
                    <div class="col-12">
                        <div class="card height-100">
                            <div class="card-body height-100">
                                <div class="d-flex flex-wrap justify-content-center align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h4">Add New Category</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    $Category = Database::search("SELECT * FROM `category`;");
                    $CategoryNum = $Category->num_rows;
                    for($x = 0; $x < $CategoryNum; $x++){
                        $CategoryData = $Category->fetch_assoc();
                    ?>
                    <div class="col-md-4">
                        <div class="card height-100 pale-green">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0"><?php echo $CategoryData["name"]; ?></p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-bookmarks"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php
                    }
                    ?>
                    <div class="col-md-4">
                        <div class="card height-100 pale-green" data-bs-toggle="modal" data-bs-target="#AddNewCategoryAdmin">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0">Add New Category</p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-1 mt-2">
                    <div class="col-md-6">
                        <div class="card height-100 pale-gold" data-bs-toggle="modal" data-bs-target="#AddNewBrandAdmin">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h5">Add New Brand</p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="card height-100 pale-gold" data-bs-toggle="modal" data-bs-target="#AddNewCategoryBrandAdmin">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h5">Brands in Category</p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-1 mt-2">
                    <div class="col-12">
                        <div class="card height-100">
                            <div class="card-body height-100">
                                <div class="d-flex flex-wrap justify-content-center align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h4">Add New Model</p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card height-100 pale-blue">
                            <div class="card-body height-100">
                                <div class="input-group height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <input id="NewModelAd" class="form-control rounded-5" type="text" placeholder="New Model Name" aria-label="New Model Input">
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 ms-2 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card height-100 pale-blue">
                            <div class="card-body height-100">
                                <div class="input-group height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <div class="col-12">
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle w-100" type="button" value="0"
                                                id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
                                                All Catagories
                                            </button>
                                            <ul class="dropdown-menu w-100 pale-blue border-1" aria-labelledby="dropdownMenuButton1">
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
                        </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                        <div class="card height-100 pale-blue">
                            <div class="card-body height-100">
                                <div class="input-group height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <div class="col-12"> 
                                        <div class="dropdown">
                                            <button class="btn btn-light dropdown-toggle w-100" type="button" value="0"
                                                id="dropdownMenuButton2" data-bs-toggle="dropdown" aria-expanded="false">
                                                All Brands
                                            </button>
                                            <ul id="BrdFillUp" class="dropdown-menu w-100 pale-blue"
                                                aria-labelledby="dropdownMenuButton2">
                                                <li><button class="dropdown-item point-none">Select Catagory First</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 d-none">
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
                    <div class="col-12 col-md-6 col-lg-12">
                        <div class="card height-100 pale-blue">
                            <div class="card-body height-100">
                                <div class="row justify-content-end">
                                    <div class="col-12 col-sm-6 col-lg-4 d-flex justify-content-end">
                                        <button onclick="AdNewModel();" class="btn btn-outline-success w-100 fw-bold">Submit New Model</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row g-1 mt-2">
                    <div class="col-md-12">
                        <div class="card height-100 pale-pink" data-bs-toggle="modal" data-bs-target="#AddNewColorAdmin">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h5">Add New Color</p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6 d-none">
                        <div class="card height-100" data-bs-toggle="modal" data-bs-target="#EditCityAdmin">
                            <div class="card-body height-100">
                                <div class="height-100 d-flex flex-wrap justify-content-between flex-md-column flex-lg-row align-items-center">
                                    <p class="mb-0 mb-md-2 mb-xl-0 h5">Edit in City</p>
                                    <i class="text-muted mb-0 mb-md-3 mb-xl-0 bi bi-plus-circle"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="modal fade" id="AddNewCategoryAdmin" tabindex="-1" aria-labelledby="New Category Model" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Add New Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input id="NewCategoryAd" class="form-control form-control-lg" type="text" placeholder="Type New Category Here" aria-label="New Category Input">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="AddNew('NewCategoryAd','Category');" type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="modal fade" id="AddNewBrandAdmin" tabindex="-1" aria-labelledby="New Brand Model" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Add New Brand</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input id="NewBrandAd" class="form-control form-control-lg my-2" type="text" placeholder="Type New Brand Here" aria-label="New Category Input">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="AddNew('NewBrandAd','Brand');" type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="modal fade" id="AddNewCategoryBrandAdmin" tabindex="-1" aria-labelledby="New Category Brand Model" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">New Brands in Category</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <label class="form-label">Select Category Here</label>
                                <select id="AdCateId" class="form-select" size="4" aria-label="size 3 select example">
                                    <?php
                                    $Category = Database::search("SELECT * FROM `category`;");
                                    $CategoryNum = $Category->num_rows;
                                    for($x = 0; $x < $CategoryNum; $x++){
                                    $CategoryData = $Category->fetch_assoc();
                                    ?>                                    
                                        <option value="<?php echo $CategoryData["id"] ?>"><?php echo $CategoryData["name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>
                                <label class="form-label mt-2">Select Brand Here</label>
                                <select id="AdBrandId" class="form-select" size="4" aria-label="size 3 select example">
                                    <?php
                                    $Brand = Database::search("SELECT * FROM `brand`;");
                                    $BrandNum = $Brand->num_rows;
                                    for($x = 0; $x < $BrandNum; $x++){
                                    $BrandData = $Brand->fetch_assoc();
                                    ?>                                    
                                        <option value="<?php echo $BrandData["id"] ?>"><?php echo $BrandData["name"] ?></option>
                                    <?php
                                    }
                                    ?>
                                </select>                         
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button type="button" onclick="BrandInCategory();" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="modal fade" id="AddNewColorAdmin" tabindex="-1" aria-labelledby="New Category Model" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Add New Color</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input id="NewColorAd" class="form-control form-control-lg" type="text" placeholder="Type New Color Here" aria-label="New Category Input">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="AddNew('NewColorAd','Color');" type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-12">
                <div class="modal fade" id="EditCityAdmin" tabindex="-1" aria-labelledby="New Category Model" aria-hidden="true">
                    <div class="modal-dialog">
                        <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title fw-bold">Edit City Data</h5>
                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                            </div>
                            <div class="modal-body">
                                <input id="NewCategoryAd" class="form-control form-control-lg" type="text" placeholder="Type New Category Here" aria-label="New Category Input">
                            </div>
                            <div class="modal-footer">
                                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                <button onclick="AddNew('NewCategoryAd','Category');" type="button" class="btn btn-primary">Save changes</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.bundle.js"></script>
</body>

</html>
<?php
}else{
?>
<script>window.location="admin.php";</script>
<?php
}