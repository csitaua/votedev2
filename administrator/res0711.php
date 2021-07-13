<?php

include 'dbc.php';
page_protect();

include "../support/connect.php";
require_once('../support/tcpdf/tcpdf.php');

$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `201107vote` ";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$totalvshare = $row[0];
$qourum =  floor(($totalvshare/2)) + 1;
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `201107vote` WHERE `Vote` = 1";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$totalvsharevoted = $row[0];
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `201107vote` WHERE `Vote` = 1 AND `ManEntry` = 0";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$totalvsharevotede = 0+$row[0];
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `201107vote` WHERE `Vote` = 1 AND `ManEntry` = 1";
$rs = mysql_query($sql);
$row = mysql_fetch_array($rs);
$totalvsharevotedman = 0+$row[0];

$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Caribbean Palm Village Resort');
$pdf->SetTitle('Voting Results');
$pdf->SetSubject('Voting Results');
$pdf->SetMargins(15,15,10);

$pdf->SetFont('times', 'B', 14);

$pdf->AddPage();

$pdf->Image('../img/logo.jpg', 15, 5, 30);
$pdf->Cell(0,5,'Voting Results',0,0,'C');
$pdf->Ln(20);
$pdf->SetFont('times', '', 11);
$pdf->cell(50,5,"Total of voting shares: ");
$pdf->cell(0,5,$totalvshare,0,1);
$pdf->cell(50,5,"Total voted: ");
$pdf->cell(0,5,$totalvsharevoted,0,1);
$pdf->cell(50,5,"Votes for qourum: ");
$pdf->cell(0,5,$qourum,0,1);
$pdf->SetFont('times', 'B', 11);
if($totalvsharevoted < $qourum){
	$pdf->cell(0,5,"Total votes are less then needed for qourum",0,1);
}
else{
	$pdf->cell(0,5,"Total votes are sufficient for qourum",0,1);
}
$pdf->SetFont('times', '', 11);

$pdf->Ln(10);

$sql = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point1` = 1 ";
$sql2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point1` = 2 ";
$sql3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point1` = -1 ";
$rs = mysql_query($sql);
$rs2 = mysql_query($sql2);
$rs3 = mysql_query($sql3);
$row = mysql_fetch_array($rs);
$row2 = mysql_fetch_array($rs2);
$row3 = mysql_fetch_array($rs3);

$yes1 = 0+$row['tvs'];
$no1 = 0+$row2['tvs'];
$notvoted1 = 0+$row3['tvs'];

$pdf->Cell(135,5,'',0,0);
$pdf->Cell(15,5,'Yes',0,0);
$pdf->Cell(15,5,'No',0,0);
$pdf->Cell(0,5,'Abstained',0,1);

$pdf->Cell(15,5,'1.',0,0);
$pdf->Cell(120,5,'Approval of the Financial Statements for the year ended 2010',0,0);
$pdf->Cell(15,5,$yes1,0,0);
$pdf->Cell(15,5,$no1,0,0);
$pdf->Cell(0,5,$notvoted1,0,1);

$sql = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point2` = 1 ";
$sql2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point2` = 2 ";
$sql3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point2` = -1 ";
$rs = mysql_query($sql);
$rs2 = mysql_query($sql2);
$rs3 = mysql_query($sql3);
$row = mysql_fetch_array($rs);
$row2 = mysql_fetch_array($rs2);
$row3 = mysql_fetch_array($rs3);

$yes2 = 0+$row['tvs'];
$no2 = 0+$row2['tvs'];
$notvoted2 = 0+$row3['tvs'];

$pdf->Cell(15,5,'2.',0,0);
$pdf->Cell(120,5,'Approval of the 2012 Budget',0,0);
$pdf->Cell(15,5,$yes2,0,0);
$pdf->Cell(15,5,$no2,0,0);
$pdf->Cell(0,5,$notvoted2,0,1);

$sql = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point3` = 1 ";
$sql2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point3` = 2 ";
$sql3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point3` = -1 ";
$rs = mysql_query($sql);
$rs2 = mysql_query($sql2);
$rs3 = mysql_query($sql3);
$row = mysql_fetch_array($rs);
$row2 = mysql_fetch_array($rs2);
$row3 = mysql_fetch_array($rs3);

$yes3 = 0+$row['tvs'];
$no3 = 0+$row2['tvs'];
$notvoted3 = 0+$row3['tvs'];

$pdf->Cell(15,5,'3.',0,0);
$pdf->Cell(120,5,'Approval of the Changes in Bylaws',0,0);
$pdf->Cell(15,5,$yes3,0,0);
$pdf->Cell(15,5,$no3,0,0);
$pdf->Cell(0,5,$notvoted3,0,1);

$sql = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point4` = 1 ";
$sql2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point4` = 2 ";
$sql3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point4` = -1 ";
$rs = mysql_query($sql);
$rs2 = mysql_query($sql2);
$rs3 = mysql_query($sql3);
$row = mysql_fetch_array($rs);
$row2 = mysql_fetch_array($rs2);
$row3 = mysql_fetch_array($rs3);

$yes4 = 0+$row['tvs'];
$no4 = 0+$row2['tvs'];
$notvoted4 = 0+$row3['tvs'];


$pdf->Cell(15,5,'4.',0,0);
$pdf->Cell(120,5,'Approval of the Changes in Articles',0,0);
$pdf->Cell(15,5,$yes4,0,0);
$pdf->Cell(15,5,$no4,0,0);
$pdf->Cell(0,5,$notvoted4,0,1);

$sql = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point5` = 1 ";
$sql2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point5` = 2 ";
$sql3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `201107vote` Where `Point5` = -1 ";
$rs = mysql_query($sql);
$rs2 = mysql_query($sql2);
$rs3 = mysql_query($sql3);
$row = mysql_fetch_array($rs);
$row2 = mysql_fetch_array($rs2);
$row3 = mysql_fetch_array($rs3);

$yes5 = 0+$row['tvs'];
$no5 = 0+$row2['tvs'];
$notvoted5 = 0+$row3['tvs'];

$pdf->Cell(15,5,'5.',0,0);
$pdf->Cell(120,5,'Approval of Extension in Duration Provision',0,0);
$pdf->Cell(15,5,$yes5,0,0);
$pdf->Cell(15,5,$no5,0,0);
$pdf->Cell(0,5,$notvoted5,0,1);
$pdf->Ln(25);

$pdf->cell(50,5,"Total of electronic votes:");
$pdf->cell(0,5,$totalvsharevotede,0,1);
$pdf->cell(50,5,"Total of manual votes:");
$pdf->cell(0,5,$totalvsharevotedman,0,1);


$sql = "SELECT DISTINCT (Proxy) FROM `201107vote` WHERE Proxy IS NOT NULL";
$rs = mysql_query($sql);

$pdf->Ln(10);
$pdf->Cell(50,5,'Number of Different Proxies:');
$pdf->Cell(0,5,mysql_num_rows($rs),0,1);

$pdf->Cell(0,5,'Proxy Names:',0,1);

$pr = mysql_num_rows($rs);
for($i = 0; $i < $pr; ){
	$i++;
	$row = mysql_fetch_array($rs);
	if($i == $pr){
		$pdf->Write(5,$row[0]);
	}
	else{
		$pdf->Write(5,$row[0].', ');
	}
}


$pdf->Output('results0711.pdf', 'D');

?>