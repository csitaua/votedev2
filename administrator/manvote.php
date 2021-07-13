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
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../styles/output.css" />
<title>Voting Administration</title>
<script type="text/javascript">
	function checkBallot(){

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
</head>

<body class="font-sans antialiased p-10">
<div class="min-h-0 bg-blue-100 p-4 m-4 mx-auto w-4/6 border-2 border-black">
	<table class="w-full p-6" >
		<tr>
    		<td colspan="4" class="text-2xl font-bold text-center">Manual Vote Entry</td>
    	</tr>
        <tr><td>&nbsp;</td></tr>
        <?php
			$b= '
					<tr>
						<form name="ballot" action="submitmanvote.php" onsubmit="return checkBallot()" method="post">
						<td colspan="4" align="left">
							<table width="100%">
								<tr>
									<td colspan="4">'.$_SESSION['user_name'].'</td>
								</tr>
								<tr>
									<td colspan="4">&nbsp;</td>
								</tr>
							</table>
							<table class="p-4 m-2 w-full border-2 border-gray-500">
								<tr>
									<td colspan="4" class="text-lg font-bold bg-gray-300 p-2">Enter Ballot Number:</td>
								</tr>
								<tr>
									<td colspan="4" class="text-xs bg-gray-200 p-1">&nbsp;</td>
								</tr>
								<tr>
									<td colspan="4" class="p-1 bg-gray-50">
										<label for="ballot" class="mb-4">Ballot Number:</label>
										<input type="text" name="ballot" maxlength="10" class="shadow appearance-none border rounded w-1/6 py-2 px-3 text-gray-700 leading-tight focus:outline-none focus:shadow-outline" placeholder="Ballot Number"/>
									</td>
								</tr>
							</table>
							</br>';


							$sql2 = "SELECT * FROM voting_points order by id ASC";
							$rs2 = $my->query($sql2);
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


						$b = $b.'<br/>
							<br/>
							<input type="submit" name="Vote" value="vote" class="bg-blue-500 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-full" />
						</form>
						</td>
					<tr>
				';

				echo $b;
		?>
   	</table>
</div>
</body>
</html>
