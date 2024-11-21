<?php
include('tabledraws.php');
//$empid=$_POST['empid'];
$month = $_POST['month'];
$year = $_POST['year'];

$m1=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
//****************************************************
if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error());
//*************************************

$sql="select empdesig(empid) as \"Designation\",count(empid) as \"No.Emps\",sum(gross::int4) as \"Tot.Gross\"  ,sum(gross::int4)/count(empid) as \"Avg.Sal\" from ind_bills_master where ofdate='$m1' and btype='SAL' group by empdesig(empid)";
//print $sql;
$rset=pg_exec($conn,$sql);
$a=array(2,3,4);
echo drawtab1($rset,$a);
$tot=0;
for($i=0;$i<pg_numrows($rset);$i++)
{
$tot=$tot+pg_result($rset,$i,2);
}
print "Total : $tot";
?>
