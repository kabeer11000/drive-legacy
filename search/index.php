<?php
include '.././server/dbConnect.php';
include '../config.php';
session_start();

gc_enable();
gc_collect_cycles();
if(!isset($_SESSION['username'])){
    header("Location:../login.php");
}
function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
   $string = preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.

   return preg_replace('/-+/', '-', $string); // Replaces multiple hyphens with single one.
}
gc_collect_cycles();
if(isset($_GET['query'])){
    $filename = strip_tags($_GET['query']);
    $username = $_SESSION['username'];
    if($_GET['scope']="1"&&isset($_GET['folder'])){
        $parent = strip_tags($_GET['folder']);
        $url = '../folder.php?id='.$parent.'&file=';

gc_collect_cycles();
$typeFolder = '
        <div class="form-group w-50 float-left" >
      <label for="inputState">Options</label>
      <select name="scope" id="inputState" class="form-control">
        <option value="0">All Drive</option>
        <option value="1">This Folder</option>
      </select>
    </div><div class="w-50 float-right text-right"><input type="submit" class="btn btn-primary btn-raised mt-4" value="Search"></div><input type="text" value="'.$parent.'" hidden name="folder">';
    $folderQuery = "AND `parent` = '$parent'";
    $queryFolderName = "SELECT * FROM `folders` WHERE `uniqueId` = '$parent' AND `owner` = '$username' LIMIT 1;";
    $folderName = mysqli_fetch_assoc(mysqli_query($db,$queryFolderName))['name'];

gc_collect_cycles();
    
    }
    else{
        $parent = strip_tags($_SESSION['uniqueId']);
        $url = '../index.php?file=';
        $typeFolder = '';
        $folderQuery = '';
        $folderName = "All Files";
    }

gc_collect_cycles();
$folderQuery = explode('+', $folderQuery);
    foreach($folderQuery as $folderQuery){
    $query = "SELECT `name`, `address`, `uniqueId`, `shared` FROM `files` WHERE `name` LIKE '".clean(strip_tags($filename))."' AND `owner`  = '$username' ".$folderQuery.";"; 
    $result = mysqli_query($db, $query);

gc_collect_cycles();    
    echo '
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, ">
    <title>'.$filename.' - Search - '.constant('APP_NAME').'</title>
    <br>
<div class="container search-bar"><div class="row"><div class="col-md-12"><form action="" class="searchForm" method="get"><input results="5" autocomplete="off" autosave="search" class="border w-100 search-inner nav-hover-search" type="search" name="query" value="'.htmlspecialchars($_GET['query']).'" placeholder="Search e.g. video.mp4" aria-label="Search">

    '.$typeFolder.'
    </form>
        </div>
        <div class="col-md-12 shadow nav-tab-search-expand d-none">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" style="width: 50%">
                    <a class="nav-link" href="../index.php"><i class="material-icons">home</i></a>
                </li>
                <li class="nav-item" style="width: 50%">
                    <a class="nav-link" href="../settings.php"><i class="material-icons">settings</i></a>
                </li>
            </ul>

        </div></div><br><p>About <span class"text-primary">'.count($result).'</span> Result Found | Searching in <span class="text-primary">'.$folderName.'</p> </div>
    <div onload="preload_remover()" class="container resultContainer mt-5"><div class="row">';

gc_collect_cycles();
while($row = mysqli_fetch_row($result)) {
        if($row['3'] == '1'){$shareBox="checked";$shareIcon='../viewer.php?id='.$row[2].'';}else{$shareBox="";$shareIcon='';}
        echo '<div class="col-sm-4 file">
<div class=" px-3 py-2 mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-bottom: 1em;height:7em;">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <a href="'.$url.$row[2].'" ><h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: #3C3F41!important; ">'.$row[0].'</h2></a>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="../uViewFile.php?id='.$row[2].'"><span class="mdc-button__ripple"></span> View</a>
      <a target="delIframe" onclick="this.parentNode.parentNode.parentNode.parentNode.hidden=true" class="text-primary mdc-button mdc-card__action mdc-card__action--button" href=".././server/files-server.php?del=1&id='.$row[2].'">  <span class="mdc-button__ripple"></span> Delete</a>
       <a target="delIframe" class="text-primary mdc-button mdc-card__action mdc-card__action--button" href=".././server/downloaders/download-file.php?id='.$row[2].'" download> <i class="material-icons">get_app</i></a> <div class="float-right px-0 mx-0">
             <div class="dropdown">
  <button class="btn w-1  px-0 mx-0" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
  <i class="material-icons">more_vert</i>  
  <div class="ripple-container"></div></button>
  <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
  <a href="#"></a>
  <form action="../server/files-server.php" target="delIframe" method="get" class="px-2 share_form'.$row[2].'">
  <input type="text" hidden name="share" value="'.$row[2].'">
   
   <div class="radio">
    <label>
      <input type="checkbox" class="share_switch'.$row[2].'" onchange="this.form.submit()" name="ShareN"  value="1" '.$shareBox.'> Link Sharing
    </label>
    <br><code readonly class="pl-2 code shareLink'.$row[2].' text-nowrap w-100">'.$shareIcon.'</code>
  </div> 
</form>    
    </div>
        </div>
        </div>
    </div>
  </div>
</div>
</div>';

gc_collect_cycles();
}

gc_collect_cycles();
}
    echo '</div></div>';
}
if($_SESSION['plus'] !=1){
    echo '';
}

gc_collect_cycles();
?>

<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<style>*{margin:0;padding:0;box-sizing:border-box}</style>
<link rel=stylesheet href=http://drive.hosted-kabeersnetwork.unaux.com/css/bootstrap_matrial_design.css><link href=https://unpkg.com/material-components-web@v4.0.0/dist/material-components-web.min.css rel=stylesheet>
<script src=http://drive.hosted-kabeersnetwork.unaux.com/js/jquery.min.js></script> <script src=https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js integrity=sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U crossorigin=anonymous></script><script src=https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js integrity=sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9 crossorigin=anonymous></script> 
<iframe class="d-none" src="index.php" name="delIframe"></iframe>


<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<style>a{text-decoration: none!important;}</style>


<style>
    .shadow-sm{box-shadow:0 .125rem .25rem rgba(0,0,0,.075)!important}.shadow{box-shadow:0 .5rem 1rem rgba(0,0,0,.15)!important}.shadow-lg{box-shadow:0 1rem 3rem rgba(0,0,0,.175)!important}.shadow-none{box-shadow:none!important}
    body{background-color: #FAFAFA}
    div.scrollmenu {background-color: #FAFAFA; overflow: auto; white-space: nowrap;height: 100%}div.scrollmenu .card {text-align:center;margin-right:1em;display: inline-block}div.scrollmenu div:hover {opacity: 100%;}
    .bg-fa{background-color: #FAFAFA;}
    .br-t{border-radius: 20px 20px 0 0;}
    .br-b{border-radius: 0px 0px 20px 20px;}
    .br-a{border-radius: 20px 20px 20px 20px;}
    .w-0{width:0rem;} .w-1{width:1rem;} .w-2{width:2rem;} .w-3{width:3rem;} .w-4{width:4rem;} .w-5{width:5rem;} .w-6{width:6rem;} .w-7{width:7rem;} .w-8{width:6.5rem;} .w-9{width:9rem;} .w-10{width:10rem;}
    .h-0{height:0rem;} .h-1{height:1rem;} .h-2{height:2rem;} .h-3{height:3rem;} .h-4{height:4rem;} .h-5{height:5rem;} .h-6{height:6rem;} .h-7{height:7rem;} .h-8{height:8rem;} .h-9{height:9rem;} .h-10{height:10rem;} .h-11{height:11rem;} .h-12{height:12rem;}
    .bx-n{box-shadow: none;}
    .h-65P{height: 65%;}
    .mt-2P{margin-top: -2.5%}
    .elps{overflow: hidden;text-overflow: ellipsis;}
    h5{font-size: 1.25em!important;}
    .nav-hover-search{transition-duration: 0.25s;box-shadow:0 .25rem 0.5rem rgba(0,0,0,.075)!important;height: 2.5rem;border-radius: 0.25rem;z-index: 5;padding-left: 1em}
    .nav-fixed-search{transition-duration: 0.25s;height: 3rem;width: 100%;position: fixed;top: 0;left: 0;right: 0;z-index: 5;padding-left: 1.5em;animation: pop 0.3s linear 1;}
    .nav-hover-search:focus{outline: none;}
    .nav-fixed-search:focus{outline: none;}
    input[type=search]::-webkit-search-cancel-button {
        -webkit-appearance: searchfield-cancel-button;
    }
    .nav-tab-search-expand{position: fixed;top: 3rem;right: 0;left: 0;z-index: 5;background-color: #fff;animation: pop 0.3s linear 1;}
    .nav-tab-search-expand-hover{position: relative;z-index: 5;background-color: #fff;}
    .nav-tabs li a{height: 4em;padding-top: -2em;margin-top: -0.75em;text-align: center;}
    @keyframes pop{
        50%  {transform: scale(1.2);}
    }
    .nav-tabs{border-bottom:1px solid #dee2e6;}
    .nav-tabs .nav-item{margin-bottom:-1px}
    .nav-tabs .nav-link{border:1px solid transparent;border-top-left-radius:.125rem;border-top-right-radius:.125rem}
    .nav-tabs .nav-link:focus,.nav-tabs .nav-link:hover{border-color:#e9ecef #e9ecef #dee2e6}
    .nav-tabs .nav-link.disabled{color:#6c757d;background-color:transparent;border-color:transparent}
    .nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active{color:#495057;background-color:#BFBFBF;opacity: 100%;border-color:#dee2e6 #dee2e6  #BFBFBF;}.nav-tabs .dropdown-menu{margin-top:-1px;border-top-left-radius:0;border-top-right-radius:0}.nav-pills .nav-link{border-radius:.125rem}.nav-pills .nav-link.active,.nav-pills .show>.nav-link{color:#fff;background-color:#BFBFBF}.nav-fill .nav-item{flex:1 1 auto;text-align:center}
    .nav-tabs{border:0}.nav-pills .nav-link,.nav-tabs .nav-link{padding:1.4286em .8575em;font-size:.875rem;font-weight:500;border:0}.nav-pills .nav-item.show .nav-link,.nav-pills .nav-link.active,.nav-tabs .nav-item.show .nav-link,.nav-tabs .nav-link.active{background-color:transparent;color:inherit}.nav-tabs .nav-link{border-bottom:.214rem solid transparent;color:rgba(0,0,0,.54)}.nav-tabs .nav-link.active{color:rgba(0,0,0,.87)}.nav-tabs .nav-link.active,.nav-tabs .nav-link.active:focus,.nav-tabs .nav-link.active:hover{border-color:theme-color(primary)}.nav-tabs .nav-link.disabled,.nav-tabs .nav-link.disabled:focus,.nav-tabs .nav-link.disabled:hover{color:rgba(0,0,0,.26)}.nav-tabs.bg-primary .nav-link{color:#fff}.nav-tabs.bg-primary .nav-link.active{color:#fff;border-color:#fff}.nav-tabs.bg-primary .nav-link.active:focus,.nav-tabs.bg-primary .nav-link.active:hover{border-color:#fff}.nav-tabs.bg-primary .nav-link.disabled,.nav-tabs.bg-primary .nav-link.disabled:focus,.nav-tabs.bg-primary .nav-link.disabled:hover{color:hsla(0,0%,100%,.84)}.nav-tabs.bg-dark .nav-link{color:#fff}.nav-tabs.bg-dark .nav-link.active{color:#fff;border-color:#fff}.nav-tabs.bg-dark .nav-link.active:focus,.nav-tabs.bg-dark .nav-link.active:hover{border-color:#fff}.nav-tabs.bg-dark .nav-link.disabled,.nav-tabs.bg-dark .nav-link.disabled:focus,.nav-tabs.bg-dark .nav-link.disabled:hover{color:hsla(0,0%,100%,.84)}
    .opacity-card-image:active{
        opacity: 70%;
    }
</style>
    <script type="text/javascript">
        var distance = $('.search-bar').offset().top;

        $(window).scroll(function() {
            if ( $(this).scrollTop() >= distance ) {
                $('.search-inner').removeClass("nav-hover-search");
                $('.search-inner').addClass("nav-fixed-search");
                $('.search-bar').addClass("mb-4");
                $('.nav-tab-search-expand').addClass("d-block");
                console.log('is in top');
            } else {
                $('.search-inner').removeClass("nav-fixed-search");
                $('.search-inner').addClass("nav-hover-search");
                $('.search-bar').removeClass("mb-4");
                $('.nav-tab-search-expand').removeClass("d-block");
                console.log('is not in top');
            }
        });
        let totalFiles = $('.file').length();
        if (totalFiles = 0){
            $('.resultContainer').html("<div class=row><div class=col-md-12><img src=.././images/kslogo.png style=width:5em;height:auto></div></div>");
        }
        
$('.search-inner').keypress(function (e) {
  if (e.which == 13) {
    $('.searchForm').submit();
    return false;    //<---- Add this line
  }
});
    </script>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145795163-3');
</script>
