<?php

include "support/db-coop.inc";
require_once("phpvalidator/validation.class.php");
require_once("support/encryptionb.php");
session_start();
session_regenerate_id (true);
$obj = new validation();

$good = 1;
$ballot = trim($_REQUEST['ballot']);
$lastname = trim($_REQUEST['lname']);

$obj->add_fields($ballot,'req',"Ballot Code is required");
$obj->add_fields($ballot,'min=10','Ballot Code has to be an 10 digit number');
$obj->add_fields($lastname,'req','Lastname is required');

$error = $obj->validate();

$my = new mysqli($host,$db_username,$db_password,$db_name);

$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();
if ($rs->num_rows == 0){
	$good = 0;
}

$ln = $row['LastName'];
$ln = str_replace("\'", "'", $ln);

$ln2 = str_replace("\'", "'", $lastname);

if(strcasecmp(trim($ln),$ln2) != 0){
	$good = 0;
}


if($good == 1 && !$error){
		$_SESSION["ballot"]=encrypt($ballot, '%E%uN~}BCL');
		//header("Location: https://irm.cpvr.com/vote/ballot.php?session=".encrypt($ballot, '%E%uN~}BCL'));
		header("Location: ballot.php");
   	exit;
}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles/output.css" />
<title>Vote</title>
</head>

<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 mx-auto w-1/2">
<div class="grid grid-cols-4 gap-2">
	<?php
	if($error){
		echo '<div class="col-span-4 md:text-1xl lg:text-4xl text-center text-red-500"> Error with supplied information</div>
					<div class="col-span-4">&nbsp;</div>
					<div class="col-span-4">Please review error(s) and go back</div>
					<div class="col-span-4">&nbsp;</div>
					<div class="col-span-4">'.$error.'</div>';
	}
	else if($good == 0){
		echo '<div class="col-span-4 md:text-1xl lg:text-4xl text-center text-red-500">Error with supplied information</div>
					<div class="col-span-4">&nbsp;</div>
					<div class="col-span-4">Please review error(s) and go back</div>
					<div class="col-span-4">&nbsp;</div>
					<div class="col-span-4">Information does not match</div>';
	}
	?>
</div>
</div>
</body>
</html>
