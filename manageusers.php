<?php
session_start();
require "connection.php";

if(isset($_SESSION["admin"])){
    $AdminEmail = "imeshdilshan2423@gmail.com";
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
        td{
            vertical-align: middle;
        }
    </style>
</head>

<body>
    <!-- Alert -->
    <?php require "alert.php"; ?>
    <!-- Alert -->
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
                <nav class="nav flex-column row-gap-1">
                    <a class="btn btn-primary text-white nav-link" href="adminpanel.php">Dashboard</a>
                    <a class="btn btn-primary text-white nav-link" href="manageproducts.php">Manage Products</a>
                    <a class="btn btn-primary text-white nav-link" href="sellinghistory.php">Sellings</a>
                    <a class="btn btn-primary text-white nav-link" href="newapply.php">Develops</a>
                </nav>
            </div>
            <div class="col-12 col-md-9 col-lg-10 mb-3">
                <div class="row pt-md-3 g-1">
                    <div class="col-12 my-3 text-center">
                        <p class="h2 fw-bold m-0 p-0 text-white">Users</p>
                    </div>
                </div>
                <div class="row">
                    <div class="col-lg-12">
                        <div class="card">
                            <div class="card-body">
                                <h4 class="card-title">User Management</h4>
                                <div class="d-flex justify-content-center my-2">
                                    <input type="text" class="form-control" id="AdminUserSearch" placeholder="Search Users" />
                                    <button onclick="AdminUserSearch();" class="btn btn-outline-primary ms-2-5">Search</button>
                                </div>
                                <div class="table-responsive mt-md-3">
                                    <table class="table table-striped">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Profile Image</th>
                                                <th>User Name</th>
                                                <th>User Email</th>
                                                <th>Mobile</th>
                                                <th>Registerd</th>
                                                <th></th>
                                            </tr>
                                        </thead>
                                        <tbody id="AdminUserFill">
                                            <?php
                                            $AllUsers = Database::search("SELECT * FROM `user`;");
                                            $AllNum = $AllUsers->num_rows;
                                            for($i = 1; $i <= $AllNum; $i++){
                                                $MsgLevel = "off";
                                                $AllData = $AllUsers->fetch_assoc();
                                                $UImages = Database::search("SELECT `user_code` FROM `user_image` WHERE `user_email` = '".$AllData["email"]."';");
                                                $UImg = $UImages->fetch_assoc();  
                                                $senderrs = Database::search("SELECT * FROM `chat` WHERE `from` = '".$AllData["email"]. "' AND `to` = '".$AdminEmail."' AND `status` = '1' ORDER BY `datetime_msg` ASC;");
                                                $sendernr = $senderrs->num_rows;
                                                if($sendernr >= 1){
                                                    $MsgLevel = "on";
                                                }
                                                                  
                                            ?>
                                                <tr <?php if($AllData["user_status_id"] == 2){echo "class='bg-danger'";}else{}?>>
                                                    <td><?php if($i < 10){ echo "0".$i ;}else{echo $i ;} ?></td>
                                                    <td class="py-1">
                                                        <div class="Chat-status <?php if($MsgLevel == "on"){echo "on";}else{echo "off";} ?>"></div>
                                                        <img onclick="AdminUserView(<?php echo $i; ?>);" class="rounded-circle round-image me-2" src="<?php if(isset($UImg["user_code"])){echo $UImg["user_code"];}
                                                        else{echo "User_img/demoProfileImg.jpg";}?>" width="50px" height="50px" alt="image" />
                                                    </td>
                                                    <td><?php echo mb_strimwidth($AllData["fname"]." ".$AllData["lname"], 0, 30, "..."); ?></td>
                                                    <td><?php echo mb_strimwidth($AllData["email"], 0, 30, "..."); ?></td>
                                                    <td><?php echo $AllData["mobile"]; ?></td>
                                                    <td><?php echo $AllData["register_date"]; ?></td>
                                                    <td><button class="btn d-flex align-items-center <?php if($AllData["user_status_id"] == 2){echo "btn-success";}else{echo "btn-danger";}?>" onclick="UserStatus('<?php echo $AllData['email'] ?>');">
                                                        <i class="bi bi-exclamation-diamond fs-5"></i><span><?php if($AllData["user_status_id"] == 2){echo "Unblock";}else{echo "Block";}?></span></button></td>
                                                </tr>
                                                                                                <!-- Model -->
                                                                                                <div class="col-12">
                                                    <div class="modal" id="AdminUserMsgModel<?php echo $i; ?>" tabindex="-1">
                                                        <div  class="modal-dialog modal-dialog-centered modal-dialog-scrollable">
                                                            <div class="modal-content">
                                                                <div class="modal-header rounded-5 text-white bg-primary py-2 m-1">
                                                                    <div class="col d-flex">
                                                                        <div class="d-flex ms-2">
                                                                            <img class="rounded-circle round-image m-auto me-2" width="60px" height="60px" src="<?php if(isset($UImg["user_code"])){echo $UImg["user_code"];}
                                                                                        else{echo "User_img/demoProfileImg.jpg";}?>" />
                                                                        </div>
                                                                        <div class="d-flex justify-content-center flex-column">
                                                                            <span><b><?php echo $AllData["fname"]." ".$AllData["lname"] ?></b></span>
                                                                        </div>
                                                                    </div>
                                                                    <a type="button" class="mx-2 bg-transparent text-white bi bi-hourglass-split" data-bs-dismiss="modal" aria-label="Close"></a>
                                                                    <a type="button" onclick="MarkAsReadAdmin('<?php echo $AllData['email'] ?>');" class="mx-2 bg-transparent text-white bi bi-trash" data-bs-dismiss="modal" aria-label="Close"></a>
                                                                </div>
                                                                <div id="chatFillrow<?php echo $i; ?>" class="modal-body">
                                                                    <div id="chat-box" class="col-12">
                                                                        <?php
                                                                        $senderresults = Database::search("SELECT * FROM `chat` WHERE (`from` = '".$AllData["email"]. "' AND `to` = '".$AdminEmail."') OR (`from` = '".$AdminEmail. "' AND `to` = '".$AllData["email"]."') ORDER BY `datetime_msg` ASC;");
                                                                        $sendernrows = $senderresults->num_rows;
                                                                        for($n = 0; $n < $sendernrows ;$n++){
                                                                        $senderdata = $senderresults->fetch_assoc();
                                                                        if($senderdata["from"] == $AdminEmail){
                                                                            ?>
                                                                            <!-- sender' message -->
                                                                            <div class="d-flex justify-content-end w-100">
                                                                                <div class="me-3 w-75">
                                                                                    <div class="bg-light rounded-3 text-end py-2 px-3">
                                                                                        <span class="text-black"><?php echo $senderdata["content"]; ?></span>
                                                                                    </div>
                                                                                    <p class="small text-black-50 mt-1 mb-1 mb-md-0 text-end"><?php echo $senderdata["datetime_msg"]; ?></p>
                                                                                </div>
                                                                            </div>
                                                                            <!-- sender' message -->
                                                                            <?php
                                                                        }
                                                                        if($senderdata["to"] == $AdminEmail){
                                                                                ?>
                                                                                <!-- receiver's' message -->
                                                                                <div class="d-flex w-100">
                                                                                    <div class="w-75">
                                                                                        <div class="bg-primary rounded-3 py-2 px-3">
                                                                                            <span class="text-white"><?php echo $senderdata["content"]; ?></span>
                                                                                        </div>
                                                                                        <p class="small text-black-50 mt-1 mb-1 mb-md-0"><?php echo $senderdata["datetime_msg"]; ?></p>
                                                                                    </div>
                                                                                </div>
                                                                                <!-- receiver's' message -->
                                                                            <?php
                                                                        }
                                                                    }
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <div id="TypeFillrow<?php echo $i; ?>" class="modal-footer">
                                                                    <div class="input-group">
                                                                        <input id="msgtxt<?php echo $i; ?>" class="form-control py-1 rounded-5" type="text"
                                                                            placeholder="Type a message..." aria-describedby="sendbtn">
                                                                        <div onclick="sendmessage('<?php echo $AllData['email'] ?>','<?php echo $i; ?>');" class="m-0 btn btn-light d-flex align-items-center rounded-5 bg-white">
                                                                            <div class="bi bi-cursor-fill p-0 m-0 text-primary"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- model -->
                                            <?php
                                            }
                                            ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
    <script src="bootstrap/bootstrap.min.js"></script>
</body>

</html>
<?php
}else{
?>
<script>window.location="admin.php";</script>
<?php
}