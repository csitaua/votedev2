<?php 
include 'dbc.php';
page_protect();

if(!checkVotelevel()){
	header("Location: index.php");
	exit();	
}
include "../support/connect.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link rel="stylesheet" type="text/css" href="../style.css" />
<title>Voting Administration</title>
<script type="text/javascript">
	function approveall(form){
		if(!document.ballot.approve.checked){
			document.ballot.point1[0].checked = false;	
			document.ballot.point1[1].checked = false;	
			document.ballot.point2[0].checked = false;	
			document.ballot.point2[1].checked = false;
			document.ballot.point3[0].checked = false;	
			document.ballot.point3[1].checked = false;	
			document.ballot.point4[0].checked = false;	
			document.ballot.point4[1].checked = false;	
			document.ballot.point5[0].checked = false;	
			document.ballot.point5[1].checked = false;
			document.ballot.point6[0].checked = false;	
			document.ballot.point6[1].checked = false;
			document.ballot.point7[0].checked = false;	
			document.ballot.point7[1].checked = false;	
			document.ballot.point8[0].checked = false;	
			document.ballot.point8[1].checked = false;	
			document.ballot.point9[0].checked = false;	
			document.ballot.point9[1].checked = false;
			document.ballot.disapprove.checked = false;
		}
		else{
			document.ballot.point1[0].checked = true;	
			document.ballot.point1[1].checked = false;	
			document.ballot.point2[0].checked = true;	
			document.ballot.point2[1].checked = false;	
			document.ballot.point3[0].checked = true;	
			document.ballot.point3[1].checked = false;	
			document.ballot.point4[0].checked = true;	
			document.ballot.point4[1].checked = false;
			document.ballot.point5[0].checked = true;	
			document.ballot.point5[1].checked = false;	
			document.ballot.point6[0].checked = true;	
			document.ballot.point6[1].checked = false;	
			document.ballot.point7[0].checked = true;	
			document.ballot.point7[1].checked = false;
			document.ballot.point8[0].checked = true;	
			document.ballot.point8[1].checked = false;	
			document.ballot.point9[0].checked = true;	
			document.ballot.point9[1].checked = false;
			document.ballot.disapprove.checked = false;
		}
	};
	function disapproveall(form){
		if(!document.ballot.disapprove.checked){
			document.ballot.point1[0].checked = false;	
			document.ballot.point1[1].checked = false;	
			document.ballot.point2[0].checked = false;	
			document.ballot.point2[1].checked = false;	
			document.ballot.point3[0].checked = false;	
			document.ballot.point3[1].checked = false;	
			document.ballot.point4[0].checked = false;	
			document.ballot.point4[1].checked = false;
			document.ballot.point5[0].checked = false;	
			document.ballot.point5[1].checked = false;
			document.ballot.point6[0].checked = false;	
			document.ballot.point6[1].checked = false;
			document.ballot.point7[0].checked = false;	
			document.ballot.point7[1].checked = false;
			document.ballot.point8[0].checked = false;	
			document.ballot.point8[1].checked = false;
			document.ballot.point9[0].checked = false;	
			document.ballot.point9[1].checked = false;
			document.ballot.approve.checked = false;
		}
		else{
			document.ballot.point1[1].checked = true;	
			document.ballot.point1[0].checked = false;	
			document.ballot.point2[1].checked = true;	
			document.ballot.point2[0].checked = false;	
			document.ballot.point3[1].checked = true;	
			document.ballot.point3[0].checked = false;	
			document.ballot.point4[1].checked = true;	
			document.ballot.point4[0].checked = false;	
			document.ballot.point5[1].checked = true;	
			document.ballot.point5[0].checked = false;	
			document.ballot.point6[1].checked = true;	
			document.ballot.point6[0].checked = false;	
			document.ballot.point7[1].checked = true;	
			document.ballot.point7[0].checked = false;	
			document.ballot.point8[1].checked = true;	
			document.ballot.point8[0].checked = false;	
			document.ballot.point9[1].checked = true;	
			document.ballot.point9[0].checked = false;	
			document.ballot.approve.checked = false;
		}
	};
	
	function checkall(){
		if(document.ballot.point1[0].checked && document.ballot.point2[0].checked && document.ballot.point3[0].checked && document.ballot.point4[0].checked && document.ballot.point5[0].checked && document.ballot.point6[0].checked && document.ballot.point7[0].checked && document.ballot.point8[0].checked && document.ballot.point9[0].checked){
			document.ballot.disapprove.checked = false;
			document.ballot.approve.checked = true;	
		}
		else if(document.ballot.point1[1].checked && document.ballot.point2[1].checked && document.ballot.point3[1].checked && document.ballot.point4[1].checked && document.ballot.point5[1].checked && document.ballot.point6[1].checked && document.ballot.point7[1].checked && document.ballot.point8[1].checked && document.ballot.point9[1].checked){
			document.ballot.disapprove.checked = true;
			document.ballot.approve.checked = false;	
		}
		else{
			document.ballot.disapprove.checked = false;
			document.ballot.approve.checked = false;
		}
	}
	
	function checkBallot(){
		
		if( (!document.ballot.point1[0].checked && !document.ballot.point1[1].checked) || (!document.ballot.point2[0].checked && !document.ballot.point2[1].checked) || (!document.ballot.point3[0].checked && !document.ballot.point3[1].checked) || (!document.ballot.point4[0].checked && !document.ballot.point4[1].checked) || (!document.ballot.point5[0].checked && !document.ballot.point5[1].checked) || (!document.ballot.point6[0].checked && !document.ballot.point6[1].checked) || (!document.ballot.point7[0].checked && !document.ballot.point7[1].checked) || (!document.ballot.point8[0].checked && !document.ballot.point8[1].checked) || (!document.ballot.point9[0].checked && !document.ballot.point9[1].checked)  ){
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

<body>

<div align="center">
	<table width="900" border="1" cellpadding=6 cellspacing=0 >
		<tr>
    		<td colspan="4" style="font-size:175%" align="center">Manual Vote Entry</td>
    	</tr>
        <tr><td>&nbsp;</td></tr>
        <?php
			echo '
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
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Enter Ballot Number:</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%"></td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										Ballot Number: 
										<input type="ballot" name="ballot" maxlength="10"/></br>
										
									</td>
								</tr>	
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Approve or disapprove all voting items</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%">Instrustions: Select approve all to approve all voting points or disapprove to disapprove all voting points.</td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										<input type="checkbox" onclick="approveall();" name="approve" > Approve all voting items <br/>
										<input type="checkbox" onclick="disapproveall();" name="disapprove"> Disapprove all voting items <br/>
									</td>
								</tr>	
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="6" style="font-size:125%">Ellection of Board Members C.P.V. Cooperative Association, July 14/28, 2013:</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="6" style="font-size:85%">&nbsp;</td>
								</tr>
								<tr>
									<td width="20%">Running For Position Of</td>
									<td width="20%">Name</td>
									<td width="20%">Current Position Of</td>
									<td width="20%">Residency</td>
									<td width="10%">Yes</td>
									<td width="10%">No</td>
								</tr>
								<tr>
									<td width="20%">President</td>
									<td width="20%">Edward J. Hayes</td>
									<td width="20%">President</td>
									<td width="20%">U.S.A.</td>
									<td width="10%"><input type="radio" name="point1" value="1" onclick="checkall();"/></td>
									<td width="10%"><input type="radio" name="point1" value="2" onclick="checkall();"/></td>
								</tr>
								<tr>
									<td width="20%">Vice- President </td>
									<td width="20%">Daniel L. Maloof</td>
									<td width="20%">Vice- President </td>
									<td width="20%">U.S.A.</td>
									<td width="10%"><input type="radio" name="point2" value="1" onclick="checkall();"/></td>
									<td width="10%"><input type="radio" name="point2" value="2" onclick="checkall();"/></td>
								</tr>
								<tr>
									<td width="20%">Secretary</td>
									<td width="20%">Gabri de Hoogd</td>
									<td width="20%">Secretary</td>
									<td width="20%">Aruba</td>
									<td width="10%"><input type="radio" name="point3" value="1" onclick="checkall();"/></td>
									<td width="10%"><input type="radio" name="point3" value="2" onclick="checkall();"/></td>
								</tr>
								<tr>
									<td width="20%">Treasurer *</td>
									<td width="20%">William L. Buley</td>
									<td width="20%"></td>
									<td width="20%">Aruba</td>
									<td width="10%"><input type="radio" name="point4" value="1" onclick="checkall();"/></td>
									<td width="10%"><input type="radio" name="point4" value="2" onclick="checkall();"/></td>
								</tr>
								<tr>
									<td width="20%">Member at Large</td>
									<td width="20%">Craig A. Zendzian</td>
									<td width="20%">Member at Large</td>
									<td width="20%">U.S.A.</td>
									<td width="10%"><input type="radio" name="point5" value="1" onclick="checkall();"/></td>
									<td width="10%"><input type="radio" name="point5" value="2" onclick="checkall();"/></td>
								</tr>
								<tr>
									<td colspan="6" style="font-size:85%">* This position has been vacant since January 5, 2013. Besides this submission for Treasurer, no other submissions were received for any of the remaining positions for the Board of Directors.</td>
								</tr>
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Approval of the Financial Compilation for the year ended 2011 (see attachment):</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%">The Board of Directors has carefully reviewed and approved this item and recommends a vote of YES</td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										<input type="radio" name="point6" value="1" onclick="checkall();"/> Yes, I approve<br/>
										<input type="radio" name="point6" value="2" onclick="checkall();"/> No, I do not approve</br>
									</td>
								</tr>	
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Approval of the Financial Compilation for the year ended 2012 (see attachment):</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%">The Board of Directors has carefully reviewed and approved this item and recommends a vote of YES</td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										<input type="radio" name="point7" value="1" onclick="checkall();"/> Yes, I approve<br/>
										<input type="radio" name="point7" value="2" onclick="checkall();"/> No, I do not approve</br>
									</td>
								</tr>	
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Approval of the 2014 Budget (see attachment): </td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%">The Board of Directors has carefully reviewed and approved this item and recommends a vote of YES</td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										<input type="radio" name="point8" value="1" onclick="checkall();"/> Yes, I approve<br/>
										<input type="radio" name="point8" value="2" onclick="checkall();"/> No, I do not approve</br>
									</td>
								</tr>	
							</table>
							<br/>
							<table width="100%" bordercolor="#000000" border="3" cellpadding="4">
								<tr>
									<td bgcolor="#999999" colspan="4" style="font-size:125%">Approval Addition to the By-Laws of CPVR Cooperative Association: Article IV- The Board Paragraph 4 (see attachment):</td>
								</tr>
								<tr>
									<td bgcolor="#CCCCCC" colspan="4" style="font-size:85%">The latest edition of Robert'."'".'s Rules of Order containing rules of order intended to be adopted as a parliamentary authority shall be used by the CPV Board of Directors when conducting Board and Members Meetings. Robert'."'".'s Rules of Order shall not supersede the existing By-Laws and Articles of the CPVR Cooperative Association.<br/><br/>The Board of Directors has carefully reviewed and approved this item and recommends a vote of YES</td>
								</tr>
								<tr>
									<td colspan="4" align="left">
										<input type="radio" name="point9" value="1" onclick="checkall();"/> Yes, I approve<br/>
										<input type="radio" name="point9" value="2" onclick="checkall();"/> No, I do not approve</br>
									</td>
								</tr>	
							</table>
							<br/>
							<input type="submit" name="Vote" value="vote" style=" width:150px" />
						</form>
						</td>
					<tr>
				';
		?>
   	</table>
</div>
</body>
</html>
