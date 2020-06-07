<?php
session_start();
include '../dbConnect.php';
if(!isset($_SESSION['username'])){
    //TODO handle redirect if user not logged in
    echo 'FUCK';
}
$notifId = '5e996300e70bb';
$query = "SELECT `title`, `description`, `uniqueToken` FROM `notifs` WHERE `owner` = '$notifId' AND `shown` = '0' ;";
$result = mysqli_query($db, $query);
$totalResults = 0;
$named_array = array();
while($row = mysqli_fetch_row($result)){
    $totalResults =$totalResults+1;
$title  = $row[0];
$desc = $row[1];
$token = $row[2];
echo $token;
    array_push($named_array, array("title" => "$title", "desc" => "$desc", "token" => "$token"));

    
}
//$named_array = array('results' => array(array("foo" => "bar", "desc" => "SSS"), array("foo" => "bar", "desc" => "SSS")));
$totalJson = '{"totalResults":"'.$totalResults.'", "results":'.json_encode($named_array).'}';
echo '</div></div>';
if(isset($_GET['seen'])&&isset($_GET['id'])){
    $token = strip_tags($_GET['id']);
    $query = "UPDATE `notifs` SET `shown` = '1' WHERE `owner` = '$notifId' AND `uniqueToken` = '$token';";
    $result = mysqli_query($db, $query);
    echo 'Done';
}
//WHERE `owner` = '$notifId' AND `shown` = '0'
?>
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
<link rel="stylesheet" href="https://hosted-kabeersnetwork.000webhostapp.com/Private/uploads/5ec291a5f10efmdb-bootstrap.css">
<script src="https://code.jquery.com/jquery-3.2.1.slim.min.js" integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<div></div>
<script>
console.log(<?php echo $totalJson; ?>);
let x  = <?php echo $totalJson; ?>;
console.log(x.totalResults);
for(var i = 0; i < x.length; i++){
    var porn = $('div').html();
    let title = x[i].title;
    let descc = x[i].desc;
    porn += title + '<br>' + descc + '<hr>';
}
$('div').html(porn);
</script>
