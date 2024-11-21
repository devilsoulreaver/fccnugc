<?php
function tab1($sql)
{
	$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
	if(!$conn)
		die(pg_error());
	$recset=pg_exec($conn,$sql);
	$retval="";
	for ($i=0;$i<pg_numrows($recset);$i++)
	{
		$retval.="<br><br><table align=center width=80% border=1 cellspacing= cellpadding=0 bgcolor=#abcdef>";
		for($j=0;$j<pg_numfields($recset);$j++)
		{
			$field=pg_fieldname($recset,$j);
			$data=pg_result($recset,$i,$j);
			$retval.="<tr><b><td align=left style=width:200 bgcolor=#fedcba><h3>$field</h3><td align=left>$data</tr>";
		}
		$retval.="</table>";
	}
	echo $retval;
}

