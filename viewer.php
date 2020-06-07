<?php
include "server/dbConnect.php";include('config.php');
$actual_link = constant('SITE_URL')."/";

if(!isset($_GET['id'])&&!isset($_SESSION['username'])){header("Location:index.php");}
echo '<style>*{margin: 0;padding: 0;box-sizing: border-box;}<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag(\'js\', new Date());

  gtag(\'config\', \'UA-145795163-3\');
</script>
</style>';
$id  = $_GET['id'];
$query = "SELECT * FROM `files` WHERE shared='1' AND uniqueId= '$id' LIMIT 1;";
$result = mysqli_query($db, $query);
$file = mysqli_fetch_assoc($result);

if ($file) {
    // if user exists
    if ($file['shared'] === '1') {
        if ($file['mimeType'] === 'image/png' || $file['mimeType'] === 'image/jpg'|| $file['mimeType'] === 'image/jpeg'||$file['mimeType'] === 'image/gif') {
            echo '<img src="user-files/'.$file['address'].'"><hr>Name: '.$file['name'].'<br>Owner: '.$file['owner'].'<form method="get" action="http://mlkit.hosted-kabeersnetwork.unaux.com/Drive-image/ocr-image.php"><input type="text" name="image" value="'.$actual_link.'user-files/'.$file['address'].'" hidden><input type="submit" value="Extract Text" class="btn btn-primary"></form>';
        }
        if ($file['mimeType'] === 'text/css' || $file['mimeType'] === 'text/php'||$file['mimeType'] === 'text/html'||$file['mimeType'] === 'text/plain') {
            echo '<code>'.file_get_contents("user-files/".$file['address']."").'<code><hr>Name: '.$file['name'].'<br>Owner: '.$file['owner'].'';
        }
        if ($file['mimeType'] === 'application/pdf') {
            echo '<iframe style="width:100vw;height:100vh;" frameborder="0" src="wrapper.php?filename='.$file["address"].'"><hr>Name: '.$file['name'].'<br>Owner: '.$file['owner'].'';
        }
        if ($file['mimeType'] === 'video/mp4'||$file['mimeType'] === 'video/avi'||$file['mimeType'] === 'video/ogg'||$file['mimeType'] === 'video/mov') {
            echo '<html lang="en"><head><meta charset="UTF-8"> <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no"><link rel="apple-touch-icon" type="image/png" href="https://static.codepen.io/assets/favicon/apple-touch-icon-5ae1a0698dcc2402e9712f7d01ed509a57814f994c660df9f7a952f3060705ee.png"><meta name="apple-mobile-web-app-title" content="CodePen"><link rel="shortcut icon" type="image/x-icon" href="https://static.codepen.io/assets/favicon/favicon-aec34940fbc1a6e787974dcd360f2c6b63348d4b1f4e06c77743096d55480f33.ico"><link rel="mask-icon" type="" href="https://static.codepen.io/assets/favicon/logo-pin-8f3771b1072e3c38bd662872f6b673a722f4b3ca2421637d5596661b4e2132cc.svg" color="#111"><title>Kabeer\'s Network Drive</title><link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.6.2/css/font-awesome.min.css"><style>#button{font-size:45px;width:100px;height:100px;position:fixed;top:50%;left:50%;z-index:2;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%);background-color:rgba(0,0,0,0.95);border:0;border-radius:50%;outline:0;cursor:pointer;box-shadow:0 0 0 2px rgba(0,0,0,0.25);-webkit-transform:scale(1,1);-moz-transform:scale(1,1);-ms-transform:scale(1,1);-o-transform:scale(1,1);transform:scale(1,1);-webkit-transition:transform .5s ease;-moz-transition:transform .5s ease;-ms-transition:transform .5s ease;-o-transition:transform .5s ease;transition:transform .5s ease}#button:hover{-webkit-transform:scale(1.2,1.2);-moz-transform:scale(1.2,1.2);-ms-transform:scale(1.2,1.2);-o-transform:scale(1.2,1.2);transform:scale(1.2,1.2);-webkit-transition:transform .5s ease;-moz-transition:transform .5s ease;-ms-transition:transform .5s ease;-o-transition:transform .5s ease;transition:transform .5s ease}#button>i{color:grey;text-shadow:1px 1px rgba(255,255,255,0.2);position:relative;margin-top:4px;margin-left:6px;-webkit-transition:color .5s ease;-moz-transition:color .5s ease;-ms-transition:color .5s ease;-o-transition:color .5s ease;transition:color .5s ease}#button:hover>i{color:white;-webkit-transition:color .5s ease;-moz-transition:color .5s ease;-ms-transition:color .5s ease;-o-transition:color .5s ease;transition:color .5s ease}#lightbox{position:fixed;top:0;bottom:0;left:0;right:0;z-index:1;display:none;background-color:rgba(0,0,0,0.95)}#video-wrapper{position:absolute;top:50%;left:50%;z-index:2;-webkit-transform:translate(-50%,-50%);-moz-transform:translate(-50%,-50%);-ms-transform:translate(-50%,-50%);-o-transform:translate(-50%,-50%);transform:translate(-50%,-50%);box-shadow:0 0 5px 1px rgba(0,0,0,0.1)}#close-btn{color:grey;font-size:25px;position:fixed;top:3%;right:3%;z-index:2;-webkit-transform:scale(1,1);-moz-transform:scale(1,1);-ms-transform:scale(1,1);-o-transform:scale(1,1);transform:scale(1,1);-webkit-transition:transform .5s ease,color .5s ease;-moz-transition:transform .5s ease,color .5s ease;-ms-transition:transform .5s ease,color .5s ease;-o-transition:transform .5s ease,color .5s ease;transition:transform .5s ease,color .5s ease}#close-btn:hover{color:white;cursor:pointer;-webkit-transform:scale(1.2,1.2);-moz-transform:scale(1.2,1.2);-ms-transform:scale(1.2,1.2);-o-transform:scale(1.2,1.2);transform:scale(1.2,1.2);-webkit-transition:transform .5s ease,color .5s ease;-moz-transition:transform .5s ease,color .5s ease;-ms-transition:transform .5s ease,color .5s ease;-o-transition:transform .5s ease,color .5s ease;transition:transform .5s ease,color .5s ease}</style><script>window.console=window.console||function(t){};</script><script>if(document.location.search.match(/type=embed/gi)){window.parent.postMessage("resize","*");}</script></head><body translate="no"><button id="button" style="display:none"><i class="fa fa-play" aria-hidden="true"></i></button><div id="lightbox" style="display:block"><i id="close-btn" class="fa fa-times" onclick="window.history.go(-1)"></i><div id="video-wrapper"><iframe id="video" style="width:90vw;height:85vh" src="server/viewers/imageViewer.php?id='.$file["uniqueId"].'" frameborder="0" allowfullscreen=""></iframe></div></div><script src="https://static.codepen.io/assets/common/stopExecutionOnTimeout-157cd5b220a5c80d4ff8e0e70ac069bffd87a61252088146915e8726e5d9f147.js"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/2.2.4/jquery.min.js"></script><script id="rendered-js">$(document).ready(function(){});</script><hr>Name: '.$file['name'].'<br>Owner: '.$file['owner'].'</body></html>';
        }
    }
    else{
        echo 'File Not Shared';
    }

}else{
    $actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
    $errorHTML = '
<!DOCTYPE html>
<html lang=en>
  <meta charset=utf-8>
  <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
  <title>Error 404 | '.constant('APP_NAME').'</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
  <style>
    *{margin:0;padding:0}html,code{font:15px/22px arial,sans-serif}html{background:#fff;color:#222;padding:15px}body{margin:7% auto 0;max-width:390px;min-height:180px;padding:30px 0 15px}* > body{background:url(https://www.google.com/images/errors/robot.png) 100% 5px no-repeat;padding-right:205px}p{margin:11px 0 22px;overflow:hidden}ins{color:#777;text-decoration:none}a img{border:0}@media screen and (max-width:772px){body{background:none;margin-top:0;max-width:none;padding-right:0}}@media only screen and (min-resolution:192dpi){}@media only screen and (-webkit-min-device-pixel-ratio:2){}
  </style>
  <a href="#">
  <div class="row"><div class="col-md-12"><img src="images/kslogo.png" style="width:5em; height:auto"></div><div class="col-md-12 mt-2"> <small style="font-size:17.5px;" class="text-muted display-4"> Kabeer\'s Drive</small></div><hr></div>
  </a>
  <p><b>404.</b> <ins>That’s an error.</ins>
  <p>The requested URL <code>'.$actual_link.'</code> was not found on this server.  <ins>That’s all we know.</ins>
';
    echo $errorHTML;
}