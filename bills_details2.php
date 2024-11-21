<?php
$retval="";
$typeid = $_POST['typeid'];
$billfrom = $_POST['billfrom'];
$billto = $_POST['billto'];
$data = $_POST['data'];
$emppayto = $_POST['emppayto'];
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");

$sql="select empid as \"EMPID\",empname(empid) as \"NAME\",gross as \"GROSS\",deds as \"DEDS\",net as \"NET\" ,to_char(this01(ofdate)-1,'Mon : YYYY') as \"MONTH\" from ind_bills_master a,bills_det b where ind_bill_no in (select ind_billno from bills_det where billno between $billfrom and $billto) and a.ind_bill_no=b.ind_billno and emppayto(empid)='$emppayto' and a.btype='$typeid' order by 2";
$recset=pg_exec($conn,$sql);
if (pg_numrows($recset)<=0)
{
	$retval.="<table align=center border=0><tr><td><h1>Sorry No Matching Found</td></tr></table>";
}
else
{
	$retval.="<script language=JavaScript>
		window.status=\"Please Wait\";
		</script>
		<table align=center border=1 width=80% bgcolor=#abcdef><tr bgcolor=#fedcba>";
	for($i=0;$i<pg_numfields($recset);$i++)
		{
		$title=pg_fieldname($recset,$i);
		$retval.="<th align=left><h3>$title </h3></th>";
		}
	for($i=0;$i<pg_numrows($recset);$i++)
	{
		$retval.="<tr>";
		for($j=0;$j<pg_numfields($recset);$j++)
		{
			$data=pg_result($recset,$i,$j);
			$retval.="<td>$data";
		}
		
	}
	$retval.="</tr></table>";
}
print $retval;
pg_close($conn);
?>
