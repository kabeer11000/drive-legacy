<?php
include 'dbConnect.php';
include '../config.php';
session_start();
gc_enable();
function clean($string) {
   $string = str_replace(' ', '-', $string);
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string);
   return preg_replace('/-+/', '-', $string);
}
function queryBuilder($url, $query){
    
   $parsedUrl = parse_url($url);
   if ($parsedUrl['path'] == null) {
      $url .= '/';
   }
   $separator = ($parsedUrl['query'] == NULL) ? '?' : '&';
   $url .= $separator . $query;
   return $url;
}
if(isset($_GET['share'])){
    if(!isset($_GET['ShareN'])){
        $shared = '0';
    }else{$shared = '1';}
    $query2 = "UPDATE `files` SET `shared`= '".$shared."' WHERE `owner` = '".$_SESSION['username']."' AND `uniqueId` = '".$_GET['share']."';";
    //echo $query2;
    $result2 = mysqli_query($db, $query2);
    mysqli_free_result($result2);
    gc_collect_cycles();
    mysqli_close($db);
    header("Location:../index.php?t=".$_GET['share'].'&m='.$shared);

}
if (isset($_GET['makeDir'])&&isset($_GET['id'])){
    $uniueId = md5(uniqid());
    $query3 = "INSERT INTO `folders`(`parent`, `childern`, `shared`, `owner`, `name`, `myDrive`, `uniqueId`) 
VALUES ('".$_GET['id']."', '', '0', '".$_SESSION['username']."','".clean($_GET['makeDir'])."', '0','".$uniueId."');";
    $result3 = mysqli_query($db, $query3);
    //mkdir(".././user-folders/".$uniueId);
    echo '<script>window.parent.location.reload()</script>';
    header("Location:../index.php");
}
if (isset($_GET['deleteDir'])){
    $delDir = $_GET['deleteDir'];
$query4 = "DELETE FROM `folders` WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
$result4 = mysqli_query($db, $query4);
$query = "SELECT `uniqueId` FROM `folders` WHERE `owner` = '".$_SESSION['username']."' AND `parent` = '$delDir';";
$result1 = mysqli_query($db, $query);
while ($row = mysqli_fetch_row($result1)) {

    $query4 = "DELETE FROM `folders` WHERE `uniqueId` = '" . $row[0] . "' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);  
    
    mysqli_free_result($result4);
    gc_collect_cycles();
    
    $query4 = "DELETE FROM `folders` WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
    
    $query4 = "DELETE FROM `files` WHERE `parent` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "'";
    $result4 = mysqli_query($db, $query4);
    
    mysqli_free_result($result4);
    gc_collect_cycles();
    
    $query4 = "DELETE FROM `files` WHERE `parent` = '" . $row[0] . "' AND `owner` = '" . $_SESSION['username'] . "'";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
    
 }
mysqli_close($db);
}
if (isset($_GET['shareDir'])){
$delDir = $_GET['shareDir'];
$query4 = "UPDATE `folders` SET `shared` = '1' WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
$result4 = mysqli_query($db, $query4);
$query = "SELECT `uniqueId` FROM `folders` WHERE `owner` = '".$_SESSION['username']."' AND `parent` = '$delDir';";
$result1 = mysqli_query($db, $query);
gc_collect_cycles();
while ($row = mysqli_fetch_row($result1)) {

    $query4 = "UPDATE `folders` SET `shared` = '1' WHERE `uniqueId` = '" . $row . "' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
    
    $query4 = "UPDATE `folders` SET `shared` = '1' WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
 }
 mysqli_close($db);
header("Location:".queryBuilder($_SERVER['HTTP_REFERER'],'&msg=Folder Shared '.urlencode(constant('SITE_URL').'/share/'.$_GET['shareDir'])));
}
if (isset($_GET['stopShareDir'])){
$delDir = $_GET['stopShareDir'];
$query4 = "UPDATE `folders` SET `shared` = '0' WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
$result4 = mysqli_query($db, $query4);
$query = "SELECT `uniqueId` FROM `folders` WHERE `owner` = '".$_SESSION['username']."' AND `parent` = '$delDir';";
$result1 = mysqli_query($db, $query);
gc_collect_cycles();
while ($row = mysqli_fetch_row($result1)) {

    $query4 = "UPDATE `folders` SET `shared` = '0' WHERE `uniqueId` = '" . $row . "' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
    
    $query4 = "UPDATE `folders` SET `shared` = '0' WHERE `uniqueId` = '$delDir' AND `owner` = '" . $_SESSION['username'] . "';";
    $result4 = mysqli_query($db, $query4);

    mysqli_free_result($result4);
    gc_collect_cycles();
 }
 mysqli_close($db);
header("Location:".queryBuilder($_SERVER['HTTP_REFERER'],'&msg=Folder UnShared'));
}