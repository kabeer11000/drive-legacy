<?php
gc_collect_cycles();
function compress($source, $destination, $quality) {
gc_enable();
gc_collect_cycles();
    $info = getimagesize($source);
    
    if ($info['mime'] == 'image/jpeg') {
        $image = imagecreatefromjpeg($source);}

    elseif ($info['mime'] == 'image/gif') {
        $image = imagecreatefromgif($source);}

    elseif ($info['mime'] == 'image/png') {
        $image = imagecreatefrompng($source);}
        
    else{
        $image = $source;}
gc_collect_cycles();

header('Content-Type: image/jpeg');
gc_collect_cycles();

    imagejpeg(imagescale($image, 350, 200), NULL, $quality);
    imagedestroy($image);
// Set the content type header - in this case image/jpeg
if(isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
  if(strtotime($_SERVER['HTTP_IF_MODIFIED_SINCE']) < time() - 600) {
    header('HTTP/1.1 304 Not Modified');
    exit;
  }
}

}
$src=$_GET['url'];
gc_enable();
gc_collect_cycles();
compress($src, NULL, $_GET['quality']);
exit;