<?php

define('APP_NAME', 'Your App Name Here');
define('K_OAUTH_KEY', 'Your Kabeers Oauth Key Here');
define('ENC_IV_KEY', 'Your Encryption IV Key Here');
define('ADMIN_USER', 'Your Admin UserName Here');
define('APP_PASS', 'Your Admin Password Here');
define('APP_NAME', 'Your App Name Here');






#-------------------------------------
# DONT EDIT BELOW THIS LINE
#-------------------------------------
function siteURL(){return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$_SERVER['HTTP_HOST'];}
define('SITE_URL',siteURL());
function md5Content($data){return md5($data);}
define('ADMIN_MD5_PASS',md5Content(constant('ADMIN_PASS')));
?>
