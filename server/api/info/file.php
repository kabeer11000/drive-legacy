<?php
session_start();
include '../../dbConnect.php';
if(isset($_GET['id'])){
    $file_id = strip_tags(htmlspecialchars($_GET['id']));
    $query = "SELECT * FROM `files` WHERE owner ='".$_SESSION['username']."' AND uniqueId='".$file_id."';";
    $result = mysqli_fetch_assoc(mysqli_query($db, $query));
if($result){
    $name = $result['name'];
    $id = $result['uniqueId'];
    $size = filesize('../../.././user-files/'.$result['address']);
    $path = $result['address'];
    $shared = $result['shared'];
    $mime = $result['mimeType'];
    $owner = $result['owner'];
    $dateCreated = $result['dateCreated'];
    $dateModified = $result['dateModified'];
        echo '{
          "name": "'.$name.'",
          "id": "'.$id.'",
          "size": "'.$size.'",
          "path": "http://drive.hosted-kabeersnetwork.unaux.com/user-files/'.$path.'",
          "shared": "'.$shared.'",
          "mime": "'.$mime.'",
          "owner": "'.$owner.'",
          "dateCreated": "'.$dateCreated.'",
          "dateModified": "'.$dateModified.'"
            
        }';
    }else{
        echo 'File Not Found';
    }
}
?>
