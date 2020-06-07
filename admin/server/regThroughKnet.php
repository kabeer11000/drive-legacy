<?php
include "dbConnect.php";
function totalKnetUsers($db){
    $query = "SELECT * FROM `users` WHERE `regKnet` = '1';";
    $result = count(mysqli_fetch_all(mysqli_query($db,$query)));
    return $result;
}
$totalKnetUsers = totalKnetUsers($db);
?>