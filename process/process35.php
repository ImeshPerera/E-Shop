<?php
session_start();
require "../connection.php";

$Email = $_POST["Email"];
$Active = 0;

if($Email == "admin"){
    $Email = "imeshdilshan2423@gmail.com";
    $rchat["fname"] = "eShop";
    $rchat["lname"] = "Admin";
    $rchat["email"] = "Admin";
}else{
    $UImages = Database::search("SELECT `user_code` FROM `user_image` WHERE `user_email` = '".$Email."';");
    $UImg = $UImages->fetch_assoc();
    $chaters = Database::search("SELECT * FROM `user` WHERE `email` = '".$Email."';");
    $rchat = $chaters->fetch_assoc();
}
    $senderrs = Database::search("SELECT * FROM `chat` WHERE (`from` = '".$Email. "' AND `to` = '".$_SESSION["user"]["email"]."') OR (`from` = '".$_SESSION["user"]["email"]. "' AND `to` = '".$Email."') ORDER BY `datetime_msg` ASC;");
    $sendernr = $senderrs->num_rows;
    ?>
        <div class="col-12 d-flex py-2 my-1 rounded-5 text-white bg-primary">
            <div class="d-flex">
                <img class="rounded-circle round-image m-auto me-2" width="60px" height="60px" src="<?php if(isset($UImg["user_code"])){echo $UImg["user_code"];}
                            else{echo "User_img/demoProfileImg.jpg";}?>" />
            </div>
            <div class="d-flex justify-content-center flex-column">
                <span><b><?php echo $rchat["fname"]." ".$rchat["lname"] ?></b></span>
            </div>
        </div>
        <div class="col-12">
            <hr class="hrbreak0 bg-dark mt-1">
        </div>
        <div id="chat-box" class="col-12 chat-box">
    <?php
    if($sendernr == 0){
        ?>
        <!-- receiver's' message -->
        <div class="d-flex w-100 align-items-center flex-column">
            <label class="text-dark bi bi-chat-dots"></label>
            <label class="text-dark">There has No chat history yet.</label>
        </div>
        <!-- receiver's' message -->
        <?php
        }
    for($i = 0; $i < $sendernr; $i++){
        $senderdata = $senderrs->fetch_assoc();
            if($senderdata["from"] == $_SESSION["user"]["email"]){
                ?>
                <!-- sender' message -->
                <div class="d-flex justify-content-end w-100">
                    <div class="me-3 w-45">
                        <div class="bg-light rounded-3 py-2 px-3">
                            <span class="text-black"><?php echo $senderdata["content"]; ?></span>
                        </div>
                        <p class="small text-black-50 mt-1 mb-1 mb-md-0 text-end"><?php echo $senderdata["datetime_msg"]; ?></p>
                    </div>
                </div>
                <!-- sender' message -->
                <?php
            }
            if($senderdata["to"] == $_SESSION["user"]["email"]){
                ?>
                <!-- receiver's' message -->
                <div class="d-flex w-100">
                    <div class="w-45">
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
    <?php
?>