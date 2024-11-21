<?php
require_once('fpdf.php');
require_once('common.php');
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
define('FPDF_FONTPATH','font/');
$bfrom=$selyear.'000001';
$bto=$selyear.'008000';
$sql="select sum(gross)::double precision  from bills_view where empid=$empid and billno between $bfrom and $bto and btype not in ('TSUR','MRI')  and get_bills_btype(billno)<>'DAAPF';";
$rec=pg_exec($conn,$sql);
$grosssal=pg_result($rec,0,0);
//Leave ded if any
$leaveded=0;
$sql="select coalesce(sum(amount),0) as amt from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto) and indid like 'LEAVE%';";
$rset=pg_exec($conn,$sql);
$leaveded=pg_result($rset,0,0);
$grosssal=$grosssal-$leaveded;
//------------------------------------------
$daacash=0;
$sql="select COALESCE(sum(amount),0) from da_arr_to_cash where empid=$empid and ofdate>='01/04/2008' and ofdate<='01/03/2009';";
$rset=pg_exec($conn,$sql);
$daacash=pg_result($rset,0,0);
$grosssal=$grosssal+$daacash;
//------------------------------------------
$daapf=0;
$sql="select COALESCE(sum(amount),0) from da_arr_to_pf where empid=$empid  and ofdate>='01/04/2008' and ofdate<='01/03/2009';";
$rset=pg_exec($conn,$sql);
$daapf=pg_result($rset,0,0);
$grosssal=$grosssal+$daapf;
//-------------------------------------------
$expay=0;
$sql="select coalesce(sum(amount),0) as amt from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto  and btype not in ('ADV','MRI','FLW','TSUR') order by ofdate) and indid in ('EXPAY','EXBP','EXDA','EXHRA','EXALLOWS');";
$rset=pg_exec($conn,$sql);
$expay=pg_result($rset,0,0);
//------------------------------------------
$grosssal=$grosssal-$expay;
//Profession Tax deducted---------------------
$sql="select sum(amount)::double precision from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid  and btype not in ('TSUR','MRI')) and indid='PROFTAX';";
$rset=pg_exec($conn,$sql);
$ptx=pg_result($rset,0,0);
//---------------------------------------------


//PF Subscription 

$sql="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='PFS' ;";
$rset=pg_exec($conn,$sql);
$pfs=pg_result($rset,0,0);
//LIC
$sql="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='LIC' ;";
$rset=pg_exec($conn,$sql);
$lic=pg_result($rset,0,0);
//SLI
$sli=0;
$sql="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='SLI' ;";
$rset=pg_exec($conn,$sql);
$sli=pg_result($rset,0,0);
//IT
$sql="select coalesce(sum(amount),0)  from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto  and btype not in ('ADV','MRI','FLW','TSUR')) and indid='INCTAX' ;";
$rset=pg_exec($conn,$sql);
$it=pg_result($rset,0,0);
//HCA
$sql="select coalesce(sum(amount),0)  from paybill where ind_bill_no in (select ind_bill_no from bills_view where empid=$empid and billno between $bfrom and $bto  and btype not in ('ADV','MRI','FLW','TSUR')) and indid='HCA' ;";
$rset=pg_exec($conn,$sql);
$hca=pg_result($rset,0,0);

$sql="select itemid,amount,type from emp_inc_tax_estimate where empid=$empid and finyear='2008:2009' order by type;";
$rset=pg_exec($conn,$sql);

$mphca=0;
$mhcaint=0;
$mhcaintp=0;
$mitex=0;
$mnpf=0;
$medu=0;
$m80ccc=0;
$m80ccd=0;
$mpension=0;
$mremune=0;
$mperq=0;
$mhonor=0;
$mfampen=0;
$mincoth=0;
$mintsnsc=0;
$mintrdepos=0;
$mhouseprop=0;
$mnlic=0;
$mproftaxe=0;
$mnse=0 ;  
$mels=0 ;  
$miib=0 ; 
$mulip=0;
$m80d=0;
$m80dd=0;
$m80ddb=0;
$m80e=0;
$m80gg=0;
$m80g=0;
$m80u=0;
$m13a=0;
$m24i=0;
$m89i=0;
$msli=0;
$mgrosssal=0;
$mdividend=0;
$i=0;
$oti=array();
while($row=pg_fetch_array($rset))
	{
	if ($row['itemid']=='PHCA')
		$mphca=$row['amount'];
	elseif ($row['itemid']=='DIVID')
		{
		$mdividend=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='ITEX')
		$mitex=$row['amount'];
	elseif ($row['itemid']=='HCAINT')
		$mhcaint=$row['amount'];
	elseif ($row['itemid']=='HCAINTP')
		$mhcaintp=$row['amount'];
	elseif ($row['itemid']=='NPF')
		$mnpf=$row['amount'];
	elseif ($row['itemid']=='NSE')
		$mnse=$row['amount'];
	elseif ($row['itemid']=='EDU')
		$medu=$row['amount'];
	elseif ($row['itemid']=='US80CCC')
		$m80ccc=$row['amount'];
	elseif ($row['itemid']=='US80CCD')
		$m80ccd=$row['amount'];
	elseif ($row['itemid']=='PENSION')
		{
		$mpension=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='REMUNE')
		{
		$mremune=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='PERQ')
		$mperq==$row['amount'];
	elseif ($row['itemid']=='HONOR')
		{
		$mhonor=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}

	elseif ($row['itemid']=='FAMPEN')
		{
		$mfampen=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	else if ($row['itemid']=='INCOTH')
		{
		$mincoth=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	else if ($row['itemid']=='INTSNSC')
		{
		$mintsnsc=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='INTRDEPOS')
		{
		$mintrdepos=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	else if ($row['itemid']=='HOUSEPROP')
		{
		$mhouseprop=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='GROSSSAL')
		{
		$mgrosssal=$row['amount'];
		$oti[$i]=$row['itemid'];
		$i++;
		}
	elseif ($row['itemid']=='NLIC')
		$mnlic=$row['amount'];
	elseif ($row['itemid']=='PROFTAXE')
		$mproftaxe=$row['amount'];
	elseif ($row['itemid']=='US13A')
		$m13a=$row['amount'];
	elseif ($row['itemid']=='US24i')
		$m24i=$row['amount'];
	elseif ($row['itemid']=='US89I')
		$m89i=$row['amount'];
	elseif ($row['itemid']=='ULIP')
		$mulip=$row['amount'];
	elseif ($row['itemid']=='ELS')
		$mels=$row['amount'];
	elseif ($row['itemid']=='IIB')
		$miib=$row['amount'];
	elseif ($row['itemid']=='US80D')
		$m80d=$row['amount'];
	elseif ($row['itemid']=='US80DD')
		$m80dd=$row['amount'];
	elseif ($row['itemid']=='PROFTAXE')
		$mproftaxe=$row['amount'];
	elseif ($row['itemid']=='US80G')
		$m80g=$row['amount'];
	elseif ($row['itemid']=='SLI')
		$msli=$row['amount'];
	elseif ($row['type']=='I')
		{
		//echo $row['type'];
		$oti[$i]=$row['amount'];
		$i++;
		}
	elseif ($row['type']=='E')
		{
		$osti[$i]=$row['amount'];
		$i++;
		}
	}

$sql="select sex,handicapped from emp_master where empid=$empid;";
$rset=pg_exec($conn,$sql);
$empsex=pg_result($rset,0,0);
$emp_disability=pg_result($rset,0,1);

//calculation starts  here 
$income=$grosssal;

if ($m24i>150000)
	$m24i=150000;
// US80U DISABILITY
if ($emp_disability=='Y')
	$m80u=50000;
$itdedtot=$it+$mitex;
$pftot=$pfs+$daapf;
$lictot=$lic+$mnlic;
$slitot=$sli+$msli;
$gross80c=$pftot+$lictot+$mulip+$medu+$mphca+$mnse+$slitot;
if ($m80ccc>100000)
	$m80ccc=100000;
if ($m80ccd>$income*10/100)
	$m80ccd=$income*10/100;
if ($gross80c>100000)
	$gross80c=100000;
		
if ($m80d>10000)
	$m80d=10000;
if ($m80dd>50000)
	$m80dd=50000;
$gross80dabove=$m80d+$m80dd+$m80ddb+$m80e+$m80gg+$m80u+$m80g;
$grosschapter6a=$gross80c+$gross80dabove;
$taxableInc=$income-$grosschapter6a;
$flimit=150000;
$ftax=15000;
$tax_15_3=0;
$tax_3_5=0;
$tax_5=0;
if ($empsex=='F')
	{
	$flimit=180000;
	$ftax=12000;
	}

if ($taxableInc>$flimit and $taxableInc<300001)
	$tax_15_3=round(($taxableInc-$flimit)*10/100);
if ($taxableInc>300000 and $taxableInc<500001)
	{ 
	$tax_15_3=$ftax;
	$tax_3_5=round(($taxableInc-300000)*20/100);
	}

if ($taxableInc>500000)
	{
	$tax_15_3=$ftax;
	$tax_3_5=40000;
	$tax_5=round(($taxableInc-500000)*30/100);
	}
$tottax=$tax_15_3+$tax_3_5+$tax_5;
$educess=round($tottax*3/100);
if ($taxableInc>1000000)
	$msc10=round($tottax*10/100);
$taxpayable=$tottax+$educess+$msc10;

//Tax Calculation Ends Here.......... 

//pdf creation starts here
$pdf= new FPDF(P,'mm','A4');
$pdf->AddPage();
$pdf->SetFont('Arial','B',16);
$pdf->MultiCell(190,8,"INCOME TAX STATEMENT 2008-2009 ",0,1,C);
$old_height=$pdf->rowheight();
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$pdf->SetFont('Arial','',12);
$pdf->Multicell(95,8,"Name and Address of the Employer ",0,0,l);
$pdf->Multicell(95,8,"Name and Designation of the Employee ",0,1,l);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(190,$new_height,190,$old_height);
//----------------------------------------
$old_height=$pdf->rowheight();
$pdf->SetFont('Arial','',9);
$pdf->Multicell(95,8,"REGISTRAR,UNIVERSITY OF CALICUT"."\n"." P.O CALICUT UNIVERSITY "."\n"." KERALA-673635 ",0,0,l);
$sql="select empid,empname(empid),empdesig(empid),empoffice(empid) from emp_master where empid='$empid'";
$emprec=pg_exec($conn,$sql);
$empname=pg_result($emprec,0,1);
$empdesig=pg_result($emprec,0,2);
$empoffice=pg_result($emprec,0,3);
$empdata=$empid."\n".$empname."\n".$empdesig."\n".$empoffice;
$pdf->Multicell(95,8,$empdata,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height); 
$pdf->line(190,$new_height,190,$old_height);
//----------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"TAN",0,0,C);
$pdf->Multicell(95,8,"PAN/GIR NO. ",0,1,C);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height); 
$pdf->line(190,$new_height,190,$old_height);
//--------------------------------------------
$sql="select pannumber from emp_master where empid='$empid'";
$rec=pg_exec($conn,$sql);
$pan=pg_result($rec,0,0);

$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"CHNU00025E",0,0,C);
$pdf->Multicell(95,8,$pan,0,1,C);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height); 
$pdf->line(190,$new_height,190,$old_height);
//-----------------------------------------------
$old_height=$pdf->rowheight();
$sql="select current_date";
$rec=pg_exec($conn,$sql);
$curdate=pg_result($rec,0,0);
$pdf->Multicell(95,5,"TDS Circle where Annual Return/Statement"."\n"."Under Section 206 is to be filed",0,0,l);
$pdf->Multicell(40,5,"Period"."\n"." "."\n"."From"."             "."To"." ",0,0,C);
$pdf->Multicell(40,5,"Assesment Year",0,1,R);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(160,$new_height,160,$old_height);  
$pdf->line(190,$new_height,190,$old_height);
//--------------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,5,"TIRUR",0,0,C);
$pdf->Multicell(40,5,"01-04-2008 "."   ".$curdate,0,0,l);
$pdf->Multicell(40,5,"2009-2010",0,1,R);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(160,$new_height,160,$old_height); 
$pdf->line(190,$new_height,190,$old_height);
//---------------------------------------------
$old_height=$pdf->rowheight();
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$pdf->SetFont('Arial','',12);
$pdf->Multicell(190,8,"DETAILS OF SALARY  AND OTHER INCOME  AND TAX DEDUCTED ",0,1,C);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(190,$new_height,190,$old_height);
//----------------------------------------------------
$pdf->SetFont('Arial','',8);
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"                        ",0,0,l);
$pdf->Multicell(40,5,"Rs",0,0,C);
$pdf->Multicell(40,5,"Rs",0,1,C);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$new_height=$pdf->rowheight();
$pdf->line(10,$new_height,10,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
$pdf->line(190,$new_height,190,$old_height);
//-------------------------------------------
$old_height=$pdf->rowheight();

$pdf->Multicell(95,8,"1.  Gross Salary      [Exclude February Salary]         ",0,0,l);
$pdf->Multicell(40,5,"        ",0,0,C);
$pdf->Multicell(40,5,$income,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//--------------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"2.  Deductions ",0,0,l);
$pdf->Multicell(95,8," ",0,1,l);
$pdf->Multicell(95,8,"    \tProfession Tax during 2008-09 ",0,0,l);
$pdf->Multicell(40,5,$ptx,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//------------------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"3.  Income Chargeable under head salaries (1)-(2) ",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$income-$ptx,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-------------------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"4.  Income From House Property ",0,0,l);
$pdf->Multicell(40,8,"     ",0,1,l);
$pdf->Multicell(95,8,"    Annual Value ",0,0,l);
$pdf->Multicell(40,8,$mhouseprop,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-------------------------------------------------
$old_height=$pdf->rowheight();
$income=$income-$m24i;
$pdf->Multicell(95,8,"    Less Deductions  U/S 24(2)",0,0,l);
$pdf->Multicell(40,8,$m24i,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//----------------------------------------------------
$old_height=$pdf->rowheight();
$income=$income;
$pdf->Multicell(95,8,"5.  Add any other income(Honorarium,Interest accrued on NSC,"."\n     "."Remuneration,Interest on fixed deposits ",0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//----------------------------------------------------
$old_height=$pdf->rowheight();
$income=$income;
$pdf->Multicell(95,8,"6.  Less deductions exempted U/S 10(34)",0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//----------------------------------------------------
$old_height=$pdf->rowheight();
$income=$income;
$pdf->Multicell(95,8,"7.  Net Total Income",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$income,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-----------------------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"8.  Less deductions under Chapter VI-A",0,0,l);
$pdf->Multicell(40,8,"     ",0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-----------------------------------------------------
$old_height=$pdf->rowheight();
//-----------------------------------------------------
$pdf->Multicell(95,8," (i) U/S 80C",0,0,l);
$pdf->Multicell(45,8," ",0,0,l);
$pdf->Multicell(45,8," ",0,1,l);
$pdf->Multicell(95,8,"     PF",0,0,l);
$pdf->Multicell(40,8,$pftot,0,1,l);
$pdf->Multicell(95,8,"     LIC",0,0,l);
$pdf->Multicell(40,8,$lictot,0,1,l);
$pdf->Multicell(95,8,"     Tuition Fee Paid",0,0,l);
$pdf->Multicell(40,8,$medu,0,1,l);
$pdf->Multicell(95,8,"     State Life Insurance",0,0,l);
$pdf->Multicell(40,8,$slitot,0,1,l);
$pdf->Multicell(95,8,"     Contribution to ULIP or UTI",0,0,l);
$pdf->Multicell(40,8,$mulip,0,1,l);
$pdf->Multicell(95,8,"     U/S 80CCC+80CCD",0,1,l);
$pdf->Multicell(95,8,"     Housing Loan Principle",0,0,l);
$pdf->Multicell(40,8,$mphca,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
//-------------------------------
$pdf->AddPage();
$pdf->SetFont('Arial','',8);
$pdf->MultiCell(190,8,"",0,1,C);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"     U/S80CCC",0,0,l);
$pdf->Multicell(40,8,$m80ccc,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"     U/S80CCD",0,0,l);
$pdf->Multicell(40,8,$m80ccd,0,1,l);
$pdf->Multicell(95,8,"   Gross Qualifying Amount",0,0,l);
$pdf->Multicell(40,8,$gross80c,0,1,l);
$pdf->Multicell(95,8,"   (ii)  U/S80D",0,0,l);
$pdf->Multicell(40,8,$m80d,0,1,l);
$pdf->Multicell(95,8,"   (iii) U/S80DD",0,0,l);
$pdf->Multicell(40,8,$m80dd,0,1,l);
$pdf->Multicell(95,8,"   (iv)  U/S80DDB",0,0,l);
$pdf->Multicell(40,8,$m80ddb,0,1,l);
$pdf->Multicell(95,8,"   (v)   U/S80E",0,0,l);
$pdf->Multicell(40,8,$m80e,0,1,l);
$pdf->Multicell(95,8,"   (vi)  U/S80GG",0,0,l);
$pdf->Multicell(40,8,$m80gg,0,1,l);
$pdf->Multicell(95,8,"   (vii) U/S80U",0,0,l);
$pdf->Multicell(40,8,$m80u,0,1,l);
$pdf->Multicell(95,8,"   (viii)U/S80G",0,0,l);
$pdf->Multicell(40,8,$m80g,0,1,l);
$pdf->Multicell(95,8,"9.   Aggregate of Deductable amount {8(i) to (viii)}",0,0,l);
$pdf->Multicell(40,8,$grosschapter6a,0,1,l);
$pdf->Multicell(95,8,"10.  Taxable Income",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$taxableInc,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-----------------------------------------
$old_height=$pdf->rowheight();
$pdf->Multicell(95,8,"11.  Tax on Total  Income",0,1,l);
$pdf->Multicell(95,8,"  a) Up to Rs.1,50,000/-              NIL",0,0,l);
$pdf->Multicell(40,8,'0',0,1,l);
$pdf->Multicell(95,8,"  b) Rs.1,50,001 To Rs.3,00,000/-     10%",0,0,l);
$pdf->Multicell(40,8,$tax_15_3,0,1,l);
$pdf->Multicell(95,8,"  c) Rs.3,00,001 To Rs.5,00,000/-     20%",0,0,l);
$pdf->Multicell(40,8,$tax_3_5,0,1,l);
$pdf->Multicell(95,8,"  d) Rs.5,00,001  and   Above           30%",0,0,l);
$pdf->Multicell(40,8,$tax_5,0,1,l);
$pdf->Multicell(95,8,"  Total 11 (a) to (d)",0,0,l);
$pdf->Multicell(40,8,$tottax,0,1,l);
$pdf->Multicell(95,8,"12. Educational Cess @3%",0,0,l);
$pdf->Multicell(40,8,$educess,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
//-------------------------------------------------
$old_height=$pdf->rowheight();
$tottax=$tottax+$educess;
$pdf->Multicell(95,8,"13. Total Tax Payable",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$tottax,0,1,l);
$pdf->Multicell(95,8,"14. Less relief U/S 89(i)",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$m89i,0,1,l);
$tottax=$tottax-$m89i;
$pdf->Multicell(95,8,"15. Net Tax Payable",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$tottax,0,1,l);
$pdf->Multicell(95,8,"16. Tax Deducted at source",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$itdedtot,0,1,l);
$baltaxpayable=$tottax-$itdedtot;
$pdf->Multicell(95,8,"17. Balance Tax Payable / Refundable",0,0,l);
$pdf->Multicell(40,8,"     ",0,0,l);
$pdf->Multicell(40,8,$baltaxpayable,0,1,l);
$new_height=$pdf->rowheight();
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(105,$new_height,105,$old_height);
$pdf->line(145,$new_height,145,$old_height);
$pdf->line(10,$pdf->rowheight(),190,$pdf->rowheight());
$pdf->MultiCell(190,8,"Certified that the details above are true to the best of my knowledge and belief.",0,1,C);
$pdf->MultiCell(190,8,"           ",0,1,C);
$pdf->MultiCell(190,8,"Signature:"."\t",0,1,C);
$pdf->MultiCell(190,8,"Name:"."\t",0,1,C);
$pdf->MultiCell(190,8,"Designation:"."\t",0,1,C);
$pdf->MultiCell(190,8,"Office:"."\t",0,1,C);
$pdf->MultiCell(190,8,"Place:C.U.Campus",0,1,l);
$pdf->MultiCell(190,8,"Date:".$curdate,0,1,l);
//-----------------------------------------------------
//pdf creation ends here 
$pdf->Output();
?>
