<?php

if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());

if ($chk6==1)
	{
	$sql="select * from leave_account where empid='$empid' and leaveid='EL' and update_on::date='$txt8'";
	$tempres=pg_exec($conn,$sql);
	
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into leave_account values('$empid','EL',$txt6,'$txt8')";
		pg_exec($conn,$sql);
		}
	else if(pg_numrows($tempres)>0)
		{
		$sql="delete from leave_account where empid=$empid and leaveid='EL'";
		pg_exec($conn,$sql);
		$sql="insert into leave_account values('$empid','EL',$txt6,'$txt8')";
		pg_exec($conn,$sql);
		}
	}
if ($chk7==1)
	{
	$sql="select * from leave_account where empid='$empid' and leaveid='HPL' and update_on::date='$txt8'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into leave_account values('$empid','HPL',$txt7,'$txt8')";
		pg_exec($conn,$sql);
		}
	else if(pg_numrows($tempres)>0)
		{
		$sql="delete from leave_account where empid=$empid and leaveid='HPL'";
		pg_exec($conn,$sql);
		$sql="insert into leave_account values('$empid','HPL',$txt7,'$txt8')";
		pg_exec($conn,$sql);
		}
	}
if ($chk5==1)
	{
	$sql="update emp_master set hpl_crd_date='$txt5' where empid='$empid'";
	pg_exec($conn,$sql);
	}
echo "<center><h1>Update the Details of $txt2</h1></center><br><form name=frm action=leaveupdate.html><center><input type=submit value=\"Next\"></center></form>";

?>

