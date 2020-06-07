<?php
include 'server/dbConnect.php';
include 'config.php';
session_start();
if(!isset($_SESSION['username'])){header("Location:login.php");}
echo '<title>'.$_SESSION['username'].' - My Activity - '.constant('APP_NAME').'</title>';
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<link href="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.css" rel="stylesheet">
<script src="https://unpkg.com/material-components-web@latest/dist/material-components-web.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://hosted-kabeersnetwork.000webhostapp.com/Private/uploads/5ec5644d589fbbootstrap-materialdesign.js"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<style>
root:{--drive-nav-grey : #D6D7D9;}
.bg-drive-grey{
    background-color: rgba(200, 200, 200, 0.7);
}
.backdrop-blur{
    backdrop-filter: blur(5px);
}
</style>
<header class="mdc-top-app-bar fixed-top bg-drive-grey text-dark backdrop-blur">
  <div class="mdc-top-app-bar__row">
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start">
      <button class="material-icons mdc-top-app-bar__navigation-icon mdc-icon-button text-dark" onclick="window.history.back()" aria-label="Open navigation menu">arrow_back</button>
      <span class="mdc-top-app-bar__title">My Activity</span>
    </section>
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end" role="toolbar">
      <button class="material-icons mdc-top-app-bar__action-item mdc-icon-button text-dark" onclick="window.location.reload()" aria-label="Favorite">refresh</button>
    </section>
  </div>
</header>

<div class="container" style="margin-top:5rem">
    <div class="row d-flex align-items-center justify-content-center">
<?php 
$username = $_SESSION['username'];
$query = "SELECT `username`, `ip`, `time`, `uniqueToken`, `loc` FROM `logins` WHERE `username` = '$username' ORDER  BY `id` DESC LIMIT 5;";
$result = mysqli_query($db, $query);
while($row = mysqli_fetch_row($result)) {
$json = file_get_contents('https://ipinfo.io/'.str_replace("-",".",$row['1']).'/geo');
$obj = json_decode($json);
$loc = explode(',', $row[4]);
echo '<div class="col-md-8 mb-5">
           <div class="card" style="width: 100%;">
            <iframe class="card-img-top" style="width:100%;height:14.5rem;" frameborder="0" scrolling="no" marginheight="0" marginwidth="0" src="https://www.openstreetmap.org/export/embed.html?bbox='.$loc[1].','.$loc[1].','.$loc[0].','.$loc[0].'&amp;layer=mapnik&amp;marker='.$loc[0].','.$loc[1].'"></iframe>
              <div class="card-body">
                <h5 class="card-title">'.$row['0'].'</h5>
                <p class="card-text text-muted small">'.ucfirst($obj->city).' | Token : '.$row['3'].'.</p>
                <button class="btn btn-primary btn-raised first text-center '.$row['3'].'BTN" onclick=detailSlideDown(\'.'.$row['3'].'\',\'.'.$row['3'].'BTN\')>More ↓</button>
              </div>
              <ul class="list-group '.$row['3'].'">
                <li class="list-group-item">City : '.ucfirst($obj->city).'</li>
                <li class="list-group-item">Region : '.ucfirst($obj->region).'</li>
                <li class="list-group-item">Country : '.ucfirst($obj->country).'</li>
                <li class="list-group-item">TimeZone : '.ucfirst($obj->timezone).'</li>
                <li class="list-group-item">Postal : '.ucfirst($obj->postal).'</li>
                <li class="list-group-item">Cordinates: '.ucfirst($obj->loc).'</li>
              </ul>
                <div class="card-footer">
                  <small class="text-muted">Last updated '.$row['2'].' <br>IP : '.str_replace("-",".",$row['1']).'</small>
                </div>
            </div>
        </div>';
    }
?>
        <small class="text-center text-muted">Only you can see this data. Kabeers Network protects your privacy and security.<br>&copy; 2020 Kabeers Network<br></small>
    </div>
</div>
<script>
$('.list-group').hide();
function detailSlideDown(id, selfname){
    $(id).slideDown();
    $(selfname).text('Less ↑');
    $(selfname).attr('onclick', 'detailSlideUp("'+id+'", "'+selfname+'")');
}
function detailSlideUp(id, selfname){
    $(id).slideUp();
    $(selfname).text('More ↓');
    $(selfname).attr('onclick', 'detailSlideDown("'+id+'", "'+selfname+'")');
}
</script>