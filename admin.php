<?php
    require "connection.php";
?>
<!DOCTYPE html>
<html>

<head>
    <title>eShop</title>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body class="main-background">
    <!-- Alert Boxes Start -->
    <?php require "alert.php"; ?>
    <!-- Alert Boxes End -->
    <div class="container-fluid vh-100 d-flex align-content-center justify-content-center">
        <div class="row align-content-sm-center">
            <!-- header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 logo">
                    </div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome Back to eShop</p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- Content Start-->
            <div class="col-12 px-3">
                <div class="row">
                    <div class="col-6 d-none d-lg-block background">
                    </div>
                    <!-- Content Sign In-->
                    <div class="col-12 col-lg-6">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-lable title2">Sign In to Admin Account</label>
                            </div>

                            <?php 
                                $admin = "";
                                if(isset($_COOKIE["admin"])){
                                    $admin = $_COOKIE["admin"];
                                }
                            ?>
                            <div class="col-12">
                                <label class="form-lable mb-3">Admin Email</label>
                                <input id="AdminEmail" class="form-control" value="<?php echo $admin ?>" type="text" />
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="Adminremember"
                                        <?php if(isset($_COOKIE["admin"])){echo "checked";}?> />
                                    <label class="form-check-label" for="Adminremember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-dark" onclick="AdminVerify();">Sign In</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-12 mt-3 mt-lg-5">
                    <p class="text-center">&copy; 2021 eShop.lk All Rights Reserved</p>
                </div>
            </div>
            <!-- Content End -->
            <!-- model Start -->
            <div id="AdminModel" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Admin Verification</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g3">
                                <div class="col-12">
                                    <label class="form-lable">Verification Code</label>
                                    <input id="AdminVerify" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button onclick="AdminLogIn();" type="button" class="btn btn-primary">Log In</button>
                        </div>
                        <p class="text-danger text-center">Don't close this box if you want to Login to Admin</p>
                    </div>
                </div>
            </div>
            <!-- model End -->
        </div>
    </div>
    <script src="script.js"></script>
    <script src="https://unpkg.com/sweetalert/dist/sweetalert.min.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>