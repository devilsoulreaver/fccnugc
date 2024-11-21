<?php
//echo $empid;
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");

$sql1="select empid as \"EMPID\",empname(empid) as \"NAME\",empdesig(empid) as \"DESIG\",empoffice(empid) as \"OFFICE\" from emp_master where empid='$empid' and empcategoryid(empid)<>'G'";
$recset1=pg_exec($conn,$sql1);
if ( pg_numrows($recset1)==0)
{
	$str="<table align=\"center\" border=\"0\" width=\"50%\">";
	$str.="<tr><td align=\"center\"><font color=\"navy\"><h1>Invalid Empid !!  Try Another........</h1></font></td></tr></table>	";
	print $str;
	return;	
}
else
{
$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"><h1>Transfer Details Of Employee</h1></td></tr></table><br>";
print $head;
$str="<table align=\"center\" border=\"0\" width=\"50%\">";
$fields=array("Emp Id","Name","Desig","Office");
for ($i=0;$i<pg_numrows($recset1);$i++)
	{
	for ($j=0;$j<pg_numfields($recset1);$j++)
		{
		//$field=pg_fieldname($recset1,0,$j);
		$str.="<tr bgcolor=#abcdef><td><h1>$fields[$j]</td>";
		$data=pg_result($recset1,$i,$j);
		$str.="<td  bgcolor=#fedcba><b>$data</tr>";
		//$name=pg_result($recset1,$i,$j);
		//$desig=pg_result($reset1,$i,$j);
		//$office=pg_result($recset1,$i,$j);
		}
	}
}
print $str;
print $sql;      
$sql2="select empid,empname(empid),office_master.name ,wefdate,enddate from emp_transfer ,office_master where emp_transfer.officeid=office_master.id and empid='$empid' and  empcategoryid(empid)<>'G' and getretdate(empid)>current_date order by 3"; 
$recset2=pg_exec($conn,$sql2);
if (pg_numrows($recset2)==0)
{
	$str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\"><h1>No Sufficient Details</h1></font></td></tr></table><br><br>";
print $str;
}
//print $str;
else
{
$str="<table align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"cyan\"> <th>Emp Id<th>EmpName<th>Office<th>WEF Date<th>End Date</th></tr>";
for ($i=0;$i<pg_numrows($recset2);$i++)
{
	$str.="<tr bgcolor=\"cyan\">";
	for($j=0;$j<pg_numfields($recset2);$j++)
	{
		$data=pg_result($recset2,$i,$j);
		$str.="<td align=\"center\">$data";
	}

//print $str;
}
print $str;
//print "HELLO";
}
?>
