<html>
<head>
<title>Employee Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<form name=frm action="prasstatt.php" method=post>
<table bgcolor=#B8C6CB width=800 align=center cellspacing="0" cellpadding="2" border=1 bordercolor=#FFFFFF>
<tr>
<td> <b>&nbsp &nbsp Select an Office :</b></td><td>
<select name="seloff">
<option value=notselected>Select Office</option>
<?php
include('datefunc.php');
$dt=putdates(0);
// connecting to the database
//***********************************************************
if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());

//selecting the offices
//***********************************************************
$qry = "select name from office_view order by 1";

if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);

for($i=0;$i<pg_numrows($rset);$i++)
	{
	$data=pg_result($rset,$i,0);
	echo "<option value=\"$data\">$data</option>";
	}
//************************************************************
echo "</select></td></tr><tr><td><b>Month : </b></td><td>$dt</td></tr>";
?>

</select></td></tr>
</table>
<center><input type=submit></center>
</form>
<hr>
<table align="center"><tr><td><img src="emblem.jpg" height=40 width=40></td><td> Finance Branch , University of Calicu//t &copy 2003</td></tr></table>
</body>
</html>

