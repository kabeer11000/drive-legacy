<?php
$filename = $_GET['filename'];

header("Content-type: application/pdf");
header("Content-Length: ".filesize("user-files/".$filename));
ob_end_flush();
@readfile("user-files/".$filename);