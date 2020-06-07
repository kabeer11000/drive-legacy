<?php
session_start();
include '../dbConnect.php';

if (isset($_GET['file'])){
    $query = "SELECT * FROM `files` WHERE owner = '".$_SESSION['username']."' AND uniqueId = '".strip_tags($_GET['file'])."' LIMIT 1 ;";
    if(mysqli_query($db, $query)) {
        $result = mysqli_query($db, $query);
        $file = mysqli_fetch_assoc($result);
        if ($file) {
            
            if ($file['mimeType'] === 'image/png' || $file['mimeType'] === 'image/jpg' || $file['mimeType'] === 'image/jpeg' || $file['mimeType'] === 'image/svg' || $file['mimeType'] === 'image/gif') {

                echo '<div class="modal fileModal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel style="overflow:hidden">' . $file['name'] . '</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><img src="server/viewers/imageViewer.php?id=' . $file['uniqueId'] . '" style=width:100%;height:auto></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
            }
            else if ($file['mimeType'] === 'video/ogg' || $file['mimeType'] === 'video/mp4' || $file['mimeType'] === 'video/m4a') {

                header("Location:uViewFile.php?id=" . $file['uniqueId']);
            }
            else if ($file['mimeType'] === 'text/css' || $file['mimeType'] === 'text/x-php' || $file['mimeType'] === 'text/html' || $file['mimeType'] === 'text/plain') {
                echo '<div class="modal fileModal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel style="overflow:hidden">' . $file['name'] . '</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><span class=bmd-form-group><textarea readonly id=textArea rows=10 style=border-radius:5px;width:100%;font-size:15px placeholder=" Nothing..." name=text value>' . htmlspecialchars(file_get_contents("../.././user-files/" . $file['address'] . "")) . '</textarea></span></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div>';
            }
            else if ($file['mimeType'] === 'application/pdf') {
                header("Location:uViewFile.php?id=" . $file['uniqueId']);
            }
            else {
                header("Location:index.php?msg=Cannot+Open+" . $file['name']);
            }

        }else{echo "No File With This Id Found";}
    }
}
gc_collect_cycles();
?>