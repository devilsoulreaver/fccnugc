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
<body>
<h2>Search PF Closure Details</h2><hr><form name=frm1 action=\"pfclosure1.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the Audit Number : </h4></td><td><input type=textbox name=empid></td></tr>
<tr><td><h4>Select the Year : </h4></td><td>";
	$dst="<select name=year language=javascript onchange=\"return year_change()\">";
	for($i=2000;$i<=2050;$i++)
    	{
        $dst.="<option value=$i>$i</option>";
        }
        $dst.="</select>";
echo "$dst</td><td><input type=textbox name=year1></td></tr></table><hr>
<center><input type=submit><input type=reset></center></form>
<h2>Search PF Transaction Details</h2><hr><form name=frm2 action=\"pftrans.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the Audit Number : </h4></td><td><input type=textbox name=empid></td></tr>
<tr><td><h4>Select the Period : </h4></td><td>";
        $dst1=putdates(0,1,1,"","month1","year1");
        $dst2=putdates(0,1,1,"","month2","year2");
echo "$dst1</td><td>To</td><td>$dst2</td></tr></table><hr>
<center><input type=submit><input type=reset></center></form>
<h2>Search PF Loan Details</h2><hr><form name=frm2 action=\"pfloans.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the Audit Number : </h4></td><td><input type=textbox name=empid></td></tr>
<tr><td><h4>Select the Period : </h4></td><td>";
        $dst1=putdates(0,1,1,"","month1","year1");
        $dst2=putdates(0,1,1,"","month2","year2");
echo "$dst1</td><td>To</td><td>$dst2</td></tr></table><hr>
<center><input type=submit><input type=reset></center></form>
</body>
</html>";
?>
