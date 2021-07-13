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
		
		$pdf->Cell(0,5,'Your proxy is: '.$row['Proxy'],0,1);
		$pdf->Ln(5);
		
		$pdf->Cell(135,5,'',0,0);
		$pdf->Cell(15,5,'Yes',0,0);
		$pdf->Cell(15,5,'No',0,0);
		$pdf->Cell(0,5,'Abstained',0,1);
		
		$pdf->Cell(15,5,'1.',0,0);		$pdf->Cell(120,5,'Approval of the 2017 Budget',0,0);
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
		$pdf->Cell(120,5,'Approval of the By-Laws of the Association as amended',0,0);
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
		$pdf->Cell(120,5,'Approval for the Board of Directors to both pursue methods of financing',0,0);
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
		$pdf->Cell(15,5,'',0,0);
		$pdf->Cell(120,5,'and to engage in Capital Improvement projects for CPVR',0,1);
		$pdf->SetFont('times', '', 11);
		$pdf->Cell(15,5,'',0,0);
		$pdf->Cell(120,5,'as stated in 2017 Budget scenario',0,0);

		
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
