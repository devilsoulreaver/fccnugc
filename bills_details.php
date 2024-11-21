<?php
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=financetest password=hahahihi");

if ($flag==0)
{	
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
	  <form name=frm1 action=\"bills_details.php\" method=post>
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
	<option value=2015>2015</option>
	<option value=2016>2016</option>
	<option value=2017>2017</option>
	<option value=2018>2018</option>
	<option value=2019>2019</option>
	<option value=2020>2020</option>
	<option value=2021>2021</option>
	<option avlue=2022>2022</option>
	<option value=2023>2023</option>
	<option value=2024>2024</option>
      	</select>
   	<td align=center><input type=\"submit\" name=\"butmon\" value=Get_Bills onClick=\"return func()\" language=\"JavaScript\">
   	</tr>
   	</form>
	</table>
   </body>
	</html>";
	print $retval;
		
}

//******************************************************************************************
if(isset($butmon))	
	{
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
	<form name=frm2 action=bills_details.php method=post>
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
	$retval1.="<tr><td>&nbsp<tr><td colspan=4 align=center><input type=submit name=butbills value=Get_Details onClick=\"return f1()\" language=\"JavaScript\"></tr><tr><td>&nbsp</form></table>";
	print $retval1;
}
//************************************************************************************************
if(isset($butbills))
{
	$retval3="";
	$sql="select typedesc from bill_types where typeid in (select btype from bills where billno between $billfrom and $billto group by btype)";
	$conn=pg_connect("dbname=finance host=192.168.0.1 port=5432 user=financetest password=fin123");
	if(!$conn)
		die(pg_error());
	$recset=pg_exec($conn,$sql);
	if (pg_numrows($recset)<=0)
	{
		$retval3.="<br><br><table align=center border=0><tr><td><h1>SORRY NO MATCHING RESULTS</H1></TR></table>";
	}
	else
	{
		$retval3.="<br><br><table align=center border=1 bgcolor=#abcdef>";
		for ($i=0;$i<pg_numrows($recset);$i++)
		{
			$data=pg_result($recset,$i,0);
			$sql="select case when typeid='PRC' then 'INC' else typeid end  from bill_types where typedesc='$data'";
			$typerec=pg_exec($conn,$sql);
			$type=pg_result($typerec,0,0);
			$retval3.="<tr><td align=center><a href=bills_details1.php?typeid=$type&billfrom=$billfrom&billto=$billto>$data</></td></tr>";
		}
		$retval3.="</table>";
	}
	print $retval3;
}
pg_close($conn);
?>
