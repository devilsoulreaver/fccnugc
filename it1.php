<html>
<head>
<body>
<tr bgcolor=#FFF2FF><td><a href="it.php" target="mainFrame"><font color=red ><h3>back</h3><tr bgcolor=#FFF2FF></a></td></tr>
</body>
<?php
include('tabledraws.php');
include('table_draws.php');
//echo $empid;
//print $empid;
//print $selyear;
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
// $sql1="select empid as \"EMPID\",empname(empid) as \"NAME\",empdesig(empid) as \"DESIG\",empoffice(empid) as \"OFFICE\" from emp_master where empid='$empid'";
// $recset1=pg_exec($conn,$sql1);
// if ( pg_numrows($recset1)==0)
// {
// 	$str="<table align=\"center\" border=\"0\" width=\"50%\">";
// 	$str.="<tr><td align=\"center\"><font color=\"navy\"><h1>Invalid Empid !!  Try Another........</h1></font></td></tr></table>	";
// 	print $str;
// 	return;	
// }
// else
// {
// $head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"><h1>Income Tax Assesment of the Employee</h1></td></tr></table><br>";
// print $head;
// $str="<table align=\"center\" border=\"0\" width=\"50%\">";
// $fields=array("Employee ID","Name","Designation","Office");
// for ($i=0;$i<pg_numrows($recset1);$i++)
// 	{
// 	for ($j=0;$j<pg_numfields($recset1);$j++)
// 		{
// 	
// 		$str.="<tr bgcolor=#abcdef><td><h1>$fields[$j]</td>";
// 		$data=pg_result($recset1,$i,$j);
// 		$str.="<td  bgcolor=#fedcba><b>$data</tr>";
// 		
// 		}
// 	}
// }
// 
// print $str;
// 
// $bfrom=$selyear.'000001';
// $bto=$selyear.'008000';
// $sql1="select sum(gross)::double precision as \"Gross Salary : \" from bills_view where empid=$empid and billno between $bfrom and $bto and btype not in ('TSUR','MRI') ;";
// //echo $sql1;
// $rset=pg_exec($conn,$sql1);
// $gross=pg_result($rset,0);
// 	if ($gross>0)
// 		{
// 		$str="<table align=\"center\" border=\"0\" width=\"50%\" bgcolor=#abcdef >";
//  		$str.="<tr><td align=\"center\"><font color=\"navy\" >Gross Salary:</font></td><td><font   color=black>$gross</td></tr></table>	";
//  		print $str;
// 		}
// 	
// $sql1="select sum(amount)::double precision as \"Profession Tax  \"  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='PROFTAX' ;";
// $rset=pg_exec($conn,$sql1);
// 
// $ptx=pg_result($rset,0);
// 	$str="<table align=\"center\" border=\"0\" width=\"50%\" bgcolor=#abcdef >";
//  	$str.="<tr><td align=\"center\"><font color=\"navy\" >Profession Tax :</font></td><td><font   color=black>$ptx</td></tr></table>	";
//  	print $str;
// 
// $sql1="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='PFS' ;";
// $rset=pg_exec($conn,$sql1);
// $pfs=pg_result($rset,0);
// 	if($pfs>0)
// 	{
// 	$str="<table align=\"center\" border=\"0\" width=\"50%\" bgcolor=#abcdef >";
//  	$str.="<tr><td align=\"center\"><font color=\"navy\" >PF subscription :</font></td><td><font   color=black>$pfs</td></tr></table>	";
//  	print $str;
// 	}
// 
// $sql1="select sum(amount)::double precision  from paybill where ind_bill_no in (select ind_bill_no from bills_view where  billno between $bfrom and $bto and empid=$empid and btype not in ('TSUR','MRI')) and indid='SLI' ;";
// $rset=pg_exec($conn,$sql1);
// $sli=pg_result($rset,0);
// 	if ($sli>0)
// 		{
// 		$str="<table align=\"center\" border=\"0\" width=\"50%\" bgcolor=#abcdef >";
//  		$str.="<tr><td align=\"center\"><font color=\"navy\" >SLI:</font></td><td><font   color=black>$sli</td></tr></table>	";
//  		print $str;
// 		}

$sql="select itemid,amount,type from emp_inc_tax_estimate where empid=$empid and finyear='2008:2009' order by type;";
$rset=pg_exec($conn,$sql);
$mphca=0;
$mitex=0;
echo "SAAAAAAA";
$row=0;
while($row=pg_fetch_array($rset))
	{
	echo "Mujeeb";
	if($row['itemid']='PHCA')
		{
		$mphca=$row['amount'];
		echo $mphca;
		}
	else if (($row['itemid']='ITEX'))
		$mitex=$row['amount'];
	}
echo "NNNNNNNNN";












?>

</head>
</html>