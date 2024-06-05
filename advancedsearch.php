<?php
session_start();
require "connection.php";
?>

<!DOCTYPE html>
<html>

<head>

    <title>eShop | Advanced Search</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />
</head>

<body class="bg-primary">
    <?php require "alert.php"; ?>
    <div class="container-fluid bg-smoke">
        <div class="row">
            <?php
            require "header.php"
            ?>
        </div>
    </div>
    <div class="container bg-sky my-3">
        <div class="row mx-md-5">
            <div class="col-12">
                <div class="row text-center align-items-center mt-3">
                    <label class="h1 fw-bold">My Products</label>
                </div>
            </div>
        </div>
        <div class="row mx-md-5">
            <div class="col-12 mb-2 mt-4">
                <div class="d-flex mb-3">
                    <input type="text" class="form-control" id="AdSearch" placeholder="Search Products" />
                    <button class="btn btn-primary ms-3" type="button" onclick="AdvanceSearch();">Search</button>
                </div>
            </div>
            <hr class="hrbreak1" />
        </div>
        <div class="row row-gap mx-md-5 py-3">
            <div class="col-12 col-md-4">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 border border-secondary" type="button" value="0" id="dropdownMenuButton6"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        All Catagories
                    </button>
                    <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton6">
                        <?php
                        $cat = Database::search("SELECT * FROM `category`;");
                        $n = $cat->num_rows;
                        for ($i = 0; $i < $n; $i++) {
                            $d = $cat->fetch_assoc();
                            $catid = $d['id'];
                        ?>
                        <li><button onclick="AdScatagory('Adcat<?php echo $catid;?>');" id="Adcat<?php echo $catid;?>"
                                class="dropdown-item" value="<?php echo $catid;?>"><?php echo $d['name'];?></button>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 border border-secondary" type="button" value="0" id="dropdownMenuButton7"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        All Brands
                    </button>
                    <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton7">
                        <?php
                        $brand = Database::search("SELECT * FROM `brand`");
                        $nbrand = $brand->num_rows;

                        for ($i = 0; $i < $nbrand; $i++) {
                            $dbrand = $brand->fetch_assoc();
                            $dbid = $dbrand['id'];
                        ?>
                        <li><button onclick="AdSbrand('Adbrd<?php echo $dbid;?>');" id="Adbrd<?php echo $dbid;?>"
                                class="dropdown-item" value="<?php echo $dbid;?>"><?php echo $dbrand['name'];?></button>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 border border-secondary" type="button" value="0" id="dropdownMenuButton8"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        All Models
                    </button>
                    <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton8">
                        <?php
                        $model = Database::search("SELECT * FROM `model`");
                        $nmodel = $model->num_rows;

                        for ($i = 0; $i < $nmodel; $i++) {
                            $dmodel = $model->fetch_assoc();
                            $modid = $dmodel['id'];
                            ?>
                        <li><button onclick="AdSmodel('Admod<?php echo $modid;?>');" id="Admod<?php echo $modid;?>"
                                class="dropdown-item"
                                value="<?php echo $modid;?>"><?php echo $dmodel['name'];?></button>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 border border-secondary" type="button" value="0" id="dropdownMenuButton9"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Condition
                    </button>
                    <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton9">
                        <?php
                        $condition = Database::search("SELECT * FROM `condition`");
                        $ncondition = $condition->num_rows;

                        for ($i = 0; $i < $ncondition; $i++) {
                            $dcondition = $condition->fetch_assoc();
                            $conditionid = $dcondition['id'];
                            ?>
                        <li><button onclick="AdScondition('Adcdi<?php echo $conditionid;?>');" id="Adcdi<?php echo $conditionid;?>"
                                class="dropdown-item"
                                value="<?php echo $conditionid;?>"><?php echo $dcondition['name'];?></button>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="dropdown">
                    <button class="btn btn-light dropdown-toggle w-100 border border-secondary" type="button" value="0" id="dropdownMenuButton10"
                        data-bs-toggle="dropdown" aria-expanded="false">
                        Select Color
                    </button>
                    <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton10">
                        <?php
                        $color = Database::search("SELECT * FROM `color`");
                        $ncolor = $color->num_rows;

                        for ($i = 0; $i < $ncolor; $i++) {
                            $dcolor = $color->fetch_assoc();
                            $colorid = $dcolor['id'];
                            ?>
                        <li><button onclick="AdSColor('AdClr<?php echo $colorid;?>');" id="AdClr<?php echo $colorid;?>"
                                class="dropdown-item"
                                value="<?php echo $colorid;?>"><?php echo $dcolor['name'];?></button>
                        </li>
                        <?php
                        }
                        ?>
                    </ul>
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="dropdown">
                    <input type="text" id="AdPriceFrom" class="form-control bg-light" placeholder="Price From" />
                </div>
            </div>
            <div class="col-12 col-md-6">
                <div class="dropdown">
                    <input type="text" id="AdPriceTo" class="form-control bg-light" placeholder="Price To" />
                </div>
            </div>
            <div class="col-12 d-flex justify-content-center">
                <button class="btn btn-outline-primary" onclick="AdvanceSearch();">Add New Filters</button>
            </div>
        </div>
        <div class="row">
            <div id="AdvanceSearchFill" class="col-12">
                <div class="row text-center">
                    <div class="h4 mt-3 mb-5"><p class="bi bi-search text-dark mb-1"></p>Welcome to the Advanced Search. Try Your Favorite Products.</d>
                    </div>
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
    <script src="bootstrap/bootstrap.bundle.js"></script>
    <script src="script.js"></script>
</body>

</html>