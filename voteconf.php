<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
session_start();

require_once "support/encryptionb.php";
include "support/db-coop.inc";
require_once('support/tcpdf/tcpdf.php');

$session = $_SESSION['ballot'];
$ballot = decrypt($session, '%E%uN~}BCL');

$my = new mysqli($host,$db_username,$db_password,$db_name);
$sql = "SELECT * FROM vote WHERE ballot = '$ballot'";
$rs = $my->query($sql);
$row = $rs->fetch_assoc();

if($rs->num_rows == 0){
	header("Location: index.php");
  exit;
}

$pdf = new TCPDF('P', 'mm', 'letter', true, 'UTF-8', false);
$pdf->setPrintFooter(false);
$pdf->setPrintHeader(false);
$pdf->SetCreator(PDF_CREATOR);
$pdf->SetAuthor('Caribbean Palm Village Resort');
$pdf->SetTitle('Voting Confirmation');
$pdf->SetSubject('Voting Confirmation');
$pdf->SetMargins(15,15,10);

$pdf->SetFont('times', 'B', 14);

$pdf->AddPage();

$pdf->Image('img/logo.jpg', 15, 5, 30);
$pdf->MultiCell(0,5,'Voting Confirmation Ballot# '.$ballot,0,'C', false, 1);
$pdf->Ln(30);

$pdf->SetFont('times', '', 11);

/*
$p1 = explode("-",$row['Point1']);
$p2 = $row['Point2'];
$p3 = $row['Point3'];
$p4 = $row['Point4'];
$p5 = $row['Point5'];

$cand[1]='Alicia Azulay (U.S.A.)';
$cand[2]='Oscar Britten (Aruba)';
$cand[3]='Kathy D\'Alesio (U.S.A.)';
$cand[4]='David George (U.S.A.)';
$cand[5]='Joseph A. Internicola (U.S.A.)';
$cand[6]='Mark Jackson (U.S.A.)';
$cand[7]='Donna McKenna (U.S.A.)';
$cand[8]='Michael O\'Connell (U.S.A.)';
$cand[9]='Peter Szulewski (U.S.A.)';*/

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
      if($vpo['answer_id']==$row['Point'.$t]){
        $pdf->Cell(15,5,'*',0,0,'',1);
				$pdf->Cell(15,5,'',0,1,'',0);
      }
      else{
        $pdf->Cell(15,5,'',0,0,'',1);
        $pdf->Cell(15,5,'',0,1,'',0);
      }
    }
    $ay = $pdf->getY();
  }
  else{
    $pdf->setXY($tx+120,$ty);
    $t = $row['Point'.$vp['id']];
    //$pdf->Cell(135,5,'',0,0);
    if($t==1){ $pdf->Cell(15,5,'*',0,0,'',1); }
    else { $pdf->Cell(15,5,'',0,0,'',1); }
    if($t==2){ $pdf->Cell(15,5,'*',0,0,'',1); }
    else { $pdf->Cell(15,5,'',0,0,'',1); }
    if($t==-1){ $pdf->Cell(0,5,'*',0,1,'',1); }
    else { $pdf->Cell(0,5,'',0,1,'',1); }
  }
  $pdf->setXY($pdf->getX(),$ay+5);
}


$pdf->SetXY(165,245);
$pdf->Cell(0,5,'Control: '.$session,0,0,'R');

ob_end_clean();
$pdf->Output('confirmation'.$ballot.'.pdf', 'D');

?>
