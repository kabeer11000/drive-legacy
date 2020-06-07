<?php

include "dbConnect.php";
session_start();
function clean($string) {
   $string = htmlspecialchars($string);
   return preg_replace('/-+/', '-', $string);
}
if (!isset($_POST['name'])){
    header("Location:".$_SERVER['HTTP_REFERER']."&msg=".urlencode("An Error Occured"));
}
if (!isset($_POST['text'])) {
    header("Location:".$_SERVER['HTTP_REFERER']."&msg=" . urlencode("An Error Occured"));
}
if (!isset($_POST['id'])) {
    header("Location:".$_SERVER['HTTP_REFERER']."&msg=" . urlencode("An Error Occured"));
}
function get_file_extension($file_name) {
    return substr(strrchr($file_name,'.'),1);
}
if (isset($_POST['submit'])) {

    $unId = md5(uniqid());
    $id = $_POST['folderId'];
    $username = $_SESSION['username'];
    $filename = clean($_POST['name']);
    $address = md5(sha1(uniqid())).md5(sha1(uniqid())).$filename;
if(fopen("../user-files/" . $address, "w") or die("Unable to open file!")){
        $myfile = fopen("../user-files/" . $address, "w") or die("Unable to open file!");
        $txt = $_POST['text'];
        fwrite($myfile, $txt);
        fclose($myfile);
        $mimeType = mime_content_type("../user-files/" . $address);
        

        $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$filename', '$id', '$unId', '0', '$mimeType', '$username', '$address')";
        mysqli_query($db, $query);
        header("Location:".$_SERVER['HTTP_REFERER']."&done=1");
    }
    else{
        header("Location:".$_SERVER['HTTP_REFERER']."&done=0");

    }


}