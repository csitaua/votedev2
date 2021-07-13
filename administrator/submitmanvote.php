<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
include 'dbc.php';
page_protect();

if(!checkVotelevel()){
	header("Location: index.php");
	exit();
}
$my = new mysqli($host,$db_username,$db_password,$db_name);

$proxy = 'Manual Vote';

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

$ballot = $_REQUEST['ballot'];

$tnow = date("Y-m-d H:i:s");

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


$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();
echo $my->error.'</br>'.$sql;
if($rs->num_rows == 0){
	echo '<script type="text/javascript"> alert("Please check Ballot Number");javascript: history.go(-1);</script>';
}

if($row['Vote']){
	echo '<script type="text/javascript"> alert("This ballot number has already voted");javascript: history.go(-1);</script>';
}
else{
	$q_update = $my->real_escape_string($q_update);
	$sql2 = "UPDATE vote SET Vote = 1 ".$q_update.", Proxy = '$proxy', `ManEntry` = 0, `Time` = '$tnow', `ipaddress`='$ipaddress', `ManEntry`=1 WHERE ballot = '$ballot'";
	$my->query($sql2);
	$user =  $_SESSION['user_name'];
	$sql2 = "INSERT INTO manvote (ballot, user) VALUES ('$ballot','$user')";
	$my->query($sql2);
	header("Location: index.php");
    exit;
}

?>
