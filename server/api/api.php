<?php

if(isset($_GET['username'])&&isset($_GET['password'])){
    $_POST['login_user'] = '';
    $_POST['username'] = strip_tags($_GET['username']);
    $_POST['password'] = md5(strip_tags($_GET['password']));
        
}
include '../login-signup-server.php';