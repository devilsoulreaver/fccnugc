<?php

include('tabledraws.php');
$seloff = $_POST['seloff'];
$year = $_POST['year'];
$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
	
$txt=strtoupper($txt);
$ofdate=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
// query creation starts here
//************************************************************
$qry="select count(empid) from emp_master where empoffice(empid)='$seloff' and empcategoryid(empid)='G'";
$totemprec=pg_exec($conn,$qry);
$totemp1=pg_result($totemprec,0,0);

//$query = "select empid as \"Audit Number\",empname as \"Name\",empdesig(empid) as \"Designation\",doret as \"D.O.T\" from emp_master where empoffice(empid)='$seloff'";
//$query.="  and empcategoryid(empid)='G' and empid not in (select empid from guest_emp_leave_report where lastmonth='$ofdate') and next01(doret)>='$ofdate' order by empname";
//print $query;
$query = "select a.empid as \"Audit Number\",a.empname as \"Name\",empdesig(a.empid) as \"Designation\",doret as \"D.O.T\",emppayto_name(a.empid) as \" PAY_OPTION:\" from emp_master a where empoffice(a.empid)='$seloff'";
$query.="  and empcategoryid(a.empid)='G' and got_attendence(a.empid,'$ofdate')='N' and next01(doret)>='$ofdate' order by empname";
print $query;
if(!$rset = pg_exec($conn,$query)) die("ERROR :" . $query);

if( ($rows=pg_numrows($rset)) <= 0)
	{
	echo "No Employees Whoes Attendance is Not yet Got<BR>";
	exit();
	}
echo "<html><head><link target=_main>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
</head><body><center><h2>Search Result</h2>
</center><form name=frm action=updateattendance_guest.php><input type=hidden name=ofdate value=$ofdate>";
$totemps=pg_numrows($rset);
echo "<center><h3> Total Number of Attendance TO Got : $totemps  of  $totemp1</h3></center>";
for ($i=0;$i<pg_numrows($rset);$i++)
	{
	echo "<a name=\"$i\"><a>";
	echo drawtab2($rset,$i,0);
	$pfno=pg_result($rset,$i,0);
	$empname=pg_result($rset,$i,1);
	echo "<center>$empname No. of Leave Days : <input type=text name=$pfno value=X></center>";
 	}
echo "<center><input name=offid type=hidden value=\"$seloff\"> <input type=submit></form>
<script language=\"javascript\">
theDate=new Date();
document.write(\"<center><b>The Report as On :   \",theDate.getHours(),\" : \",theDate.getMinutes(),\"       \",theDate.getDate(),\" / \",theDate.getMonth()+1,\" / \",theDate.getFullYear(),\"</b></center>\");
</script></html>";		
?>
