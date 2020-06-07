<?php
session_start();
$url = 'https://ui-avatars.com/api/?name='.$_SESSION['username'];
$img = '.././user-AccountImages/'.$uniqueId.$url.'.png';
file_put_contents($img, file_get_contents($url));
