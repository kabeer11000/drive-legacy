<?php
session_start();
include 'config.php';
if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['id']);
    header("location: login.php");
}

if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}

echo '
<nav style="z-index: 3" class="navbar fixed-top navbar-expand-lg navbar-light bg-light">
  <a class="navbar-brand" href="#">Welcome <span class="text-muted">'.$_SESSION['username'].'</span></a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto"><!--
      <li class="nav-item active">
        <a class="nav-link" href="?deleteAll=true">Delete all</a>
      </li>-->
      <li class="nav-item">
      <a class="nav-link" href="index.php"><img src="./images/back_icon.png" style="width: 1.5em;height: auto;background-color: #e9ecef;border-radius: 40px"></a>
    
      </li>
      <li class="nav-item">
       <a class="nav-link" href="index.php">Home</a>
   
      </li>
      
      <li class="nav-item">
    <a class="nav-link" href="upload.php">Upload</a>
      </li>
      
      <li class="nav-item">
    <a class="nav-link" href="text-editor.php">Text Editor</a>
      </li>
      
    </ul>
    <ul class="navbar-nav ml-auto">
    
      <li class="nav-item">
     <a class="nav-link" href="?logout=true">Log Out</a>
      </li>
    </ul>
  </div>
</nav>';
?>
<html>

<meta charset="utf-8">
<title><?php constant('APP_NAME')?></title>
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link rel="shortcut icon" type="image/png" href="favicon.png"/>
<link rel="shortcut icon" type="image/png" href="ic_launcher.png"/>
<link rel="stylesheet" type="text/css" href="css/bootstrap_matrial_design.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/propper.js"></script>
<script type="text/javascript" src="js/bootstrap_matrial_design.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145795163-3');
</script>

<div class="container mt-5 pt-5"></div>
<div class="container mt-5">
    <div class="row">
        <div class="col-md-12">
            <div class="text-muted display-4" style="font-size:20px">Enter Url of a file or website to download it remotely</div>
            <hr>
            <form method="get" action="server/downloaders/download-url.php">
                <div class="input-group mb-3 mt-5">
                    <input type="text" name="url" class="form-control" placeholder="Enter Url of any file or website..." aria-label="Recipient's username" aria-describedby="basic-addon2">
                    <div class="input-group-append">
                        <button class="btn btn-secondary" type="submit">Download</button>
                    </div>
                </div>
            </form>

        </div>
    </div>
</div>
</html>