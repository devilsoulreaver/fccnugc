<?php
include('tabledraws.php');
if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error());
$empid=$auditno;
$qry="select empname as \"Name\",empoffice(empid) as \"Office\",empdesig(empid) as \"Designation\",get_payscale(empid) as \"Pay Scale\",get_bp(empid) as \"Basic Pay\" from emp_master where empid='$empid'";
 $qry=stripslashes($qry);
 //echo $qry;
 $rset=pg_exec($conn,$qry);
if (pg_numrows($rset)!=0)
  {
    echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
    echo drawtab2($rset,0,0);
  }    else exit();
  
$sql="select case when indid='BP' then 'B.Pay' else 'D.A' end,amount as \"Amount\",to_char(effectdate-1,'Month:YYYY') as \"Month\" from paybill where ind_bill_no in (select ind_bill_no from ind_bills_master where empid='$empid') and indid in ('BP','DA') order by effectdate";

$rset=pg_exec($conn,$sql);
$arr=array(1);
echo drawtab1($rset,$arr);

?>
