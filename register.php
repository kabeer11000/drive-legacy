
<?php include('server/login-signup-server.php'); include 'config.php';

if (isset($_SESSION['username'])) {
    //$_SESSION['msg'] = "You must log in first";
    header('location: index.php');
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
$loginButton = '<a class="btn bg-dark text-light" href="https://kabeerjaffri.000webhostapp.com/?redirect='.$actual_link.'&clientId='.encrypt(constant('K_OAUTH_KEY'),$uniqueId).'&action=signup&key='.$uniqueId.'"><img src="images/kslogo.png" style="width: 1.5em; height: auto;" class="mx-2">Continue with <strong>Kabeer\'s Network</strong></a>';
?>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

<title>Sign Up to <?php echo constant('APP_NAME'); ?>.</title>

<link rel="stylesheet" type="text/css" href="css/bootstrap_matrial_design.css">
<script type="text/javascript" src="js/jquery.min.js"></script>
<script type="text/javascript" src="js/propper.js"></script>
<script type="text/javascript" src="js/bootstrap_matrial_design.js"></script>
<style type="text/css">*{margin: 0;padding: 0;box-sizing: border-box;}</style>
<!-- Default form login -->
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <form class="text-center border border-light p-5" action="register.php" method="post">

                <p class="h4 mb-2"><img style="width: 2em;height: auto;" src="images/kslogo.png"></p>
                <p class="h4 mb-2">Sign Up</p>
                <p class="small text-muted mb-4 pb-4">Continue to <?php echo constant('APP_NAME'); ?></p>
                <p class="small text-danger" style="color: red"><?php include('errors.php'); ?></p>

                <button type="button" class="btn btn-secondary float-right" onmousedown="ShowPassword()" onmouseleave="HidePassword()"><img src="https://cdn3.iconfinder.com/data/icons/glypho-design/64/eye-512.png" style="width:1em;height:auto;"></button>
                <!-- Email -->
                <input type="text" id="defaultLoginFormEmail" name="username" value="<?php echo $username; ?>" class="username form-control mb-4" placeholder="Username">

                <input type="email" id="defaultLoginFormEmail" name="email" value="<?php echo $email; ?>" class="form-control mb-4" placeholder="Email">

                <!-- Password -->
                <input type="password" id="defaultLoginFormPassword" name="password_1" class="password P1  form-control mb-4" placeholder="Password">

                <!-- Password -->
                <input type="password" id="defaultLoginFormPassword" name="password_2"class="form-control P2 mb-4" placeholder="Confirm Password">

                <script>
                    function HidePassword(){
                        $('.P1').attr("type","password");
                        $('.P2').attr("type","password");
                    }
                    function ShowPassword() {
                        $('.P1').attr("type","text");
                        $('.P2').attr("type","text");
                    }
                </script>
                <div class="form-group float-left text-left">
                    <input type="checkbox" name="agree-term" id="agree-term" class="agree-term">
                    <label for="agree-term" class="label-agree-term"><a href="http://drive.hosted-kabeersnetwork.unaux.com/terms.html" class="term-service">End User Agreement</a></label>
                </div>
                <!-- Sign in button -->
                <button class="btn btn-info btn-block my-4 signup_btn" type="submit" name="reg_user">Sign up</button>
<hr>
                <?php echo $loginButton;?>
                <!-- Register -->
                <p>Already a member?<br>
                    <a href="login.php">Sign in</a>
                </p>

            </form>
		</div>
    </div>
</div>

            