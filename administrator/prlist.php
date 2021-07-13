<?php

include 'dbc.php';
page_protect();

include "../support/connect.php";
require_once('../support/tcpdf/tcpdf.php');

if(checkAdmin()){
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
	$pdf->SetTitle('Proxy Sheet');
	$pdf->SetSubject('Proxy Sheet');
	$pdf->SetMargins(15,15,10);
	
	$pdf->SetFont('times', 'B', 14);
	
	$pdf->AddPage();
	
	$pdf->Image('../img/logo.jpg', 15, 5, 30);
	$pdf->Cell(0,5,'Proxy Sheet',0,0,'C');
	$pdf->Ln(20);
	$pdf->SetFont('times', '', 11);
	
	
	$sql = "SELECT DISTINCT (Proxy) FROM `201107vote` WHERE Proxy IS NOT NULL";
	$rs = mysql_query($sql);
	
	$pdf->Ln(10);
	$pdf->Cell(50,5,'Number of Different Proxies:');
	$pdf->Cell(0,5,mysql_num_rows($rs),0,1);
	$pdf->Ln(10);
	
	$pdf->Cell(60,5,'Proxy Names');
	$pdf->Cell(35,5,'Present/Eligible');
	$pdf->Cell(50,5,'NOT Present/NOT Eligible');
	$pdf->Cell(0,5,'Voting Share using this proxy',0,1);
	$pdf->Ln(3);
	
	$tvs = 0;
	$pr = mysql_num_rows($rs);
	for($i = 0; $i < $pr; ){
		$i++;
		
		$row = mysql_fetch_array($rs);
		
		$sql2 = "SELECT SUM( `VoteShare` ) AS tvs FROM `201107vote` WHERE `Vote` = 1 AND Proxy = '$row[0]'";
		$rs2 = mysql_query($sql2);
		$row2 = mysql_fetch_array($rs2);
		$totalvsharevotedpr = $row2[0];
		$tvs = $tvs + $totalvsharevotedpr;
		
		if(strcmp($row[0],'Personal at Meeting') != 0){
			$pdf->Cell(60,5,$row[0]);
			$pdf->Cell(15,5,'');
			$pdf->Cell(5,3,'',1);
			$pdf->Cell(37,5,'');
			$pdf->Cell(5,3,'',1);
			$pdf->Cell(40,5,'');
			$pdf->Cell(0,5,$totalvsharevotedpr,0,1);
			$pdf->Ln(2);
		}
		
	}
	
	
	
	$pdf->Output('proxysheet.pdf', 'D');
}

?>