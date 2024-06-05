<?php

session_start();

require "connection.php";

if(isset($_SESSION["user"])){
?>
<!DOCTYPE html>
<html>

<head>
    <title>eShop User Profile</title>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<?php
    $gen = Database::search("SELECT `name` FROM gender WHERE `id` = '".$_SESSION["user"]["gender_id"]."';");
    $gendata = $gen->fetch_assoc();
    $result = Database::search("SELECT `line1`,`line2`,city.`name` AS `cityname`,`postal_code`,district.`name` AS 
    `districtname`,district.`id` AS `districtid`,province.`name` AS `provincename`,province.`id` AS `provinceid` FROM
    user INNER JOIN user_has_address ON user.email = user_has_address.user_email INNER JOIN 
    city ON user_has_address.city_id = city.id INNER JOIN district ON city.district_id = district.id 
    INNER JOIN province ON district.province_id = province.id WHERE `email` = '".$_SESSION["user"]["email"]."';");
    $data = $result->fetch_assoc();
?>

<body class="bg-primary" <?php if(isset($data["provincename"])){?>
    onload="showProvince('Provin<?php echo $data['provinceid'];?>');" <?php }else{}?>>
    <!-- Alert Boxes Start -->
    <?php require "alert.php"; ?>
    <!-- Alert Boxes End -->
    <div class="container-fluid">
        <?php
        require "header.php";
        ?>
        <div class="row">
            <div class="col-12 bg-light mt-0 mb-5 mt-3 mt-sm-4 mt-md-5">
                <div class="row">
                    <div class="col-12 col-md-12 col-lg-3 border-end">
                        <div class="d-flex flex-column align-items-center text-center p-3 py-0 py-lg-5">
                            <?php
                            $UImageCheck = Database::search("SELECT `user_code` FROM user_image WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
                            $CheckImg = $UImageCheck->fetch_assoc();
                            ?>
                            <img class="rounded-circle round-image mt-2 mt-sm-3 mt-md-4 mt-md-5" id="UserImage"
                                src="<?php if(isset($CheckImg["user_code"])){echo $CheckImg["user_code"];}else{echo "User_img/demoProfileImg.jpg";}?>"
                                width="150px" height="150px" />
                            <span
                                class="fw-bold mt-2"><?php echo $_SESSION["user"]["fname"]."&nbsp;".$_SESSION["user"]["lname"]; ?></span>
                            <span class="text-black-50"><?php echo $_SESSION["user"]["email"]; ?></span>
                            <input class="d-none" type="file" id="Userprofileimg" accept="img/*" />
                            <label class="btn btn-primary mt-3" onclick="ChangeUserImage();" for="Userprofileimg">Update
                                Profile Image</label>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 col-lg-5 border-end">
                        <div class="p-3 py-5">
                            <div class="row mb-3">
                                <h4>Profile Settings</h4>
                            </div>
                            <div class="row mt-0 mt-md-2 g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Name</label>
                                    <input id="UserUpfname" type="text" class="form-control" placeholder="First Name"
                                        value="<?php echo $_SESSION["user"]["fname"]; ?>" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Surname</label>
                                    <input id="UserUplname" type="text" class="form-control" placeholder="Last Name"
                                        value="<?php echo $_SESSION["user"]["lname"]; ?>" />
                                </div>
                            </div>
                            <div class="row mt-2 g-2">
                                <div class="col-md-12">
                                    <label class="form-label">Mobile Number</label>
                                    <input id="UserUpmobile" type="text" class="form-control"
                                        placeholder="Mobile Number"
                                        value="<?php echo $_SESSION["user"]["mobile"]; ?>" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Password</label>
                                    <div class="input-group mb-3">
                                        <input id="UserUppassword" class="form-control" type="password"
                                            placeholder="Password"
                                            value="<?php echo $_SESSION["user"]["password"]; ?>" />
                                        <button id="UserUppasswordb" onclick="showUpPass();"
                                            class="btn btn-light bi bi-eye"></button>
                                    </div>
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Email Address</label>
                                    <input id="UserUpemail" type="text" class="form-control" placeholder="Email Address"
                                        value="<?php echo $_SESSION["user"]["email"]; ?>" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Registerd Date &amp; Time</label>
                                    <input type="text" class="form-control" placeholder="Registerd Date"
                                        value="<?php echo $_SESSION["user"]["register_date"]; ?>" readonly />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Address Line 01</label>
                                    <input id="UserUpline1" type="text" class="form-control"
                                        placeholder="Address Line 01"
                                        value="<?php if(isset($data["line1"])){echo $data["line1"];}else{}?>" />
                                </div>
                                <div class="col-md-12">
                                    <label class="form-label">Address Line 02</label>
                                    <input id="UserUpline2" type="text" class="form-control"
                                        placeholder="Address Line 02"
                                        value="<?php if(isset($data["line2"])){echo $data["line2"];}else{}?>" />
                                </div>
                            </div>
                            <div class="row mt-2 g-2">
                                <div class="col-md-6">
                                    <label class="form-label">Province</label>
                                    <?php
                            $prov = Database::search("SELECT * FROM province;");
                            $provnum = $prov->num_rows;
                            ?>
                                    <div class="dropdown border border-1">
                                        <button class="btn btn-light bg-white dropdown-toggle w-100" type="button"
                                            id="dropdownMenuButton4"
                                            value="<?php if(isset($data["provinceid"])){echo $data["provinceid"];}else{echo "0";}?>"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php if(isset($data["provincename"])){echo $data["provincename"];}else{echo "Select Province";}?>
                                        </button>
                                        <ul class="dropdown-menu min-w-100" aria-labelledby="dropdownMenuButton4">
                                            <?php
                                    for($Pi = 0; $Pi < $provnum; $Pi ++){
                                    $provdata = $prov->fetch_assoc();
                                    ?>
                                            <li><button
                                                    onclick="showProvince('Provin<?php echo $provdata['id'];?>');resetDist();"
                                                    id="Provin<?php echo $provdata["id"];?>"
                                                    value="<?php echo $provdata["id"];?>"
                                                    class="dropdown-item"><?php echo $provdata["name"];?></button></li>
                                            <?php
                                    }
                                    ?>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">District</label>
                                    <?php
                                    $Distr = Database::search("SELECT * FROM district;");
                                    $Distrnum = $Distr->num_rows;
                                    ?>
                                    <div class="dropdown border">
                                        <button class="btn btn-light bg-white dropdown-toggle w-100" type="button"
                                            id="dropdownMenuButton5"
                                            value="<?php if(isset($data["districtid"])){echo $data["districtid"];}else{echo "0";}?>"
                                            data-bs-toggle="dropdown" aria-expanded="false">
                                            <?php if(isset($data["districtname"])){echo $data["districtname"];}else{echo "Select District";}?>
                                        </button>
                                        <ul class="dropdown-menu min-w-100" id="districtdropmenu"
                                            aria-labelledby="dropdownMenuButton5">
                                            <li><button class="dropdown-item point-none">Select Province</button></li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">City</label>
                                    <input id="UserUpcity" type="text" class="form-control" placeholder="City"
                                        value="<?php if(isset($data["cityname"])){echo $data["cityname"];}else{}?>" />
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label">Postal Code</label>
                                    <input id="UserUppostal" type="text" class="form-control" placeholder="Postal Code"
                                        value="<?php if(isset($data["postal_code"])){echo $data["postal_code"];}else{}?>" />
                                </div>
                                <div class="col-md-6 offset-md-3">
                                    <label class="form-label">Gender</label>
                                    <input type="text" class="form-control" placeholder="Gender" readonly
                                        value="<?php echo $gendata["name"] ?>" />
                                </div>
                                <div class="mt-5 text-center">
                                    <button onclick="UpdateUserProfile();" class="btn btn-primary">Update
                                        Profile</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-5 col-lg-4 pb-5">
                        <div class="row p-1 p-md-3 py-0 pt-md-5">
                            <div class="col-md-12">
                                <div class="d-flex d-md-inline py-1 py-md-0">
                                    <span class="fw-bold Rat">User Ratings</span>
                                </div>
                                <div
                                    class="d-flex star-box justify-content-center justify-content-sm-start justify-content-md-center py-1 py-md-0">
                                    <span class="bi bi-star-fill fs-4 text-warning"></span>
                                    <span class="bi bi-star-fill fs-4 text-warning"></span>
                                    <span class="bi bi-star-fill fs-4 text-warning"></span>
                                    <span class="bi bi-star-fill fs-4 text-warning"></span>
                                    <span class="bi bi-star-fill fs-4 text-secondary"></span>
                                </div>
                                <p>4.1 avarage based on 254 reviews. </p>
                                <hr class="hrbreak0" />
                            </div>
                        </div>
                        <div class="row g-2 p-2 p-lg-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mt-1 mt-md-2">
                                        <div>5 Star</div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-success" role="progressbar"
                                                style="width: 55%" aria-valuenow="55" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">75</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mt-1 mt-md-2">
                                        <div>4 Star</div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped" role="progressbar"
                                                style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">105</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mt-1 mt-md-2">
                                        <div>3 Star</div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-info" role="progressbar"
                                                style="width: 50%" aria-valuenow="50" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">150</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mt-1 mt-md-2">
                                        <div>2 Star</div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-warning" role="progressbar"
                                                style="width: 75%" aria-valuenow="75" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">150</div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="mt-1 mt-md-2">
                                        <div>1 Star</div>
                                    </div>
                                    <div class="col-12 col-md-12">
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-striped bg-danger" role="progressbar"
                                                style="width: 100%" aria-valuenow="100" aria-valuemin="0"
                                                aria-valuemax="100">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-12">
                                        <div class="text-end">150</div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- Footer Start -->
    <?php
    require "footer.php";
    ?>
    <!-- Footer End -->
    <script src="bootstrap/bootstrap.bundle.js"></script>
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