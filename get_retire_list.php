<?php
include('tabledraws.php');
$conn=pg_connect("dbname=financetest user=finance host=192.168.0.1 password=fin123");

$sql="select next01('31/08/2004'::date)-1";
$trec=pg_exec($conn,$sql);
$retdate=pg_result($trec,0,0);

for($i=0;$i<60;$i++)
{
$sql="select empid as \"Emp.ID\",getauditno(empid) as \"Audit No.\",empname as \"Name\",dob as \"D.O.B\",empdesig(empid) as \"Desig.\" from emp_master where getretdate(empid)::date='$retdate' and empcategoryid(empid)<>'G' order by 3";
$rset=pg_exec($conn,$sql);
echo "<table width=900 align=center><tr><td><h3>Retirment on : $retdate</h3></td></tr></table>";
echo drawtab1($rset,array(),900);

$sql="select next01('$retdate'::date+1)-1";
$trec=pg_exec($conn,$sql);
$retdate=pg_result($trec,0,0);

}

?>
