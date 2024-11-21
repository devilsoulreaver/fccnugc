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
<body bgcolor=#ABSCDFFF>";


echo "$dst</td><td></td></tr></table><hr>
<center></center></form>
<h2> DRAWN DETAILS</h2><hr><form name=frm2 action=\"drawn_details2.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the PF Number : </h4></td><td><input type=textbox name=empid></td></tr>
<tr><td><h4>Select the Period : </h4></td><td>";
        $dst1=putdates(0,1,1,"","month1","year1");
        $dst2=putdates(0,1,1,"","month2","year2");
echo "$dst1</td><td>To</td><td>$dst2</td></tr></table><hr>
<center><input type=submit><input type=reset></center></form> ";

echo "
</form>
</body>
</html>";


