
<?php include('server/login-signup-server.php');include('config.php');

if (isset($_SESSION['username'])) {
}

function encrypt($string,$encryption_key){
    $ciphering = "AES-128-CTR";
    $iv_length = openssl_cipher_iv_length($ciphering);
    $options = 0;
    $encryption_iv = constant('ENC_IV_KEY');
    $encryption = openssl_encrypt($string, $ciphering,
    $encryption_key, $options, $encryption_iv);
    return $encryption;
}

$actual_link = constant('SITE_URL')."/server/login-signup-server.php";
$uniqueId = urlencode(base64_encode(uniqid()));
$loginButton = '<a class="btn bg-dark text-light" href="https://kabeerjaffri.000webhostapp.com/?redirect='.$actual_link.'&clientId='.encrypt(constant('K_OAUTH_KEY'),$uniqueId).'&action=login&key='.$uniqueId.'"><img src="images/kslogo.png" style="width: 1.5em; height: auto;" class="mx-2">Continue with <strong>Kabeer\'s Network</strong></a>';


?>
<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-145795163-3"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-145795163-3');
</script>

<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Login to <?php echo constant('APP_NAME'); ?></title>

<link rel="stylesheet" type="text/css" href="css/bootstrap_matrial_design.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/propper.js"></script>
<script type="text/javascript" src="js/bootstrap_matrial_design.js"></script>
<style type="text/css">*{margin: 0;padding: 0;box-sizing: border-box;}</style>
<script>
    $(document).ready(function() {
        var start = new Date();

        $(window).unload(function() {
            var end = new Date();
            $.post("server/user-time/timme.php",
                {
                    time: end - start
                },
                function(data, status){
                    alert("Data: " + data + "\nStatus: " + status);
                });
        });
    });
</script>
<!-- Default form login -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="text-center border border-light p-5" action="login.php" method="post">

                <p class="h4 mb-2"><img style="width: 2em;height: auto;" src="images/kslogo.png"></p>
                <p class="h4 mb-2">Sign in</p>
                <p class="small text-muted mb-4 pb-4">Continue to <?php echo constant('APP_NAME'); ?></p>
                <p class="small text-danger" style="color: red"><?php include('errors.php'); ?></p>
                <!-- Email -->
                <input type="text" id="defaultLoginFormEmail" name="username" class="form-control mb-4" placeholder="Username">

                <!-- Password -->
                <input type="password" id="defaultLoginFormPassword" name="password" class="form-control mb-4 P1" placeholder="Password">

                <button type="button" class="btn btn-secondary float-right" onmousedown="ShowPassword()" onmouseleave="HidePassword()"><img src="https://cdn3.iconfinder.com/data/icons/glypho-design/64/eye-512.png" style="width:1em;height:auto;"></button>

                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4" type="submit" name="login_user">Sign in</button>
                <hr>
                <?php echo $loginButton;?>
                <!-- Register -->
                <p>Not a member?
                    <a href="register.php">Register</a>
                </p>

            </form>

            <script>
                function HidePassword(){
                    $('.P1').attr("type","password");
                }
                function ShowPassword() {
                    $('.P1').attr("type","text");
                }
            </script>
        </div>
   </div>
</div>
</div>