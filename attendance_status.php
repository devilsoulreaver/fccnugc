<?php
$year = $_POST['year'];
$month = $_POST['month'];
$m1=date("d/m/Y",mktime(0,0,0,$month,1,$year));
//print "The Request Under Process........ $m1";

print "<table><tr bgcolor=#a2a6c7><td><h3>The Attendance Status for the Month </h3></td><td><h2>";
print strftime('%B - %Y',mktime(0,0,0,$month,1,$year));
print " </h2></td></tr></table>";

$conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=hahahihi");


$sql="select  id,name from office_view order by name";
//print $sql;
$rset=pg_exec($conn,$sql);

$mrec=pg_exec($conn,"select next01('$m1')");
$m1=pg_result($mrec,0,0);


print "<table border=1 align=center><tr bgcolor=#9FD2FF><th>Office</th><th>Att.Got</th><th>Total Emps.</th><th></th></tr>";
for($i=0;$i<pg_numrows($rset);$i++)
{	
	$office=pg_result($rset,$i,1);
	$officeid=pg_result($rset,$i,0);
	$sql="select coalesce(count(distinct a.empid),0) from emp_master a,emp_transfer b where b.officeid='$officeid' and empcategoryid(a.empid)<>'G' and empdesig(a.empid)<> 'Assistant (Provisional)' and a.doret>current_date and got_attendence(a.empid,'$m1')='Y' and b.enddate='01/01/1900' and a.empid=b.empid";
	$trec1=pg_exec($conn,$sql);
	
	$sql="select count(distinct a.empid) from emp_master a,emp_transfer b where b.officeid='$officeid' and empcategoryid(a.empid)<>'G' and empdesig(a.empid)<> 'Assistant (Provisional)' and a.doret>current_date and a.empid=b.empid and b.enddate='01/01/1900'";
	$trec2=pg_exec($conn,$sql);
	
	$totno=pg_result($trec2,0,0);
	$gotno=pg_result($trec1,0,0);
	
	if ($totno<>$gotno) print "<tr bgcolor=#FFA69A>"; else print "<tr>";
	print "<td>$office</td>";
	print "<td>$gotno</td>";
	print "<td>$totno</td>";
	if ($totno<>$gotno) 
	{
	print "<td><a href=getpendingatt.php?office=$officeid&ofdate=$m1 target=mainFrame>Details</a></td></tr>";
	}
	else
	{
		print "<td>.</td></tr>";
	}
	
}
print "</table>";

?>
