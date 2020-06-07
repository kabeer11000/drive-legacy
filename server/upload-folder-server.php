<?php
include 'dbConnect.php';
session_start();


$total = count($_FILES['file']['name']);
for( $i=0 ; $i < $total ; $i++ ) {

$hash = md5(sha1(uniqid()));    
$target_dir = "../user-files/";
$uploadOk = 1;
$fileName = basename($_FILES["file"]["name"][$i]);
$id = $_GET['id'];
$username = $_SESSION['username'];
$uniqueId = md5(uniqId()."");
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['tmp_name'][$i]);
$mimeType = $mime;
$address  = $hash.$uniqueId.$fileName;
$target_file = $target_dir .$hash.$uniqueId. basename($_FILES["file"]["name"][$i]);
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
if ($_FILES["file"]["size"][$i] > 99999999) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {



    if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file)) {
        //echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
        $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$fileName', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
        mysqli_query($db, $query);
        $response = "user-files/".$address;
    } else {}
  }
}
    

echo $response;