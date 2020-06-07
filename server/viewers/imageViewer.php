<?php
include '../dbConnect.php';
session_start();

if(!isset($_SESSION['username']) && !isset($_SESSION['id']) ){
    header("Location:../../login.php");
}
if (!isset($_GET['id'])){header("Location:../../index.php");}
$query = "SELECT * FROM `files` WHERE owner = '".$_SESSION['username']."' AND uniqueId = '".$_GET['id']."' LIMIT 1 ;";
$result = mysqli_query($db, $query);
$file = mysqli_fetch_assoc($result);

header('Content-Description: File Transfer');
header('Content-Type: application/octet-stream');
header('Content-Transfer-Encoding: binary');
header('Expires: 0');
header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
header('Pragma: public');
header("Content-Type: ".$file['mimeType']);
header("Content-Length: ".filesize("../../user-files/".$file['address']));
ob_end_flush();
@readfile("../../user-files/".$file['address']);

?>