<?php
if ($conn1 = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());

$sql="select empid,empname from emp_master where empoffice(empid)='$offid' and empcategoryid(empid)='G'";
$rec=pg_exec($conn1,$sql);
for($i=0;$i<pg_numrows($rec);$i++)
	{
	$data=pg_result($rec,$i,0);
	$empname=pg_result($rec,$i,1);
	//$lday=$$data;
	$lday=$_REQUEST[$data];
	if ($lday<>'X')
	{
	print $data;
	print $ofdate;
	print $lday;
	$sql="insert into guest_emp_leave_report (empid,lastmonth,ldays) values ('$data','$ofdate',$lday)";
#      print $sql;
	pg_exec($conn1,$sql);
	}
	}
print "<form action=empattendence1_guest.php><center><h3>The Attendance Updated Successfully....</h3><br><input type=submit value=Next> </center></form>";
?>
