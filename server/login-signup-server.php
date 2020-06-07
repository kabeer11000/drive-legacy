<?php
session_start();
include 'dbConnect.php';

gc_enable();
// initializing variables
$username = "";
$email    = "";
$errors = array();

if(isset($_GET['removeAccountFromDevice'])){
    
    unset($_COOKIE['username']);
    setcookie('username', '', time() - 3600, '/');
    
    unset($_COOKIE['passwod']);
    setcookie('password', '', time() - 3600, '/');
    gc_collect_cycles();
    header("Location:../index.php?logout=true");
}

function clean($string) {
   $string = str_replace(' ', '-', $string); // Replaces all spaces with hyphens.
  return preg_replace('/[^A-Za-z0-9\-]/', '', $string); // Removes special chars.
}
function random_color_part() {
    return str_pad( dechex( mt_rand( 0, 255 ) ), 2, '0', STR_PAD_LEFT);
}

function random_color() {
    return random_color_part() . random_color_part() . random_color_part();
}
//COOKIE LOGIN
if(isset($_COOKIE['username'])&&isset($_COOKIE['password'])){
    $username = mysqli_real_escape_string($db, strip_tags(clean($_COOKIE['username'])));
    $password = mysqli_real_escape_string($db, strip_tags(clean($_COOKIE['password'])));
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            mysqli_free_result($results);
    gc_collect_cycles();
    
            $find_id_query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $id_query_result = mysqli_query($db, $query);
            $id_query_result = mysqli_fetch_assoc($id_query_result);
    gc_collect_cycles();

            if (empty($id_query_result['uniqueId'])) {array_push($errors, "Id Not Found");}
            $_SESSION['username'] = $username;
            $_SESSION['image'] = $id_query_result['picture'];
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['id'] = $id_query_result['uniqueId'];
            $_SESSION['plus'] = $id_query_result['plus'];
            
            mysqli_free_result($id_query_result);
            $ipaddress = $_SERVER["REMOTE_ADDR"];
            function ip_details($ip) {
                $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
                $details = json_decode($json);
                return $details;
            }
            $details = ip_details($ipaddress);
            $loc =  $details->loc;
            $uniqueToken = md5(uniqid()).md5(uniqid()).date();
            $time = date('Y-m-d H:i:s');
            $ipaddress = str_replace('.','-',$details->ip);
            $query  = "INSERT INTO `logins`(`ip`, `username`, `time`, `uniqueToken`, `loc`) VALUES ('$ipaddress','$username','$time','$uniqueToken','$loc');";
            mysqli_query($db,$query);
            mysqli_close($db);
            header("location: index.php");
            exit;
        }   else {array_push($errors, "Wrong username/password combination!");echo '<script>window.history.back();</script>';}
    }
    
}
    gc_collect_cycles();

// REGISTER USER
if (isset($_POST['reg_user'])) {
    // receive all input values from the form
    $id = uniqid();
    //
    $username = mysqli_real_escape_string($db, strip_tags(clean( $_POST['username'])));
    $email = mysqli_real_escape_string($db, strip_tags(clean($_POST['email'])));
    $password_1 = mysqli_real_escape_string($db, strip_tags(clean($_POST['password_1'])));
    $password_2 = mysqli_real_escape_string($db, strip_tags(clean($_POST['password_2'])));
    //
    $uniqueId = mysqli_real_escape_string($db, $id);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($uniqueId)) { array_push($errors, "Somthing went wrong"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    gc_collect_cycles();

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
        if ($user['username'] === $username) {
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
            array_push($errors, "email already exists");
        }
    }
    gc_collect_cycles();

    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = md5($password_1);//encrypt the password before saving in the database
        $AUTO = md5(uniqid());
        $url = 'https://ui-avatars.com/api/?color=FFFFFF&background='.random_color().'&format=png&size=250&rounded=true&length=2&uppercase=true&name='.$username;
        $img = '../user-AccountImages/'.$AUTO.'.png';
        $imageFile = $AUTO.'.png';
        file_put_contents($img, file_get_contents($url));
        
        $query = "INSERT INTO `users` (username, email, password, uniqueId, picture) 
  			  VALUES('$username', '$email', '$password','$uniqueId','$imageFile')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['id'] = $uniqueId;
        $_SESSION['image'] = $imageFile;
        $_SESSION['plus'] = '0';
        $query = "INSERT INTO `folders` (parent, childern, shared, owner, name) 
  			  VALUES('$uniqueId', '', '', '$username', 'My Drive')";
        mysqli_query($db, $query);
//Adding Session Info
        $ipaddress = $_SERVER["REMOTE_ADDR"];
        function ip_details($ip) {
            $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
            $details = json_decode($json);
            return $details;
        }
        $details = ip_details($ipaddress);
        $loc =  $details->loc;
        $uniqueToken = md5(uniqid()).md5(uniqid()).date();
        $time = date('Y-m-d H:i:s');
        $ipaddress = str_replace('.','-',$details->ip);
        $query  = "INSERT INTO `logins`(`ip`, `username`, `time`, `uniqueToken`, `loc`) VALUES ('$ipaddress','$username','$time','$uniqueToken','$loc');";
        mysqli_query($db,$query);
//Adding Session Info
        if (!file_exists('user-files/'.$_SESSION['id'])) {
           // mkdir('user-files/'.$_SESSION['id'], 0777, true);
        }
    gc_collect_cycles();
        	setcookie ("username",$_SESSION["username"],time()+ 3600);
        	setcookie ("password",strip_tags(clean($_POST['password_1'])),time()+ 3600);
        
        mysqli_close($db);
        //header('location: ../index.php?id='.$uniqueId);
        header('location: ./index.php');
    }
}
    gc_collect_cycles();

// ... 
if (isset($_POST['login_user'])) {

    $username = mysqli_real_escape_string($db, strip_tags(clean($_POST['username'])));
    $password = mysqli_real_escape_string($db, strip_tags(clean($_POST['password'])));
    if (empty($username)) {
        array_push($errors, "Username is required");
    }
    gc_collect_cycles();
    if (empty($password)) {
        array_push($errors, "Password is required");
    }
    if (count($errors) == 0) {
        $password = md5($password);
        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
        if (mysqli_num_rows($results) == 1) {
            //

            $find_id_query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $id_query_result = mysqli_query($db, $query);
            $id_query_result = mysqli_fetch_assoc($id_query_result);

            if (empty($id_query_result['uniqueId'])) {array_push($errors, "Id Not Found");}
            //
            $_SESSION['username'] = $username;
            $_SESSION['image'] = $id_query_result['picture'];
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['id'] = $id_query_result['uniqueId'];
            $_SESSION['plus'] = $id_query_result['plus'];
    gc_collect_cycles();
            
            mysqli_free_result($id_query_result);
            //header('location: ../index.php?id='.$id_query_result['uniqueId']);
//Adding Session Info
            $ipaddress = $_SERVER["REMOTE_ADDR"];
            function ip_details($ip) {
                $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
                $details = json_decode($json);
                return $details;
            }
            $details = ip_details($ipaddress);
            $loc =  $details->loc;
            $uniqueToken = md5(uniqid()).md5(uniqid()).date();
            $time = date('Y-m-d H:i:s');
            $ipaddress = str_replace('.','-',$details->ip);
            $query  = "INSERT INTO `logins`(`ip`, `username`, `time`, `uniqueToken`, `loc`) VALUES ('$ipaddress','$username','$time','$uniqueToken','$loc');";
            mysqli_query($db,$query);
    gc_collect_cycles();
//Adding Session Info
	setcookie ("username",$_SESSION["username"],time()+ 3600);
	setcookie ("password", strip_tags(clean($_POST['password'])),time()+ 3600);

            header("location: ./index.php");
            exit;
            //echo '<script>window.history.back();</script>'
        }else {
            array_push($errors, "Wrong username/password combination!");
            echo '<script>window.history.back();</script>';
    gc_collect_cycles();
        }
    }
    
    mysqli_close($db);
    gc_collect_cycles();
}
//Continue With Kabeer's Network
//SignUp

if($_GET['action']=="signup"){
    // receive all input values from the form
    $AutoGenPassword = strip_tags(clean($_GET['password']));
    
    $id = uniqid();
    $username = mysqli_real_escape_string($db, strip_tags(clean($_GET['username'])));
    $email = mysqli_real_escape_string($db, strip_tags(clean($_GET['email'])));
    $password_1 = mysqli_real_escape_string($db, $AutoGenPassword);
    $password_2 = mysqli_real_escape_string($db, $AutoGenPassword);
    
    $uniqueId = mysqli_real_escape_string($db, $id);

    // form validation: ensure that the form is correctly filled ...
    // by adding (array_push()) corresponding error unto $errors array
    if (empty($username)) { array_push($errors, "Username is required"); }
    if (empty($email)) { array_push($errors, "Email is required"); }
    if (empty($uniqueId)) { array_push($errors, "Somthing went wrong"); }
    if (empty($password_1)) { array_push($errors, "Password is required"); }
    if ($password_1 != $password_2) {
        array_push($errors, "The two passwords do not match");
    }
    gc_collect_cycles();

    // first check the database to make sure
    // a user does not already exist with the same username and/or email
    $user_check_query = "SELECT * FROM users WHERE username='$username' OR email='$email' LIMIT 1";
    $result = mysqli_query($db, $user_check_query);
    $user = mysqli_fetch_assoc($result);

    if ($user) { // if user exists
    if ($user['username'] === $username) {
        echo '<script>window.history.back();</script>';
            array_push($errors, "Username already exists");
        }

        if ($user['email'] === $email) {
echo '<script>window.history.back();</script>';
            array_push($errors, "email already exists");
        }
    }
    gc_collect_cycles();
    // Finally, register user if there are no errors in the form
    if (count($errors) == 0) {
        $password = $password_1;
        //encrypt the password before saving in the database
        $auto = md5(uniqid());
        $fileUser = $username;
        $url = 'https://kabeerjaffri.000webhostapp.com/user-AccountImages/'.$_GET['img'];
        $imageFile = $auto.'.png';
        copy($url, '.././user-AccountImages/'.$auto.'.png');
        $query = "INSERT INTO `users` (username, email, password, uniqueId, picture,regKnet) 
  			  VALUES('$username', '$email', '$password','$uniqueId','$imageFile', '1')";
        mysqli_query($db, $query);
        $_SESSION['username'] = $username;
        $_SESSION['success'] = "You are now logged in";
        $_SESSION['id'] = $uniqueId;
        $_SESSION['image'] = $imageFile;
        $_SESSION['plus'] = '0';
        $query = "INSERT INTO `folders` (parent, childern, shared, owner, name) 
  			  VALUES('$uniqueId', '', '', '$username', 'My Drive')";
        mysqli_query($db, $query);
//Adding Session Info
        $ipaddress = $_SERVER["REMOTE_ADDR"];
        function ip_details($ip) {
            $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
            $details = json_decode($json);
            return $details;
        }
        $details = ip_details($ipaddress);
        $loc =  $details->loc;
        $uniqueToken = md5(uniqid()).md5(uniqid()).date();
        $time = date('Y-m-d H:i:s');
        $ipaddress = str_replace('.','-',$details->ip);
        $query  = "INSERT INTO `logins`(`ip`, `username`, `time`, `uniqueToken`, `loc`) VALUES ('$ipaddress','$username','$time','$uniqueToken','$loc');";
        mysqli_query($db,$query);
    gc_collect_cycles();
//Adding Session Info
        if (!file_exists('user-files/'.$_SESSION['id'])) {
       //     mkdir('user-files/'.$_SESSION['id'], 0777, true);
        }
	setcookie ("username",$_SESSION["username"],time()+ 3600);
	setcookie ("password",$AutoGenPassword,time()+ 3600);


            mysqli_close($db);
        //header('location: ../index.php?id='.$uniqueId);
        header('location: ../index.php');
    }

}
//Login
if($_GET['action']=="login") {

    // receive all input values from the form
    $username = mysqli_real_escape_string($db, strip_tags(clean($_GET['username'])));
    $password = mysqli_real_escape_string($db, strip_tags(clean($_GET['password'])));

    if (empty($username)) {
echo '<script>window.history.back();</script>';
        array_push($errors, "Username is required");
    }
    if (empty($password)) {
echo '<script>window.history.back();</script>';
        array_push($errors, "Password is required");
    }

        $query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
        $results = mysqli_query($db, $query);
    gc_collect_cycles();
        if (mysqli_num_rows($results) == 1) {
            //

            $find_id_query = "SELECT * FROM users WHERE username='$username' AND password='$password'";
            $id_query_result = mysqli_query($db, $query);
            $id_query_result = mysqli_fetch_assoc($id_query_result);

            if (empty($id_query_result['uniqueId'])) {array_push($errors, "Id Not Found");}
            
            $_SESSION['username'] = $username;
            $_SESSION['success'] = "You are now logged in";
            $_SESSION['id'] = $id_query_result['uniqueId'];
            $_SESSION['plus'] = $id_query_result['plus'];
            $_SESSION['image'] = $id_query_result['picture'];
            //header('location: ../index.php?id='.$id_query_result['uniqueId']);
//Adding Session Info
            $ipaddress = $_SERVER["REMOTE_ADDR"];
            function ip_details($ip) {
                $json = file_get_contents("http://ipinfo.io/{$ip}/geo");
                $details = json_decode($json);
                return $details;
    gc_collect_cycles();
            }
            $details = ip_details($ipaddress);
            $loc =  $details->loc;
            $uniqueToken = md5(uniqid()).md5(uniqid()).date();
            $time = date('Y-m-d H:i:s');
            $ipaddress = str_replace('.','-',$details->ip);
            $query  = "INSERT INTO `logins`(`ip`, `username`, `time`, `uniqueToken`, `loc`) VALUES ('$ipaddress','$username','$time','$uniqueToken','$loc');";
            mysqli_query($db,$query);
//Adding Session Info
	setcookie ("username",$_SESSION["username"],time()+ 3600);
	setcookie ("password",strip_tags(clean($_GET['password'])),time()+ 3600);

            mysqli_close($db);
            header("location: ../index.php");
            exit;
            //echo '<script>window.history.back();</script>'
        }else {
echo '<script>window.history.back();</script>';
            array_push($errors, "Wrong username/password combination");
        }
    gc_collect_cycles();
}
?>
<?php include("activeusers/active_users_record.php");     gc_collect_cycles();?>
