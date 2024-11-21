<?php
include ("tabledraws.php");
$year = $_POST['year'];
$month = $_POST['month'];
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");

$retval="<html>
  <head>
    <title></title>
    <meta content=\"\">
    <style></style>
    <script language=\"JavaScript\">
    function func()
    {
	if (document.frm1.month.value==0)
	{
		alert (\"You Have To Select A Month\");
		document.frm1.month.focus();
	}
	elsif (document.frm1.year.value==0000)
	{
		alert (\"You Have To Select A Year\");
		document.frm1.year.focus();
	)
    }
  </script>
  </head>
  <body>
  <table width=60% border=0 bgcolor=navy cellpadding=1 cellspacing=1 align=center>
  <form name=frm1 action=\"bill_details.php\" method=post>
  <tr><td align=center><h3><font color=#ffffff>Select a Month :</td>
  <td align=center><select name=\"month\" >
  	<option value=0>Month</option>
	<option value=1>January</option>
	<option value=2 >Febrauary</option>
	<option value=3 >March</option>
	<option value=4 >April</option>
	<option value=5 >May</option>
	<option value=6 >June</option>
	<option value=7 >July</option>
	<option value=8 >August</option>
	<option value=9 >September</option>
	<option value=10 >October</option>
	<option value=11 >November</option>
	<option value=12 >December</option>
      </select>
    <td align=center>
      <select name=\"year\" >
	<option value=0000>Year</option>
	<option value=2001>2001</option>
	<option value=2002>2002</option>
	<option value=2003>2003</option>
	<option value=2004>2004</option>
	<option value=2005>2005</option>
	<option value=2006>2006</option>
	<option value=2007>2007</option>
	<option avlue=2008>2008</option>
	<option value=2009>2009</option>
	<option value=2010>2010</option>
      </select>
   <td align=center><input type=\"submit\" name=\"butmon\" value=Get_Bills onClick=\"return func()\" language=\"JavaScript\">
   </tr>
   </form>
   </table>
   </body>
</html>";
print $retval;
//******************************************************************************************
//if(isset($butmon))	
//	{
	$retval1="<br><br>
	<script language=\"JavaScript\">
	function f1()
	{
	if (document.frm2.billtype.value==\"null\")
		{
			alert(\"Sorry You Have To Select A Bill Type\");
			return false;
		}
	}	
	</script>
	<table width=50% border=0 bgcolor=#C0C0C0 align=center >
	<form name=frm2 action=bill_details.php method=post>
	<tr>
		<td colspan=4 align=center><h3><font color=navy>Select A Range Of Bill Nos:
	</tr>
	<tr>
		<td>&nbsp
	</tr>
	<tr>
		<td align=center><h3><font color=navy>From :
		<td align=center><select name=billfrom>";
	$m1=date('d/m/Y',mktime(0,0,0,$month,1,$year));
	$m2=date('d/m/Y',mktime(0,0,0,$month+1,1,$year));
	$sql="select billno from bills where this01(billdate)>='$m1' and this01(billdate)<='$m2' order by 1";
	$recset=pg_exec($conn,$sql);
	for($i=0;$i<pg_numrows($recset);$i++)
		{
			$data=pg_result($recset,$i,0);
			$retval1.="<option value=$data>$data</option>";	
		}
	$retval1.="</select>";	
	$retval1.="<td align=center><h3><font color=navy>To  :<td align=center><select name=billto>";
	$sql="select billno from bills where this01(billdate)>='$m1' and this01(billdate)<='$m2' order by 1";
        $recset=pg_exec($conn,$sql);
        for($i=0;$i<pg_numrows($recset);$i++)
        {
		$data=pg_result($recset,$i,0);
		$retval1.="<option value=$data>$data</option>";
	}
	$retval1.="</select>";
	$retval1.="</tr><tr><td>&nbsp</tr> 
	<tr><td colspan=4 align=center><font color=navy><h3>Of Type &nbsp &nbsp 
	<select name=billtype>
	<option value=null>BILL TYPES";	
	$sql="select typeid,typedesc from bill_types ";
	$recset=pg_exec($conn,$sql);
	for($i=0;$i<pg_numrows($recset);$i++)
	{
		$data_id=pg_result($recset,$i,0);
		$data=pg_result($recset,$i,1);
		$retval1.="<option value=$data_id>$data";
	}	
	$retval1.="</select></tr>
	<tr><td>&nbsp</tr>
	<tr><td colspan=4 align=center><input type=submit name=butbills value=Get_Details onClick=\"return f1()\" language=\"JavaScript\"></tr>
	<tr><td>&nbsp</form></table>";
	print $retval1;
	//}
//************************************************************************************************
if(isset($butbills))
	{
	$conn=pg_connect("dbname=finance host=192.168.0.1 port=5432 user=finance password=hahahihi");
	
	$sql="select emppayto_name(empid) as \"PAYMENT AGENCY\",sum(a.net)::numeric as \"AMOUNT\" from ind_bills_master a,bills_det b where a.btype='$billtype' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto group by emppayto_name(empid)";
	$recset1=pg_exec($conn,$sql);
	if (pg_numrows($recset1)<=0)
		print "<br><br><table align=center><tr><td><br><h1>SORRY....NO MATCHING RESULT </td></tr></table>";
	else
	        {
	        $sql="select sum(a.net)::numeric as \"AMOUNT\" from ind_bills_master a,bills_det b where a.btype='$billtype' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto";
	        $recset2=pg_exec($conn,$sql);
	        $retval2="<br><br><table align=center border=1 width=60% bgcolor=#abcdef><tr>";
		for($i=0;$i<pg_numfields($recset1);$i++)
			{
				$data=pg_fieldname($recset1,$i);
				$retval2.="<th align=left bgcolor=#fedcba>$data";
			}
		for($i=0;$i<pg_numrows($recset1);$i++)
		{
			$retval2.="<tr>";
			for($j=0;$j<pg_numfields($recset1);$j++)
				{
					$data=pg_result($recset1,$i,$j);
					$retval2.="<td align=left>$data";
				}
			$retval2.="</tr>";	
		}
		print $retval2;
		$data=pg_result($recset2,0,0);
		$retval3="<tr bgcolor=#fedcba >
		<td align=center><h3><font color=navy>TOTAL <td align=left><h3><font color=navy>$data";
		print $retval3;
		}
		pg_close($conn);
	}	
?>
