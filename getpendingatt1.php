<?php

include("tabledraws.php");

$empid=$_POST['empid'];
$offfice = $_POST['office'];
$year = $_POST['year'];
$conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=hahahihi") or die("Could Not Connect to Database");

$sql="select distinct a.empid as \"Emp.ID\",empname(a.empid) as \"Name\",empdesig(a.empid) as \"Desig\" from emp_master a,emp_transfer b ";
$sql.=" where b.officeid='$office' and empcategoryid(a.empid)<>'G' and empdesig(a.empid) = 'Assistant (Provisional)' ";
$sql.=" and a.doret>current_date and got_attendence(a.empid,'$ofdate')='N' and ";
$sql.=" b.empid=a.empid and b.enddate='01/01/1900'";
$sql.=" order by 2";
$rset=pg_exec($conn,$sql);

print drawtab1($rset,array());

pg_close($conn);

?>
