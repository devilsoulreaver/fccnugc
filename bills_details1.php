<?php
$retval2="";
$typeid = $_GET['type'];
$billfrom = $_GET['billfrom'];
$billto = $_GET['billto'];
$data = $_GET['data'];
$emppayto = $_GET['emppayto'];
print $typeid;
print 'sdsdsd';
$conn=pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
// $sql="select emppayto_name(empid) as \"PAYMENT AGENCY\",sum(a.net)::int4 as \"AMOUNT\",emppayto(empid) from ind_bills_master a,bills_det b where a.btype='$typeid' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto group by emppayto_name(empid),emppayto(empid)";

$sql="select emppayto_name(empid) as \"PAYMENT AGENCY\",sum(a.net)::int4 as \"AMOUNT\",emppayto(empid) from ind_bills_master a,bills_det b where a.btype='$typeid' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto group by emppayto_name(empid),emppayto(empid)";
$recset=pg_exec($conn,$sql);
//print $typeid;
if (pg_numrows($recset)<=0)
   $retval2= "<br><br><table align=center><tr><td><br><h1>SORRY....NO JISH MATCHING RESULTS </td></tr></table>";
else
   {
   	$sql="select sum(a.net)::int4 as \"AMOUNT\" from ind_bills_master a,bills_det b where a.btype='$typeid' and a.ind_bill_no=b.ind_billno and b.billno between $billfrom and $billto";
   	$recset1=pg_exec($conn,$sql);
   	$retval2="<br><br><table align=center border=1 width=50% bgcolor=#abcdef><tr>";
	for($i=0;$i<pg_numfields($recset);$i++)
   	{
	   $data=pg_fieldname($recset,$i);
	   $retval2.="<th align=left bgcolor=#fedcba>$data";
	}
  	 for($i=0;$i<pg_numrows($recset);$i++)
	   {
		   $retval2.="<tr>";
		   for($j=0;$j<pg_numfields($recset);$j++)
   			{
			   $data=pg_result($recset,$i,$j);
			   if ($j==1)
			   {
			   	$retval2.="<td align=right>$data";
			   }
			   else
			   {
			      $retval2.="<td align=left>$data";
			   }
			   if ($j==1)
			   break;
			}
  		   
		   $emppayto=pg_result($recset,$i,2);
		   
		   $retval2.="<td> <a href=bills_details2.php?emppayto=$emppayto&billfrom=$billfrom&billto=$billto&typeid=$typeid target=Mainframe>Details</a></tr>";
  	  }
 }
   print $retval2;
   $data=pg_result($recset1,0,0);
   $retval3="<tr bgcolor=#fedcba> <td align=center><h3><font color=navy>TOTAL <td align=right><h3><font color=navy>$data<td>$nbsp";
	print $retval3;
	pg_close($conn);
?>	
