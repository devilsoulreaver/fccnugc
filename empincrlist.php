<HTML>
<HEAD>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="styles/manual.css" type="text/css">
</HEAD>
<BODY>
<?php
include('tabledraws.php');

$ofdate=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
//old query
//$txt="select distinct(a.empid) as \"Emp.ID\",getauditno(empid) as \"Audit No.\",empname(a.empid) as \"Name\",empdesigid(empid) as \"Desig\",get_payscale(a.empid) as \"Scale\",max(a.cur_bp) as \"B.P\",max(a.wefdate) as \"Inc.Date\", getretdate(empid) as \"Doret\" from emp_bp_incr a where date_part('month',a.wefdate)=$month  and a.sanc_date=(select max(sanc_date) from emp_bp_incr where empid=a.empid) and empwdtypeid(a.empid)='S' and empcategoryid(a.empid)<>'G' and substr('a.empid',1,1)<>'T'  and substr('a.empid',1,1)<>'X' and getretdate(empid)::date>current_date GROUP by a.empid;";
//New query
//$txt="select distinct(a.empid) as \"Emp.ID\",getauditno(empid) as \"Audit No.\",empname(a.empid) as \"Name\",empdesigid(empid) as \"Desig\",get_payscale(a.empid) as \"Scale\",max(a.cur_bp) as \"B.P\",max(a.wefdate) as \"Inc.Date\", getretdate(empid) as \"Doret\" from emp_bp_incr a where date_part('month',a.wefdate)=$month  and a.sanc_date=(select max(sanc_date) from emp_bp_incr where empid=a.empid ) and empwdtypeid(a.empid)='S' and empcategoryid(a.empid)<>'G' and getfirst(a.empid) not in ('T','X') and isret(a.empid)='N' and length(a.empid)<>5 GROUP by a.empid;";
$txt="select distinct(a.empid) as \"Emp.ID\",getauditno(empid) as \"Audit No.\",empname(a.empid) as \"Name\",empdesigid(empid) as \"Desig\",get_payscale(a.empid) as \"Scale\",max(a.cur_bp) as \"B.P\",max(a.wefdate) as \"Inc.Date\", getretdate(empid) as \"Doret\" from emp_bp_incr a where date_part('month',a.wefdate)=$month  and a.cur_bp=(select max(cur_bp) from emp_bp_incr where empid=a.empid ) and empwdtypeid(a.empid)='S' and empcategoryid(a.empid)<>'G' and getfirst(a.empid) not in ('T','X') and isret(a.empid)='N' and length(a.empid)<>5 GROUP by a.empid;";
//echo $txt;
if ($conn=pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));

else
        {
        echo trigger_error("Unable to Connect PG");
        //die(pg_error());
        }

//print $txt;
$txt1=stripslashes($txt);
if(!$rset = pg_exec($conn,$txt1)) die("ERROR :" . $txt1);
if( ($rows=pg_numrows($rset)) <= 0)
        {
        echo "<table bgcolor=cyan><tr><td><b>"."No Matching Results"."<b></td></tr></table>";
        exit();
        }

echo "<body bgcolor=#B8C6CB><center>";
/*"<h2>The Query Execution Result</h2></center><hr>
The Query : &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; <a href=\"javascript:window.close()\"> Close Window </a><div class=example>$txt</div>";
*/
echo drawtab1($rset);
$rows=pg_numrows($rset);
echo "<br><b>The No. of Rows Returned : $rows </b>&nbsp; &nbsp; &nbsp; &nbsp; &nbsp; ";
//"<a href=\"javascript:window.close()\"> Close Window </a>";
?>
</BODY>
</HTML>
