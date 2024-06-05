<?php
require "../connection.php";

$fname =$_POST["fname"];
$lname =$_POST["lname"];
$email =$_POST["email"];
$password =$_POST["password"];
$mobile =$_POST["mobile"];
$gender =$_POST["gender"];

if(empty($fname)){
    echo "Please Enter Your First Name First";
}elseif(strlen($fname) >= 50){
    echo "You First Name length is incorrect. Are you Humen ?";
}elseif(empty($lname)){
    echo "Please Enter Your Last Name";
}elseif(strlen($lname) >= 50){
    echo "You Last Name length is incorrect. Are you Humen ?";
}elseif(empty($email)){
    echo "Please Enter Your Email";
}elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
    echo "Your Email is not Validated. Type a Correct One";
}elseif(strlen($email) > 100){
    echo "your email length is exceed the limit.";
}elseif(empty($password)){
    echo "Your Password field is Empty";
}elseif((strlen($password) <= 5)||(strlen($password) >= 20)){
    echo "Your Password length is not applicable";
}elseif(empty($mobile)){
    echo "Your Mobile Field is Empty";
}elseif(preg_match("/07[0,1,2,4,5,6,7,8][0-9]+/",$mobile)==0){
    echo "Your Mobile Number is not applicable";
}elseif(strlen($mobile) != 10){
    echo "Your Mobile Number length is not applicable";
}else{
    
    $r = Database::search("SELECT * FROM `user` WHERE `email` = '".$email."';");
    if($r->num_rows > 0){
        echo "User with the same email address or mobile number already exsist";
    }else{
        $d = new DateTime();
        $tz = new DateTimeZone("Asia/Colombo");
        $d->setTimezone($tz);
        $date = $d->format("Y-m-d H:i:s");
    
        Database::iud("INSERT INTO `user`(`email`,`fname`,`lname`,`password`,`mobile`,`register_date`,`gender_id`) VALUES ('".$email."','".$fname."','".$lname."','".$password."','".$mobile."','".$date."','".$gender."')");
        Database::iud("INSERT INTO `chat` (`from`,`to`,`content`,`datetime_msg`,`status`) VALUES ('imeshdilshan2423@gmail.com','".$email."','Welcome to eShop...','".$date."','1')");
        echo "Success";
        }
}
?>