<?php
session_start();
if(!isset($_SESSION['username'])){header('Location:../../login.php');}
if(isset($_GET['d'])){
$d = strip_tags($_GET['d']);
echo '
<html>
<head>
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">
</head>
<body>
<div class="container-fluid bg-transparent">
<div class="row text-center d-flex justify-content-center align-items-center bg-transparent">
<div class="col-9 bg-dark px-4 py-4 rounded border-muted" style="margin-top:10rem;width:100%;">
<div class="text-light h4">No Preview Available<br><br><a href=".././downloaders/download-file.php?id='.$d.'" class="btn btn-primary btn-raised">Download</a></div>
</div></div></div>
<style>body{background-color:rgba(52, 52, 52, 1)}.row{background-color:rgba(37, 37, 38, 0.001)}col-10{background-color:rgba(37, 37, 38, 0)}</style>
</body>
</html>';    
}
?>
