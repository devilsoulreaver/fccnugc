<?php

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());
$flag=0;
$sql="update emp_master set ";
if ($chk3==1) { $sql.=" doj='$txt3',";$flag=1;}
if ($chk4==1) { $sql.=" religion='$txt4',"; $flag=1;}
if ($chk5==1) { $sql.=" caste='$txt5',"; $flag=1;}
if ($chk6==1) { $sql.=" res_category='$selcat',"; $flag=1;}
if ($chk20==1) { $sql.=" dob='$txt20',"; $flag=1;}

$sql=substr($sql,0,-1);
$sql.=" where empid='$txt0'";
if ($flag==1) pg_exec($conn,$sql);

if ($chk7==1) 
	{ 
	$sql="update emp_transfer set enddate='01/03/2003' where empid='$txt0' and enddate='01/01/1900'";
	pg_exec($conn,$sql);
	$sql="insert into emp_transfer values('$txt0','$seloffice','01/03/2003','01/01/1900')";
	pg_exec($conn,$sql);
	}
if ($chk8==1||$chk9==1||$chk10==1)
	{
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_desig where length(refid::text)<9");
	$refid=pg_result($refidrec,0,0);

	$sql="update emp_desig set enddate='$txt9' where empid='$txt0' and enddate='01/01/1900'";
	pg_exec($conn,$sql);

	$sql="insert into emp_desig (empid,desigid,wefdate,sanc_date,enddate,refid) values('$txt0','$seldesig','$txt9','$txt10','01/01/1900',$refid)";
	pg_exec($conn,$sql);
	}

if ($chk11==1||$chk12==1||$chk12==1)
	{
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_scale where length(refid::text)<9");
	$refid=pg_result($refidrec,0,0);
	$scalerec=pg_exec($conn,"select id,payid from pay_scale where scale='$selpayscale'");
	$sid=pg_result($scalerec,0,0);
	$payid=pg_result($scalerec,0,1);
	echo $sid;
	echo $payid;
	$sql="update emp_scale set enddate='$txt9' where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);

	$sql="insert into emp_scale (empid,pay_id,payscale_id,wefdate,enddate,sanc_date,refid) values('$txt0','$payid','$sid','$txt12','01/01/9999','$txt13',$refid)";
	pg_exec($conn,$sql);
 	}

if ($chk14==1||$chk15==1||$chk16==1)
	{
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_bp_incr where length(refid::text)<9");
	$refid=pg_result($refidrec,0,0);


	$sql="insert into emp_bp_incr (empid,cur_bp,wefdate,sanc_date,refid) values('$txt0','$txt14','$txt15','$txt16',$refid)";
	pg_exec($conn,$sql);
	
	}
if ($chk18==1)
	{
	$sql="select * from leave_account where empid='$txt0' and leaveid='EL' and update_on::date='31/12/2002'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
	{
	$sql="insert into leave_account values('$txt0','EL',$txt18,'31/12/2002')";
	pg_exec($conn,$sql);
	}
	}
if ($chk19==1)
	{
	$sql="select * from leave_account where empid='$txt0' and leaveid='HPL' and update_on::date='31/12/2002'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
	{
	$sql="insert into leave_account values('$txt0','HPL',$txt19,'31/12/2002')";
	pg_exec($conn,$sql);
	}
	}
if ($chk20==1)
	{
	$sql="update emp_master set doret=getretdate(empid) where empid='$txt0'";
	pg_exec($conn,$sql);
	}
echo "<center><h1>Update the Details of $txt2</h1></center><br><form name=frm action=newempdet.html><center><input type=submit value=\"Next\"></center></form>";



?>

