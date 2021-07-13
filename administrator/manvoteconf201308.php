<?php 
include 'dbc.php';
page_protect();
include "../support/connect.php";
require_once('../support/tcpdf/tcpdf.php');

if(checkAdmin()){

	$sql = "SELECT * FROM vote WHERE ManEntry = 1";
	$rs = mysql_query($sql);
	
	$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);
	$pdf->setPrintFooter(false);
	$pdf->setPrintHeader(false);
	$pdf->SetCreator(PDF_CREATOR);
	$pdf->SetAuthor('Caribbean Palm Village Resort');
	$pdf->SetTitle('Voting Confirmation');
	$pdf->SetSubject('Voting Confirmation');
	$pdf->SetMargins(15,15,10);
	
	
	while($row = mysql_fetch_array($rs)){
	
		$pdf->SetFont('times', 'B', 14);
		
		$pdf->AddPage();
		
		$pdf->Image('../img/logo.jpg', 15, 5, 30);
		$pdf->MultiCell(0,5,'Voting Confirmation Ballot# '.$row['ballot'],0,'C', false, 1);
		$pdf->Ln(30);
		
		$pdf->SetFont('times', '', 11);
		
		$p1 = $row['Point1'];
		$p2 = $row['Point2'];
		$p3 = $row['Point3'];
		$p4 = $row['Point4'];
		$p5 = $row['Point5'];
		$p6 = $row['Point6'];
		$p7 = $row['Point7'];
		$p8 = $row['Point8'];
		$p9 = $row['Point9'];
		
		$pdf->Cell(0,5,'Your proxy is: '.$row['Proxy'],0,1);
		$pdf->Ln(5);
		
		$pdf->Cell(135,5,'',0,0);
		$pdf->Cell(15,5,'Yes',0,0);
		$pdf->Cell(15,5,'No',0,0);
		$pdf->Cell(0,5,'Abstained',0,1);
		
		$pdf->Cell(15,5,'1.',0,0);		$pdf->Cell(120,5,'Elect Edward J. Hayes for President',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p1 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p1 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'2.',0,0);
		$pdf->Cell(120,5,'Elect Daniel L. Maloof for Vice- President',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p2 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p2 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'3.',0,0);
		$pdf->Cell(120,5,'Elect Gabri de Hoogd for Secretary',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p3 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p3 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'4.',0,0);
		$pdf->Cell(120,5,'Elect William L. Buley for Treasurer',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p4 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p4 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'5.',0,0);
		$pdf->Cell(120,5,'Elect Craig A. Zendzian for Member at Large',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p5 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p5 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'6.',0,0);
		$pdf->Cell(120,5,'Approval of the Financial Compilation for the year ended 2011',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p6 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p6 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'7.',0,0);
		$pdf->Cell(120,5,'Approval of the Financial Compilation for the year ended 2012',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p7 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p7 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'8.',0,0);
		$pdf->Cell(120,5,'Approval of the 2014 Budget',0,0);
		$pdf->SetFont('times', 'B', 16);
		if($p8 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p8 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'9.',0,0);
		$pdf->MultiCell(120,5,'Approval Addition to the By-Laws of CPVR Cooperative Association: Article IV- The Board Paragraph 4',0,'l',0,0,'','',true);
		$pdf->SetFont('times', 'B', 16);
		if($p9 == 1){
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else if($p9 == 2){
			$pdf->Cell(15,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}
		else{
			$pdf->Cell(30,5,'',0,0);
			$pdf->writeHTMLCell(15,5,'','','*',0,1);
		}

		
		$pdf->SetFont('times', '', 8);
		
		$ballot = $row['ballot'];
		$sql2 = "SELECT * FROM manvote where ballot = '$ballot'";
		$rs2 = mysql_query ($sql2);
		$row2 = mysql_fetch_array($rs2);
		
		$pdf->SetXY(165,245);
		$pdf->Cell(0,5,'User: '.$row2['user'],0,0,'R');
	}
	
	
	$pdf->Output('confirmation'.$ballot.'.pdf', 'D');
}

?>
