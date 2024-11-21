<html>
<head>
<title>The Attendance Certificate</title>
</head>
<body>
<center>
<?php
$offid = $_POST['offid'];

	$conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=hahahihi");
	
	
	$sql="select name from office_master where id='$offid'";
	$trec=pg_exec($conn,$sql);
	$offname=pg_result($trec,0,0);
	print "<h3><i>
	ATTENDANCE CERTIFICATE OF THE STAFF OF <b><u>$offname </u></b>
	<br>
	FOR THE PERIOD FROM ________________________ TO ______________________
	</h3>
	</center>";
	$sql="select distinct a.empid,empname(a.empid),empdesig(a.empid),emppayto_name(a.empid) from emp_transfer as a inner join emp_master as b on a.empid=b.empid where officeid ='$offid' and enddate='01/01/1900' and is_withheld_sal(a.empid,current_date)='N' and getretdate(a.empid)::date>current_date and empcategoryid(a.empid)<>'G' and length(a.empid)<>5 and b.doret>current_date order by 2";
	//print $sql;
	$res=pg_exec($conn,$sql);
	print "<table border=1 align=center width=100%>";
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
	for($i=0;$i<pg_numrows($res);$i++)
	{
	 $slno=$i+1;
	 print "<tr><td>$slno</td>";
	 	for($j=0;$j<pg_numfields($res);$j++)
		{
		$data=pg_result($res,$i,$j);
		print "<td>$data</td>";
		}
	 print "<td> &nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td><td>&nbsp;</td>";
	 print "</tr>";
	}
	print "</table><br><table border=0 width=100%><br><br><tr><td align=right><h4>AR / DR / H.O.D</h4></td></tr></br></br></table>";
?>
</body>
</html>
