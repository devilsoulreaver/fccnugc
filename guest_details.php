<?php
include("table_draws.php");
$htm="<table align=center width=60% border=1 bgcolor=#c0c0c0><tr><td align=center><h1><font color=navy>Available Details Of Contract/Guest Employee</td></tr></table> </font></h1>";
$sql="select a.empid as \"EMP ID\",empname as \"NAME\",get_bp(a.empid) as \"REMUNERATION\",termfrom as \"TERM FROM\",termto as \"TERM TO\",coalesce(b.ordno,'__') as \"ORDER NO\",coalesce(b.orddate,'09/09/9999') as \"ORDER DATE\" from emp_master a,guest_details_edit b where a.empid='$empid' and a.empid=b.empid";
print $htm;
$retval=tab1($sql);
print $retval;
?>


