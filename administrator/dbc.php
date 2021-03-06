<?php

include "../support/db-coop.inc";
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2010. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.


define("COOKIE_TIME_OUT", 10); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 9); // salt for password

//define ("ADMIN_NAME", "admin"); // sp

/* Specify user levels */
define ("ADMIN_LEVEL", 5);
define ("VOTEADM_LEVEL", 4);
define ("RES_LEVEL",3);
define ("USER_LEVEL", 1);
define ("GUEST_LEVEL", 0);

define("COOKIE_TIME_OUT", 1); //specify cookie timeout in days (default is 10 days)
define('SALT_LENGTH', 9); // salt for password


/*************** reCAPTCHA KEYS****************/
$publickey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";
$privatekey = "xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx";


/**** PAGE PROTECT CODE  ********************************
This code protects pages to only logged in users. If users have not logged in then it will redirect to login page.
If you want to add a new page and want to login protect, COPY this from this to END marker.
Remember this code must be placed on very top of any html or php page.
********************************************************/

function page_protect() {
session_start();
include "../support/db-coop.inc";
global $db;
$my = new mysqli($host,$db_username,$db_password,$db_name);
/* Secure against Session Hijacking by checking user agent */
if (isset($_SESSION['HTTP_USER_AGENT']))
{
    if ($_SESSION['HTTP_USER_AGENT'] != md5($_SERVER['HTTP_USER_AGENT']))
    {
        logout();
        exit;
    }
}

// before we allow sessions, we need to check authentication key - ckey and ctime stored in database

/* If session not set, check for cookies set by Remember me */
if (!isset($_SESSION['user_id']) && !isset($_SESSION['user_name']) )
{
	if(isset($_COOKIE['user_id']) && isset($_COOKIE['user_key'])){
	/* we double check cookie expiry time against stored in database */

	$cookie_user_id  = filter($_COOKIE['user_id']);
	$rs_ctime = $my->query("select `ckey`,`ctime` from `users` where `id` ='$cookie_user_id'");
  $row = $rs_ctime->fetch_assoc();
  $ckey = $row['ckey'];
  $ctime = $row['ctime'];
	//list($ckey,$ctime) = mysql_fetch_row($rs_ctime);
	// coookie expiry
	if( (time() - $ctime) > 60*60*24*COOKIE_TIME_OUT) {

		logout();
		}
/* Security check with untrusted cookies - dont trust value stored in cookie.
/* We also do authentication check of the `ckey` stored in cookie matches that stored in database during login*/

	 if( !empty($ckey) && is_numeric($_COOKIE['user_id']) && isUserID($_COOKIE['user_name']) && $_COOKIE['user_key'] == sha1($ckey)  ) {
	 	  session_regenerate_id(); //against session fixation attacks.

		  $_SESSION['user_id'] = $_COOKIE['user_id'];
		  $_SESSION['user_name'] = $_COOKIE['user_name'];
		/* query user level from database instead of storing in cookies */
      $rs = $my->query("select user_level from users where id='$_SESSION[user_id]'");
      $row = $rs->fetch_assoc();
      $user_level = $row['user_level'];
      //list($user_level) = mysql_fetch_row(mysql_query("select user_level from users where id='$_SESSION[user_id]'"));

		  $_SESSION['user_level'] = $user_level;
		  $_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

	   } else {
	   logout();
	   }

  } else {
	header("Location: login.php");
	exit();
	}
}
}



function filter($data) {
  include "../support/db-coop.inc";
	$data = trim(htmlentities(strip_tags($data)));
	if (get_magic_quotes_gpc())
	$data = stripslashes($data);
  $my = new mysqli($host,$db_username,$db_password,$db_name);
	$data = $my->real_escape_string($data);
  $my->close();
	return $data;
}



function EncodeURL($url)
{
$new = strtolower(ereg_replace(' ','_',$url));
return($new);
}

function DecodeURL($url)
{
$new = ucwords(ereg_replace('_',' ',$url));
return($new);
}

function ChopStr($str, $len)
{
    if (strlen($str) < $len)
        return $str;

    $str = substr($str,0,$len);
    if ($spc_pos = strrpos($str," "))
            $str = substr($str,0,$spc_pos);

    return $str . "...";
}

function isEmail($email){
  return preg_match('/^\S+@[\w\d.-]{2,}\.[\w]{2,6}$/iU', $email) ? TRUE : FALSE;
}

function isUserID($username)
{
	if (preg_match('/^[a-z\d_]{5,20}$/i', $username)) {
		return true;
	} else {
		return false;
	}
 }

function isURL($url)
{
	if (preg_match('/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i', $url)) {
		return true;
	} else {
		return false;
	}
}

function checkPwd($x,$y)
{
if(empty($x) || empty($y) ) { return false; }
if (strlen($x) < 4 || strlen($y) < 4) { return false; }

if (strcmp($x,$y) != 0) {
 return false;
 }
return true;
}

function GenPwd($length = 7)
{
  $password = "";
  $possible = "0123456789bcdfghjkmnpqrstvwxyz"; //no vowels

  $i = 0;

  while ($i < $length) {


    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);


    if (!strstr($password, $char)) {
      $password .= $char;
      $i++;
    }

  }

  return $password;

}

function GenKey($length = 7)
{
  $password = "";
  $possible = "0123456789abcdefghijkmnopqrstuvwxyz";

  $i = 0;

  while ($i < $length) {


    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);


    if (!strstr($password, $char)) {
      $password .= $char;
      $i++;
    }

  }

  return $password;

}


function logout()
{
include "../support/db-coop.inc";
global $db;
session_start();
$my = new mysqli($host,$db_username,$db_password,$db_name);
if(isset($_SESSION['user_id']) || isset($_COOKIE['user_id'])) {
$my->query("update `users`
			set `ckey`= '', `ctime`= ''
			where `id`='$_SESSION[user_id]' OR  `id` = '$_COOKIE[user_id]'");
}

/************ Delete the sessions****************/
unset($_SESSION['user_id']);
unset($_SESSION['user_name']);
unset($_SESSION['user_level']);
unset($_SESSION['HTTP_USER_AGENT']);
session_unset();
session_destroy();

/* Delete the cookies*******************/
setcookie("user_id", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_name", '', time()-60*60*24*COOKIE_TIME_OUT, "/");
setcookie("user_key", '', time()-60*60*24*COOKIE_TIME_OUT, "/");

header("Location: login.php");
}

// Password and salt generation
function PwdHash($pwd, $salt = null)
{
    if ($salt === null)     {
        $salt = substr(md5(uniqid(rand(), true)), 0, SALT_LENGTH);
    }
    else     {
        $salt = substr($salt, 0, SALT_LENGTH);
    }
    return $salt . sha1($pwd . $salt);
}

function checkAdmin() {

	if($_SESSION['user_level'] == ADMIN_LEVEL) {
		return 1;
	}
	else {
		return 0 ;
	}
}

function checkVotelevel(){
	if($_SESSION['user_level'] >= VOTEADM_LEVEL) {
		return 1;
	}
	else {
		 return 0 ;
	}
}

function checkReslevel(){
	if($_SESSION['user_level'] >= RES_LEVEL) {
		return 1;
	}
	else {
		 return 0 ;
	}
}

?>
