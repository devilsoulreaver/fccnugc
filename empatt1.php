<html>
<head>
<title>Employee Search</title>
<body bgcolor=white>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<?php
include('tabledraws.php');
$seloff = $_POST['seloff'];
$year=$_POST['year'];
$month=$_POST['month'];


$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
	
$txt=strtoupper($txt);
$ofdate=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
// query creation starts here
//************************************************************
//$qry="select count(empid) from emp_master where empoffice(empid)='$seloff' and empcategoryid(empid)<>'G' and next01(getretdate(empid)::date)>='$ofdate'";
//$totemprec=pg_exec($conn,$qry);
//$totemp1=pg_result($totemprec,0,0);

// $query = "select empid as \"Audit Number\",empname as \"Name\",empdesig(empid) as \"Designation\",empdesig(empid) as \"Current Designation\" from emp_master where empoffice(empid)='$seloff'";
// $query.="  and empcategoryid(empid)<>'G' and next01(getretdate(empid)::date)>='$ofdate'and empid not in (select empid from emp_attendance where att_date='$ofdate') order by empname";
// print $query;

$query = "select empid ,empname ,empdesig(empid),emppayto_name(empid)  from emp_master where empoffice(empid)='$seloff'";
$query.="  and empcategoryid(empid)<>'G' and length(empid)<>5  and doret>= current_date and getretdate(empid)::date>current_date and empid not in (select empid from emp_attendance where att_date='$ofdate') order by empname";
//print $query;
if(!$rset = pg_exec($conn,$query)) die("ERROR :" . $query);


if( ($rows=pg_numrows($rset)) <= 0)
	{
	echo "<center><h2><font color=red>pls check the month selected </font></h2></center>";
	exit();
	}

print "<h3 align=center>
			ATTENDANCE CERTIFICATE OF THE STAFF OF <b><i><u>$seloff</u></i></b>
	<br><br></br>
			FOR THE PERIOD FROM ________________________   <i>TO</i> _________________________
	</h4>
	<br></br>
	</center>";
	//$sql="select distinct a.empid,empname(a.empid),empdesig(a.empid),emppayto_name(a.empid) from emp_transfer as a inner join emp_master as b on a.empid=b.empid where officeid='$seloff' and enddate='01/01/1900' and is_withheld_sal(a.empid,current_date)='N' and getretdate(a.empid)::date>current_date and empcategoryid(a.empid)<>'G' and length(a.empid)<>5 and b.doret>current_date order by 2";
	//print $sql;
	$res=pg_exec($conn,$query);
	print "<table border=1 align=center width=95%>";
	print "<tr>
	<th rowspan=2>Sl.No.</th>
	<th rowspan=2>Emp.ID</th>
	<th rowspan=2>Name</th>
        <th rowspan=2 width=100>Designation</th>
        <th rowspan=2>Payment Option </th>
	<th colspan=2 width=200>Period of <br>Leave</th>
	<th rowspan=2 width=100>Nature of <br>Leave</th>
	<th rowspan=2>Date of <br>Forwarding <br>Leave</th>
	<th rowspan=2>Remarks</th>
	</tr><tr><th>From</th><th>To &nbsp;&nbsp;&nbsp;</th></tr>";
	for($i=0;$i<pg_numrows($res)+3;$i++)
	{
	 $slno=$i+1;
	 print "<tr><td>$slno</td>";
	 if (pg_numrows($res)>$i)
	 {
	 	for($j=0;$j<pg_numfields($res);$j++)
		{
		$data=pg_result($res,$i,$j);
		print "<td>$data</td>";
		}
	}
	else
	{
                   for($j=0;$j<pg_numfields($res);$j++)
		   {
			print "<td><br>&nbsp;&nbsp;&nbsp; </br></td>";
		}
	}

	 print "<td> &nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	 print "</tr>";
	}
	print "</table><br><table border=0 width=100%><br><br><tr><td align=right><h4>AR / DR / H.O.D</h4></td></tr></br></br></table>";
	print "</table><br><table border=0 width=100%><br><br><tr><td align=left><font color=Red valign=right><h5>NOTE :Please Verify The Employee-id, Name and No.of Employees.<br>  If any Excluders in the list strike out and  Please Report In Finance Computer Cell. <br>   Please Enroll Details Of New and Transferred Employees in the Blank space Provided Below.</h></br></font> </h4></td></tr></br></br></table>";

// echo "<html><head><link target=_main>
// <meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
// <link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
// </head><body>
// <form name=frm action=updateattendance.php> <input type=hidden name=ofdate value=$ofdate>";
// //$totemps=pg_numrows($rset);
// //echo "<center><h3> Total Number of Attendance TO Got : $totemps  of  $totemp1</h3></center>";
// for ($i=0;$i<pg_numrows($rset);$i++)
// 	{
// 	echo "<table width=400 align=center><tr><td colspan=2>";
// 	echo "<a name=\"$i\"><a>";
// 	echo drawtab2($rset,$i,1,400);
// 	echo "</td></tr><tr bgcolor=#ebe0d5><td>";
// 	$pfno=pg_result($rset,$i,0);
// 	$empname=pg_result($rset,$i,1);
// 	echo "Got Attendance : </td><td><input type=checkbox name=$pfno value=1></td></tr></table>";
//  	}
// echo "<center><input name=offid type=hidden value=\"$seloff\"> <input type=submit></form>
// </html>";
?>
<hr>
<table align="center" bgcolor=#AAFFEE><tr><td> <img src="emblm.gif" valign=center  cellpadding=1  height=100 width=100></td><td> Finance Branch,M.G University @2009 </td></tr></table>
</body>
</html>
