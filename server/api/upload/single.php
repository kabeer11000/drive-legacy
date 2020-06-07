<?php
include '../../dbConnect.php';
session_start();

gc_enable();

function compressImage($source, $destination, $quality) {

  $info = getimagesize($source);

  if ($info['mime'] == 'image/jpeg') 
    $image = imagecreatefromjpeg($source);

  elseif ($info['mime'] == 'image/gif') 
    $image = imagecreatefromgif($source);

  elseif ($info['mime'] == 'image/png') 
    $image = imagecreatefrompng($source);

  imagejpeg($image, $destination, $quality);
  imagedestroy($image);
    gc_collect_cycles();
}


$total = count($_FILES['file']['name']);

// Loop through each file
for( $i=0 ; $i < $total ; $i++ ) {
$hash = md5(sha1(uniqid()));
$target_dir = "../../.././user-files/";
$uploadOk = 1;
$fileName = basename($_FILES["file"]["name"][$i]);
$id = $_SESSION['id'];
$username = $_SESSION['username'];
$uniqueId = md5(uniqId()."");
$finfo = finfo_open(FILEINFO_MIME_TYPE);
$mime = finfo_file($finfo, $_FILES['file']['tmp_name'][$i]);
$mimeType = $mime;
$address  = $hash.$uniqueId.$fileName;
$target_file = $target_dir .$hash.$uniqueId. basename($_FILES["file"]["name"][$i]);
$valid_ext = array('png','jpeg','jpg');
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

// Check if file already exists
if (file_exists($target_file)) {
    echo "Sorry, file already exists.";
    $uploadOk = 0;
}
// Check file size
if ($_FILES["file"]["size"][$i] > 99999999) {
    echo "Sorry, your file is too large.";
    $uploadOk = 0;
}

    gc_collect_cycles();
/*// Allow certain file formats
if($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg"
    && $imageFileType != "gif" ) {
    echo "Sorry, only JPG, JPEG, PNG & GIF files are allowed.";
    $uploadOk = 0;
}*/
// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {

        if (isset($_POST['full'])){

            if(in_array($file_extension,$valid_ext)){
                $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$fileName', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
                mysqli_query($db, $query);


                compressImage($_FILES['imagefile']['tmp_name'][$i],$location,1);
                echo '<script>window.top.location.href+="?upload=success"</script>';
                
    gc_collect_cycles();
            }
            else if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file)) {
                //echo "The file ". basename($_FILES["file"]["name"][$i]). " has been uploaded.";
                $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$fileName', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
                mysqli_query($db, $query);

    gc_collect_cycles();

                echo '<script>window.top.location.href+="?upload=success"</script>';
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }else{

            if(in_array($file_extension,$valid_ext)){
                $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$fileName', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
                mysqli_query($db, $query);


    gc_collect_cycles();
    
                compressImage($_FILES['imagefile']['tmp_name'][$i],$location,1);
                $response = "../../.././user-files/".$address;

                echo $response;
                
            }
            else if (move_uploaded_file($_FILES["file"]["tmp_name"][$i], $target_file)) {
                //echo "The file ". basename($_FILES["file"]["name"]). " has been uploaded.";
        $now = time();
        $query = "INSERT INTO `files` (name, parent, uniqueId, shared, mimeType, owner, address) 
  			  VALUES('$fileName', '$id', '$uniqueId', '0', '$mimeType', '$username', '$address')";
                mysqli_query($db, $query);

$size = filesize('../../.././user-files/'. $address);
echo '{
   "name":"'.$fileName.'",
   "id":"'.$uniqueId.'",
   "size":"'.$size.'",
   "path":"http://drive.hosted-kabeersnetwork.unaux.com/user-files/'.$address.'",
   "shared":"0",
   "mime":"'.$mimeType.'",
   "owner":"'.$username.'",
   "dateCreated":"'.$now.'",
   "dateModified":"'.$now.'"
}';
gc_collect_cycles();
        //echo '<script>window.top.location.href+="?upload=success"</script>';
        } else {
echo '{
   "upload":"failed"
}';
        }
        }



}

    mysqli_close($db);
}

?>

<? include("activeusers/active_users_record.php"); ?>