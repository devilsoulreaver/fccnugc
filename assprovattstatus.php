<html>
<head>
<title>Employee Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<form name=frm action="assprovattstatus1.php" method=post>
<table bgcolor=#B8C6CB width=100% align=center cellspacing="0" cellpadding="2" border=1 bordercolor=#FFFFFF>
<tr ><td colspan=2>Select the Month </td></tr>
<tr><td>
<?php
include('datefunc.php');
$dt=putdates(0);

//************************************************************
echo "<b>Month : </b></td><td>$dt";
?>
</td>
</tr>
</table>
<center><input type=submit></center>
</form>
<hr>
</body>
</html>

