<?php
include "dbConnect.php";
function totalUsers($db){
    $query = "SELECT * FROM `users`";
    $result = count(mysqli_fetch_all(mysqli_query($db,$query)));
    return $result;
}
$totalUsers = totalUsers($db);
?>