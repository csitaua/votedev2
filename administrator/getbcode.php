<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'dbc.php';
page_protect();
include "../support/db-coop.inc";
$my = new mysqli($host,$db_username,$db_password,$db_name);
if(!checkReslevel()){
	header("Location: index.php");
	exit();
}

$mem = $_REQUEST['member'];

$sql = "SELECT * FROM vote WHERE OwnerNumber = '$mem'";
$rs = $my->query($sql);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../styles/output.css" />
<title>Get Ballot Code</title>
</head>

<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 m-4 mx-auto w-1/2 border-2 border-black">
<div align="center">
	<table class="w-full p-6" >
		<tr>
    		<td colspan="4" class="text-2xl font-bold text-center">Get ballot code</td>
    	</tr>
        <tr>
        	<td colspan="4" align="right"><a href="index.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Back</a> &nbsp; &nbsp; <a href="logout.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Logout </a></td>
        </tr>
        <?php

			if($rs->num_rows == 0){
				echo '
					<tr>
						<td colspan="4">
							Please check owner number system could not find owner with owner number '.$mem.'
						</td>
					</tr>
				';
			}
			else{
				$row = $rs->fetch_assoc();
				echo '
					<tr>
						<td class="w-1/6 p-2 text-right">
							Last name:
						</td>
						<td colspan="3" class="p2 font-medium">
							'.$row['LastName'].'
						</td>
					</tr>
					<tr>
						<td class="w-1/6 p-2 text-right">
							Ballot Code:
						</td>
						<td colspan="3" class="p2 font-medium">
							'.$row['ballot'].'
						</td>
					</tr>
					<tr>
						<td class="w-1/6 p-2 text-right">
							Voting share:
						</td>
						<td colspan="3" class="p2 font-medium">
							'.$row['VoteShare'].'
						</td>
					</tr>
				';
			}

		?>

   	</table>
</div>
</body>
</html>
