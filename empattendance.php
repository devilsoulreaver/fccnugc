<?php

include('tabledraws.php');
$seloff = $_POST['seloff'];
$year = $_POST['year'];
$month = $_POST['month'];
$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
$txt=strtoupper($txt);
//print 'lllllll' . $txt;
//$year="2020";
//print 'kkkkkkk' . $year;
$ofdate=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
//print $ofdate;
//print 'mmmmm' . $seloff;
// query creation starts here
//************************************************************
$qry="select count(empid) from emp_master where empoffice(empid)='$seloff' and empcategoryid(empid)<>'G' and doret>= current_date and empdesig(empid)<> 'Assistant (Provisional)'  and next01(getretdate(empid)::date)>='$ofdate' "  ;
//print $qry;
$totemprec=pg_exec($conn,$qry);
$totemp1=pg_result($totemprec,0,0);
//print $totemp1;
// $query = "select empid as \"Audit Number\",empname as \"Name\",empdesig(empid) as \"Designation\",empdesig(empid) as \"Current Designation\" from emp_master where empoffice(empid)='$seloff'";
// $query.="  and empcategoryid(empid)<>'G' and next01(getretdate(empid)::date)>='$ofdate'and empid not in (select empid from emp_attendance where att_date='$ofdate') order by empname";
// print $query;

$query = "select empid as \"Audit Number\",empname as \"Name\",empdesig(empid) as \"Designation\",emppayto_name(empid) as \"Payment_Option\",empdesig(empid) as \"Current Designation\" from emp_master where empoffice(empid)='$seloff' ";
//---------------------------------------------------------------------------------------------------------------------
$query.="  and empcategoryid(empid)<>'G' and empdesig(empid)<>'Assistant (Provisional)' and doret>= current_date  and empid not in (select empid from emp_attendance where att_date='$ofdate') order by empname";
//----------------------------------------------------------------------------------------------------------
//$query.="  and empcategoryid(empid)<>'G' and doret>= current_date  and  empid not in (select empid from emp_attendance where att_date='$ofdate') order by empname";
//-------------------------------------------------------------------------------------------------------------
//print $query;
$rset = pg_exec($conn,$query);
//print "asasass";
//print  pg_numrows($rset);
if( ($rows=pg_numrows($rset)) <= 0)
	{
	echo "<center><h2>No Employees Whoes Attendance is Not yet Got</h2></center>";
	exit();
	}
echo "<html><head><link target=_main>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
</head><body>
<form name=frm action=updateattendance.php  method=post> <input type=hidden name=ofdate value=$ofdate>";
$totemps=pg_numrows($rset);
//print $totemps;
echo "<center><h3> Total Number of Attendance TO Got : $totemps  of  $totemp1</h3></center>";
for ($i=0;$i<pg_numrows($rset);$i++)
	{
	echo "<table width=400 align=center><tr><td colspan=2>";
	echo "<a name=\"$i\"><a>";
	echo drawtab2($rset,$i,1,400);
	echo "</td></tr><tr bgcolor=#ebe0d5><td>";
	$pfno=pg_result($rset,$i,0);
	$empname=pg_result($rset,$i,1);
	echo "Got Attendance : </td><td><input type=checkbox name=$pfno value=1></td></tr></table>";
 	}
echo "<center><input name=offid type=hidden value=\"$seloff\"> <input type=submit></form>
</html>";		
?>
