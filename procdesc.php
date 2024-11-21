<html><head><link target=_main>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
</head><body>

<table width=75% bgcolor=#B6FFFA>
<tr>
<td>
<h2>The Procedures in Finance Database</h2>
</td>
</tr>
</table>

<?php	
include('tabledraws.php');
$conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=fin123");

#********************************************************************
# the functions
$qry="select proname from pg_proc where proowner = (select usesysid from pg_user where usename='finance') order by proname";
$qry=stripslashes($qry);
if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);
print "<ul>";
for ($i=0;$i<pg_numrows($rset);$i++)
	{
	$data=pg_result($rset, $i,0);
	echo "<li><a href=\"#$data\">$data</a></li>";
	}
print "</ul>";

for($k=0;$k<pg_numrows($rset);$k++)
	{
	$procsel=pg_result($rset,$k,0);
	$qry="SELECT format_type(p.prorettype, NULL) as \"Return Type\",oidvectortypes(p.proargtypes) as \"Arguments\", l.lanname as \"Procedure Language\", p.prosrc as \"Source\" FROM pg_proc p,  pg_language l, pg_user u WHERE p.prolang = l.oid AND p.proowner = u.usesysid  AND p.prorettype <> 0 and (pronargs = 0 or oidvectortypes(p.proargtypes) <> '')  AND p.proname ='$procsel'";
	$qry=stripslashes($qry);
	if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	echo "<a name=\"#$procsel\"></a><center><h3> The Details of The Function :  <i>$procsel</i></h3></center><hr>";
	for ($j=0;$j<pg_numrows($rset1);$j++)
   		{
   		echo drawtab2($rset1,$j,1);
   		$data=pg_result($rset1,$j,3);
   		echo "<table border=1 align=center width=785><tr width=785><td><b>Source Code</b></td></tr><tr><td width=785><pre>$data</pre></td></tr></table><hr>";
		}
	}
?>
</body>
</html>
