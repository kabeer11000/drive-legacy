<?php
include "../dbConnect.php";
session_start();
if (!isset($_GET['id'])){header("Location:../../index.php");}
$query = "SELECT * FROM `files` WHERE `uniqueId` = '".$_GET['id']."' AND `shared` = '1';";
$result = mysqli_query($db, $query);
$result = mysqli_fetch_assoc($result);
if($result['shared'] = '1') {
    $file='../../.././user-files/'.$result['address'];
    //header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
    header("Content-Type: " . $result['mimeType']);
    header("Content-Length: " . filesize($file));
    header("Content-Disposition: attachment; filename=\"" . $result['name'] . "\"");
    readfile($file);
}else{
    header("Location:../../../index.php");
    echo 'File Was Not Foind On Server';}