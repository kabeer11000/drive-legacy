<?php

// ###############  SET UP THE VARIABLES  ########################################

// FOLDER USED TO STORE TEMPORAL FILES
//    IMPORTANT: the folder must have proper permissions to allow writing files
//    The name of the temporal files contains the IP address of the user
//    ($_SERVER["DOCUMENT_ROOT"] is the root folder for the website)
$folder=$_SERVER["DOCUMENT_ROOT"]."/users_rZO2CZUMK6/";

// TIME SINCE LAST ACTIVITY OF AN USERS TO BE CONSIDERED NON-ACTIVE
$timeold=300;   // seconds

// ###############  THE WORKING PART OF THE SCRIPT ##############################

// DO NOT SHOW ERRORS TO VISITORS (just in case)
error_reporting(0);

// GET ACTUAL TIME
$actualtime=date("U");   // seconds since January 1st, 1970.

// GET IP ADDRESS OF USER (a function in the bottom is used)
$ip=getIP();

// REGISTER THE USER
//      A file will be created. The name of the file will contain the IP of the user.
//      In case the file already exists, it will be overwritted.
//      The creation time of the file will indicate how long ago the user
//              with this IP visited a page containing this active users counter
        // OPTION 1, for PHP4 or superior
        $cf = fopen($folder.$ip, "w");
        fwrite($cf, "");
        fclose($cf);
        // OPTION 2, for PHP5 or superior
        // file_put_contents ($folder."$ip.txt", "0");

// COUNT NUMBER OF ACTIVE USERS
//      All files within folder $folder will be checked
//      Files $timeold seconds old (defined above) will be deleted
//      Files created up to $timeold seconds ago will be accounted as active users

        // a counter; no users at this moment
        $counter=0;
        // get the list of files within $folder
        $dir = dir($folder);
        // check all files one by one (variable $temp will be the name of each file)
        while($temp = $dir->read()){
                // the ones bellow are not files, so continue to next $temp
                if ($temp=="." or $temp==".."){continue;}
                // For real files, get the last modification time
                //   (number of seconds since January 1st, 1970)
                //    and save the data to variable $filecreatedtime
                $filecreatedtime=date("U", filemtime($folder.$temp));
                // check whether the file is $timeold seconds old
                if ($actualtime>($filecreatedtime+$timeold)){
                        // the file IS old, so delete it
                        unlink ($folder.$temp);                                                                   //
                }else{
                        // the file IS NOT old, so an active user will be accounted
                        $counter++;
        }
}
// DISPLAY NUMBER OF ACTIVE USERS
        // Option 1  (displays only the number of active users)
        //print "Users online: $counter";
        // Option 2  (displays number of active users, and defines how old an active user is in seconds).
        // print "Users online: $counter (in last $timeold seconds)";
        // Option 3  (displays number of active users, and defines how old an active user is in minutes).
        $minutes=round($timeold/60);
        print "$counter";

// ########################  FUNCTIONS  #########################################
// funtion getIP will be used to get IP address of visitor
function getIP() {
        // Option 1 to get the IP address of visitor
        //      if a value for $_SERVER['HTTP_X_FORWARDED_FOR'] is available
        //      $ip is obtained and returned
        if(isset($_SERVER['HTTP_X_FORWARDED_FOR'])){
                $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
                return $ip;
        }
        // Option 2 to get the IP address of visitor
        //      if a value for $_SERVER['REMOTE_ADDR'] is available
        //      $ip is obtained and returned
        if(isset($_SERVER['REMOTE_ADDR'])){
                $ip = $_SERVER['REMOTE_ADDR'];
                return $ip;
        }
        // IP has not been obtained, so a default IP is returned
        //      The default value will be used very few times, so
        return "0.0.0.0";
}

?>