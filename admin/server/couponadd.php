<?php
include "dbConnect.php";
session_start();
if ($_SESSION['username'] != "bugs"){
    header("Location:../login.php");
}
function addCoupon($db, $code){
    $query = "INSERT INTO `coupons`(`code`, `used`) VALUES ('$code','0')";
    mysqli_query($db,$query);
}
if (isset($_POST['couponCode'])){
    addCoupon($db,$_POST['couponCode']);
    header("Location:".$_SERVER['HTTP_REFERER']."?result=Coupon+Successfully+Added");
}