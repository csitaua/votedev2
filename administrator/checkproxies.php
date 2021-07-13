<?php 
include 'dbc.php';
page_protect();
include "../support/connect.php";
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<title>Voting Administration</title>
</head>

<body>

<div align="center">
	<table width="800" border="1" cellpadding=6 cellspacing=0 >
		<tr>
    		<td colspan="4" style="font-size:175%" align="center">Proxies Verification</td>
    	</tr>
        <tr>
        	<td colspan="4" align="right"><a href="myaccount.php">My Account</a> &nbsp; &nbsp; <a href="logout.php">Logout </a></td>
        </tr>
        <?php
			if(checkAdmin()){
				echo '
					<tr>
						<td width="225">Proxy Verification Sheet</td>
						<td colspan="3">
							<a href="prlist.php">Proxy List</a>
						</td>
					</tr>
					<tr>
						<td>Select Elegible Proxies</td>
						<td colspan="3">
							<a href="eligible.php">Select Eligible</a>
						</td>
					</tr>
				';
			}
		?>
        
   	</table>   
</div>
</body>
</html>