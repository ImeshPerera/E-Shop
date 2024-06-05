<?php
session_start();
require "../connection.php";

$UserUpfname = $_POST["UserUpfname"];
$UserUplname = $_POST["UserUplname"];
$UserUpmobile = $_POST["UserUpmobile"];
$UserUppassword = $_POST["UserUppassword"];
$UserUpemail = $_POST["UserUpemail"];
$UserUpline1 = $_POST["UserUpline1"];
$UserUpline2 = $_POST["UserUpline2"];
$UserUpProvinceid = $_POST["UserUpProvinceid"];
$UserUpDistrictid = $_POST["UserUpDistrictid"];
$UserUpcity = $_POST["UserUpcity"];
$UserUppostal = $_POST["UserUppostal"];

if(empty($UserUpfname)){
    echo "Please Enter Your First Name First";
}elseif(strlen($UserUpfname) >= 50){
    echo "You First Name length is incorrect. Are you Humen ?";
}elseif(empty($UserUplname)){
    echo "Please Enter Your Last Name";
}elseif(strlen($UserUplname) >= 50){
    echo "You Last Name length is incorrect. Are you Humen ?";
}elseif(empty($UserUpemail)){
    echo "Please Enter Your Email";
}elseif(!filter_var($UserUpemail,FILTER_VALIDATE_EMAIL)){
    echo "Your Email is not Validated. Type a Correct One";
}elseif(strlen($UserUpemail) > 100){
    echo "your email length is exceed the limit.";
}elseif(empty($UserUppassword)){
    echo "Your Password field is Empty";
}elseif((strlen($UserUppassword) <= 5)||(strlen($UserUppassword) >= 20)){
    echo "Your Password length is not applicable";
}elseif(empty($UserUpmobile)){
    echo "Your Mobile Field is Empty";
}elseif(preg_match("/07[0,1,2,4,5,6,7,8][0-9]+/",$UserUpmobile)==0){
    echo "Your Mobile Number is not applicable";
}elseif(strlen($UserUpmobile) != 10){
    echo "Your Mobile Number length is not applicable";
}elseif(empty($UserUpline1)){
    echo "Please Enter Your Address Line 1";
}elseif(strlen($UserUpline1) >= 100){
    echo "Your Address Line 1 length is incorrect.";
}elseif(empty($UserUpline2)){
    echo "Please Enter Your Address Line 2";
}elseif(strlen($UserUpline2) >= 100){
    echo "Your Address Line 2 length is incorrect.";
}elseif($UserUpProvinceid == 0 || $UserUpProvinceid > 9){
    echo "Please Select Your Province First";
}elseif($UserUpDistrictid == 0 || $UserUpDistrictid > 9){
    echo "Please Select Your District";
}elseif(empty($UserUpcity)){
    echo "Please Enter Your City Name";
}elseif(strlen($UserUpcity) >= 50){
    echo "You City Name length is incorrect.";
}elseif((!mb_ereg_match('^[0-9]+$', $UserUppostal)) || (strlen($UserUppostal) != 5)){
    echo "You Postal Code is incorrect.";
}else{
    $Citydataid;
    $CityhasPostal = Database::search("SELECT * FROM city WHERE `postal_code` = '".$UserUppostal."';");
    if($CityhasPostal->num_rows == 1){
        $citydata = $CityhasPostal->fetch_assoc();
        $UserUpcity = $citydata["name"];
        $Citydataid = $citydata["id"];
    }else{
        Database::iud("INSERT INTO city(`name`,`postal_code`,`district_id`) VALUES ('".$UserUpcity."','".$UserUppostal."','".$UserUpDistrictid."');");
        $CitynewPostal = Database::search("SELECT * FROM city WHERE `postal_code` = '".$UserUppostal."';");
        $citynewdata = $CitynewPostal->fetch_assoc();
        $Citydataid = $citynewdata["id"];
    }
    $Addressdata = Database::search("SELECT `user_email` FROM user_has_address WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
    if($Addressdata->num_rows == 1){
        Database::iud("Update user_has_address SET `line1` = '".$UserUpline1."',`line2` = '".$UserUpline2."',`city_id` = '".$Citydataid."' WHERE `user_email` = '".$_SESSION["user"]["email"]."';");
        echo "SA1";
    }else{
        Database::iud("INSERT INTO user_has_address(`user_email`,`line1`,`line2`,`city_id`) VALUES ('".$_SESSION["user"]["email"]."','".$UserUpline1."','".$UserUpline2."','".$Citydataid."');");
        echo "SA2";
    }
}

?>
