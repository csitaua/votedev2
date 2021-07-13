<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();

require_once "support/encryptionb.php";
include "support/db-coop.inc";

$session = $_SESSION['ballot'];
$ballot = decrypt($session, '%E%uN~}BCL');

$my = new mysqli($host,$db_username,$db_password,$db_name);
$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();

if($rs->num_rows == 0){
	header("Location: index.php");
  exit;
}


$sql2 = "SELECT * FROM voting_points order by id ASC";
$rs2 = $my->query($sql2);
$q_update='';
while ($vp = $rs2->fetch_assoc()){
  $tid = $vp['id'];
  if(isset($_REQUEST['point'.$tid])){
    $p[$tid] = $_REQUEST['point'.$tid];
  }
  else{
    $p[$tid] = -1;
  }
  $q_update = $q_update.', Point'.$tid.' = '.$p[$tid];
}
$proxy = 'Online';

$tnow = date("Y-m-d H:i:s");

//Get Ip address
$ipaddress = '';
if (!empty($_SERVER['HTTP_CLIENT_IP']))
	$ipaddress = $_SERVER['HTTP_CLIENT_IP'];
else if(!empty($_SERVER['HTTP_X_FORWARDED_FOR']))
	$ipaddress = $_SERVER['HTTP_X_FORWARDED_FOR'];
else if(!empty($_SERVER['HTTP_X_FORWARDED']))
	$ipaddress = $_SERVER['HTTP_X_FORWARDED'];
else if(!empty($_SERVER['HTTP_FORWARDED_FOR']))
	$ipaddress = $_SERVER['HTTP_FORWARDED_FOR'];
else if(!empty($_SERVER['HTTP_FORWARDED']))
	$ipaddress = $_SERVER['HTTP_FORWARDED'];
else if(!empty($_SERVER['REMOTE_ADDR']))
	$ipaddress = $_SERVER['REMOTE_ADDR'];
else
	$ipaddress = 'UNKNOWN';


if($row['Vote']){
	echo '<script type="text/javascript"> alert("You have already voted");javascript: history.go(-1);</script>';
}
else{
  $q_update = $my->real_escape_string($q_update);
	$sql2 = "UPDATE vote SET Vote = 1 ".$q_update.", Proxy = '$proxy', `ManEntry` = 0, `Time` = '$tnow', `ipaddress`='$ipaddress' WHERE ballot = '$ballot'";
	if(!$my->query($sql2)){
    printf('Error 102, please contact Caribbean Palm Village Resort.');
  }
  else{
	   header("Location: ballot.php");
     exit;
  }
}
?>
