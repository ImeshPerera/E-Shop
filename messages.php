<?php
session_start();
require "connection.php";

if(isset($_SESSION["user"])){

?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <link rel="icon" href="resources/logo.svg" />
    <link rel="stylesheet" href="bootstrap/bootstrap-icons.css" />
    <link rel="stylesheet" href="bootstrap/bootstrap.min.css" />
    <link rel="stylesheet" href="style.css" />


    <title>e-Shop | Messages</title>

</head>

<body onload="SelectUserMsg('admin');">
    <!-- Alert -->
    <?php require "alert.php"; ?>
    <!-- Alert -->
    <div class="container-fluid">
        <!-- header -->
        <?php require "header.php"; ?>
        <!-- header -->
    </div>
    <div class="container-fluid bg-sky">
        <div class="row">
            <div class="col-12 py-4 px-4">
                <div class="row rounded">

                    <div class="col-12 col-md-5 px-0">
                        <div id="MsgUserFill" class="row px-4">
                            <div class="col-12 d-flex justify-content-between my-1 py-2 rounded-5 Chat-User">
                                <div class="d-flex justify-content-center flex-column">
                                    <span class="h5"><b>Recent Chats</b></span>
                                    <span><b>User&nbsp;:&nbsp;</b><?php echo $_SESSION["user"]["email"] ?></span>
                                </div>
                                <!-- <div class="chat-ball">4</div> -->
                            </div>
                            <div class="col-12">
                                <hr class="hrbreak0 bg-dark mt-1">
                            </div>
                            <div onclick="SelectUserMsg('admin');" class="col-12 d-flex py-2 my-1 bg-white rounded-5">
                                <div class="d-flex">
                                    <img class="rounded-circle round-image m-auto me-2" width="60px" height="60px" src="resources/demoProfileImg.jpg" />
                                </div>
                                <div class="d-flex justify-content-center flex-column">
                                    <span><b>eShop Admin</b></span>
                                    <span><b>Connected : </b>Welcome to eShop...</span>
                                </div>
                            </div>
                            <?php
                            $chaters = Database::search("SELECT * FROM `user` WHERE `email` NOT IN ('".$_SESSION["user"]["email"]."') ORDER BY `register_date` ASC LIMIT 3");
                            $ChatN = $chaters->num_rows;
                            for ($x = 0; $x < $ChatN; $x++) {
                                $rchat = $chaters->fetch_assoc();
                                $senderrs = Database::search("SELECT * FROM `chat` WHERE `from` = '".$rchat['email']. "' OR `to` = '".$rchat['email']."'");
                                $sendernr = $senderrs->num_rows;
                                $UImages = Database::search("SELECT `user_code` FROM `user_image` WHERE `user_email` = '".$rchat["email"]."';");
                                $UImg = $UImages->fetch_assoc();                        
                                    ?>
                                    <div onclick="SelectUserMsg('<?php echo $rchat['email']; ?>');" class="col-12 d-flex py-2 my-1 bg-white rounded-5">
                                        <div class="d-flex">
                                            <img class="rounded-circle round-image m-auto me-2" width="60px" height="60px" src="<?php if(isset($UImg["user_code"])){echo $UImg["user_code"];}
                                                else{echo "User_img/demoProfileImg.jpg";}?>" />
                                        </div>
                                        <div class="d-flex justify-content-center flex-column">
                                            <span><b><?php echo $rchat["fname"]." ".$rchat["lname"] ?></b></span>
                                            <?php
                                            if($sendernr >= 1){
                                                $senderdata = $senderrs->fetch_assoc();
                                            ?>
                                            <span><b>Connected : </b><?php echo mb_strimwidth($senderdata["content"], 0, 20, "..."); ?></span>
                                            <?php
                                            }else{
                                            ?>
                                            <span><b>Not Connected</b></span>
                                            <?php
                                            }
                                            ?>
                                        </div>
                                    </div>
                            <?php
                            }
                            ?>
                            <div class="col-12 d-flex justify-content-center align-items-center bg-white my-1 rounded-5">
                                <div class="bi bi-three-dots"></div>
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-md-7 px-0 d-flex flex-column justify-content-between">
                        <div id="chatFillrow" class="row px-4">
                        </div>
                        <div id="TypeFillrow" class="row mb-1 rounded-5">   
                        </div>
                    </div>
                </div>
            </div>

            <!-- footer -->
            <?php require "footer.php"; ?>
            <!-- footer -->

        </div>
    </div>



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