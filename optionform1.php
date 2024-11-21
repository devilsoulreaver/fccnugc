<?php

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());

$flag=0;
$sql="update emp_master set ";
if ($chk6==1) { $sql.=" sbtacno='$txt6',";$flag=1;}
if ($chk5==1) { $sql.=" salwdtype='$selpayment',";$flag=1;}

$sql=substr($sql,0,-1);
$sql.=" where empid='$txt1'";
if ($flag==1) pg_exec($conn,$sql);

if ($chk4==1) 
	{
	$sql="delete from emp_transfer where empid='$txt1' and enddate='01/01/1900'";
	pg_exec($conn,$sql); 
	$sql="insert into emp_transfer values('$txt1','$seloffice','01/03/2003','01/01/1900')";
	pg_exec($conn,$sql);
	}

if ($chk3==1)
	{
	/*$refidrec=pg_exec($conn,"select max(refid)+1 from emp_desig where length(refid::text)<9");
	$refid=pg_result($refidrec,0,0);

	$sql="update emp_desig set enddate='01/03/2003' where empid='$txt1' and enddate='01/01/1900'";
	pg_exec($conn,$sql);

	$sql="insert into emp_desig (empid,desigid,wefdate,sanc_date,enddate,refid) values('$txt1','$seldesig','01/03/2003','01/03/2003','01/01/1900',$refid)";*/
	
	$sql="insert into desig_change values('$txt1','$seldesig')";
	pg_exec($conn,$sql);
	}

echo "<center><h1>Update the Details of $txt2</h1></center><br><form name=frm action=optionform.html><center><input type=submit value=\"Next\"></center></form>";



?>

