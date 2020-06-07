<?php
include 'dbConnect.php';
include '../config.php';
session_start();
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: ../login.php');
}
// =========== https://github.com/ttodua/useful-php-scripts ==========
//                                 USAGE:
//     new GoodZipArchive('path/to/input/folder',    'path/to/output_zip_file.zip') ;
// ======================================================================


class GoodZipArchive extends ZipArchive
{
    //@author Nicolas Heimann
    public function __construct($a=false, $b=false) { $this->create_func($a, $b);  }

    public function create_func($input_folder=false, $output_zip_file=false)
    {
        if($input_folder !== false && $output_zip_file !== false)
        {
            $res = $this->open($output_zip_file, ZipArchive::CREATE);
            if($res === TRUE) 	{ $this->addDir($input_folder, basename($input_folder)); $this->close(); }
            else  				{ echo 'Could not create a zip archive. Contact Admin.'; }
        }
    }

    // Add a Dir with Files and Subdirs to the archive
    public function addDir($location, $name) {
        $this->addEmptyDir($name);
        $this->addDirDo($location, $name);
    }

    // Add Files & Dirs to archive
    private function addDirDo($location, $name) {
        $name .= '/';         $location .= '/';
        // Read all Files in Dir
        $dir = opendir ($location);
        while ($file = readdir($dir))    {
            if ($file == '.' || $file == '..') continue;
            // Rekursiv, If dir: GoodZipArchive::addDir(), else ::File();
            $do = (filetype( $location . $file) == 'dir') ? 'addDir' : 'addFile';
            $this->$do($location . $file, $name . $file);
        }
    }
}
if(!isset($_GET['dirName'])){
    header("Location:".constant('APP_NAME'));
}
$zip  = new ZipArchive();
$zip_name = time().'.zip';
if ($zip ->open(ZipArchive::CREATE)!== true){
    echo 'Error Open Zip Module';
}
$query  = "SELECT `address` FROM `files` WHERE `parent` = '".$_GET['dirName']."'";
$result = mysqli_query($db,$query);
while($row = mysqli_fetch_row($result)) {
$zip -> addFile(".././user-files/".$row);
}
$zip ->close();
if (file_exists(".././user-files/".$zip_name)){
    $filename = ".././user-files/".$zip_name;
    header("Content-type:application/zip");
    header("Content-Disposition: attachment; filename=".$filename);
    readfile($filename);
    unlink($filename);
}

$data = $_GET['dirName'];
$dirName = substr($data, strpos($data, "/") + 1);

new GoodZipArchive($_GET['dirName'],'userDirDownload/'.$_SESSION['username'].'-'.$dirName.'.zip');
$url = 'downloaders/userDirDownload/'.$_SESSION['username'].'-'.$dirName.'.zip';
$file = 'userDirDownload/'.$_SESSION['username'].'-'.$dirName.'.zip';
header('Content-Type: application/zip');
header("Content-Disposition: attachment; filename='".$url."'");
header('Content-Length: ' . filesize($url));
header("Location: ".$url);
register_shutdown_function('unlink', $file);

?>