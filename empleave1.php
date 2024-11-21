<html>
<body>
<?php
include("tabledraws.php");
if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());

$sql="select auditno as \"Audit Number\",empid as \"PF Number\",empname as \"Name\",empdesig(empid) as \"Designation\",empoffice(empid) as \"Office\" from emp_master where auditno='$auditno'";

$rset=pg_exec($conn,$sql);

echo drawtab2($rset,0,0);

?>
<table><tr><td>afsdfasdfsdf</td></tr></table>
</body>
</html>
