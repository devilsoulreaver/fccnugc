<?php
//echo $empid;
$empid=$_POST['empid'];
//$month = $_POST['month'];
//$year = $_POST['year'];
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");

$sql1="select empid as \"EMPID\",empname(empid) as \"NAME\",empdesig(empid) as \"DESIG\",empoffice(empid) as \"OFFICE\",get_payscale(empid) from emp_master where empid='$empid' and empcategoryid(empid)<>'G'";
$recset1=pg_exec($conn,$sql1);
if ( pg_numrows($recset1)==0)
{
	$str="<table align=\"center\" border=\"0\" width=\"25%\">";
	$str.="<tr><td align=\"center\"><font color=\"navy\"><h1>Invalid Empid !!  Try Another........</h2></font></td></tr></table>	";
	print $str;
	return;	
}
else
{
$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"><h1>DA / INCREMENT ARREAR TO NPS</h1></td></tr></table><br>";
print $head;
$str="<table align=\"center\" border=\"0\" width=\"25%\">";
$fields=array("Employee ID","Name","Designation","Office","Pay Scale ");
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
// $sql2="select a.empid,a.cur_bp,a.wefdate,a.sanc_date,b.ordno,b.orddate from emp_bp_incr as a inner join bp_incr_log as b on  a.empid='$empid' and  empcategoryid(a.empid)<>'G' and getretdate(a.empid)::date>current_date and a.empid=b.empid and a.refid=b.refid and a.wefdate=b.wefdate order by 3";
$sql2= "select empid,wefdate,amount,percentage,remarks from da_arr_nps where empid='$empid' order by 2";

$recset2=pg_exec($conn,$sql2);
if (pg_numrows($recset2)==0)
{
	$str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\"><h1>No Sufficient Details</h1></font></td></tr></table><br><br>";
print $str;
}
//print $str;
else
{
$str="<table align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"cyan\"> <th>Emp Id<th>WEF Date<th>Amount</th><th>percentage<th>Remarks<th></tr>";
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
