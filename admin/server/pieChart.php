<?php
include '../.././server/dbConnect.php';
function random_color_part() {return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);}
function random_color_insert() {return random_color_part() . random_color_part() . random_color_part();}
function random_color($count){$colors = [];for ($i=0;$i<$count;$i++){$colors.push(random_color_insert());}return $colors;}


//PDFs
function PDFs($db){
    $query = "SELECT * FROM `files` WHERE `mimeType` = 'application/pdf';";
    $pdfs = count(mysqli_fetch_all(mysqli_query($db, $query)));
    return $pdfs;
}
//Photos
function Photos($db){
    $query = "SELECT * FROM `files` WHERE `mimeType` IN ('image/png', 'image/svg', 'image/jpg', 'image/jpeg', 'image/pjpeg');";
    $photos = count(mysqli_fetch_all(mysqli_query($db, $query)));
    return $photos;
}
//Videos
function Videos($db){
    $query = "SELECT * FROM `files` WHERE `mimeType` IN ('video/avi', 'video/mpeg', 'video/mov', 'video/webm', 'video/m4a', 'video/mp4');";
    $videos = count(mysqli_fetch_all(mysqli_query($db, $query)));
    return $videos;
}
//Others
function Others($db){
    $query = "SELECT * FROM `files` WHERE `mimeType` NOT IN ('video/avi', 'video/mpeg', 'video/mov', 'video/webm', 'video/m4a', 'video/mp4', 'image/png', 'image/svg', 'image/jpg', 'image/jpeg', 'image/pjpeg', 'application/pdf');";
    $others = count(mysqli_fetch_all(mysqli_query($db, $query)));
    return $others;
}
$pdfs = PDFs($db);
$videos = Videos($db);
$photos = Photos($db);
$others = Others($db);
?>