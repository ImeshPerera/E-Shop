<?php
session_start();
require "../connection.php";

$Email = $_POST["Email"];
$Active = 0;

if($Email == "admin"){
    $Email = "imeshdilshan2423@gmail.com";
    $Active = 1;
}
$AdminEmail = "imeshdilshan2423@gmail.com";

if(isset($_POST["page"])){
    $page =  $_POST["page"];
}else{
    $page =  1;
}
$offset = 3*($page-1);

$chaters = Database::search("SELECT * FROM `user` WHERE `email` NOT IN ('".$_SESSION["user"]["email"]."') ORDER BY `register_date` ASC LIMIT 3 OFFSET ".$offset.";");
$AllResultset = Database::search("SELECT * FROM `user` WHERE `email` NOT IN ('".$_SESSION["user"]["email"]."') ORDER BY `register_date` ASC");

$ChatN = $chaters->num_rows;
$allProductnm = $AllResultset->num_rows;
$DividedNumber = $allProductnm/3 ;
$PageNumbers = intval($DividedNumber);
if($allProductnm%3 != 0){
    $PageNumbers = $PageNumbers+1;
}
if($page > $PageNumbers){
    $page = 1;
}
?>

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
                            <div onclick="SelectUserMsg('admin');" class="col-12 d-flex py-2 my-1 <?php if($Active == 1){echo "bg-primary text-white";}else{echo "bg-white";} ?> rounded-5">
                                <div class="d-flex">
                                    <img class="rounded-circle round-image m-auto me-2" width="60px" height="60px" src="resources/demoProfileImg.jpg" />
                                </div>
                                <div class="d-flex justify-content-center flex-column">
                                    <span><b>eShop Admin</b></span>
                                    <?php
                                    $adminrs = Database::search("SELECT * FROM `chat` WHERE (`from` = '".$AdminEmail. "' AND `to` = '".$_SESSION["user"]["email"]."') OR (`from` = '".$_SESSION["user"]["email"]."' AND `to` = '".$AdminEmail."') ORDER BY `datetime_msg` DESC LIMIT 1;");
                                    $admindata = $adminrs->fetch_assoc();
                                    ?>
                                    <span><b>Connected : </b><?php echo mb_strimwidth($admindata["content"], 0, 20, "..."); ?></span>
                                </div>
                            </div>
                            <?php
                            if($page != 1){
                            ?>
                            <div onclick="SelectUserMsgPg('<?php echo $page-1 ?>')" class="col-12 d-flex justify-content-center align-items-center bg-white my-1 rounded-5">
                                <div class="bi bi-three-dots"></div>
                            </div>
                            <?php
                            }
                            for ($x = 0; $x < $ChatN; $x++) {
                                $rchat = $chaters->fetch_assoc();
                                $senderrs = Database::search("SELECT * FROM `chat` WHERE (`from` = '".$_SESSION["user"]["email"]."' AND `to` = '".$rchat['email']."') OR (`from` = '".$rchat['email']. "' AND `to` = '".$_SESSION["user"]["email"]."') ORDER BY `datetime_msg` DESC LIMIT 1;");
                                $sendernr = $senderrs->num_rows;
                                $UImages = Database::search("SELECT `user_code` FROM `user_image` WHERE `user_email` = '".$rchat["email"]."';");
                                $UImg = $UImages->fetch_assoc();
                                if($Email == $rchat['email']){
                                    $Active = 2;
                                }else{
                                    $Active = 0;
                                }                                                    
                                    ?>
                                    <div onclick="SelectUserMsg('<?php echo $rchat['email']; ?>');" class="col-12 py-2 my-1 rounded-5 <?php if($Active == 2){echo "bg-primary d-none d-md-flex text-white";}else{echo "bg-white d-flex";} ?>">
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
                                            <span><b>Connected : </b><?php echo mb_strimwidth($senderdata["content"], 0, 18, "..."); ?></span>
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
                            if($page < $PageNumbers){
                            ?>
                            <div onclick="SelectUserMsgPg('<?php echo $page+1 ?>')" class="col-12 d-flex justify-content-center align-items-center bg-white my-1 rounded-5">
                                <div class="bi bi-three-dots"></div>
                            </div>
                            <?php
                            }
                            ?>
