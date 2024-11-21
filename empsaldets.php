<?php
include('datefunc.php');
if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());


$dt=putdates(0);
?>
<table border=0>
<tr><td>
	<table>
	<form name=frm1 action="empsaldets1.php" method=post>
	<tr>
		<td colspan=2 bgcolor=#b3cff3><h2>Search Salary Details</h2></td>
	</tr>
	<tr>
		<td><h4>Enter the Audit Number : </h4></td>
		<td><input type=textbox name=empid></td>
	</tr>
	<tr>
		<td><h4>Select a Month : </h4></td>
		<td><?=$dt?></td>
	</tr>
	<tr>
		<td colspan=2 align=center bgcolor=#171769><input type=submit></td>
	</tr>
	</form>
	</table>
	<table>
	<form name=frm2 action=empallpayments.php method=post >
	<tr>
	<td colspan=2 bgcolor=#b3cff3><h2>All Payments Details</h2></td>
	</tr>
	<tr>
		<td><h4>Enter the Audit Number : </h4></td>
		<td><input type=textbox name=empid></td>
	</tr>
	<tr>
		<td><h4>From the Month : </h4></td><td><?=$dt?></td>
	</tr>
	<tr>
	<td colspan=2 align=center bgcolor=#171769><input type=submit></td>
	</tr>
</form>
</table>
</td></tr>
</table>
<hr>
<form action=desigwisesalreport.php method=post name=frm3>
Designation Wise Salary Report for the Month : <?=$dt?><input type=submit>
</form>
<hr><br><br><br>
<table align=\"center\"> <h2>Office Wise Salary Details</h2><form action=\"officewisesaldet.php\" method=post name=\"frm4\"><?=$dt?><input type=submit>
