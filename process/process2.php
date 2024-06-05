<?php
    session_start();
    require "../connection.php";

    $email = $_POST["email"];
    $password = $_POST["password"];
    $remember = $_POST["remember"];

    $resultsetem = Database::search("SELECT * FROM user WHERE `email` = '".$email."';");
    $emailn = $resultsetem->num_rows;

    $resultset = Database::search("SELECT * FROM user WHERE `email` = '".$email."' AND `password` = '".$password."';");
    $n = $resultset->num_rows;

    if(empty($email)){
    echo "Please Enter Your Email";
    }elseif(!filter_var($email,FILTER_VALIDATE_EMAIL)){
        echo "Your Email is not Validated. Type a Correct One";
    }elseif(strlen($email) > 100){
        echo "your email length is exceed the limit.";
    }elseif($emailn != 1){
        echo "Your Email is not Existed";
    }elseif(empty($password)){
        echo "Your Password field is Empty";
    }elseif((strlen($password) <= 5)||(strlen($password) >= 20)){
        echo "Your Password length is not applicable";
    }elseif($n == 1){
        echo "Success";
        $data = $resultset->fetch_assoc();
        $_SESSION["user"] = $data;
        if($remember == "true"){
            setcookie("e",$email,time()+(60*60*24*365),"/");
            setcookie("p",$password,time()+(60*60*24*365),"/");
        }else{
            setcookie("e","",-1,"/");
            setcookie("p","",-1,"/");
        }
    }else{
        echo "Probably your password is Incorrect";
    }
?>