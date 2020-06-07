<?php
include '../dbConnect.php';
session_start();

if (isset($_GET['logout'])){
    session_destroy();
    unset($_SESSION['id']);
    unset($_SESSION['username']);
    unset($_SESSION['image']);
}
if (isset($_GET['host'])){$host = $_GET['host'];}
if (!isset($_SESSION['username'])&&!isset($_SESSION['id'])&&!isset($_SESSION['picture'])){header("Location:login.php");}
if (isset($_GET['t'])){
    if($_GET['m'] == 0){$THEME = "danger"; $MESSAGE = "<strong>UnShared </strong> Link Sharing is Turned Off for this file.";}else{$MESSAGE = "<strong>Shared </strong> This File Has been Shared! Anyone with this link can view it.";$THEME = "success";}
    echo '<div class="alert alert-'.$THEME.' alert-dismissible fade show" role="alert">'.$MESSAGE.'<br><code>https://domain.com/viewer.php?id='.$_GET['t'].' - UnAvailabale</code><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><script>function f(){$(".alert").slideUp();var myNewURL = "";
window.history.pushState("", "", "?" + myNewURL );}window.setTimeout(f, 3000);</script>';
}
if (isset($_GET['msg'])){
    $message = strip_tags(urldecode($_GET['msg']));
    $message = '  <div class="message mdc-card__actions mdc-card__actions--full-bleed w-100 text-center">
  <a class="mdc-button mdc-card__action mdc-card__action--button" href="#">
    <div class="mdc-button__ripple"></div>
    <span class="mdc-button__label">'.$message.'</span>
    <i class="material-icons mdc-button__icon" aria-hidden="true">priority_high</i>
  </a>
</div><script>function f(){$(".message").slideUp();var myNewURL = "";
window.history.pushState("", "", "?" + myNewURL );}window.setTimeout(f, 3000);</script>';
}else{$message='';}
if (isset($_GET['file'])){
    $query = "SELECT * FROM `files` WHERE owner = '".$_SESSION['username']."' AND uniqueId = '".strip_tags($_GET['file'])."' LIMIT 1 ;";
    if(mysqli_query($db, $query)) {
        $result = mysqli_query($db, $query);
        $file = mysqli_fetch_assoc($result);
        if ($file) {
            // if user exists
            if ($file['mimeType'] === 'image/png' || $file['mimeType'] === 'image/jpg' || $file['mimeType'] === 'image/jpeg' || $file['mimeType'] === 'image/svg' || $file['mimeType'] === 'image/gif') {

                echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class=modal-title id=exampleModalLabel>' . $file['name'] . '</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><img src="server/viewers/imageViewer.php?id=' . $file['uniqueId'] . '" style=width:100%;height:auto></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
            }
            else if ($file['mimeType'] === 'video/ogg' || $file['mimeType'] === 'video/mp4' || $file['mimeType'] === 'video/m4a') {

                header("Location:uViewFile.php?id=" . $file['uniqueId']);
            }
            else if ($file['mimeType'] === 'text/css' || $file['mimeType'] === 'text/x-php' || $file['mimeType'] === 'text/html' || $file['mimeType'] === 'text/plain') {
                echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class=modal-title id=exampleModalLabel>' . $file['name'] . '</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><span class=bmd-form-group><textarea readonly id=textArea rows=10 style=border-radius:5px;width:100%;font-size:15px placeholder=" Nothing..." name=text value>' . file_get_contents("user-files/" . $file['address'] . "") . '</textarea></span></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div>';
            }
            else if ($file['mimeType'] === 'application/pdf') {
                header("Location:uViewFile.php?id=" . $file['uniqueId']);
            }

        }else{header("Location:index.php?msg=".urlencode("No File With This Id Found"));}
    }
}

echo '
<style>*{margin:0;padding:0;box-sizing:border-box}body{margin:0;padding:0;box-sizing:border-box}</style>
<div id="preloader" class="px-0 mx-0" style="position: fixed;display:block;z-index: 200002; width: 100%;height: 100%;margin-top:0!important;padding-top:0!important;background-image: linear-gradient(#F6F6F6,#F6F6F6);background-repeat: no-repeat;background-size: cover;" class="container-fluid text-center">

<div role="progressbar" style="z-index:999999" class="progress-bar mdc-linear-progress mdc-linear-progress--indeterminate"><div class="mdc-linear-progress__buffering-dots"></div><div class="mdc-linear-progress__buffer"></div><div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar"><span class="mdc-linear-progress__bar-inner"></span></div><div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar"><span class="mdc-linear-progress__bar-inner"></span></div></div>
</div>
  <script>
  
function preload_remover()
{
        $("#preloader").hide();
         
}
</script>
<style>main{z-index: 1}</style> <div class="modal fade" id="MakeFolderModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true"><div class="modal-dialog modal-dialog-centered" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="exampleModalLongTitle">Make New Folder</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body"><div class="form-inline ml-auto" style="margin-top:0"><div class="md-form my-0"><form action="server/files-server.php" method="get" target="MakeFolderIframe"><input id="newFolder" style="font-size:15px;opacity:70%;width:100%" name="makeDir" class="form-control" type="text" placeholder="Enter Folder Name" aria-label="Search"></div></div></div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button><button id="newFolderBtn" type="submit" data-toggle="tooltip" data-placement="bottom" title="Make New Folder" style="font-size:15px;opacity:70%" class="btn btn-outline-white btn-md my-0 ml-sm-2">Create</button></form></div></div></div></div><div class="bmd-layout-canvas fixed-top"><div class="bmd-layout-container fixed-top bmd-drawer-f-l bmd-drawer-overlay"><header class="bmd-layout-header"><div id="navbar-search-flood" class="main_search_nav_wrapper navbar-search-flood navbar navbar-light bg-faded" style="background-color:#D6D7D9;box-shadow:none"><a data-toggle="drawer" data-target="#dw-p1" aria-expanded="false"><i class="material-icons" aria-hidden="true">menu</i></a><ul class="nav navbar-nav mr-auto ml-2 text-left"><li data-toggle="drawer" data-target="#dw-p1" aria-expanded="false" class="navbar-brand text-dark" style="color:#212529">My Drive</li></ul><button class="mdc-icon-button material-icons mdc-top-app-bar__action-item--unbounded" onclick="window.location.reload()" aria-label="Download">refresh</button><button class="mdc-icon-button text-dark search_icon_button material-icons mdc-top-app-bar__action-item--unbounded" aria-label="Download">search</button></div></header><div id="dw-p1" class="bmd-layout-drawer bg-faded" aria-expanded="false" aria-hidden="true"><header style="background-color:#E6E6E6;text-overflow:ellipsis;overflow:hidden"><a class="navbar-brand"><img src="user-AccountImages/'.$_SESSION["image"].'" style="border-radius:30px; margin-top:-3px;margin-right:.25em;width:1.5em;height:auto;opacity:90%">'.$_SESSION['username'].'</a></header><ul class="mdc-list list-group"><a class="list-group-item" href="index.php"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">home</i>Home</a><a class="list-group-item" href="upload.php"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">backup</i>Upload</a><a class="list-group-item" href="editor.php"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">code</i>Text Editor</a><a class="list-group-item" href="download.php"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">get_app</i>Download URL</a><hr><a class="list-group-item text-primary" data-toggle="modal" data-target="#MakeFolderModal"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">create_new_folder</i>New Folder</a><hr><a class="list-group-item" href="settings.php"><i class="material-icons mdc-list-item__graphic" aria-hidden="true">settings</i>Settings</a><div class="a list-group-item fixed-bottom TotalFilesCount"></div></ul></div>';
echo '<iframe name="MakeFolderIframe" class="d-none"></iframe>';
echo '<style>*{margin:0;padding:0;box-sizing:border-box}</style><link rel=stylesheet href=../.././css/bootstrap_matrial_design.css><link href=https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css rel=stylesheet><script src=https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.js></script><script src=../.././js/jquery.min.js></script> <script src=https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js integrity=sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U crossorigin=anonymous></script><script src=https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js integrity=sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9 crossorigin=anonymous></script><main class="bmd-layout-content"> <div class=container  style=margin-top:1em><div class=row>';
if(!isset($_SESSION['username']) && !isset($_SESSION['id'])){
    header("Location:login.php");
}
echo $message;
$query = "SELECT `name`, `uniqueId` FROM `folders` WHERE owner = '".$_SESSION['username']."' AND parent = '".$_SESSION['id']."' AND myDrive=0;";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
if ($user) {
    echo '<div class="col-md-12"><span class="demo-card__title mdc-typography mdc-typography--headline6">Folders</span><hr style="border-color: transparent"></div>';
    $result = mysqli_query($db, $query);
    while($row = mysqli_fetch_row($result)){

            echo '

<div class="col-md-6">

<div class=" px-2 py-2 mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black"><a href="folder.php?id='.$row[1].'"><i class="material-icons mdc-list-item__graphic mr-2">folder</i>'.$row[0].' </h2>
    </div>
  </div>
</div>

</div>';
        }



}
$query1 = "SELECT `name`,`uniqueId`, `address`,`shared`,`mimeType` FROM `files` WHERE owner ='".$_SESSION['username']."' AND parent='".$_SESSION['id']."';";
    //DELETE FROM `files` WHERE shared = '0';
    $result1 = mysqli_query($db, $query1);
echo '<div class="col-md-12"><span class="demo-card__title mdc-typography mdc-typography--headline6">Files</span><hr style="border-color: transparent"></div>';

  if ($result1){
      while($row = mysqli_fetch_row($result1)){

        if($row['3'] == '1'){$shareBox="checked";$shareIcon='<!--<i class="material-icons">folder_shared</i>-->';}else{$shareBox="";$shareIcon='';}
           echo '<div class="col-md-6">

<div class=" px-3 py-2 mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 1em;height:7em;">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <button onclick=return1("'.$row[1].'","'.$host.'")><h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></button>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="../../uViewFile.php?id='.$row[1].'"><span class="mdc-button__ripple"></span> View</a>
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="../files-server.php?del=1&id='.$row[1].'">  <span class="mdc-button__ripple"></span> Delete</a>
       <div class="float-right px-0 mx-0">
             <div class="dropdown">
  <button class="btn w-1  px-0 mx-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <i class="material-icons">more_vert</i>  
  <div class="ripple-container"></div></button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  <form action="../files-server.php" target="shareIframe" method="get" class="px-2 share_form'.$row[1].'">
  <input type="text" hidden name="share" value="'.$row[1].'">
   
   <div class="radio">
    <label>
      <input type="checkbox" class="share_switch'.$row[1].'"  name="ShareN"  value="'.$row[3].'" '.$shareBox.'> Link Sharing
    </label>
  </div> 
    <script>$(document).ready(function(){$(".share_switch'.$row[1].'").change(function(){$(".share_form'.$row[1].'").submit()});});</script>
</form>    
    </div>
        </div>
        </div>
    </div>
  </div>
</div>
</div>';
    }

  }

?>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, "><link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<style>a{text-decoration: none!important;}.show{border-radius:5px;box-shadow:none;border:1px #E6E6E6 solid}</style>
<script> $(document).ready(function () {
        $('#exampleModal').modal("show");
        /*            if($("#textArea").length){
                        alert("The element you're testing is present.");
                    }*/
        $("#exampleModal").on('hidden.bs.modal', function(){
            //alert("FUCK");
            window.history.back();

        });
        preload_remover();
        function return1(id,host) {

        }
    })</script>
<iframe name="shareIframe" style="display: none"></iframe>