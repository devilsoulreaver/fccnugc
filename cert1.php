<?php
require_once('fpdf.php');
require_once('common.php');
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
define('FPDF_FONTPATH','font/');
$sql="select empid,empname(empid),empdesig(empid),empoffice(empid),dob,doj,doret from emp_master where empid='$empid'";
$emprec=pg_exec($conn,$sql);
$empname=pg_result($emprec,0,1);
$empdesig=pg_result($emprec,0,2);
$empoffice=pg_result($emprec,0,3);
$dob=pg_result($emprec,0,4);
$doj=pg_result($emprec,0,5);
$doret=pg_result($emprec,0,6);
$empdata=$empid."\n".$empname."\n".$empdesig."\n".$empoffice;
$m1=date("d/m/Y",mktime(0,0,0,$month1,1,$year1));
$sql="select saldetails('$empid','$m1',next01($m1))";
$salrec=pg_exec($conn,$sql);

// Calculation Ends Here.......... 

//pdf creation starts here
$pdf= new FPDF(P,'mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',11);
$pdf->MultiCell(190,8,"EMPLOYMENT CERTIFICATE ISSUED TO",0,1,C);
$pdf->MultiCell(190,8,"MAHATMA GANDHI UNIVERSITY EMPLOYEES CO-OPERATIVE",0,1,C);
$pdf->MultiCell(190,8,"SOCIETY LTD.NO.K.771",0,1,C);
$pdf->SetFont('Arial','',10);
$pdf->MultiCell(190,8,"UNIVERSITY BUILDING,PRIYADARSINI HILLS P.O,PIN 686 560,KOTTAYAM DT",0,1,C);
$old_height=$pdf->rowheight();

$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,8,"Certified that Sri. /Smt.   $empname    S/o / D/o /W/o  $fname   residing at $hname P.O $po Village $vlg  Taluk  $tlk   ",0,1,C);
$pdf->MultiCell(190,8,"$dt District who has signed below is permanant / officiating   / acting $empdesig in the Office $empoffice and that on his/her ",0,1,C);
$pdf->MultiCell(190,8,"executing the agreement under Sec.37 of the Co-operative Societies  Act 1969.I am prepared to deduct the instalment due to the  ",0,1,C);
$pdf->MultiCell(190,8,"Society from   his / her salary and remit the same to the society",0,1,C);
$pdf->line(30,$pdf->rowheight(),160,$pdf->rowheight());
$old_height=$pdf->rowheight();
$pdf->SetFont('Arial','B',10);
$pdf->MultiCell(165,8,"  DETAILS OF HIS /   HER  SERVICE",0,1,C);
$new_height=$pdf->rowheight();
$pdf->line(30,$new_height,30,$old_height);
$pdf->line(160,$new_height,160,$old_height);
$pdf->line(30,$pdf->rowheight(),160,$pdf->rowheight());
$pdf->SetFont('Arial','',7);
$pdf->MultiCell(165,8,"Date of Birth and Age                 :$dob",0,1,C);
$new_height=$pdf->rowheight();
$pdf->line(30,$new_height,30,$old_height);
$pdf->line(160,$new_height,160,$old_height);
$pdf->line(30,$pdf->rowheight(),160,$pdf->rowheight());
$pdf->MultiCell(165,8,"2.Date of Entry in to service                 :$doj",0,1,C);


// $pdf->Multicell(95,8,$hname,0,1,l);
// $pdf->Multicell(95,8,$po,0,1,l);
// $pdf->Multicell(95,8,$vlg,0,1,l);
// $pdf->Multicell(95,8,$tlk,0,1,l);

//-----------------------------------------------------
//pdf creation ends here 
$pdf->Output();
?>
