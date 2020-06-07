<?php
if(isset($_GET['url'])){
    echo '<pre>'.htmlspecialchars(file_get_contents(strip_tags('../.././user-files/'.$_GET['url']))).'</pre>';
}
?>
