<?php
include "../dbConnect.php";
session_start();
if (isset($_GET['adsUrl'])){
    function insertIntoDb($db, $username, $kind, $redirect){
        $uniqueToken = md5(sha1(uniqid().date()));
        $redirect = urldecode($redirect);
        $query = "INSERT INTO `adslog`(`whoclicked`, `uniqueToken`, `kind`, `redirect`) VALUES ('$username','$uniqueToken','$kind','$redirect');";
        mysqli_query($db, $query);
    }
   insertIntoDb($db,$_SESSION['username'],1,$_GET['adsUrl']);
   header("Location:".$_GET['adsUrl']);
}
?>