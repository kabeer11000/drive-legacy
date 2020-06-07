<?php

include ".././server/dbConnect.php";

if (isset($_GET['msg'])){
    $message = strip_tags(urldecode($_GET['msg']));
    $message = '  <div class="message mt-5 mdc-card__actions mdc-card__actions--full-bleed w-100 text-center">
  <a class="mdc-button mdc-card__action mdc-card__action--button" href="#">
    <div class="mdc-button__ripple"></div>
    <span class="mdc-button__label">'.$message.'</span>
    <i class="material-icons mdc-button__icon" aria-hidden="true">priority_high</i>
  </a>
</div><script>function f(){$(".message").slideUp();var myNewURL = "id='.$_GET['id'].'";
window.history.pushState("", "", "?" + myNewURL );}window.setTimeout(f, 3000);</script>';
}else{$message='';}

if (!isset($_GET['id'])){
    header("Location:.././index.php?msg=Error");
}else{

$user_check_query = "SELECT * FROM `folders` WHERE uniqueId='".$_GET['id']."' AND shared = '1' LIMIT 1";
$result = mysqli_query($db, $user_check_query);
$user = mysqli_fetch_assoc($result);

if ($user) { // if user exists
    if ($user['uniqueId'] != $_GET['id']) {
        header("Location:.././index.php?msg=Error");
    }
}else{    header("Location:.././index.php?msg=Folder+Not+Found");}
    $FolderId = $_GET['id'];
}

echo '

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, ">
<title>'.$user['name'].' - Kabeer\'s Drive</title>
<meta property="og:image" content="https://img.techpowerup.org/200523/kslogo.jpg" />
<meta property="og:type" content="Web App" />
<meta property="og:title" content="'.$user['name'].' - Kabeer\'s Drive" />
<meta property="og:description" content="Open '.$user['name'].' in Kabeers Drive" />
<link rel=stylesheet href=.././css/bootstrap_matrial_design.css>
<link rel="stylesheet" href=".././css/materialDesign.css">

<script src=".././js/jquery.min.js"></script>
<!-- Lightbox-->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.css" />
<script src="https://cdn.jsdelivr.net/gh/fancyapps/fancybox@3.5.7/dist/jquery.fancybox.min.js"></script>
<!-- Lightbox-->
<script src=.././js/propper.js></script>
<script src=.././js/bootstrap_matrial_design.js></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<script>$(document).ready(function() { $("body").bootstrapMaterialDesign(); });</script>
<style>

main::-webkit-scrollbar {
  width: 0.5em;
  border-radius:20px
}
 
main::-webkit-scrollbar-track {
  //box-shadow: inset 0 0 6px rgba(0, 0, 0, 0.3);
  background-color:#EEE
}
 
main::-webkit-scrollbar-thumb {
  background-color: darkgrey;
  outline: 1px solid slategrey;
}
* {
  -webkit-touch-callout: none; /* iOS Safari */
    -webkit-user-select: none; /* Safari */
     -khtml-user-select: none; /* Konqueror HTML */
       -moz-user-select: none; /* Old versions of Firefox */
        -ms-user-select: none; /* Internet Explorer/Edge */
            user-select: none; /* Non-prefixed version, currently
                                  supported by Chrome, Edge, Opera and Firefox */
}
</style>
';
/*if (isset($_GET['file']) && isset($_GET['id'])){
    $query = "SELECT * FROM `files` WHERE uniqueId = '".$_GET['file']."' LIMIT 1 ;";
    $result = mysqli_query($db, $query);
    $file = mysqli_fetch_assoc($result);
    if ($file) {
        // if user exists
        if ($file['mimeType'] === 'image/png' || $file['mimeType'] === 'image/jpg'|| $file['mimeType'] === 'image/jpeg'|| $file['mimeType'] === 'image/svg'||$file['mimeType'] === 'image/gif') {

            echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel>'.$file['name'].'</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><img src=".././user-files/'.$file['address'].'" style=width:100%;height:auto></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
        }
        else if ($file['mimeType'] === 'video/ogg' || $file['mimeType'] === 'video/mp4'|| $file['mimeType'] === 'video/m4a') {

            echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel>'.$file['name'].'</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><iframe frameborder="0" src=".././user-files/'.$file['address'].'" style=width:100%;height:70vh></iframe></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
        }
        else if ($file['mimeType'] === 'text/css' || $file['mimeType'] === 'text/x-php'||$file['mimeType'] === 'text/html'||$file['mimeType'] === 'text/plain') {
            echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel>'.$file['name'].'</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><span class=bmd-form-group><textarea readonly id=textArea rows=10 style=border-radius:5px;width:100%;font-size:15px placeholder=" Nothing..." name=text value>'.file_get_contents(".././user-files/".$file['address']."").'</textarea></span></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div>';
        }
        else if ($file['mimeType'] === 'application/pdf') {
            echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel>'.$file['name'].'</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><iframe frameborder="0" src=".././user-files/'.$file['address'].'" style=width:100%;height:70vh></iframe></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
        }
        else {
            echo '<div class="modal fade" id=exampleModal tabindex=-1 role=dialog aria-labelledby=exampleModalLabel aria-hidden=true><div class=modal-dialog role=document><div class=modal-content><div class=modal-header><h5 class="modal-title text-truncate" id=exampleModalLabel>'.$file['name'].'</h5><button type=button class=close data-dismiss=modal aria-label=Close><span aria-hidden=true>&times;</span></button></div><div class=modal-body><iframe frameborder="0" src=".././user-files/'.$file['address'].'" style=width:100%;height:70vh></iframe></div><div class=modal-footer><button type=button class="btn btn-secondary" data-dismiss=modal>Close</button></div></div></div></div></div>';
        }

    }else{header("Location:folder.php?id=".$_GET['id']."&msg=File+Not+Found");}
}
*/
echo '
<style>
    main {
        z-index: 1
    }
    @media(min-width:340px){
      //  #dw-p1{width:83vw;}
    }
</style>
<div class="bmd-layout-canvas fixed-top">
    <div class="bmd-layout-container fixed-top bmd-drawer-f-l bmd-drawer-overlay">
        <header class="bmd-layout-header">
            <div id="navbar-search-flood" class="main_search_nav_wrapper navbar-search-flood navbar navbar-light bg-faded" style="background-color:#D6D7D9;box-shadow:none"><a data-toggle="drawer" data-target="#dw-p1" aria-expanded="false"><i class="material-icons" aria-hidden="true">menu</i></a>
                <ul class="nav navbar-nav mr-auto ml-2 text-left">
                    <li data-toggle="drawer" data-target="#dw-p1" aria-expanded="false" class="navbar-brand text-dark" style="color:#212529">'.$user['name'].'</li>
                </ul>
                <button class="mdc-icon-button material-icons mdc-top-app-bar__action-item--unbounded" onclick="window.location.reload()" aria-label="Download">refresh</button>
            </div>
        </header>
        <div id="dw-p1" class="bmd-layout-drawer bg-faded" aria-expanded="false" aria-hidden="true">
            <header style="background-color:#E6E6E6;text-overflow:ellipsis;overflow:hidden">
                <a class="navbar-brand small"><a class="navbar-brand small"><img src=".././images/kslogo.png" style="width:2rem;height:auto"><br><small class="text-muted mt-2 pt-2">Sign in <br>to access all your<br>files on <b>Kabeers Drive</b>.</small></a></a>
            </header>
            <ul class="mdc-list list-group">
            <a class="list-group-item" href="mailto:kabeer11000@gmail.com&subject=Define Your Problem">Help</a>
            <a class="list-group-item" href="mailto:kabeer11000@gmail.com">Send Feedback</a>
            <a class="list-group-item" href="http://static-kabeersnetwork.000webhostapp.com/terms/drive/">Privacy Policy</a>
            <a class="list-group-item" href="../login.php">Login</a>
            <a class="list-group-item btn btn-primary btn-raised w-5" href="../register.php">Sign up</a>
            <div class="a list-group-item TotalFilesCount"></div>
            </ul>
        </div>';
echo '<iframe name="MakeFolderIframe" class="d-none"></iframe>';
echo '<style>*{margin:0;padding:0;box-sizing:border-box}</style> <main class="bmd-layout-content"> <div class=container  style=margin-top:1em><div class="row mainContainer">'.$message.'';

$count = 0;
$random_number_array = range(0, 20);
shuffle($random_number_array );
$random_number_array = array_slice($random_number_array ,0,10);
$adsRandom = $random_number_array;

$query = "SELECT `name`, `uniqueId` FROM `folders` WHERE parent = '".$_GET['id']."' AND shared = '1' AND myDrive=0; ";
$result = mysqli_query($db, $query);
$user = mysqli_fetch_assoc($result);
if ($user) {
    echo '<div class="col-md-12 foldertext"><span class="demo-card__title mdc-typography mdc-typography--headline6">Folders</span><hr style="border-color: transparent"></div>';
   $result = mysqli_query($db, $query);
    while ($row = mysqli_fetch_row($result)) {

        echo '

<div class="col-md-6 col-xl-4 col-xs-12 col-sm-6 folder">
<div class=" px-1  mdc-card mdc-card--outlined demo-card mt-1 mb-2" style="width: 100%;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <a href="' . $row[1] . '"><h2 class="demo-card__title mdc-typography mdc-typography--headline6  text-truncate" style="color: black"><i class="material-icons mdc-list-item__graphic mr-2">folder</i>' . $row[0] . ' </h2></a>
    </div>
  </div>
</div>
</div>';

        }


}

       $query1 = "SELECT `name`,`uniqueId`, `address`,`shared`, `mimeType` FROM `files` WHERE parent='" . $FolderId . "' ;";
        $result1 = mysqli_query($db, $query1);

        if ($result1) {
            echo '<div class="col-md-12 filetext" style="margin-bottom:-3em"><span class="demo-card__title mdc-typography mdc-typography--headline6 filestext">Files</span><hr style="border-color: transparent"></div>';

            while ($row = mysqli_fetch_row($result1)) {
                if ($row[3] == '1') {
                    $sharebox = 'checked';
                    $shareIcon = '';
                } else {
                    $sharebox = null;
                    $shareIcon = '';
                }
                $file = $row;
                $file['mimeType'] = $row[4];
        
        if (in_array($row[4],array('image/png', 'image/jpg', 'image/jpeg', 'image/gif'))) {
            echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" href=".././user-files/'.$row[2].'"  data-caption="'.$row[0].'" style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"> <div class="mdc-card__media mb-1  demo-card__media d-flex align-items-center justify-content-center"> <img  onerror=this.src=".././user-files/'.$row[2].'" src="http://drive.hosted-kabeersnetwork.unaux.com/server/thumbnail/?quality=10&url=http://drive.hosted-kabeersnetwork.unaux.com/user-files/'.$row[2].'"  style=" object-fit: fill;width:auto;height:10rem;margin-top:0"></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a> <a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a> </div> </div></div></div>';
        }
        else if (in_array($row[4], array('video/ogg', 'video/mp4', 'video/m4a', 'video/3gpp', 'video/quicktime', 'video/x-msvideo', 'video/x-ms-wmv'))) {
            echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" data-type="video" data-small-btn="true" href=".././user-files/'.$row[2].'"  data-caption="'.$row[0].'" style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"> <div class="mdc-card__media mb-1  demo-card__media d-flex align-items-center justify-content-center" style="height:10rem"> <div class="embed-responsive embed-responsive-16by9"> <i class="material-icons embed-responsive-item text-center" style=" object-fit: fill;width:auto;height:15rem;margin-top:0;font-size:8rem;text-align:center;margin-left:25.5%;margin-top:2.5%">movie</i></div></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a> <a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a> </div> </div></div></div>';
        }
        else if (in_array($file['mimeType'], ['text/css', 'text/x-php', 'text/html', 'text/plain', 'image/svg+xml'])) {
            echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" data-type="iframe" data-fancybox="cl-group" href=".././server/viewers/htmlspecialchars.php?url='.$row[2].'" data-thumb="https://www.materialui.co/materialIcons/action/code_black_192x192.png"  data-caption="'.$row[0].'" style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"> <div class="mdc-card__media mb-1  demo-card__media" style="height:10rem"> <div class="embed-responsive embed-responsive-16by9"> <div class="embed-responsive-item"  scrolling="no" style="pointer-events:none;width:100%;height:auto;margin-top:0"><code>'.htmlspecialchars(file_get_contents('.././user-files/'.$row[2])).'</code></div></div></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a><a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a></div> </div></div></div>';
        }
        else if (in_array($row[4], array('application/pdf', 'application/vnd.ms-powerpoint', 'application/vnd.openxmlformats-officedocument.presentationml.presentation', 'application/rtf', 'application/msword', 'application/vnd.openxmlformats-officedocument.wordprocessingml.document'))) {
            echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" data-type="iframe" data-thumb="https://icons-for-free.com/iconfiles/png/512/picture+as+pdf+48px-131985228214037181.png" data-caption="'.$row[0].'" href="https://docs.google.com/gview?url=http://drive.hosted-kabeersnetwork.unaux.com/user-files/'.$row[2].'&embedded=true"style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"> <div class="mdc-card__media mb-1  demo-card__media d-flex align-items-center justify-content-center" style="height:10rem"> <div class="embed-responsive embed-responsive-16by9"> <i class="material-icons embed-responsive-item text-center" style=" object-fit: fill;width:auto;height:15rem;margin-top:0;font-size:8rem;text-align:center;margin-left:25.5%;margin-top:2.5%">picture_as_pdf</i></div></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a><a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a> </div> </div></div></div>';
        }
        else if (in_array($row[4],array('application/x-rar-compressed', 'application/octet-stream', 'application/zip', 'application/x-zip-compressed', 'multipart/x-zip'))) {
            echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" data-type="iframe" data-fancybox="cl-group" href=".././server/modal/no-preview.php?d='.$row[1].'"  data-caption="'.$row[0].'" style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"> <div class="mdc-card__media mb-1  demo-card__media d-flex align-items-center justify-content-center" style="height:10rem"> <div class="embed-responsive embed-responsive-16by9"> <i class="material-icons embed-responsive-item text-center" style=" object-fit: fill;width:auto;height:15rem;margin-top:0;font-size:8rem;text-align:center;margin-left:25.5%;margin-top:2.5%">archive</i></div></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a><a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a> </div> </div> </div></div>';
        }
        else{
        echo '<div class="col-md-6 col-xl-3 col-xs-12 col-sm-6 file minusTop"  id="file" oncontextmenu="fileContextMenuBuilder(\'?id='.$_GET['id'].'&file='.$row[1].'\',\'user-files/'.$row[2].'\')"><div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 0em;"> <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0"><a data-fancybox="file" data-type="iframe" data-fancybox="cl-group" href=".././server/modal/no-preview.php?d='.$row[1].'"  data-caption="'.$row[0].'" style="text-decoration: none !important" class="demo-card__primary bg-light text-decoration-none"><div class="mdc-card__media mb-1  demo-card__media d-flex align-items-center justify-content-center" style="height:10rem"> <div class="embed-responsive embed-responsive-16by9"> <i class="material-icons embed-responsive-item text-center" style=" object-fit: fill;width:auto;height:15rem;margin-top:0;font-size:8rem;text-align:center;margin-left:25.5%;margin-top:2.5%">broken_image</i></div></div><h2 class="text-truncate demo-card__title mdc-typography mdc-typography--headline6" style="color: black">'.$shareIcon.$row[0].'</h2></a>  </div> <div class="mdc-card__actions"> <div class="mdc-card__action-buttons"> <a class="text-primary mdc-button mdc-card__action mdc-card__action--button mx-0 px-0" href="?id='.$_GET['id'].'&file='.$row[1].'"> <i class="material-icons">open_in_new</i></a> <a class="text-primary" href=".././user-files/'.$row[2].'" target="delIframe" download> <i class="material-icons">get_app</i></a><div class="float-right px-0 mx-0"></div> </div> </div></div></div>';
        }


/*    if(isset($_SESSION['plus'])&&in_array($count, $adsRandom)&& $_SESSION['plus'] != 1){

                    echo '
              <div style="margin-top:-1em" class="col-md-6 col-xl-4 col-xs-6 col-sm-6 '.$count.' d-flex justify-content-center mb-3" >
<div class="mdc-card mdc-card--outlined demo-card " style="width: 100%;padding-top: 0;padding-bottom: 0;margin-bottom: 0;height:7em">

<div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
<div class="demo-card__primary">
<iframe data-aa="1352585" src="//acceptable.a-ads.com/1352585" scrolling="no" style="border:0px; padding:0; width:100%; height:5em; overflow:hidden" allowtransparency="true"></iframe>
    </div>
  </div>
  <div class="mdc-card__actions" style="background-color:#8ACDC7;color:white;">
    <div class="mdc-card__action-buttons" style="height:1em">
      <a class="text-muted mdc-button mdc-card__action "><span class="mdc-button__ripple"></span> Ad By Kabeer\'s Network</a>

      <button  onclick="hideAd(\''.$count.'\')"  class="text-muted mdc-button mdc-card__action "><span class="mdc-button__ripple"></span> Hide Ad</button>

    </div>

  </div>
</div></div>
              
';
                }*/
                $count= $count+1;


            }
        }

echo '</div></div></main>';

?>

<style>*{margin:0;padding:0;box-sizing:border-box}</style>
<iframe name="shareIframe" style="display: none"></iframe>
<script> $(document).ready(function () {
        $('#exampleModal').modal("show");
        $("#exampleModal").on('hidden.bs.modal', function(){
            window.history.replaceState({}, document.title, "?id=<?php echo $_GET['id'];?>" );
            console.log(removeURLParameter(window.location.href, 'file'));
        });
    });
</script>
<style>*{margin:0;padding:0;box-sizing:border-box}</style>
<iframe class="d-none" src="index.php" name="delIframe"></iframe>

<style>.round{border-radius:50%}.fab{-webkit-transition:all 300ms ease-in-out;transition:all 300ms ease-in-out;width:56px;height:56px;background-color:#0f9c8f;display:-webkit-box;display:flex;-webkit-box-align:center;align-items:center;-webkit-box-pack:center;justify-content:center;position:fixed;right:12.5px;bottom:15px;-webkit-user-select:none;-moz-user-select:none;-ms-user-select:none;user-select:none;//cursor:pointer;color:#FFF;font-size:2em;box-shadow:0 3px 10px rgba(0,0,0,0.16),0px 3px 10px rgba(0,0,0,0.16)}.fab i{-webkit-transition:all 300ms ease-in-out;transition:all 300ms ease-in-out;will-change:transform}.inner-fabs .fab{width:40px;height:40px;right:20px;bottom:23px;font-size:1.5em;z-index:99999;will-change:bottom}.inner-fabs.show .fab:nth-child(1){bottom:80px}.inner-fabs.show .fab:nth-child(2){bottom:130px}.inner-fabs.show .fab:nth-child(3){bottom:180px}.inner-fabs.show .fab:nth-child(4){bottom:230px}.inner-fabs.show .fab:nth-child(5){bottom:280px}.inner-fabs.show .fab:nth-child(6){bottom:330px}.inner-fabs.show+.fab i{-webkit-transform:rotate(135deg);transform:rotate(135deg)}.fab:before{content:attr(data-tooltip);-webkit-transition:opacity 150ms cubic-bezier(0.4,0,1,1);transition:opacity 150ms cubic-bezier(0.4,0,1,1);position:absolute;visibility:hidden;opacity:0;box-shadow:0 1px 2px rgba(0,0,0,0.15);color:#ececec;right:50px;top:25%;background-color:rgba(70,70,70,0.9);font-size:.5em;line-height:1em;display:inline-block;text-align:center;white-space:nowrap;border-radius:2px;padding:6px 8px;max-width:200px;font-weight:bold;text-overflow:ellipsis;vertical-align:middle}.inner-fabs.show .fab:hover:before{content:attr(data-tooltip);visibility:visible;opacity:1}</style>

<script>
    var TotalFiles = $(".file").length;
    TotalFiles += $(".folder").length;

    $('.TotalFilesCount').html('<i class="material-icons mdc-list-item__graphic" aria-hidden="true">list</i> Total Files: '+TotalFiles);
    if (TotalFiles ==0){
        $('.mainContainer').html('<style>.noitemContanier{margin-top:5%;transition-duration:1s}.noitemImage{width:20vw;transition-duration:1s}@media screen and (max-width: 600px) {.noitemImage{width:35vw;}.noitemContanier{margin-top:25%;}}</style><div class="col-md-12  text-center noitemContanier" style="opacity: 70%;"><img src="images/nofiles-icon.svg" class="noitemImage" style="height:auto;background-color:#FAFAFA;"><div class="h5" style="margin-bottom:-1em">Nothing Here!</div><br><small class="h6">Upload a file or add from Text Editor to upload</small></div>');

    }
    function hideAd(Aclass = ""){
        $('.'+Aclass).addClass("hide");
    }
    var TotalFiles = $(".mdc-card").length;

    $('.TotalFilesCount').html('<i class="material-icons mdc-list-item__graphic" aria-hidden="true">list</i> Total Files: '+TotalFiles);
    if (TotalFiles ==0){
        $('.mainContainer').html('<style>.noitemContanier{margin-top:5%;transition-duration:1s}.noitemImage{width:20vw;transition-duration:1s}@media screen and (max-width: 600px) {.noitemImage{width:35vw;}.noitemContanier{margin-top:25%;}}</style><div class="col-md-12  text-center noitemContanier" style="opacity: 70%;"><img src=".././images/nofiles-icon.svg" class="noitemImage" style="height:auto;background-color:#FAFAFA;"><div class="h5" style="margin-bottom:-1em">Nothing Here!</div><br><small class="h6">Upload a file or add from Text Editor to upload</small></div>');
    }
    var TotalFiles = $('.file').length;
    if (TotalFiles == 0){
        $('.filestext').hide();
    }
    var TotalFiles = $('.folder ').length;
    if (TotalFiles == 0){
        //$('.recentContainer').hide();
    }

</script>
<style>.hide{display:none!important;}a{text-decoration:none!important}</style>
<br><br>
<!-- ADS  CASH ADS-->
<?php
/*<script>if (typeof(Storage) !== "undefined") {if(localStorage.getItem("signedup") == null){localStorage.setItem("signedup", "true");window.location.href="https://kabeersdrive.ueuo.com";}}</script>*/
          if($_SESSION['plus'] != 1){
          //echo '<script data-cfasync="false" type="text/javascript" src="https://www.onclicksuper.com/a/display.php?r=3243199"></script>';
          }
?>
<script>
$(document).on('contextmenu', function(e){
    $('#menuUl').css({
       left:  e.pageX,
       top:   e.pageY,
       display:   'block'
    });
});
function fileContextMenuBuilder(viewLink, downloadLink) {
//        $('#menuUl').html('<a class="dropdown-item" tabindex="-1" href="'+viewLink+'" >VIEW</a><a class="dropdown-item" tabindex="-1" href="'+downloadLink+'" download target="delIframe">DOWNLOAD</a>');
//        $('#menuUl').addClass("show");
 }
</script>
<div  id="menuUl" class="dropdown-menu" aria-labelledby="dropdownMenuButton"></div>

<script type="text/javascript">
let files = document.getElementsByClassName('file');
//for(i=0;i<files.length;i++){
//    files[i].addEventListener('contextmenu', function (e) {
//      e.preventDefault();
//    }, false);
//}
    $(document).ready(function(){

      let $contextMenu = $('#menuUl');
      $('html').click(function() {
          $contextMenu.removeClass('show');
          $('#menuUl').html('');
      });
    });
function showBackButton(){
    document.getElementById('navbar-search-flood').innerHTML+='<button class="mdc-icon-button material-icons mdc-top-app-bar__action-item--unbounded" onclick="history.back()" aria-label="Download">arrow_back</button>';
}
if(document.referrer==""){}else{showBackButton()}
$('[data-fancybox]').fancybox({
	protect: true
});
        </script>
        
<style>
#menuUl {
display:none;
position: absolute;
margin-bottom:0;
}
.minusTop{
    margin-top:-1.5rem;
}</style>
