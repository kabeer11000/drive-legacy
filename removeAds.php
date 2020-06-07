<?php
include('server/removeAds.php');
include 'config.php';
session_start();
if(isset($_GET['msg'])&&isset($_GET['t'])){
if($_GET['t']==1) {
    $doneHtml = '<div class="alert alert-success" role="alert">' . $_GET['msg'] . '</div><script>function f(){$(".alert").slideUp();var myNewURL = "";
window.history.pushState("", "", "?" + myNewURL );}window.setTimeout(f, 3000);</script>';
}else{
    $doneHtml = '<div class="alert alert-danger" role="alert">' . $_GET['msg'] . '</div><script>function f(){$(".alert").slideUp();var myNewURL = "";
window.history.pushState("", "", "?" + myNewURL );}window.setTimeout(f, 3000);</script>';

}
}else{$doneHtml = '';}
if (!isset($_POST['coupon'])){$_POST['coupon'] ='';}
if(!isset($_SESSION['username'])){
    header("Location:login.php");
}
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145795163-3');
</script>

<link rel="stylesheet" href="https://unpkg.com/bootstrap-material-design@4.1.1/dist/css/bootstrap-material-design.min.css" integrity="sha384-wXznGJNEXNG1NFsbm0ugrLFMQPWswR3lds2VeinahP8N0zJw9VWSopbjv2x7WCvX" crossorigin="anonymous">

<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://unpkg.com/popper.js@1.12.6/dist/umd/popper.js" integrity="sha384-fA23ZRQ3G/J53mElWqVJEGJzU0sTs+SvzG8fXVWP+kJQ1lwFAOkcUOysnlKJC33U" crossorigin="anonymous"></script>
<script src="https://unpkg.com/bootstrap-material-design@4.1.1/dist/js/bootstrap-material-design.js" integrity="sha384-CauSuKpEqAFajSpkdjv3z9t8E7RlpJ1UP0lKM/+NdtSarroVKu069AlsRPKkFBz9" crossorigin="anonymous"></script>
<script>$(document).ready(function() { $('body').bootstrapMaterialDesign(); });</script>

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text-center mt-5">

                <p class="h4 mb-2"><img style="width: 2em;height: auto;border-radius: 30px" src="user-AccountImages/<?php echo $_SESSION['image'];?>"></p>
                <p class="h5 mb-2">Enter Coupon To Remove Ad's</p>
                <p class="small text-muted mb-4 pb-4">Continue to <?php echo constant('APP_NAME'); ?></p>
            </div>
            <errors class="text-warning p "><?php echo $doneHtml;?></errors>
            <form action="server/removeAds.php" method="post">
                <div class="form-group row">
                    <label for="staticEmail" class="col-sm-2 col-form-label">User Name</label>
                    <div class="col-md-12">
                        <style>#staticEmail:focus{outline: none}background-color:#EEEEEE;border-radius:10px;padding-left:0.5em;</style>
                        <input type="text" readonly class="form-control-plaintext text-muted mt-2"  style="height:2em;"  id="staticEmail" value="<?php echo $_SESSION['username']; ?>">
                    </div>
                </div>
                <div class="form-group row">
                    <label for="inputPassword" class="col-sm-2 col-form-label">Coupon Code</label>
                    <div class="col-md-12">
                        <input autocomplete="off" class="form-control" id="inputPassword" style="height:3em;" name="coupon" type="text" value="<?php echo $_POST['coupon']; ?>" placeholder="Enter Coupon Code Here">
                    </div>
                </div>
                <div class="form-group row px-5">
                    <input type="submit" value="Done" class="btn text-light bg-primary w-100">
                </div>
            </form>
        </div>
    </div>
</div>
<style>
    *{margin:0;padding:0;box-sizing:border-box;}
    input:focus{}
</style>