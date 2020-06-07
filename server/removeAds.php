<?php
include 'dbConnect.php';

if(isset($_POST['coupon'])) {
    $userCode = strip_tags($_POST['coupon']);
    $query = "SELECT `code`, `used` FROM `coupons` WHERE `used` ='0'";
    $result = mysqli_query($db, $query);
    $resultCode = 0;
    while ($row = mysqli_fetch_row($result)) {
        if ($row[0]==$userCode) {
                $query = "UPDATE `users` SET `plus` = '1' WHERE `uniqueId`  = '" . $_SESSION['id'] . "' AND `username` = '" . $_SESSION['username'] . "';";
                $id_query_result = mysqli_query($db, $query);
                $query = "UPDATE `coupons` SET `used` = '1' WHERE `code`  = '" . $userCode . "';";
                $id_query_result = mysqli_query($db, $query);
                $_SESSION['plus']=1;
                $resultCode = 1;
        }
    }
    if ($resultCode == 1){
        header("Location:../removeAds.php?msg=Ads Have Been Removed For This Account&t=1");
    }else{
        header("Location:../removeAds.php?msg=Incorrect Coupon Code!&t=0");
    }

}