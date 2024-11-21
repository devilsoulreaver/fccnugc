<?php
$empname=strtoupper($empname);
function drawtab1($sql)
{
	$conn=pg_connect("dbname=financetest port=5432 host=192.168.0.1 user=finance password=hahahihi");
	if (!$conn)
	        die (pg_error());
	$retval="";
	$head="";
	$data="";
	$recset=pg_exec($conn,$sql);
	if (pg_numrows($recset)<=0)
	        $retval.="<table align=\"center\" border=\"0\" bgcolor=#C0C0C0><h1>There Is No Matching Result</table>";
	else
	{
		$retval.="<table width=\"100%\" border=\"1\" bgcolor=\"#abcdef\" align=\"center\" cellspacing=2> ";
		for ($j=0;$j<pg_numfields($recset);$j++)
			{
				$head=pg_fieldname($recset,$j);
				$retval.="<th align=\"left\">$head";
			}
			$retval.="<br>";	
		for ($i=0;$i<pg_numrows($recset);$i++)
		{	
			$retval.="<tr>";
			for ($j=0;$j<pg_numfields($recset);$j++)
			{
				$data=pg_result($recset,$i,$j);
				$retval.="<td>$data";
			}	
		$empid=pg_result($recset,$i,0);
		$retval.="<td><a href=guest_details.php?empid=$empid target=MainFrame>Details</a></td>";		     }
	}				
	echo $retval;
}
$sql="select empid as \"EMP ID\",empname as \"NAME\",empdesig(empid) as \"DESIGNATION\",empoffice(empid) as \"OFFICE\" from emp_master where empname like '%$empname%' and empcategoryid(empid)='G' order by 2";
drawtab1($sql);
?>
