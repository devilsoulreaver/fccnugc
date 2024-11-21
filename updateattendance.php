<?php
//phpinfo();
$offid = $_POST['offid'];
$data = $_POST['data'];
$ofdate = $_POST['ofdate'];
$REMOTE_ADDR = '192.168.0.1';
$conn1 = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
       
//echo "Madhu";
$sql="select empid,empname from emp_master where empoffice(empid)='$offid' and empcategoryid(empid)<>'G'";
$rec=pg_exec($conn1,$sql);
echo pg_numrows($rec);
for($i=0;$i<pg_numrows($rec);$i++)
	{
	$data=pg_result($rec,$i,0);
	$empname=pg_result($rec,$i,1);
	
	
       if ($_REQUEST[$data]==1)
	{
	//echo "RAAAAAAAAA";
	$sql="insert into emp_attendance values ('$data','$ofdate',now(),'$REMOTE_ADDR')";
	pg_exec($conn1,$sql);
	//echo $sql;
	}

	}
print "<form action=empattendence1.php><center><h3>The Attendance Updated Successfully....</h3><br><input type=submit value=Next> </center></form>";
?>
