<?php
session_start();
if ($_SESSION['username'] != "bugs"){
    header("Location:../login.php");
}
include "pieChart.php";
include "totalUsers.php";
include "regThroughKnet.php";
include "tablesData.php";
include "areaChart.php";
include "activeUsers.php";
include "totalLogins.php";

//http://drive.hosted-kabeersnetwork.unaux.com/server/activeusers/active_users_record.php
?>