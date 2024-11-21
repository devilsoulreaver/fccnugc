<?php
include ('class.ezpdf.php');
include ('common.php');
//=========Connecting=================
//--------------------------------------------------------------------------
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










/*$mark=array();
$SEMHEADING=array();
$semtotal=array();

if ($date)
{
$date=$date;
}
else
{
	$qry="select current_date";
	$yearset=pg_exec($conn,$qry);
	$date=pg_fetch_result($yearset,0,0);
}



$pdf = &new Cezpdf('a4');
$pdf->selectFont('../mls/fonts/Helvetica.afm');



//******************************************************
$newlines="\n\n\n\n\n\n\n";




	//----------------------------to find lateral entry------------------------------

	//$sem_list =array('I & II','III','IV','V','VI','VII','VIII' );
	
	//===========================================================================
	
	
	
	$pdf->ezText("aaaaaaaaaaaaaaaaaaaaaaaaaaaa");

	$pd =  array(
	array('name'=>"Dated ",'name1'=>": ",'name2'=>" date " ));

 	$pd2= array(array('name'=>"Name ",'name1'=>":" ,'name2'=>"<b> nam </b>" ,'name3'=>"Register Number" ,'name4'=>":" ,'name5'=>" <b>regno</b>" ));
	
 	$pd3= array(array('name'=>"Course",'name1'=>":",'name2'=>"Bachelor of Technology ( Engg. ) <b> ( LATERAL ENTRY ) </b>" ));
	

 	$pd4= array(array('name'=>"Branch",'name1'=>":",'name2'=>"courname" ));

	$pdf->ezTable($pd,$cols,'',
	           array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>12,'cols'=>
     array('name'=>array('justification'=>'right','width'=>450),'name1'=>array('justification'=>'right','width'=>20),'name2'=>array('justification'=>'right','width'=>80))));


 	$pdf->ezText($newlines);

	$pdf->ezTable($pd2,$cols,'',
	           array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>12,'cols'=>
		   array('name'=>array('justification'=>'left','width'=>50),'name1'=>array('justification'=>'center','width'=>20),'name2'=>array('justification'=>'left','width'=>236),'name3'=>array('justification'=>'right','width'=>125),'name4'=>array('justification'=>'center','width'=>15),'name5'=>array('justification'=>'right','width'=>95)
		   )));


 	$pdf->ezTable($pd3,$cols,'',
	           array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>12,'cols'=>
		   array('name'=>array('justification'=>'left','width'=>50),'name1'=>array('justification'=>'center','width'=>20),'name2'=>array('justification'=>'left','width'=>471)
		   )));

	$pdf->ezTable($pd4,$cols,'',
	           array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>12,'cols'=>
		   array('name'=>array('justification'=>'left','width'=>50),'name1'=>array('justification'=>'center','width'=>20),'name2'=>array('justification'=>'left','width'=>471)
		   )));


 	$pdf->selectFont('../mls/fonts/Helvetica.afm');



$HEADING =  array(
array('name'=>"\n\nSUBJECT CODE\n",'name1'=>"\n\nSUBJECT TITLE\n\n",'name2'=>'Marks Awarded','name3'=>'Maximum Marks','name4'=>''.$pdf->addText(545,583,12,'R / S / I',-90).'','name5'=>''.$pdf->addText(564,589,12,'P / F',-90).''));


	$pdf->ezTable($HEADING,$cols,'',
		array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>12,
'cols'=>array('name'=>array('justification'=>'center','width'=>73),
'name1'=>array('justification'=>'center','width'=>210),
'name2'=>array('justification'=>'center','width'=>108),
'name3'=>array('justification'=>'center','width'=>110),
'name4'=>array('justification'=>'center','width'=>20),
'name5'=>array('justification'=>'center','width'=>20),)
));

//      ist  column
	$pdf->addText(335,579,12,'Written',-90);
	$pdf->addText(371,573,12,'Sessional',-90);
	$pdf->addText(408,583,12,'Total',-90);
//      2nd  column
	$pdf->addText(443,579,12,'Written',-90);
	$pdf->addText(482,572,12,'Sessional',-90);
	$pdf->addText(519,583,12,'Total',-90);



	// HORIZONTAL LINE
//      ist  column vertical line
	$pdf->line(348,572,348,628);//   line(x1,y1,x2,y2);
	$pdf->line(385,572,385,628);
//      2nd column vertical line
	$pdf->line(458,572,458,628);
	$pdf->line(496,572,496,628);
////////////////////////////////////////////////////////////
//      1st horizontal line

	$pdf->line(312,628,530,628);






for($i=0;$i<sizeof($SEM);$i++){
	if ($latflag){
		if ($SEM[$i]=='6'){
			$pdf->ezNewPage();


			$pdf->addText(336,745,12,'Written',-90);
			$pdf->addText(371,736,12,'Sessional',-90);
			$pdf->addText(408,745,12,'Total',-90);
//      2nd  column
			$pdf->addText(445,745,12,'Written',-90);
			$pdf->addText(483,736,12,'Sessional',-90);
			$pdf->addText(518,745,12,'Total',-90);

	// HORIZONTAL LINE
//      ist  column vertical line
			$pdf->line(349,736,349,792);//   line(x1,y1,x2,y2);
			$pdf->line(384,736,384,792);
//      2nd column vertical line
			$pdf->line(458,736,458,792);
			$pdf->line(496,736,496,792);
////////////////////////////////////////////////////////////
//      1st horizontal line

			$pdf->line(313,792,530,792);

			$HEADING =  array(
array('name'=>"\n\nSUBJECT CODE\n",'name1'=>"\n\nSUBJECT TITLE\n\n",'name2'=>'Marks Awarded','name3'=>'Maximum Marks','name4'=>''.$pdf->addText(545,748,12,'R / S / I',-90).'','name5'=>''.$pdf->addText(564,757,12,'P / F',-90).''));

			$pdf->ezTable($HEADING,$cols,'',
			array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>12,
			'cols'=>array('name'=>array('justification'=>'center','width'=>73),
			'name1'=>array('justification'=>'center','width'=>210),
			'name2'=>array('justification'=>'center','width'=>108),
			'name3'=>array('justification'=>'center','width'=>110),
			'name4'=>array('justification'=>'center','width'=>20),
			'name5'=>array('justification'=>'center','width'=>20),)
			));
		}
	}else{
		if ($SEM[$i]=='5'){
			$pdf->ezNewPage();


			$pdf->addText(336,745,12,'Written',-90);
			$pdf->addText(371,736,12,'Sessional',-90);
			$pdf->addText(408,745,12,'Total',-90);
//      2nd  column
			$pdf->addText(445,745,12,'Written',-90);
			$pdf->addText(483,736,12,'Sessional',-90);
			$pdf->addText(518,745,12,'Total',-90);

	// HORIZONTAL LINE
//      ist  column vertical line
			$pdf->line(349,736,349,792);//   line(x1,y1,x2,y2);
			$pdf->line(384,736,384,792);
//      2nd column vertical line
			$pdf->line(458,736,458,792);
			$pdf->line(496,736,496,792);
////////////////////////////////////////////////////////////
//      1st horizontal line

			$pdf->line(313,792,530,792);

			$HEADING =  array(
array('name'=>"\n\nSUBJECT CODE\n",'name1'=>"\n\nSUBJECT TITLE\n\n",'name2'=>'Marks Awarded','name3'=>'Maximum Marks','name4'=>''.$pdf->addText(545,748,12,'R / S / I',-90).'','name5'=>''.$pdf->addText(564,757,12,'P / F',-90).''));

			$pdf->ezTable($HEADING,$cols,'',
			array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>12,
			'cols'=>array('name'=>array('justification'=>'center','width'=>73),
			'name1'=>array('justification'=>'center','width'=>210),
			'name2'=>array('justification'=>'center','width'=>108),
			'name3'=>array('justification'=>'center','width'=>110),
			'name4'=>array('justification'=>'center','width'=>20),
			'name5'=>array('justification'=>'center','width'=>20),)
			));
		}
	}
	$SEMTITLE = array('name'=>"SEMESTER : <b>". $sem_list[$i]." </b>");
	array_push($SEMHEADING,$SEMTITLE);

	$pdf->ezTable($SEMHEADING,$cols,'',array('xPos'=>305, 'width'=>540,'showHeadings'=>0,'shaded'=>0,
	'showLines'=>1,'fontSize'=>12,'cols'=>array('name'=>array('justification'=>'left','width'=>541))));


	$qry="select distinct papcode from marks where regno= '".$regno."' and substr(papcode,4,1)='". $SEM[$i]."'  order by papcode ;";
	//print $qry;
	$papset=pg_exec ($database,$qry);

	for ($j=0;$j<pg_num_rows($papset);$j++) {
		$papcode1=pg_fetch_result($papset,$j,0);
		$papcode=trim($papcode1);
		$qry="select  opcode FROM pcode_linker WHERE syllabusyear='".$sylyear."' AND npcode = '".$papcode."' ;";
		//print $qry;

		$pcodeset=pg_exec ($database,$qry);

		$pcode=pg_fetch_result($pcodeset,0,0);

        	$qry="select  PNAME,EXTMAX,INTMAX,(COALESCE(EXTMAX,'0')::TEXT::INT+COALESCE(INTMAX,'0')::TEXT::INT) AS TOTAL FROM PAPER WHERE 			YEAR='".$sylyear."' AND PCODE = '".$papcode."';";


		$papdetset=pg_exec ($database,$qry);
		$pname=pg_fetch_result($papdetset,0,0);
		$extmax=pg_fetch_result($papdetset,0,1);
		$intmax=pg_fetch_result($papdetset,0,2);
		$totmax=pg_fetch_result($papdetset,0,3);


		$qry="select consolidated('".$regno."','".$papcode."');";
		//print $qry;
		$studset=pg_exec ($database,$qry);
		$studmark=pg_fetch_result($studset,0,0);

		list($regno1,$papcode1,$extobt,$intobt,$total1,$newstatus,$status)=split(":",$studmark);

		if ($extmax==0){
			$extmax="**";
			$extobt="**";

		}
//
		if ($intmax=='0'){
			$intmax="**";
			$intobt="**";
		}

		$mark1=  array('name'=>"$pcode",'name1'=>"$pname",'name2'=>"$extobt",'name3'=>"$intobt",'name4'=>"$total1",'name5'=>"$extmax",'name6'=>"$intmax",'name7'=>"$totmax",'name8'=>"$newstatus",'name9'=>"$status");

		array_push($mark,$mark1);


	}

		$pdf->ezTable($mark,$cols,'',
			array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>8,
			'cols'=>array('name'=>array('justification'=>'left','width'=>73),
			'name1'=>array('justification'=>'left','width'=>210),
			'name2'=>array('justification'=>'right','width'=>36),
			'name3'=>array('justification'=>'right','width'=>36),
			'name4'=>array('justification'=>'right','width'=>36),
			'name5'=>array('justification'=>'right','width'=>38),
			'name6'=>array('justification'=>'right','width'=>38),
			'name7'=>array('justification'=>'right','width'=>34),
			'name8'=>array('justification'=>'center','width'=>20),
			'name9'=>array('justification'=>'center','width'=>20),
		)));


		$qry="select semtot,exttot,inttot from semtotal where regno='".$regno."'  and  sem='". $SEM[$i]."';";
		//print $qry;
		$semset=pg_exec($database,$qry);
		$semtot=pg_fetch_result($semset,0,0);
	//	print $semtot;
		$exttot=pg_fetch_result($semset,0,1);
	//	print $exttot;
		$inttot=pg_fetch_result($semset,0,2);
	//	print $inttot;


		$qry="select total,exttot,inttot from semtable  WHERE SEM='".$SEM[$i]."' AND PCODE = '".$selbranch."';";
		$semtableset=pg_exec($database,$qry);
		$semgtot=pg_fetch_result($semtableset,0,0);
		$semexttot=pg_fetch_result($semtableset,0,1);
		$seminttot=pg_fetch_result($semtableset,0,2);



		$semtotal1=array('name'=>'<b>TOTAL</b>','name1'=>"<b>$exttot</b>",'name2'=>"<b>$inttot</b>",'name3'=>"<b>$semtot</b>",'name4'=>"<b>$semexttot</b>",'name5'=>"<b>$seminttot</b>",'name6'=>"<b>$semgtot</b>",'name7'=>'');

		array_push($semtotal,$semtotal1);

		$pdf->ezTable($semtotal,$cols,'',
			array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>8,
			'cols'=>array('name'=>array('justification'=>'center','width'=>283),
			'name1'=>array('justification'=>'right','width'=>36),
			'name2'=>array('justification'=>'right','width'=>36),
			'name3'=>array('justification'=>'right','width'=>36),
			'name4'=>array('justification'=>'right','width'=>38),
			'name5'=>array('justification'=>'right','width'=>38),
			'name6'=>array('justification'=>'right','width'=>34),
			'name7'=>array('justification'=>'right','width'=>40))));

	$mark=array();
	$SEMHEADING= array();
	$semtotal=array();

}

	

	

	$grand=array();

	$grandtotal=array('name'=>"<b>GRAND TOTAL</b>",'name1'=>"<b>$wrtotal</b>",'name2'=>"<b>$sestotal</b>",'name3'=>"<b>$grtotal</b>",'name4'=>"<b>$gexttot</b>",'name5'=>"<b>$ginttot</b>",'name6'=>"<b>$ggtot</b>",'name7'=>'');
	array_push($grand,$grandtotal);

		$pdf->ezTable($grand,$cols,'',
			array('xPos'=>305, 'width'=>500,'showHeadings'=>0,'shaded'=>0, 'showLines'=>1,'fontSize'=>8,
			'cols'=>array('name'=>array('justification'=>'center','width'=>283),
			'name1'=>array('justification'=>'right','width'=>36),
			'name2'=>array('justification'=>'right','width'=>36),
			'name3'=>array('justification'=>'right','width'=>36),
			'name4'=>array('justification'=>'right','width'=>38),
			'name5'=>array('justification'=>'right','width'=>38),
			'name6'=>array('justification'=>'right','width'=>34),
			'name7'=>array('justification'=>'right','width'=>40))));


	$data =  array(
 array('name'=>'P : Passed','name1'=>'F : Failed','name2'=>'R : Regular','name3'=>'S : Supplementary','name4'=>'I : Improvement' ));
	$pdf->ezTable($data,$cols,'',
		array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>10,
'cols'=>array('name'=>array('justification'=>'left','width'=>108),
'name1'=>array('justification'=>'center','width'=>108),
'name2'=>array('justification'=>'center','width'=>108),
'name3'=>array('justification'=>'center','width'=>108),
'name4'=>array('justification'=>'right','width'=>108)
)));


$pdf->selectFont('./fonts/Times-Italic.afm');


	$data =  array(
 array('name'=>"$FOOTER"));
	$pdf->ezTable($data,$cols,'',
		array('xPos'=>305, 'width'=>541,'showHeadings'=>0,'shaded'=>0, 'showLines'=>0,'fontSize'=>10,
'cols'=>array('name'=>array('justification'=>'left','width'=>541),
'name1'=>array('justification'=>'left','width'=>0),
'name2'=>array('justification'=>'left','width'=>0),
'name3'=>array('justification'=>'right','width'=>0))
));


$pdf->ezText("\n\n\n");

	$pdf->selectFont('../mls/fonts/Helvetica.afm');
	$newlines="\n\n\n\n\n\n\n\n\n\n";
	$newlines2="\n\n\n\n\n\n\n\n";
	$pdf->ezNewPage();
	

 $pdf->ezStream();
$pdf->ezNewPage();*/

?>
