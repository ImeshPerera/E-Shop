<?php
require "connection.php";

echo $merchant_id         = $_POST['merchant_id'];
echo $order_id             = $_POST['order_id'];
echo $payhere_amount     = $_POST['payhere_amount'];
echo $$email            = $_POST["email"];
echo $product_id         = $_POST["custom_1"];
$payhere_currency    = $_POST['payhere_currency'];
$status_code         = $_POST['status_code'];
$md5sig                = $_POST['md5sig'];
$merchant_secret = '4eZQzn3zujp4OTcrezSbMR4vUnrvLJO258RiH6EKke2C'; // Replace with your Merchant Secret (Can be found on your PayHere account's Settings page)
$local_md5sig = strtoupper (md5 ( $merchant_id . $order_id . $payhere_amount . $payhere_currency . $status_code . strtoupper(md5($merchant_secret)) ) );
if (($local_md5sig === $md5sig) AND ($status_code == 2) ){
    
    $d = new DateTime();
    $tz = new DateTimeZone("Asia/Colombo");
    $d->setTimezone($tz);
    $date = $d->format("Y-m-d H:i:s");
    Database::iud("INSERT INTO invoice(`order_id`,`product_id`,`user_email`,`total`,`datetime_purchased`) VALUES('qwwqdasdasdasd','13','imeshdilshan8181@gmail.com','19850','2021-04-24 12.44.56'); ");
    Database::iud("INSERT INTO invoice(`order_id`,`product_id`,`user_email`,`total`,`datetime_purchased`) VALUES('".$order_id."','".$product_id."','".$email."','".$payhere_amount."','".$date."');"); 
    $q1 = "SELECT `qty` FROM product WHERE `id` = '".$order_id."';";
    $resultset = $dbms->query($q1);
    $data = $resultset ->fetch_assoc();
    $in = $data["qty"];
    $out = $in - 1 ;
    $q1 = "UPDATE product SET `qty` = '".$out."' WHERE `id` = '".$order_id."';";
    $dbms->query($q1);

}