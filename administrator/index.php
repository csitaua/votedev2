<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
include 'dbc.php';
page_protect();
include "../support/db-coop.inc";
$my = new mysqli($host,$db_username,$db_password,$db_name);
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../styles/output.css" />
<title>Voting Administration</title>
</head>

<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 m-4 mx-auto w-1/2 border-2 border-black">
	<table class="w-full p-6" >
		<tr>
    		<td colspan="4" class="text-2xl font-bold text-center p-2">Voting Administration</td>
    	</tr>
        <tr>
        	<td colspan="4" class="text-right p-2"><a href="myaccount.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">My Account</a> &nbsp; &nbsp; <a href="logout.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Logout </a></td>
        </tr>
        <?php
			$now = date("F j, Y, g:i a");
			$voteendstring = date("F j, Y, g:i a",$voteend);
			if(checkVotelevel()){

				echo '
					<tr>
    					<td class="w-1/6 p-2">Enter Vote</td>
						<td colspan="3" class="p-2">
							<a href="manvote.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Enter votes manually</a>
						</td>
    				</tr>'
				;
			}
			if(checkReslevel()){
				$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` ";
				$rs = $my->query($sql);
				$row = $rs->fetch_assoc();
				$totalvshare = $row['tvs'];
				$qourum =  floor(($totalvshare/2)) + 1;
				$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1";
				$rs = $my->query($sql);
				$row = $rs->fetch_assoc();
				$totalvsharevoted = $row['tvs'];
				$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1 AND `ManEntry` = 0";
				$rs = $my->query($sql);
				$row = $rs->fetch_assoc();
				$totalvsharevotede = 0+$row['tvs'];
				$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1 AND `ManEntry` = 1";
				$rs = $my->query($sql);
				$row = $rs->fetch_assoc();
				$totalvsharevotedman = 0+$row['tvs'];
				$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 2";
				$rs = $my->query($sql);
				$row = $rs->fetch_assoc();
				$totalvshareannulled = 0+$row['tvs'];
				echo '
					<tr>
						<form name="getballotcode" action="getbcode.php" method="post">
    					<td colspan="4" class="p-2">Check Ballot Code (Please Enter Member Number) &nbsp;
							<input type="text" name="member" maxlength="6" /> &nbsp;
							<input type="submit" value="Submit" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full" />
						</td>
						</form></tr>';

				if( checkAdmin() ){
					echo '
						<tr>
							<td class="w-1/6 p-2">Check Proxies</td>
							<td colspan="3" class="p-2">
								<a href="checkproxies.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Check Proxies</a>
							</td>
						</tr>
						<tr>
							<td class="w-1/6 p-2">Annul Vote</td>
							<td colspan="3" class="p-2">
								<a href="annulvote.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Annul vote</a>
							</td>
						</tr>
						<tr>
							<td class="w-1/6 p-2">Manual Votes Conformation</td>
							<td colspan="3" class="p-2">
								<a href="manvoteconf.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Manual Votes Conformation</a>
							</td>
						</tr>
					';
				}
    			echo '
					<tr>
    					<td class="w-1/6 p-2">View Results</td>
						<td colspan="3" class="p-2">
							<a href="res.php" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-1 rounded-full">Voting Results Report</a>
						</td>
    				</tr>
					<tr>
						<td colspan="4" class="p-2">
							<table width="100%">
								<tr>
									<td width="150">Total Voting Shares:</td>
									<td width="75">'.$totalvshare.'</td>
									<td width="150">Qourum:</td>
									<td width="75">'.$qourum.'</td>
									<td width="150">Total of votes cast:</td>
									<td>'.$totalvsharevoted.'</td>
								</tr>
								<tr>
									<td>Electronic votes:</td>
									<td>'.$totalvsharevotede.'</td>
									<td>Manual votes entered:</td>
									<td>'.$totalvsharevotedman.'</td>
									<td>Annulled Votes</td>
									<td>'.$totalvshareannulled.'</td>

								</tr>
							</table>
						</td>
					</tr>
				';
			}
		?>
 	</table>
</div>
</body>
</html>
