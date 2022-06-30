<?php

//error_reporting(E_ALL);
//ini_set('display_errors', '1');

require_once "support/encryptionb.php";
include "support/db-coop.inc";
session_start();

$session = $_SESSION['ballot'];
$error = 0;

$my = new mysqli($host,$db_username,$db_password,$db_name);

$ballot = decrypt($session, '%E%uN~}BCL');
$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();

if($rs->num_rows == 0){
	$error = 1;
	header("Location: index.php");
   exit;
}

if(isset($_POST['download_document'])) {
		$file = 'docs/2022.pdf';
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename=' . basename($file));
    header('Content-Transfer-Encoding: binary');
    header('Expires: 0');
    header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file));
    ob_clean();
    flush();
    readfile($file);
    exit;
}

if(isset($_POST['exit_button'])){
	session_unset();
	session_destroy();
	header("Location: index.php");
  exit;
}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script src="js/scripts.js"></script>
<script type="text/javascript">

	function checkBallot(){

		if(!document.ballot.agreement.checked){
			alert('You cannot vote since you have not checked the agreement box');
			return false;
		}

		<?php
			$sql2 = "SELECT * FROM voting_points order by id ASC";
			$rs2 = $my->query($sql2);
			$t = '';
			while ($vp = $rs2->fetch_assoc()){
				$sql3 = 'SELECT * FROM voting_points_options WHERE voting_points_id = '.$vp['id'].' order by location ASC';
				$rs3 = $my->query($sql3);
				$nrows = $rs3->num_rows;
				$trows = 0;
				if($t ==''){
					$t = $t.'(';
				}
				else{
					$t = $t.' || (';
				}
				while ($nrows != $trows){
					if($trows == 0){
						$t = $t.'!document.ballot.point'.$vp['id'].'['.$trows.'].checked';
					}
					else{
						$t = $t.' && !document.ballot.point'.$vp['id'].'['.$trows.'].checked';
					}
					$trows++;
			 }

			 $t = $t.')';
		}
		?>
		if( <?php echo $t; ?> ){
			var answer = confirm('You have not voted on all items, do you want to continue?');
			if(answer){

			}
			else{
				return false;
			}
		}

		return true;
	};
</script>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="styles/output.css" />
<title>CPVR Online Voting</title>
</head>
<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 mx-auto w-4/6">
<table width="100%" border="1" cellpadding=6 cellspacing=0 >
	<tr>
    	<td colspan="4" class="text-center md:text-1xl lg:text-4xl font-medium"><?php echo $voting_year; ?> Annual General Meeting Voting</td>
    </tr>
	<?php
		date_default_timezone_set('America/Aruba');
		$now = date("F j, Y, g:i a");
		$voteendstring = date("F j, Y, g:i a",$voteend);

		if($error == 0 && $voteend >= time()){
			/*$temp = rand(111111111,999999999);

			while(file_exists("temp/".$temp.".pdf")){
				$temp = rand(1111111111,9999999999);
			}

			copy ("protected/Convocation-2011.pdf", "temp/".$temp.".pdf");*/
			echo '
				<tr>
					<td class="text-left">
						<form name="ballot_exit" action="ballot.php" method="post">
						<input type="submit" value="Exit" name="exit_button" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-full" />
						</form>
					</td>
					<td colspan="3" class="text-right md:text-xs lg:text-sm">Current Time '.$now.' -4 GMT'.'</td>
				</tr>
				<tr><td colspan="4" class="text-right md:text-xs lg:text-sm">Voting Closes '.$voteendstring.' -4 GMT'.'</td></tr>
				<tr>
					<td colspan="4" align="left">Welcome '.$row['FirstName'].' '.$row['LastName'].' you have ';
			if($row['Vote']==1){
				echo '
						already voted.</td>
						</tr>
				';
			}
			else{
				echo '
						not voted yet.</td>
						<tr>
				';
			}
			echo '
				 <tr>
    				<td colspan="4" align="left">
					For documentations download the: <br/>
					<form name="convocation_download" action="ballot.php" method="post">
					<input type="submit" value="'.$voting_year.' Convocation" name="download_document" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-full" />
					</form>
					<br/>

					</td>
   				 </tr>
			';

			if($row['Vote'] == 1){
				echo '
				 <tr>
    				<td colspan="4" align="left"><a class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-1 px-4 rounded-full" href="voteconf.php">Voting Confirmation Download</a></td>
   				 </tr>
			';
			}

			if($row['Vote']!=1){

				$sql2 = "SELECT * FROM voting_points order by id ASC";
				$rs2 = $my->query($sql2);
				$b = '<tr>
					<form name="ballot" action="submitvote.php" onsubmit="return checkBallot()" method="post">
					<td colspan="4" align="left">
						<table width="100%">
							<tr>
								<td colspan="4" class="text-xl text-center">Online Ballot #'.$ballot.'</td>
							</tr>
							<tr>
								<td colspan="4" align="right">Voting Shares: '.$row['VoteShare'].'
							</tr>
							<tr>
								<td colspan="4" align="left"><br/>As a member of Caribbean Palm Village Resort Cooperative Association, you are cordially invited to cast your vote on items appearing on the agenda, at the Annual General meeting of Members to be held on August 30, 2020 at 10:00 am at the Resort.</td>
							</tr>
							<tr>
								<td colspan="4">&nbsp;</td>
							</tr>
						</table>
						<br/>
						<br/>';

				while ($vp = $rs2->fetch_assoc()){
					//voting_points
					$b = $b.'
						<table class="p-4 m-2 w-full border-2 border-gray-500">
							<tr>
								<td colspan="6" class="text-lg font-bold bg-gray-300 p-2">'.$vp['question'].'</td>
							</tr>
							<tr>
								<td colspan="6" class="text-xs bg-gray-200 p-1">
								'.$vp['additional'].'
								</td>
							</tr>
							<tr>
								<td colspan="6" class="p-1 bg-gray-50">';

				$sql3 = 'SELECT * FROM voting_points_options WHERE voting_points_id = '.$vp['id'].' order by location ASC';
				$rs3 = $my->query($sql3);
				while ($vpo = $rs3->fetch_assoc()){
					$b = $b.'
						<input type="radio" name="point'.$vp['id'].'" value="'.$vpo['answer_id'].'" /> '.$vpo['answer'].'<br/>
					';
				}
				$b = $b.'
							</td>
							</tr>
						</table>
						<br/>
					';
				}

				$b = $b.'
							<input type="checkbox" name="agreement" /> By checking this box below I agree that I am '.$row['FirstName'].' '.$row['LastName'].'
							<br/>
							<br/>
							<input type="submit" name="Vote" value="vote" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" />
						</form>
						</td>
					<tr>
				';

				echo $b;

			}//end if not voted yet

		}
		else if($error == 0 && $voteend <= time()){
			echo '<td colspan="4" style="font-size:125%" align="center">Voting Closed at '.$voteendstring.' -4GMT current time is '.$now.' -4 GMT</td>';
		}
	?>

</table>
</div>
</body>
</html>
