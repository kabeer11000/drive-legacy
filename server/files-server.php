<?php
include "dbConnect.php";
session_start();

gc_enable();
if (!isset($_SESSION['username']) && !isset($_SESSION['id'])){
    header("Location:../index.php");
}
gc_collect_cycles();
//if(!isset($_GET['id'])){
  //  header("Location:index.php");
//}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
if(isset($_GET['del'])&&isset($_GET['id'])) {
    $query = "SELECT `address` FROM `files` WHERE owner='" . $_SESSION['username'] . "' AND uniqueId= '" . strip_tags($_GET['id']) . "' LIMIT 1; ";
    $result = mysqli_query($db, $query);
    $file = mysqli_fetch_assoc($result);
    foreach ($file as $a) {
        if ($file) {
            $query1 = "DELETE FROM `files` WHERE owner='" . $_SESSION['username'] . "' AND uniqueId= '" . strip_tags($_GET['id']) . "' LIMIT 1; ";
            $result1 = mysqli_query($db, $query1);
            $file = mysqli_fetch_assoc($result1);
            unlink(".././user-files/" . $a);
            //header('Location: ' . $_SERVER['HTTP_REFERER']);
            gc_collect_cycles();


        }

    }
    mysqli_free_result($file);
    mysqli_close($db);
    gc_collect_cycles();

}
if (isset($_GET['return'])){

}
// data-id="'.$row[1].'"
if(isset($_GET['delD'])) {
    $query = "SELECT `address` FROM `folder` WHERE owner='" . $_SESSION['username'] . "' AND uniqueId= '" . strip_tags($_GET['id']) . "' LIMIT 1; ";
    $result = mysqli_query($db, $query);
    $file = mysqli_fetch_assoc($result);
    foreach ($file as $a) {
        if ($file) {
            $query1 = "DELETE FROM `files` WHERE owner='" . $_SESSION['username'] . "' AND uniqueId= '" . strip_tags($_GET['id']) . "' LIMIT 1; ";
            $result1 = mysqli_query($db, $query1);
            $file = mysqli_fetch_assoc($result1);
            unlink(".././user-files/" . $a);
            mysqli_free_result($file);
            mysqli_close($db);
            gc_collect_cycles();
            header("Location:../index.php");


        }

    }
}
if(isset($_GET['share'])){
    if(!isset($_GET['ShareN'])){
        $shared = '0';
    }else{$shared = '1';}
    $query2 = "UPDATE `files` SET `shared`= '".$shared."' WHERE `owner` = '".$_SESSION['username']."' AND `uniqueId` = '".strip_tags($_GET['share'])."';";
    //echo $query2;
    $result2 = mysqli_query($db, $query2);
    mysqli_free_result($result2);
    mysqli_close($db);
    gc_collect_cycles();
if($_GET['result']==0){}
    else{
     //header("Location:../index.php?t=".strip_tags($_GET['share']).'&m='.$shared);
    }

}
if (isset($_GET['makeDir'])){
    $uniueId = md5(uniqid());
    $now = time();
    $query3 = "INSERT INTO `folders`(`parent`, `childern`, `shared`, `owner`, `name`, `myDrive`, `uniqueId`) 
VALUES ('".$_SESSION['id']."', '', '0', '".$_SESSION['username']."','".clean($_GET['makeDir'])."', '0','".$uniueId."');";
    $result3 = mysqli_query($db, $query3);
    //mkdir(".././user-folders/".$uniueId);
    echo '<script>window.parent.location.reload()</script>';
    mysqli_free_result($result3);
    mysqli_close($db);
    gc_collect_cycles();
    if($_GET['result']==0){}
    else{
    header("Location:../index.php");
    }
}
if (isset($_GET['deleteDir'])){
    $query = "DELETE FROM `folders` WHERE `uniqueId` = '".$_GET['deleteDir']."';";
    $result = mysqli_query($db,$query);
    $query = "DELETE FROM `files` WHERE `parent` = '".$_GET['deleteDir']."';";
    $result = mysqli_query($db,$query);
    mysqli_free_result($result);
    mysqli_close($db);
    gc_collect_cycles();


}
if (isset($_GET['deleteAllD'])){
   $query = "SELECT `address` FROM `files` WHERE `owner` = '".$_SESSION['username']."'";
   $result = mysqli_query($db,$query);
   while ($row = mysqli_fetch_row($result)){
       foreach ($row as $row) {
       $query = "DELETE FROM `files` WHERE `address` = '" . $row . "'";
           $result = mysqli_query($db, $query);
           unlink("../user-files/" . $row);

       }
   }
    mysqli_free_result($result);
    gc_collect_cycles();

   $query = "SELECT `uniqueId` FROM `folders` WHERE `owner` = '".$_SESSION['username']."'";
   $result = mysqli_query($db,$query);
   while ($row = mysqli_fetch_row($result)) {
       foreach ($row as $row) {

               $query = "DELETE FROM `folders` WHERE `uniqueId` = '" . $row . "' AND MyDrive=0";
               $result = mysqli_query($db, $query);
               unlink("../user-folders/" . $row);
               gc_collect_cycles();
       }
   }
   header("Location:../index.php");
}
if(isset($_GET['delList'])) {
    $list = explode ("," , strip_tags($_GET['delList']));
    foreach($list as $list){
            $query1 = "DELETE FROM `files` WHERE owner='" . $_SESSION['username'] . "' AND uniqueId= '" . $list . "' LIMIT 1; ";
            $result1 = mysqli_query($db, $query1);
            $file = mysqli_fetch_assoc($result1);
            unlink(".././user-files/" . $a);
    }
    
    gc_collect_cycles();
    header("Location:".$_SERVER['HTTP_REFERER']);
}
if(isset($_GET['rename'])){
    $user = [strip_tags($_GET['name']), strip_tags($_GET['id']), $_SESSION['username']];
    //rename("/test/file1.txt","/home/docs/my_file.txt");
    
$now = time();//FROM_UNIXTIME($now)
    $query = "UPDATE `files` SET `name` = '$user[0]' WHERE `uniqueId` = '$user[1]' AND `owner` = '$user[2]';";
    mysqli_query($db, $query);
    header("Location:".$_SERVER['HTTP_REFERER']);
}
