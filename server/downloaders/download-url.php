<?php
include '../dbConnect.php';
session_start();
$id = $_SESSION['id'];


if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../../login.php');
}
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    header("location: ../login.php");
}

// Initialize a file URL to the variable
/*if(isset($_GET['url'])){

$url = $_GET['url'];
} */
//$remote_url =
$url = $_GET['url'];

// Use basename() function to return the base name of file
$file_name = basename($url);
//$file_name = preg_replace("/[^a-zA-Z]/", "", $file_name).".html";

//if(strpos($file_name,".html")||strpos($file_name,".txt")==false){
// Use file_get_contents() function to get the file
// from url and use file_put_contents() function to
// save the file by using base name
$uniqueId = sha1(md5(uniqid()));
$id = $_SESSION['id'];
$fileName = $uniqueId.$file_name;
$username = $_SESSION['username'];
$address = $fileName;
if(file_put_contents("../.././user-files/". $fileName,file_get_contents($url))) {

    $mimeType = mime_content_type("../.././user-files/". $fileName);
    $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$file_name', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
    mysqli_query($db, $query);

    //echo "File downloaded successfully<br>"."http://hosted-kabeersnetwork.unaux.com/Private/uploads/".$file_name;
    //echo '<script>window.location.href="user-files/files.php";<script>';
    header("Location:".$_SERVER['HTTP_REFERER']);
}
else {
    echo "File downloading failed.";
}
//}
?>