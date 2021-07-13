<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
include 'dbc.php';
page_protect();
require_once('../support/tcpdf/tcpdf.php');

$my = new mysqli($host,$db_username,$db_password,$db_name);

if(!checkAdmin()){
	header("Location: index.php");
  exit;
}

$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` ";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();
$totalvshare = $row['tvs'];
$qourum =  floor(($totalvshare/2)) + 1;
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1";
$rs =  $my->query($sql);
$row = $rs->fetch_assoc();
$totalvsharevoted = $row['tvs'];
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1 AND `ManEntry` = 0";
$rs =  $my->query($sql);
$row = $rs->fetch_assoc();
$totalvsharevotede = 0+$row['tvs'];
$sql = "SELECT SUM( `VoteShare` ) AS tvs FROM `vote` WHERE `Vote` = 1 AND `ManEntry` = 1";
$rs =  $my->query($sql);
$row = $rs->fetch_assoc();
$totalvsharevotedman = 0+$row['tvs'];

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
//$pdf->cell(50,5,"Votes for qourum: ");
//$pdf->cell(0,5,$qourum,0,1);
$pdf->SetFont('times', 'B', 11);
if($totalvsharevoted < $qourum){
	//$pdf->cell(0,5,"Total votes are less then needed for qourum",0,1);
}
else{
	//$pdf->cell(0,5,"Total votes are sufficient for qourum",0,1);
}
$pdf->SetFont('times', '', 11);

$pdf->Ln(5);

$pdf->Cell(135,5,'',0,0);
$pdf->Cell(15,5,'Yes',0,0);
$pdf->Cell(15,5,'No',0,0);
$pdf->Cell(0,5,'Abstained',0,1);

$sql2 = "SELECT * FROM voting_points order by id ASC";
$rs2 = $my->query($sql2);

while ($vp = $rs2->fetch_assoc()){
		$pdf->Cell(15,5,$vp['id'].'.',0,0);
		$tx = $pdf->getX();
		$ty = $pdf->getY();
		$pdf->SetFillColor(256,256,256);
		$pdf->Multicell(120,5,$vp['question'],0,'L',1);
		$ay = $pdf->getY();
		$fill = 1;
		if($vp['candidate']){
			$sql3 = 'SELECT * FROM voting_points_options WHERE voting_points_id = '.$vp['id'].' order by location ASC';
			$rs3 = $my->query($sql3);
			while ($vpo = $rs3->fetch_assoc()){
				if($fill==0){
					$pdf->SetFillColor(256,256,256);
					$fill=1;
				}
				else{
					$pdf->SetFillColor(222,222,222);
					$fill=0;
				}
				$pdf->Cell(15,5,'',0,0,'',0);
				$pdf->Cell(120,5,$vpo['answer'],0,0,'',1);
				$t = $vp['id'];
				$answer_id = $vpo['answer_id'];
				$sqlt1 = "SELECT Sum( `VoteShare` ) AS tvs FROM `vote` Where `Point".$t."` = ".$answer_id." AND `Vote`=1";
				$sqlt2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `vote` Where `Point".$t."` != ".$answer_id." AND `Vote`=1";
				$rst1 = $my->query($sqlt1);
				$rst2 = $my->query($sqlt2);
				$rowt1 = $rst1->fetch_assoc();
				$rowt2 = $rst2->fetch_assoc();
				$yes1 = 0+$rowt1['tvs'];
				$no1 = 0+$rowt2['tvs'];
				$pdf->Cell(15,5,$yes1,0,0,'',1);
				$pdf->Cell(15,5,$no1,0,1,'',1);
			}
			$ay = $pdf->getY();
		}
		else{

			$pdf->setXY($tx+120,$ty);
			$t = $vp['id'];
			$sqlt1 = "SELECT Sum( `VoteShare` ) AS tvs FROM `vote` Where `Point".$t."` = 1 AND `Vote`=1";
			$sqlt2 = "SELECT Sum( `VoteShare` ) AS tvs FROM `vote` Where `Point".$t."` = 2 AND `Vote`=1";
			$sqlt3 = "SELECT Sum( `VoteShare` ) AS tvs FROM `vote` Where `Point".$t."` = -1 AND `Vote`=1";
			$rst1 = $my->query($sqlt1);
			$rst2 = $my->query($sqlt2);
			$rst3 = $my->query($sqlt3);
			$rowt1 = $rst1->fetch_assoc();
			$rowt2 = $rst2->fetch_assoc();
			$rowt3 = $rst3->fetch_assoc();

			$yes1 = 0+$rowt1['tvs'];
			$no1 = 0+$rowt2['tvs'];
			$notvoted1 = 0+$rowt3['tvs'];

			$pdf->Cell(15,5,$yes1,0,0);
			$pdf->Cell(15,5,$no1,0,0);
			$pdf->Cell(0,5,$notvoted1,0,1);
		}
		$pdf->setXY($pdf->getX(),$ay+5);
}

$pdf->ln(25);

$pdf->cell(50,5,"Total of electronic votes:");
$pdf->cell(0,5,$totalvsharevotede,0,1);
$pdf->cell(50,5,"Total of manual votes:");
$pdf->cell(0,5,$totalvsharevotedman,0,1);

ob_end_clean();
$pdf->Output('results.pdf', 'D');

?>
