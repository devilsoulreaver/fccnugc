<?php
require_once('fpdf.php');
require_once('common.php');
define('FPDF_FONTPATH','font/');
$pdf= new FPDF(P,'mm','A4');


$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
$sql1="select empid as \"EMPID\",empname(empid) as \"NAME\",empdesig(empid) as \"DESIG\",empoffice(empid) as \"OFFICE\" from emp_master where empid='$empid'";
$recset1=pg_exec($conn,$sql1);



$bfrom=$selyear.'000001';
$bto=$selyear.'008000';
$sql1="select sum(gross)::double precision as \"Gross Salary : \" from bills_view where empid=$empid and billno between $bfrom and $bto and btype not in ('TSUR','MRI') ;";

$rset=pg_exec($conn,$sql1);
$gross=pg_result($rset,0,0);
// print "\n";
 echo 'gross=',$gross;

$sql="select coalesce(sum(amount),0) as amt from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto) and indid like 'LEAVE%';";
$rset=pg_exec($conn,$sql);
$leaveded=pg_result($rset,0,0);

echo 'leaveded=',$leaveded;

$gross=$gross-$leaveded;

$sql1="select sum(amount)::double precision as \"Profession Tax  \"  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='PROFTAX' ;";
$rset=pg_exec($conn,$sql1);
$ptx=pg_result($rset,0,0);

 echo 'ptx=',$ptx;

$sql1="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='PFS' ;";
$rset=pg_exec($conn,$sql1);
$pfs=pg_result($rset,0,0);

echo 'pfs=',$pfs;

$sql1="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='SLI' ;";
$rset=pg_exec($conn,$sql1);
$sli=pg_result($rset,0,0);

echo 'sli=',$sli;

$sql="select coalesce(sum(amount),0)  from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto  and btype not in ('ADV','MRI','FLW','TSUR')) and indid='HCA' ;";
$rset=pg_exec($conn,$sql);
$hca=pg_result($rset,0,0);

echo 'HCA=',$hca;



$sql="select coalesce(sum(amount),0)  from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto  and btype not in ('ADV','MRI','FLW','TSUR')) and indid='INCTAX' ;";
$rset=pg_exec($conn,$sql);
$it=pg_result($rset,0,0);

echo 'IT=',$it;












$pdf->AddPage();
$pdf->SetFont('Arial','B',12);
$pdf->MultiCell(190,15,"",0,1,l);
//$pr_title="UNIVERSITY OF CALICUT"."\n"."INCOME TAX  STATEMENT";
$pdf->MultiCell(60,8,"",0,0,l);
$pdf->MultiCell(62,8,"UNIVERSITY OF CALICUT",0,1,C);
$pdf->MultiCell(18,12,"Reg.No",1,0,C);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(50,12,$regno,1,1,C);
 
$pdf->MultiCell(60,8,"",0,0,l);
$pdf->SetFont('Arial','B',14);
$pdf->MultiCell(62,8,"MUJEEB",0,0,C);
$pdf->MultiCell(68,8,"",0,1,C);
$pdf->SetFont('Arial','B',14);
$title_head="FINANCIAL YEAR  2008-2009";
$pdf->MultiCell(190,8,$title_head,0,1,C);
 
 

// //$course_code=substr($regno,4,3);
// //$center_code=substr($regno,0,2);
// 
// 
// $pdf->MultiCell(20,7,"",0,0,C);
// $pdf->MultiCell(25,7,"Branch",0,0,l);
// $pdf->MultiCell(125,7,$course_name,1,0,l);
// $pdf->MultiCell(10,7,"",0,1,l);
// 
// $pdf->MultiCell(190,5,"",0,1,l);
// 
// 
// 
// 
// 
// $std_res=pg_exec($link,"select *  from studentmaster where regno='$regno'");
// $std_row=pg_fetch_array($std_res,0);
// //$std_det_res=pg_exec($link,"select *  from studentdet where regno='$regno'");
// //$std_det_row=pg_fetch_array($std_det_res,0);
// $elective2=$std_det_row['elective2'];
// $elective3=$std_det_row['elective3'];
// 
// $elective2_nm_res=pg_exec($link,"select pname from paper where pcode='$elective2' and year='2004'");
// $elective2_name=pg_fetch_result($elective2_nm_res,0,0);
// $elective3_nm_res=pg_exec($link,"select pname from paper where pcode='$elective3' and year='2004'");
// $elective3_name=pg_fetch_result($elective3_nm_res,0,0);
// 
// $ele2_op_res=pg_exec($link,"select opcode from pcode_linker where npcode='$elective2' and syllabusyear='2004'");
// $ele2_op=pg_fetch_result($ele2_op_res,0,0);
// $ele3_op_res=pg_exec($link,"select opcode from pcode_linker where npcode='$elective3' and syllabusyear='2004'");
// $ele3_op=pg_fetch_result($ele3_op_res,0,0);
// 
// $elective="(".$ele2_op.")".$elective2_name."\n"."(".$ele3_op.")".$elective3_name;
// 
// 
// $pdf->SetFont('Arial','',12);
// 
// $old_height=$pdf->rowheight();
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// $pdf->MultiCell(50,7,"Center of Examination",0,0,l);
// 
// $pdf->MultiCell(140,7,$center_name,0,1,l);
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// 
// $pdf->MultiCell(50,7,"Name of candidate",0,0,l);
// 
// $pdf->MultiCell(140,7,$std_row['name'],0,1,l);
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// 
// $pdf->MultiCell(50,7,"Date of Birth",0,0,l);
// 
// $pdf->MultiCell(140,7,$std_det_row['dob'],0,1,l);
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// 
// $pdf->MultiCell(50,7,"Electives Chosen",0,0,l);
// $pdf->MultiCell(140,7,$elective,0,1,l);
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// $new_height=$pdf->rowheight();
// 
// $pdf->line(10,$new_height,10,$old_height);
// $pdf->line(60,$new_height,60,$old_height);
// $pdf->line(200,$new_height,200,$old_height);
// $pdf->SetFont('Arial','',10);
// $pdf->MultiCell(190,7,"Details of Papers for which the Candidate is appearing for",0,1,C);
// $pdf->SetFont('Arial','',12);
// $pdf->MultiCell(30,7,"Theory Papers",0,0,l);
// 
// $sem_course=$course_code."8";
// $pap_th_query="select * from regpaper where regno='$regno' and papcode in(select distinct pcode from paper where category='T' and year='2004' and pcode like '$sem_course%') order by papcode";
// $pap_th_res=pg_exec($link,$pap_th_query);
// if(pg_num_rows($pap_th_res)!=0)
// {
// 	for($i=0;$i<pg_num_rows($pap_th_res);$i++)
// 	{
// 		if($i!=0)
// 			$pdf->MultiCell(30,7,"",0,0,l);
// 		$pap_th_row=pg_fetch_array($pap_th_res,$i);
// 		$papcode=$pap_th_row['papcode'];
// 		$opcd_query="select opcode from pcode_linker where npcode=trim('$papcode') and syllabusyear='2004'";
// 		$opcd_res=pg_exec($link,$opcd_query);
// 		$opcd=pg_fetch_result($opcd_res,0,0);
// 		$pname_res=pg_exec($link,"select pname from paper where pcode='$papcode' and year='2004'");
// 		$pname=pg_fetch_result($pname_res,0,0);
// 		$p=$i+1;
// 		$p_no="Paper  ".$p;
// 		$pdf->MultiCell(25,7,$p_no,0,0,l);
// 		$pdf->MultiCell(30,7,$opcd,0,0,l);
// 		$pdf->MultiCell(100,7,$pname,0,1,l);
// 
// 	}
// 
// }
// //$pdf->MultiCell(30,7,"",0,0,l);
// $p=$i+1;
// $p_no="Paper  ".$p;
// 
// $pdf->MultiCell(30,7,"",0,0,l);
// $pdf->MultiCell(25,7,$p_no,0,0,l);
// $pdf->MultiCell(30,7,$ele2_op,0,0,l);
// $pdf->MultiCell(100,7,$elective2_name,0,1,l);
// $p++;
// $p_no="Paper  ".$p;
// $pdf->MultiCell(30,7,"",0,0,l);
// $pdf->MultiCell(25,7,$p_no,0,0,l);
// $pdf->MultiCell(30,7,$ele3_op,0,0,l);
// $pdf->MultiCell(100,7,$elective3_name,0,1,l);
// $pap_pr_query="select * from regpaper where regno='$regno' and papcode in(select distinct pcode from paper where category='P' and year='2004' and pcode like '$sem_course%') order by papcode";
// 
// $pap_pr_res=pg_exec($link,$pap_pr_query);
// 
// if(pg_num_rows($pap_pr_res)!=0)
// {$pdf->MultiCell(30,7,"Practicals",0,0,l);
// 	for($i=0;$i<pg_num_rows($pap_pr_res);$i++)
// 	{
// 		if($i!=0)
// 			$pdf->MultiCell(30,7,"",0,0,l);
// 		$pap_pr_row=pg_fetch_array($pap_pr_res,$i);
// 		$papcode=$pap_pr_row['papcode'];
// 		$opcd_res=pg_exec($link,"select opcode from pcode_linker where npcode=trim('$papcode') and syllabusyear='2004'");
// 		$opcd=pg_fetch_result($opcd_res,0,0);
// 		$pname_res=pg_exec($link,"select pname from paper where pcode='$papcode' and year='2004'");
// 		$pname=pg_fetch_result($pname_res,0,0);
// 		$p=$p+1;
// 		$p_no="Paper  ".$p;
// 		$pdf->MultiCell(25,7,$p_no,0,0,l);
// 		$pdf->MultiCell(30,7,$opcd,0,0,l);
// 		$pdf->MultiCell(100,7,$pname,0,1,l);
// 
// 	}
// 	
// }
// $pap_ds_query="select * from regpaper where regno='$regno' and papcode in(select distinct pcode from paper where category='D' and year='2004' and pcode like '$sem_course%') order by papcode";
// 
// $pap_ds_res=pg_exec($link,$pap_ds_query);
// 
// if(pg_num_rows($pap_ds_res)!=0)
// {$pdf->MultiCell(30,7,"",0,0,l);
// 	for($i=0;$i<pg_num_rows($pap_ds_res);$i++)
// 	{
// 		if($i!=0)
// 			$pdf->MultiCell(30,7,"",0,0,l);
// 		$pap_ds_row=pg_fetch_array($pap_ds_res,$i);
// 		$papcode=$pap_ds_row['papcode'];
// 		$opcd_res=pg_exec($link,"select opcode from pcode_linker where npcode=trim('$papcode') and syllabusyear='2004'");
// 		$opcd=pg_fetch_result($opcd_res,0,0);
// 		$pname_res=pg_exec($link,"select pname from paper where pcode='$papcode' and year='2004'");
// 		$pname=pg_fetch_result($pname_res,0,0);
// 		$p=$p+1;
// 		$p_no="Paper  ".$p;
// 		$pdf->MultiCell(25,7,$p_no,0,0,l);
// 		$pdf->MultiCell(30,7,$opcd,0,0,l);
// 		$pdf->MultiCell(100,7,$pname,0,1,l);
// 
// 	}
// 	
// }
// $pap_viva_query="select * from regpaper where regno='$regno' and papcode in(select distinct pcode from paper where category='V' and year='2004' and pcode like '$sem_course%' ) order by papcode";
// $pap_viva_res=pg_exec($link,$pap_viva_query);
// 
// if(pg_num_rows($pap_viva_res)!=0)
// {$pdf->MultiCell(30,7,"",0,0,l);
// 	for($i=0;$i<pg_num_rows($pap_viva_res);$i++)
// 	{
// 		if($i!=0)
// 			$pdf->MultiCell(30,7,"",0,0,l);
// 		$pap_viva_row=pg_fetch_array($pap_viva_res,$i);
// 		$papcode=$pap_viva_row['papcode'];
// 		$opcd_res=pg_exec($link,"select opcode from pcode_linker where npcode=trim('$papcode') and syllabusyear='2004'");
// 		$opcd=pg_fetch_result($opcd_res,0,0);
// 		$pname_res=pg_exec($link,"select pname from paper where pcode='$papcode' and year='2004'");
// 		$pname=pg_fetch_result($pname_res,0,0);
// 		$p=$p+1;
// 		$p_no="Paper  ".$p;
// 		$pdf->MultiCell(25,7,$p_no,0,0,l);
// 		$pdf->MultiCell(30,7,$opcd,0,0,l);
// 		$pdf->MultiCell(100,7,$pname,0,1,l);
// 
// 	}
// 	
// }
// $pdf->line(10,$pdf->rowheight(),200,$pdf->rowheight());
// $pdf->MultiCell(190,2,"",0,1,l);
// $ph_y=$pdf->rowheight();
// $pdf->MultiCell(190,10,"",0,1,l);
// 
// $pdf->MultiCell(50,10,"",0,0,l);
// 
// $pdf->MultiCell(40,5,"Identifying Officer's Name,Designation and Address",0,0,l);
// $pdf->MultiCell(100,5,".........................................................................................................................................................................................................................................................",0,1,l);
// $pdf->MultiCell(190,5,"",0,1,l);
// $pdf->MultiCell(50,10,"",0,0,l);
// $pdf->SetFont('Arial','',8);
// $pdf->MultiCell(140,4,"(To be attested by a Member of Teaching Staff of the College not below the rank of a lecturer)",0,1,l);
// $pdf->MultiCell(190,10,"",0,1,l);
// $pdf->SetFont('Arial','',10);
// $ident_sign="Signature of Identifying Officer with Seal"."\n"."(To be signed on the Photograph)";
// $pdf->MultiCell(70,5,$ident_sign,0,0,l);
// $pdf->MultiCell(20,5,"",0,0,l);
// $std_sign="Signature of the Candidate................................................."."\n"."(To be signed in the Presence of Identifying Officer)";
// $pdf->MultiCell(100,5,$std_sign,0,1,l);
// 
// $pdf->MultiCell(190,8,"",0,1,l);
// $pdf->MultiCell(40,4,"(College Seal)",0,0,C);
// $pdf->MultiCell(150,4,"",0,1,l);
// $pdf->MultiCell(190,8,"",0,1,l);
// $pdf->MultiCell(60,5,"Pareeksha Bhavan",0,0,l);
// $pdf->MultiCell(130,5,"",0,1,l);
// $pdf->MultiCell(60,5,"Calicut University P.O.",0,0,l);
// $pdf->MultiCell(70,5,"",0,0,l);
// $pdf->SetFont('Arial','B',12);
// $pdf->MultiCell(60,5,"Controller of Examinations",0,1,l);
// $pdf->SetFont('Arial','',10);
// $pdf->MultiCell(60,5,"673 635",0,0,l);
// $pdf->MultiCell(70,5,"",0,0,l);
// $pdf->MultiCell(60,5,"University of Calicut",0,1,C);
// //$ce_det="Controller of Examinations"."\n"."University"
// $photo_name1="uploaded_files/".$regno.".jpg";
// 
// $photo_name3="uploaded_files/".$regno.".JPG";
// if(file_exists($photo_name1))
// 	$photo_name="uploaded_files/".$regno.".jpg";
// else if(file_exists($photo_name3))
// 	$photo_name="uploaded_files/".$regno.".JPG";
// 
// $pdf->Image($photo_name,10,$ph_y,40,50);
// }
// else
// {
// 	$verify_msg="Hall Ticket of Candidate with Register Number ".$regno." is with held";
// 	$pdf->MultiCell(190,8,$verify_msg,0,1,l);
// }
// 
// }
// else
// {
// 	$not_app_msg="This Candidate with Register Number ".$regno." is not Applied for Btech VIII Semester(Regular) Examination will be held on JUNE 2008";
// 	$pdf->MultiCell(190,8,$not_app_msg,0,1,l);
// }
// }//end for

$pdf->Output();
?>