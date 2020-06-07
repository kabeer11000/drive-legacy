<?php
include "../dbConnect.php";
include '../../config.php';
session_start();
if ($_SESSION['username'] != constant('ADMIN_USER')){
    header("Location:../../login.php");
}

function average($a){
    $a = array_filter($a);
    if(count($a)) {
        return $average=array_sum($a)/count($a);
    }
}
function insert($db, $time){
    $query = "SELECT * FROM `usertimes`";
    if (mysqli_fetch_assoc(mysqli_query($db,$query))){
        $result = $time;
        $query = "INSERT INTO `usertimes`(`times`) VALUES ('$result')";
        mysqli_query($db,$query);
    }else{
        $result = $time;
        $query = "INSERT INTO `usertimes`(`times`) VALUES ($result)";
        mysqli_query($db,$query);
    }

}
if (isset($_GET['time'])){
    insert($db, strip_tags($_GET['time']));
}
?>