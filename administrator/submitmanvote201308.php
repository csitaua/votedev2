<?php 
include 'dbc.php';
page_protect();

if(!checkVotelevel()){
	header("Location: index.php");
	exit();	
}
include "../support/connect.php";

$proxy = 'Manual Vote';
$p1 = $_REQUEST['point1'];
$p2 = $_REQUEST['point2'];
$p3 = $_REQUEST['point3'];
$p4 = $_REQUEST['point4'];
$p5 = $_REQUEST['point5'];
$p6 = $_REQUEST['point6'];
$p7 = $_REQUEST['point7'];
$p8 = $_REQUEST['point8'];
$p9 = $_REQUEST['point9'];
$ballot = $_REQUEST['ballot'];


if(!$p1){
	$p1 = -1;;	
}
if(!$p2){
	$p2 = -1;;	
}
if(!$p3){
	$p3 = -1;;	
}
if(!$p4){
	$p4 = -1;;	
}
if(!$p5){
	$p5 = -1;;	
}
if(!$p6){
	$p6 = -1;;	
}
if(!$p7){
	$p7 = -1;;	
}
if(!$p8){
	$p8 = -1;;	
}
if(!$p9){
	$p9 = -1;;	
}

$tnow = date("Y-m-d H:i:s");


$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);

if(mysql_num_rows($rs) == 0){
	echo '<script type="text/javascript"> alert("Please check Ballot Number");javascript: history.go(-1);</script>';
}

if($row['Vote']){
	echo '<script type="text/javascript"> alert("This ballot number has already voted");javascript: history.go(-1);</script>';
}
else{
	$sql2 = "UPDATE vote SET Vote = 1, Point1 = '$p1', Point2 = '$p2', Point3 = '$p3', Point4 = '$p4', Point5 = '$p5', Point6 = '$p6', Point7 = '$p7', Point8 = '$p8', Point9 = '$p9', Proxy = '$proxy', `ManEntry` = 0, `Time` = '$tnow', `ipaddress`='$ipaddress', `ManEntry`=1 WHERE ballot = '$ballot'";
	mysql_query($sql2);	
	$user =  $_SESSION['user_name'];
	$sql2 = "INSERT INTO manvote (ballot, user) VALUES ('$ballot','$user')";
	mysql_query($sql2);	
	header("Location: https://192.168.1.16/vote/administrator/index.php");
    exit;	
}

?>
