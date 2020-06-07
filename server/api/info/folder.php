<?php
session_start();
include '../../dbConnect.php';
if(isset($_GET['id'])){
    $folder_id = strip_tags(htmlspecialchars($_GET['id']));
    $query = "SELECT * FROM `folders` WHERE owner ='".$_SESSION['username']."' AND uniqueId='".$folder_id."';";
    $result = mysqli_fetch_assoc(mysqli_query($db, $query));
if($result){
    $name = $result['name'];
    $id = $result['uniqueId'];
    $shared = $result['shared'];
    $owner = $result['owner'];
    $dateCreated = $result['dateCreated'];
    $dateModified = $result['dateModified'];
        echo '{
          "name": "'.$name.'",
          "id": "'.$id.'",
          "shared": "'.$shared.'",
          "owner": "'.$owner.'",
          "dateCreated": "'.$dateCreated.'",
          "dateModified": "'.$dateModified.'"
        }';
    }else{
        echo 'Folder Not Found';
    }
}
?>
