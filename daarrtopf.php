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
<body bgcolor=grey>
<h2> DA ARREAR TO PF DETAILS  </h2><hr><form name=frm1 action=\"daarrtopf1.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the Audit Number : </h4></td><td><input type=textbox name=empid></td></tr>
";
	//$dst="<select name=year language=javascript onchange=\"return year_change()\">";
	//for($i=2000;$i<=2050;$i++)
    	{
        $dst.="<option value=$i>$i</option>";
        }
        $dst.="</select>";
echo "$dst</td><td></td></tr></table><hr>
<center><input type=submit><input type=reset></center></form>
<h2> DA ARREAR TO CASH DETAILS</h2><hr><form name=frm2 action=\"daarrtopf2.php\" method=post><table align=center cellpadding=3><tr><td><h4>Enter the Audit Number : </h4></td><td><input type=textbox name=empid>
";
       // $dst1=putdates(0,1,1,"","month1","year1");
       // $dst2=putdates(0,1,1,"","month2","year2");
echo "$dst1</td><td></td><td>$dst2</td></tr></table><hr>
<center><input type=submit><input type=reset></center></form>
<h2></h2><hr><form name=frm2 action=\"pfl.php\" method=get><table align=center cellpadding=3><tr><td><h4>
";
        //$dst1=putdates(0,1,1,"","month1","year1");
        //$dst2=putdates(0,1,1,"","month2","year2");
echo "$dst1</td><td></td><td>$dst2</td></tr></table><hr>

</body>
</html>";
?>
