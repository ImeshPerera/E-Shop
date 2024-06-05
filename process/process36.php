<?php
session_start();
require "../connection.php";

$Email = $_POST["Email"];
$Active = 0;

if($Email == "admin"){
    $Email = "imeshdilshan2423@gmail.com";
    $rchat["email"] = "admin";
}else{
    $chaters = Database::search("SELECT * FROM `user` WHERE `email` = '".$Email."';");
    $rchat = $chaters->fetch_assoc();
}
?>
<!-- text -->
        <div class="input-group">
            <input id="msgtxt" class="form-control py-1 rounded-5" type="text"
                placeholder="Type a message..." aria-describedby="sendbtn">
            <div onclick="sendmessage('<?php echo $rchat['email'] ?>');" class="m-0 btn btn-light d-flex align-items-center rounded-5 bg-white">
                <div class="bi bi-cursor-fill p-0 m-0 text-primary"></div>
            </div>
        </div>
<!-- text -->
    <?php
?>