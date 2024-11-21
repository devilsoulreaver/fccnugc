<?php
include ("tabledraws.php");
$billtype = $_POST['billtype'];
$billfrom = $_POST['billfrom'];
$billto = $_POST['billto'];
$data = $_POST['data'];
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=fin123");

$sql="select emppayto_name(empid)::int4 as \"PAYMENT AGENCY\",sum(a.net)::int4 as \"AMOUNT\" from ind_bills_master a,bills_det b where a.btype='$billtype' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto group by emppayto_name(empid)";
$recset1=pg_exec($conn,$sql);
if (pg_numrows($recset1)<=0)
	print "<table align=center><tr><td><br><h1>SORRY....NO MATCHING RESULT </td></tr></table>";
else	
	{
	$sql="select sum(a.net)::int4 as \"AMOUNT\" from ind_bills_master a,bills_det b where a.btype='$billtype' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto";
	$recset2=pg_exec($conn,$sql);
	print drawtab10($recset1);
	//print drawtab10($recset2);
	$data=pg_result($recset2,0,0);
	$retval="<table width=600 bgcolor=#abcdef border=1 align=center>
	<tr><td align=center style=width:400><h3><font color=navy>AMOUNT <td align=left><h3><font color=navy>$data";
	print $retval;
	}
?>

