<?php
include('tabledraws.php');

if(!$empid)
	{
	echo "<h3>Error :</h3><hr><h2>Please Enter the Audit Number</h2><hr>";
	exit();
	}
//******************************************************

$m1=date("d/m/Y",mktime(0,0,0,$month,1,$year));
//****************************************************
if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());
//****************************************************

$qry="select empname as \"Name\",empoffice(empid) as \"Office\",empdesig(empid,'$m1') as \"Designation\"
,get_payscale(empid,'$m1') as \"Pay Scale\",get_bp(empid,'$m1') as \"Basic Pay\" from emp_master where empid='$empid'";
$qry=stripslashes($qry);
$rset=pg_exec($conn,$qry);

$found=pg_numrows($rset);
if ($found>0)
{
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);
}
 
$sql="select  * from bill_types";
$rbset=pg_exec($conn,$sql);
for($i=0;$i<pg_numrows($rbset);$i++)
{
	$data1=pg_result($rbset,$i,0);
	$data2=pg_result($rbset,$i,1);

//**************************************************
//$sql="select sum(gross) as \"Gross\",sum(deds) as \"Deductions\",sum(net) as \"Net\",typedesc as \"Type of Bill\",to_char(ofdate-1,'Month:yyyy') from ind_bills_master,bill_types where empid='$empid' and this01(ofdate-1)>='$m1' and typeid=btype and btype='$data1' group by btype,ofdate,empid,typedesc order by ofdate";
#$rset=pg_exec($conn,$sql);
$sql="select  gross as \"GROSS\",deds as \"DEDS\",net as \"NET\",typedesc as \"TYPE\",case when billno=888888888 then 'TO PF A/C' else billno::text end as \"BILL NO\",to_char(this01(ind_bills_master.ofdate-1),'Mon : yyyy') as \"MONTH\",remarks as \"Remarks\" from ind_bills_master,bill_types,bills_det where btype=typeid and empid='$empid' and this01(ofdate-1)>='$m1' and bills_det.ind_billno=ind_bills_master.ind_bill_no and btype='$data1'  order by ind_bills_master.ofdate;";
#echo $sql;
#$sql="SELECT b.billno as \"Bill No\", c.billdate as \"Bill Date\",sum(a.gross) AS \"Gross\", sum(a.deds) AS \"Deds\", sum(a.net) AS \"Net\",a.wdtype as \"WD Type\" FROM ind_bills_master a, (bills_det b LEFT JOIN bills c ON ((b.billno = c.billno))) WHERE (a.ind_bill_no = b.ind_billno)  and a.empid='$empid' and this01(c.billdate)>='$m1' and a.btype='$data1' GROUP BY b.billno, a.empid, a.btype, c.billdate, a.wdtype";
//	$sql="select gross as \"Gross\",deds as \"Deductions\",net as \"Net\",typedesc as \"Type\",case when billno=888888888 then 'TO PF A/C' else billno::text end as \"Bill No.\",to_char(this01(billdate),'Mon : yyyy') as \"Month\" from tot_bill_view,bill_types where btype=typeid and btype='$data1' and this01(billdate)>='$m1' and empid='$empid' order by billdate"; 
	#print $sql;
	$rset=pg_exec($conn,$sql);

	if (pg_numrows($rset)==0) continue;
	echo "<br><h2>$data2</h2>";

	echo drawtab1($rset);
	}

?>
