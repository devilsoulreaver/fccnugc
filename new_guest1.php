<?php
print "Trem : $term";
if($conn=pg_connect("host=192.168.0.1 dbname=financetest port=5432 user=finance password=hahahihi"));
	else die(pg_error());
	
$sql="select empid from emp_master where empid='$empid'";
$res=pg_exec($conn,$sql);
$retval="<html><body><align=\"center\">";
if ($len=pg_numrows($res))
	{
		$retval.="<h1>There Is Already An employee With This ID<br>Try another ";
		$retval.="<br>&nbsp<br>&nbsp ";
		$retval.="<form name\"frm2\" action=\"new_guest.php\" method=\"post\">
		<table width=\"50%\" align=\"center\" border=\"0\">
		<tr><td><input type=\"submit\" value=\"Next\">
		</td></tr></table></form>";
	}	
		
else
	{
		$sql="begin work";
		pg_exec($conn,$sql);
		$sql="insert into emp_master (empid,empname,edu_qual,tempaddress,address,permphone,mobno,sex,dob,religion,caste,doj,doret,conv_date,joining_ordno,joining_orddate,pannumber)";
	if ($term=="days")
		{
			$doret_query="select '$doj'::date+$termdays-1";
			$doret_record=pg_exec($conn,$doret_query);
			$doret=pg_result($doret_record,0,0);
		}
	if ($term=="month")
		{
			$doret_query="select addmonths('$doj'::date,$termdays)::date-1";
			$doret_record=pg_exec($conn,$doret_query);
			$doret=pg_result($doret_record,0,0);
		}
	if($term=="year")
		{
			$doret_query="select '$doj'::date+$termdays*365-1";
			$doret_rec=pg_exec($conn,$doret_query);
			$doret=pg_result($doret_rec,0,0);
		}
	
	$conv_date=$doj;
	$sql.="values('$empid','$empname','$eduqual','$presaddress','$permaddress','$phone','$mob','$sex','$dob','$religion','$caste','$doj','$doret','$conv_date','$ordno','$orddate','$panno')";
	//print $sql;
	pg_exec($conn,$sql);
	$sql="insert into emp_transfer values('$empid','$office','$doj','01/01/1900')"; 
	//print $sql;
	pg_exec($conn,$sql);
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_desig where length(refid::text)<=9");
	$refid=pg_result($refidrec,0,0);
	$sql="insert into emp_desig (empid,desigid,wefdate,sanc_date,enddate,refid) values('$empid','$desig','$doj','$doj','01/01/1900',$refid)";
	//print $sql;
	pg_exec($conn,$sql);
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_bp_incr where length(refid::text)<=10");
	$refid=pg_result($refidrec,0,0);
        $sql="insert into emp_bp_incr (empid,cur_bp,wefdate,sanc_date,refid) values('$empid','$pay','$doj','$doj',$refid)";
	//print $sql;
	pg_exec($conn,$sql);
	$sql="insert into guest_details_edit (empid,termfrom,termto,ordno,orddate) values ('$empid','$doj','$doret','$ordno','$orddate')";
	//print $sql;
        pg_exec($conn,$sql);
	$sql="insert into emp_payoption values('$empid','1','$sbtacno','SB','M.G.U Campus','--','$doj')";
	//print $sql;
	pg_exec($conn,$sql);
	pg_exec($conn,"commit");
	$retval="<H1 align=\"center\">The Employee  Details Of  $empname with ID ($empid) Submitted Successfully </H1>
	<form name=\"frm3\" action=\"new_guest.php\" method=\"post\">
	<table align=\"center\"><tr><td><input name=\"submit\" type=\"submit\" value=\"Next\"></input></td></tr></table></from>";
	echo $retval;

	}
	
?>

