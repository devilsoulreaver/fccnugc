<html>
<head>
<body>
<tr bgcolor=#FFF2FF><td><a href="tappal_reg.php" target="mainFrame"><font color=red ><h3>back</h3><tr bgcolor=#FFF2FF></a></td></tr>
</body>
<?php
//echo $empid;
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");

$sql1="select a.refid ,b.name,a.received_on,a.description,a.given_to,a.gave_on from tappal_register as a inner join tappal_types b on a.refid>2008000000 and  a.type=b.id";
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
$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=pink><td align=\"center\"><h1>TAPPAL STATUS</h1></td></tr></table><br>";
print $head;
//$str="<table align=\"center\" border=\"0\" width=\"50%\">";
//$fields=array("","Name","Designation","Office","Pay Scale ");
for ($i=0;$i<pg_numrows($recset1);$i++)
	{
	for ($j=0;$j<pg_numfields($recset1);$j++)
		{
		//$field=pg_fieldname($recset1,0,$j);
		$str.="<tr bgcolor=blue><td><h1>$fields[$j]</td>";
		$data=pg_result($recset1,$i,$j);
		$str.="<td  bgcolor=blue><b>$data</tr>";
		//$name=pg_result($recset1,$i,$j);
		//$desig=pg_result($reset1,$i,$j);
		//$office=pg_result($recset1,$i,$j);
		}
	}
}
//print $str;
//print $sql;
$sql2="select a.refid ,b.name,a.received_on,a.description,a.nameid,a.orderdate,c.name,a.given_to,a.gave_on from tappal_register as a,tappal_types as b , office_master as c  where  a.refid>2008000000 and  a.type=b.id and a.office=c.id order by 3;";
$recset2=pg_exec($conn,$sql2);
if (pg_numrows($recset2)==0)
{
	$str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"#ABCDEF8B\"><h1>No Sufficient Details</h1></font></td></tr></table><br><br>";
print $str;
}
//print $str;
else
{
$str="<table align=\"center\" border=\"0\" width=\"100%\"><tr bgcolor=\"#ABCDEF\"><h2> <th>FileNo<th>FileType<th><font color=red>Receiving Date </font><th>Description</th><th>name&id<th>Dated<th>Office<th>Allotted To<th>Alloted Date<h2></tr>";
for ($i=0;$i<pg_numrows($recset2);$i++)
{
	$str.="<tr bgcolor=#AAAAA1>";
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

</head>
</html>