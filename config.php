<?php

define('APP_NAME', 'Your App Name Here');
define('K_OAUTH_KEY', 'Your Kabeers Oauth Key Here');
define('ENC_IV_KEY', 'Your Encryption IV Key Here');
define('ADMIN_USER', 'Your Admin UserName Here');
define('ADMIN_PASS', 'Your Admin Password Here');
define('DB_HOST', 'Your Database Host Here');
define('DB_USER_NAME', 'Your Database UserName');
define('DB_PASSWORD', 'Your Database Password');
define('DB_NAME', 'Your Database Name');



#-------------------------------------
# DONT EDIT BELOW THIS LINE
#-------------------------------------
function siteURL(){
    return (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' || $_SERVER['SERVER_PORT'] == 443) ? "https://" : "http://".$_SERVER['HTTP_HOST'];
}
define('SITE_URL',siteURL());
function md5Content($data){
    return md5($data);
}
define('ADMIN_MD5_PASS', md5Content(constant('ADMIN_PASS')));
?>
