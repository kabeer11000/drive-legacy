<?php
session_start();
$id = $_SESSION['id'];
if (!isset($_SESSION['username'])) {
    $_SESSION['msg'] = "You must log in first";
    header('location: login.php');
}
include 'config.php';
?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145795163-3');
</script>
<script src="https://code.jquery.com/jquery-3.4.1.min.js"
integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo="
crossorigin="anonymous"></script>

<link rel="stylesheet" type="text/css" href="css/materialDesign.css">

<style>*{margin:0;padding:0;box-sizing:border-box}body{margin:0;padding:0;box-sizing:border-box}</style>
<div id="preloader" style="position: fixed;display:block;z-index: 200002; width: 100%;height: 100%;background-image: linear-gradient(#F6F6F6,#F6F6F6);background-repeat: no-repeat;background-size: cover;" class="text-center">

<div role="progressbar" style="margin:0;padding:0; z-index:999999" class="mdc-linear-progress mdc-linear-progress--indeterminate"><div class="mdc-linear-progress__buffering-dots"></div><div class="mdc-linear-progress__buffer"></div><div class="mdc-linear-progress__bar mdc-linear-progress__primary-bar"><span class="mdc-linear-progress__bar-inner"></span></div><div class="mdc-linear-progress__bar mdc-linear-progress__secondary-bar"><span class="mdc-linear-progress__bar-inner"></span></div></div>  
</div>
  <script>
function preload_remover()
{
        $("#preloader").fadeOut();

}
</script>

<title>Settings <?php echo constant('APP_NAME'); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>
<style>
a{text-decoratin:none;}</style>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/icon?family=Material+Icons">
<body onload="preload_remover()">
<header class=" mdc-top-app-bar" style="background-color: #FAFAFA">
  <div class="mdc-top-app-bar__row"  style="background-color:#D6D7D9">
    <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-start" style="background-color: #D6D7D9;color: #2E2E2E;">
      <a class="mdc-icon-button material-icons" href="#" onclick="goBack()">arrow_back</a><span class="mdc-top-app-bar__title">Settings</span> </section>
  <section class="mdc-top-app-bar__section mdc-top-app-bar__section--align-end"  style="background-color: #D6D7D9;color: #2E2E2E;">
      <button class="mdc-icon-button material-icons mdc-top-app-bar__action-item--unbounded" onClick="window.location.reload();"aria-label="Download">refresh</button>
    </section>
 </div>
  
<script>
function goBack() {
  window.history.back();
}
</script>
  </div>
    <style> body { font-family: Verdana, sans-serif; margin: 0; } * { box-sizing: border-box; } .row > .column { padding: 0 8px; } .row:after { content: ""; display: table; clear: both; } .column { float: left; width: 25%; } /* The Modal (background) */ .modal { display: none; position: fixed; z-index: 1; padding-top: 100px; left: 0; top: 0; width: 100%; height: 100%; overflow: auto; background-color: black; } /* Modal Content */ .modal-content { position: relative; background-color: #fefefe; margin: auto; padding: 0; width: 90%; max-width: 1200px; } /* The Close Button */ .close { color: white; position: absolute; top: 10px; right: 25px; font-size: 35px; font-weight: bold; } .close:hover, .close:focus { color: #999; text-decoration: none; cursor: pointer; } .mySlides { display: none; } .cursor { cursor: pointer; } /* Next & previous buttons */ .prev, .next { cursor: pointer; position: absolute; top: 50%; width: auto; padding: 16px; margin-top: -50px; color: white; font-weight: bold; font-size: 20px; transition: 0.6s ease; border-radius: 0 3px 3px 0; user-select: none; -webkit-user-select: none; } /* Position the "next button" to the right */ .next { right: 0; border-radius: 3px 0 0 3px; } /* On hover, add a black background color with a little bit see-through */ .prev:hover, .next:hover { background-color: rgba(0, 0, 0, 0.8); } /* Number text (1/3 etc) */ .numbertext { color: #f2f2f2; font-size: 12px; padding: 8px 12px; position: absolute; top: 0; } .caption-container { text-align: center; background-color: black; padding: 2px 16px; color: white; } .demo { opacity: 0.6; } .active, .demo:hover { opacity: 1; } img.hover-shadow { transition: 0.3s; } .hover-shadow:hover { box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2), 0 6px 20px 0 rgba(0, 0, 0, 0.19); }</style>

    <div id="myModal" class="modal" style="background-color: #2B2B2B">
        <span class="close cursor" onclick="closeModal()">&times;</span>
        <div class="modal-content " style="background-color: #2B2B2B">

            <div class="mySlides d-flex justify-content-center" style="background-color: #000;">
                <img src="user-AccountImages/<?php echo $_SESSION['image']?>" style="border-radius:30em;background-color: #000; width:20em">
            </div>


            <a class="prev" onclick="plusSlides(-1)">&#10094;</a>
            <a class="next" onclick="plusSlides(1)">&#10095;</a>

            <div class="caption-container">
                <p id="caption h4"><?php echo $_SESSION['username']?></p>
            </div>


        </div>
    </div>

    <script>
        function openModal() {
            document.getElementById("myModal").style.display = "block";
        }

        function closeModal() {
            document.getElementById("myModal").style.display = "none";
        }

        var slideIndex = 1;
        showSlides(slideIndex);

        function plusSlides(n) {
            showSlides(slideIndex += n);
        }

        function currentSlide(n) {
            showSlides(slideIndex = n);
        }

        function showSlides(n) {
            var i;
            var slides = document.getElementsByClassName("mySlides");
            var dots = document.getElementsByClassName("demo");
            var captionText = document.getElementById("caption");
            if (n > slides.length) {slideIndex = 1}
            if (n < 1) {slideIndex = slides.length}
            for (i = 0; i < slides.length; i++) {
                slides[i].style.display = "none";
            }
            for (i = 0; i < dots.length; i++) {
                dots[i].className = dots[i].className.replace(" active", "");
            }
            slides[slideIndex-1].style.display = "block";
            dots[slideIndex-1].className += " active";
            captionText.innerHTML = dots[slideIndex-1].alt;
        }
    </script>


</header>
  <div class="container">
  	<div class="row">
        <div class="col-md-12 d-flex justify-content-center mt-5"><img onclick="openModal();currentSlide(1)"  style="width: 5em;border-radius: 30em; height: auto;margin-top: 10vh" src="user-AccountImages/<?php echo $_SESSION['image']?>"></div>
        <hr>        <div class="col-md-12 text-center mt-2"><div class="mdc-typography--headline5 text-center text-dark">Welcome, <?php echo $_SESSION['username']?></div><br><p style="color: #686C71">Manage your info, privacy, and security to make Drive work better for you</p></p></div>
            <div class="col-md-12" style="padding-top: 1.5em;padding-bottom: 0;margin-bottom: 0;position:static;">
<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Delete All Files</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Delete's All your files. This action cannot be reverted!</h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="server/files-server.php?deleteAllD=true">  <span class="mdc-button__ripple"></span> Delete</a>
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button">  <span class="mdc-button__ripple"></span> Learn More</a>
    </div>
  </div>
</div>
		
<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;margin-bottom:1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Log Out</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Log out of <?php echo constant('APP_NAME'); ?> on this Device</h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="index.php?logout=true">  <span class="mdc-button__ripple"></span> Logout</a>
    </div>
  </div>
</div>

<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Download your Files</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Download All your files. Stored on <?php echo constant('APP_NAME'); ?></h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="userFilesDownloader.php">  <span class="mdc-button__ripple"></span> Download</a>
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button">  <span class="mdc-button__ripple"></span> Learn More</a>
    </div>
  </div>
</div>

<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Remove Account From Device</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Remove Current Account From <?php echo constant('APP_NAME'); ?></h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="server/login-signup-server.php?removeAccountFromDevice=true">  <span class="mdc-button__ripple"></span> Remove</a>
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button">  <span class="mdc-button__ripple"></span> Learn More</a>
    </div>
  </div>
</div>

<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Remove Ads</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Remove Ads from <?php echo constant('APP_NAME'); ?> for this account.</h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="removeAds.php">  <span class="mdc-button__ripple"></span>Remove Ad's</a>
    </div>
  </div>
</div>

<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Legal</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">Privacy Policy For <?php echo constant('APP_NAME'); ?></h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="https://static-kabeersnetwork.000webhostapp.com/terms/drive/">  <span class="mdc-button__ripple"></span>View Legal</a>
    </div>
  </div>
</div>


<div class="mdc-card mdc-card--outlined demo-card" style="width: 100%;margin-top: 0;padding-top: 0;padding-bottom: 0;margin-bottom: 1em">
  <div class="mdc-card__primary-action demo-card__primary-action" tabindex="0">
    <div class="demo-card__primary">
      <h2 class="demo-card__title mdc-typography mdc-typography--headline6" style="color: black">Your Activity</h2>
      <h3 class="demo-card__subtitle mdc-typography mdc-typography--subtitle2">View your activity inside <?php echo constant('APP_NAME'); ?></h3>
    </div>
  </div>
  <div class="mdc-card__actions">
    <div class="mdc-card__action-buttons">
      <a class="text-primary mdc-button mdc-card__action mdc-card__action--button" href="activity.php"> View</a>
    </div>
  </div>
</div>
  		</div>
</div>
<iframe hidden name="async"></iframe>
</body>
