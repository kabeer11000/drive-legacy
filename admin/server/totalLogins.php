<?php
include "dbConnect.php";
function totalLogins($db){
    $query = "SELECT * FROM `logins`";
    $result = count(mysqli_fetch_all(mysqli_query($db,$query)));
    return $result;
}
$totalLogins = totalLogins($db);
?>