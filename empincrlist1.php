<html>
<head>
<title>Employee Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<form name=frm action="empincrlist.php" method=post>
<table bgcolor=#B8C6CB width=800 align=center cellspacing="0" cellpadding="2" border=1 bordercolor=#FFFFFF>
<tr>
<td> <b>&nbsp &nbsp Select Type:</b></td><td>
<select name="seloff">
<option value=notselected>Select Type</option>
<option value=self>Self-drawing only</option>
<option value=estd>Establishment only</option>
<option value=both>Both</option>
</select></td></tr><tr><td>
<?php
include('datefunc.php');
$dt=putdates(0);

//************************************************************
echo "</select></td></tr><tr><td><b>Month : </b></td><td>$dt</td></tr>";
?>
</td>
</tr>
</table>
<center><input type=submit></center>
</form>
<hr>
<table align="center"><tr><td><img src="emblm.gif" height=40 width=40></td><td> Finance Branch ,M.G University @ 2009</td></tr></table>
</body>
</html>

