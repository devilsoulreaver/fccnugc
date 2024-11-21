<?php
include('datefunc.php');
echo "
<html>
<head>
<script language=javascript>
function year_change()
{
frm1.year1.value=parseInt(frm1.year.value)+1;
}
</script>
</head>
<body bgcolor=grey>";

echo "$dst</td><td></td></tr></table><hr>
<center></center></form>
<h2> SALARY CERTIFICATE </h2><hr><form name=frm2 action=\"cert1.php\" method=get><table align=center cellpadding=3><tr><td><h4>Enter the Emp.ID : </h4></td><td><input type=textbox name=empid></td></tr>
<tr><td><h4>Select the Month : </h4></td><td>";
$dst=putdates(0,1,1,"","month1","year1");
echo "$dst<tr><td><h4>S/o / D/o / W/o :</h4></td><td> <input type=textbox name=fname></tr>
<tr><td><h4>House Name :</h4></td><td> <input type=textbox name=hname></tr>
<tr><td><h4>Post Office :</h4></td><td> <input type=textbox name=po></tr>
<tr><td><h4>Villege :</h4></td><td> <input type=textbox name=vlg></tr>
<tr><td><h4>Taluk:</h4></td><td> <input type=textbox name=tlk></tr>
<tr><td><h4>District:</h4></td><td> <input type=textbox name=dt></tr>

</table><hr>
<center><input type=submit><input type=reset></center></form> ";

echo "
</form>
</body>
</html>";
