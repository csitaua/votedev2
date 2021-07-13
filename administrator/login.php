<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
/*************** PHP LOGIN SCRIPT V 2.3*********************
(c) Balakrishnan 2009. All Rights Reserved

Usage: This script can be used FREE of charge for any commercial or personal projects. Enjoy!

Limitations:
- This script cannot be sold.
- This script should have copyright notice intact. Dont remove it please...
- This script may not be provided for download except from its original site.

For further usage, please contact me.

***********************************************************/
include 'dbc.php';
$my = new mysqli($host,$db_username,$db_password,$db_name);
$err = array();

foreach($_GET as $key => $value) {
	$get[$key] = filter($value); //get variables are filtered.
}

if ($_POST['doLogin']=='Login')
{

foreach($_POST as $key => $value) {
	$data[$key] = filter($value); // post variables are filtered
}


$user_email = $data['usr_email'];
$pass = $data['pwd'];


if (strpos($user_email,'@') === false) {
    $user_cond = "user_name='$user_email'";
} else {
      $user_cond = "user_email='$user_email'";

}


$result = $my->query("SELECT `id`,`pwd`,`full_name`,`approved`,`user_level` FROM users WHERE
           $user_cond
			AND `banned` = '0'
			");
$num = $result->num_rows;

  // Match row found with more than 1 results  - the user is authenticated.
    if ( $num > 0 ) {
		$row = $result->fetch_assoc();
		//list($id,$pwd,$full_name,$approved,$user_level) = $row;
		$id = $row['id'];
		$pwd = $row['pwd'];
		$full_name = $row['full_name'];
		$approved = $row['approved'];
		$user_level = $row['user_level'];

		if(!$approved) {
			$err[] = "Account not activated. Please check your email for activation code";
		 }

		//check against salt
	if ($pwd === PwdHash($pass,substr($pwd,0,9))) {
	if(empty($err)){

     // this sets session and logs user in
       session_start();
	   session_regenerate_id (true); //prevent against session fixation attacks.

	   // this sets variables in the session
		$_SESSION['user_id']= $id;
		$_SESSION['user_name'] = $full_name;
		$_SESSION['user_level'] = $user_level;
		$_SESSION['HTTP_USER_AGENT'] = md5($_SERVER['HTTP_USER_AGENT']);

		//update the timestamp and key for cookie
		$stamp = time();
		$ckey = GenKey();
		$my->query("update users set `ctime`='$stamp', `ckey` = '$ckey' where id='$id'");

		//set a cookie

	   if(isset($_POST['remember'])){
				  setcookie("user_id", $_SESSION['user_id'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_key", sha1($ckey), time()+60*60*24*COOKIE_TIME_OUT, "/");
				  setcookie("user_name",$_SESSION['user_name'], time()+60*60*24*COOKIE_TIME_OUT, "/");
				   }
		  header("Location: index.php");
		 }
		}
		else
		{
		//$msg = urlencode("Invalid Login. Please try again with correct user email and password. ");
		$err[] = "Invalid Login. Please try again with correct user email and password.";
		//header("Location: login.php?msg=$msg");
		}
	} else {
		$err[] = "Error - Invalid login. No such user exists";
	  }
}



?>
<html>
<head>
<title>Members Login</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="js/jquery-1.3.2.min.js"></script>
<script language="JavaScript" type="text/javascript" src="js/jquery.validate.js"></script>
  <script>
  $(document).ready(function(){
    $("#logForm").validate();
  });
  </script>
<link rel="stylesheet" type="text/css" href="../styles/output.css" />

</head>

<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 mx-auto w-1/2">
<table class="w-full p-5">
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
  <tr>
    <td class="w-1/6"><p>&nbsp;</p>
      <p>&nbsp; </p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p></td>
    <td class="w-5/6 text-2xl font-bold">Login User
	  <?php
	  /******************** ERROR MESSAGES*************************************************
	  This code is to show error messages
	  **************************************************************************/
	  if(!empty($err))  {
	   echo "<div class=\"msg\">";
	  foreach ($err as $e) {
	    echo "$e <br>";
	    }
	  echo "</div>";
	   }
	  /******************************* END ********************************/
	  ?></p>
      <form action="login.php" method="post" name="logForm" id="logForm" >
        <table width="65%" border="0" cellpadding="4" cellspacing="4" class="loginform">
          <tr>
            <td colspan="2">&nbsp;</td>
          </tr>
          <tr>
            <td width="28%">Username / Email</td>
            <td width="72%"><input name="usr_email" type="text" class="required" id="txtbox" size="25"></td>
          </tr>
          <tr>
            <td>Password</td>
            <td><input name="pwd" type="password" class="required password" id="txtbox" size="25"></td>
          </tr>
          <tr>
            <td colspan="2"><div align="center">
                <input name="remember" type="checkbox" id="remember" value="1">
                Remember me</div></td>
          </tr>
          <tr>
            <td colspan="2"> <div align="center">
                  <input name="doLogin" type="submit" id="doLogin3" value="Login" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full">
              </div></td>
          </tr>
        </table>
        <div align="center"></div>
        <p align="center">&nbsp; </p>
      </form>
      <p>&nbsp;</p>

      </td>
    <td width="196" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3">&nbsp;</td>
  </tr>
</table>
</div>
</body>
</html>
