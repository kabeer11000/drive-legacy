<?php
include "dbConnect.php";
function GetArray($db){
    $query  = "SELECT * FROM `users`";
    $result = count(mysqli_fetch_all(mysqli_query($db,$query)));
    return $result;
}
$AreaChartArrayString = GetArray($db);
