<?php
$actual_link = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$errorHTML = '
<!DOCTYPE html>
<html lang=en>
  <meta charset=utf-8>
  <meta name=viewport content="initial-scale=1, minimum-scale=1, width=device-width">
  <title>Error 404 | Kabeer\'s Drive</title>
  <link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

  <style>
    *{margin:0;padding:0}html,code{font:15px/22px arial,sans-serif}html{background:#fff;color:#222;padding:15px}body{margin:7% auto 0;max-width:390px;min-height:180px;padding:30px 0 15px}* > body{background:url(https://www.google.com/images/errors/robot.png) 100% 5px no-repeat;padding-right:205px}p{margin:11px 0 22px;overflow:hidden}ins{color:#777;text-decoration:none}a img{border:0}@media screen and (max-width:772px){body{background:none;margin-top:0;max-width:none;padding-right:0}}@media only screen and (min-resolution:192dpi){}@media only screen and (-webkit-min-device-pixel-ratio:2){}
  </style>
  <a href="http://drive.hosted-kabeersnetwork.unaux.com">
  <div class="row"><div class="col-md-12"><img src="http://drive.hosted-kabeersnetwork.unaux.com/images/kslogo.png" style="width:5em; height:auto"></div><div class="col-md-12 mt-2"> <small style="font-size:17.5px;" class="text-muted display-4"> Kabeer\'s Drive</small></div><hr></div>
  </a>
  <p><b>404.</b> <ins>That’s an error.</ins>
  <p>The requested URL <code>'.$actual_link.'</code> was not found on this server.  <ins>That’s all we know.</ins>
';
echo $errorHTML;?>