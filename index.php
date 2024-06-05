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
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css"/>
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />

</head>

<body class="main-background" <?php if(isset($_GET["Sign_In"])){echo "onload='IndexAlert(Error);'"; } ?>>
    <!-- Alert Boxes Start -->
    <?php require "alert.php"; ?>
    <!-- Alert Boxes End -->
    <div class="container-fluid vh-100 d-flex align-content-center">
        <div class="row align-content-sm-center">
            <!-- header -->
            <div class="col-12">
                <div class="row">
                    <div class="col-12 logo">
                    </div>
                    <div class="col-12">
                        <p class="text-center title1">Hi, Welcome to eShop</p>
                    </div>
                </div>
            </div>
            <!-- header -->

            <!-- Content Start-->
            <div class="col-12 px-3">
                <div class="row">
                    <div class="col-6 d-none d-lg-block background">
                    </div>
                    <!-- Content Sign Up-->
                    <div class="col-12 col-lg-6 <?php if(isset($_GET["Sign_In"])){?><?php echo "d-none"; }else{} ?>" id="signUpBox">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-lable title2">Create New Account</label>
                                <p class="text-danger" id="msg1"></p>
                            </div>
                            <div class="col-6">
                                <label class="form-lable">First Name</label>
                                <input id="fname" class="form-control" type="text" />
                            </div>
                            <div class="col-6">
                                <label class="form-lable">Last Name</label>
                                <input id="lname" class="form-control" type="text" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Email</label>
                                <input id="email" class="form-control" type="text" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Password</label>
                                <div class="input-group mb-3">
                                    <input id="password" class="form-control" type="password" />
                                    <button id="password1b" onclick="showPass1();" class="btn btn-light bi bi-eye"></button>
                                </div>
                            </div>
                            <div class="col-6">
                                <label class="form-lable">Mobile</label>
                                <input id="mobile" class="form-control" type="text" />
                            </div>
                            <div class="col-6">
                                <label class="form-lable">Gender</label>
                                <select id="gender" class="form-select">
                                    <?php
                                    $result = Database::search("SELECT * FROM gender;");
                                    $num = $result->num_rows;
                                    for($x = 0; $x < $num; $x++){
                                        $data = $result->fetch_assoc();
                                    ?>
                                    <option value="<?php echo $data["id"] ?>"><?php echo $data["name"] ?></option>
                                    <?php
                                        } 
                                    ?>
                                </select>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button onclick="SignUp();" class="btn btn-primary">Sign Up</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-dark" onclick="changeView();">Already have an account? Sign
                                    In</button>
                            </div>
                        </div>
                    </div>
                    <!-- Content Sign In-->
                    <div class="col-12 col-lg-6 <?php if(isset($_GET["Sign_In"])){?><?php }else{echo "d-none";} ?>" id="signInBox">
                        <div class="row g-3">
                            <div class="col-12">
                                <label class="form-lable title2">Sign In to Your Account</label>
                                <p class="text-danger" id="msg2"></p>
                            </div>

                            <?php 
                                $e = "";
                                $p = "";

                                if(isset($_COOKIE["e"])){
                                    $e = $_COOKIE["e"];
                                }
                                if(isset($_COOKIE["p"])){
                                    $p = $_COOKIE["p"];
                                }
                            ?>
                            <div class="col-12">
                                <label class="form-lable">Email</label>
                                <input id="email2" class="form-control" value="<?php echo $e ?>" type="text" />
                            </div>
                            <div class="col-12">
                                <label class="form-lable">Password</label>
                                <div class="input-group mb-3">
                                    <input id="password2" class="form-control" value="<?php echo $p ?>"
                                        type="password" />
                                    <button id="password2b" onclick="showPass2();" class="btn btn-light bi bi-eye"></button>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <a href="#" class="link-primary" onclick="ForgotPassword();">Forgot Password?</a>
                                </div>
                            </div>
                            <div class="col-12 col-md-6">
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" id="remember" <?php if(isset($_COOKIE["p"])){echo "checked";}?>/>
                                    <label class="form-check-label" for="remember">Remember Me</label>
                                </div>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button onclick="SignIn();" class="btn btn-primary">Sign In</button>
                            </div>
                            <div class="col-12 col-lg-6 d-grid">
                                <button class="btn btn-danger" onclick="changeView();">New to eShop? Sign Up</button>
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
            <div id="forgetPasswordModel" class="modal fade" tabindex="-1">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title">Reset Your Password</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            <div class="row g3">
                                <div class="col-6">
                                    <label class="form-lable">New Password</label>
                                    <div class="input-group mb-3">
                                        <input id="password3" type="password" class="form-control" />
                                        <button id="password3b" onclick="showPass3();"
                                            class="btn btn-outline-primary bi-eye"></button>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <label class="form-lable">Re-Type Password</label>
                                    <div class="input-group mb-3">
                                        <input id="password4" type="password" class="form-control" />
                                        <button id="password4b" onclick="showPass4();"
                                            class="btn btn-outline-primary bi-eye"></button>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-lable">Verification Code</label>
                                    <input id="verifycode" class="form-control" />
                                </div>
                            </div>
                        </div>
                        <div class="modal-footer text-center">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                            <button onclick="ResetPassword();" type="button" class="btn btn-primary">Save
                                changes</button>
                            <p class="text-danger">Don't close this box if you want to change your password</p>
                        </div>
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