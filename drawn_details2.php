<?php

include('tabledraws.php');
$empid = $_POST['empid'];
$year1 = $_POST['dst1'];
$year2 = $_POST['dst2'];
if(!$empid) 
{
echo "<h3>Error :</h3><hr><h2>Please Enter the Audit Number</h2><hr>";
exit();
}
//******************************************************
// the ofdates 
 //$m1=date("d/m/Y",mktime(0,0,0,$month1,1,$year1));
 //$m2=date("d/m/Y",mktime(0,0,0,$month2,31,$year2));


 $m1=date("d/m/Y",mktime(0,0,0,$month1,1,$year1));
 $m2=date("d/m/Y",mktime(0,0,0,$month2,1,$year2));
 //****************************************************
 
 $arr=array(1);
 //****************************************************
$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
       //****************************************************

 //****************************************************
$qry="select empname as \"Name\",empoffice(empid) as \"Office\",empdesig(empid) as \"Designation\",get_payscale(empid) as \"Pay Scale\" from emp_master where empid='$empid'";
$qry=stripslashes($qry);
$rset=pg_exec($conn,$qry);
if (pg_numrows($rset)!=0)
{
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);

//  $qry="select saldetails('$empid','$m1','$m2')";
//  $trec=pg_exec($conn,$qry);
//  $msg=pg_result($trec,0,0);
//  if (strlen($msg)>10){
// 	echo "<h3>Information :</h3><hr><h2>$msg</h2><hr>";
// 	exit();
//  }

$sql="select distinct a.billno,a.billdate from bills a,bills_det b,ind_bills_master c where c.empid='$empid' and c.ofdate between '$m1' and '$m2' and a.billno=b.billno and b.ind_billno=c.ind_bill_no order by billno";
$trec=pg_exec($conn,$sql);
//$bno=pg_result($trec,0,0);
//$bdate=pg_result($trec,0,1);
//echo "<table align=center><tr bgcolor=#b3cff3><td><b>Bill No:</b></td><td>$bno</td><td><b>Bill Date:</b></td><td>$bdate</td></tr></table>";
 //****************************************************
 //$allowqry="select case when indid in ('LEAVEEX','LEAVESPL')='t' then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"Emoluments\",amount::numeric(10,2) as \"Amount\" ,to_char(this01(ofdate-1),'Mon : yyyy') as \"MONTH\"  from temp_sal_det  where empid='$empid' and groupid like 'ALLOW%' and ofdate between '$m1' and '$m2' and groupid<>'TAXPRED'order by ofdate";


 $allowqry="select case when indid in ('LEAVEEX','LEAVESPL')='t' then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"Emoluments\",amount::numeric(10,2) as \"Amount\", to_char(this01(effectdate-1),'Mon : yyyy') as \"MONTH\" from paybill  where ind_bill_no in(select ind_bill_no from ind_bills_master where empid='$empid')and groupid like 'ALLOW%' and effectdate  between '$m1' and '$m2' and groupid<>'TAXPRED' order by effectdate,indid";

 $rset=pg_exec($conn,$allowqry);
 if (pg_numrows($rset)!=0)
 {
 echo drawtab1($rset,$arr);
 }

 $allowtot=0.00;
 for($i=0;$i<pg_numrows($rset);$i++)
	{
	$allowtot+=pg_result($rset,$i,1);
	}
//echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Gross Amount</b>:  </td><td align=right><b>$allowtot.00</b></td></tr></table> ";

 $dedqry="select case when indid in ('LEAVEBP','LEAVEDA','LEAVEHRA') then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"Deductions\",amount::numeric(10,2) as \"Amount\" from temp_sal_det where empid='$empid' and groupid like 'DED%' and ofdate='$m2' and groupid<>'TAXPRED'";
 $rset=pg_exec($conn,$dedqry);
 //if (pg_numrows($rset)!=0)
 {
 //echo drawtab1($rset,$arr);
 }
 
 $dedtot=0;
 for($i=0;$i<pg_numrows($rset);$i++)
        {
        $dedtot+=pg_result($rset,$i,1);
        }

//echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Total Deduction</b>:  </td><td align=right><b>$dedtot.00</b></td></tr></table> ";
$allowtot=$allowtot-$dedtot;
//echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b><font size=5>Net Amount  </font></b>:  </td><td align=right><font size=5><b>$allowtot.00</b></font></td></tr></table> ";
}
else
{
echo "<h3>Error :</h3><hr><h2>Audit Number Not Found </h2><hr>";
exit();
}
?>
