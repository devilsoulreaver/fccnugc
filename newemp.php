<?php

if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());

$sql="select max(empid::text::int4)+1 from emp_master where empid like '20___'";
$maxrec=pg_exec($conn,$sql);

$maxid=pg_result($maxrec,0,0);
		

echo "
<html>
<head>
<script language=\"javascript\">
function add_new()
{
a=window.confirm('Are you Sure to Add New Employee ? Hope You filled all the Fields');
for (var i=0;i<frm1.elements.length;i++)
{
if(frm1.elements[i].value==\"\"||frm1.elements.value==\"null\")
	{
	frm1.elements[i].focus()
	return false;
	}
}
frm1.submit();
return true;
}
</script>
</head>
<form name=frm1 action=\"newemp1.php\" onSubmit=\"return add_new()\" language=\"javascript\">
<table border=0 align=center cellpadding=2 width=810>
<tr bgcolor=#3366BB><th colspan=2 align=right><font color=white><h3>The New Employee Details</h3></font></th></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>PF No.</font></b></td>
<td><input name=\"empid\" type=text value=\"$maxid\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Name</font></b></td>
<td><input name=\"empname\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 400px\"></td>
</tr>";


echo "</td></tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Designation</font></b>
 </td><td>";
 $rettab="<select name=\"seldesig\">";
 //selecting the designations
 //************************************************************
 $qry = "select name,id from desig_master order by 1";
 if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	for($j=0;$j<pg_numrows($rset1);$j++)
        	{
        	$data1=pg_result($rset1,$j,0);
		$data2=pg_result($rset1,$j,1);
        	$rettab.="<option value=\"$data2\">$data1</option>";
        		}
		$rettab.="</select>";
echo $rettab;
echo "</td></tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>WEF Date</font></b></td>
<td><input name=\"desigwef\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Sanc. Date</font></b></td>
<td><input name=\"desigsanc\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr>";

echo "
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Pay Scale</font></b></td>
<td>";

$qry = "select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='U' and wefdate = (select max(wefdate) from pay_master where stype='U') union select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='S' and wefdate = (select max(wefdate) from pay_master where stype='S')";

$rettab="<select name=\"selpayscale\">";
if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	for($j=0;$j<pg_numrows($rset1);$j++)
		{
		$data1=pg_result($rset1,$j,0);
		$data2=pg_result($rset1,$j,0);
		$rettab.="<option value=\"$data2\">$data1</option>";
		}
		$rettab.="</select>";
echo $rettab;

echo "</td></tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>WEF Date</font></b></td>
<td><input name=\"scalewef\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Sanc.Date</font></b></td>
<td><input name=\"scalesanc\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr>";


echo "<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Date of Birth</font></b></td>
<td><input name=\"dob\" type=text value=\"01/01/2000\" style=\"HEIGHT: 20px;WIDTH: 90px\">&nbsp&nbsp&nbsp
<font color=black><b>Sex</font></b>&nbsp:&nbsp&nbsp&nbsp<select name=sex><option value=M>Male</option><option value=F>Female</option></select>&nbsp&nbsp<font color=black><b>Blood Group</font></b>&nbsp&nbsp<input type=text name=bg style=\"width:35px\" value=\"--\"></td></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Religion</font></b></td>
<td><input name=\"religion\" type=text value=\"---\" style=\"HEIGHT: 20px;WIDTH: 150px\">&nbsp&nbsp<font color=black><b>Caste&nbsp:&nbsp</font></b><input name=\"caste\" type=text value=\"---\" style=\"HEIGHT: 20px;WIDTH: 150px\"><font color=black><b> &nbsp &nbsp Res. Category &nbsp:&nbsp&nbsp</font></b>";
 $rettab="<select name=\"selcat\">";
 //selecting the reservation categories
 //************************************************************
 $qry="select 'FC' union select 'OBC'union select 'SC' union select 'ST' union select 'OEC'";
 if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
 for($j=0;$j<pg_numrows($rset1);$j++)
 	{
 	$data1=pg_result($rset1,$j,0);
 	$rettab.="<option value=\"$data1\">$data1</option>";
 	}
	$rettab.="</select>";
 echo $rettab;
 echo "</td></tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Edu.Quali.</font></b></td>
<td><input name=\"quali\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 400px\"></td>
</tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Basic Pay</font></b></td>
<td><input name=\"bp\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 100px\"></td></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>WEF Date</font></b></td>
<td><input name=\"incrdate\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Sanc.Date</font></b></td>
<td><input name=\"incrsanc\" type=text value=\"01/07/2008\" style=\"HEIGHT: 20px;WIDTH:90px\"></td>
</tr>




<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Office</font></b></td><td> ";

 //selecting the offices
 //****************************************
 $rettab="<select name=\"seloffice\">";
 //selecting the designations
 //************************************************************
 $qry = "select name,id from office_master order by 1";
 if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	for($j=0;$j<pg_numrows($rset1);$j++)
		{
		$data1=pg_result($rset1,$j,0);
		$data2=pg_result($rset1,$j,1);
        	$rettab.="<option value=\"$data2\">$data1</option>";
        	}
		$rettab.="</select>";

echo $rettab;


 echo "</td></tr><tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Pres.Address</font></b></td>
<td><input name=\"presadd\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 450px\"></td>
</tr>
</td></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Phone No</font></b></td>
<td><input name=\"phno\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 175px\"></td>
</tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Mob.No</font></b></td>
<td><input name=\"mobno\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 175px\"></td>
</tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>PAN NO</font></b></td>
<td><input name=\"panno\" type=text value=\"\" style=\"HEIGHT: 20px;WIDTH: 175px\"></td>
</tr>


";



echo "<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Payment to :</font></b>
 </td><td>";

	$qry = "select * from payment_agency";
	$rettab="<select name=\"selpayment\">";
	if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	for($j=0;$j<pg_numrows($rset1);$j++)
		{
		$data1=pg_result($rset1,$j,1);
		$data2=pg_result($rset1,$j,0);
		$rettab.="<option value=\"$data2\">$data1</option>";
		}
		$rettab.="</select>";
echo $rettab;
echo "&nbsp &nbsp<font color=black><b>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp SB Account No.</font></b>&nbsp &nbsp : &nbsp &nbsp<input name=\"sbtacno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 100px\"></td></tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Date of Join</font></b></td><td><input name=\"doj\" type=text value=\"01/01/1980\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Joining Order No</font></b></td><td><input name=\"joinorder\" type=text value=\"AD..\" style=\"HEIGHT: 20px;WIDTH: 200px\"></td>
</tr>
<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Order Date</font></b></td><td><input name=\"jorddate\" type=text value=\"01/01/1980\" style=\"HEIGHT: 20px;WIDTH: 90px\"></td>
</tr>

<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>Handicapped</font></b></td><td><input type=checkbox name=\"hand\"  value=Y ></td>
</tr>


<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>MGUECS No</font></b></td><td><input name=\"mguecsno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 75px\">
&nbsp&nbsp<font color=black><b>GIS No &nbsp:&nbsp</font></b><input name=\"gisno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 75px\">
&nbsp&nbsp<font color=black><b>SWF No &nbsp:&nbsp</font></b><input name=\"swfno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 75px\">
&nbsp&nbsp<font color=black><b>FBS No &nbsp:&nbsp</font></b><input name=\"fbsno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 75px\">

</td>



</tr>


<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>No. of Earned Leave:</font></b></td>
<td><input name=\"elno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 50px\">&nbsp &nbsp<font color=black><b>&nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp &nbsp No. Half Pay Leave</font></b>&nbsp &nbsp : &nbsp &nbsp<input name=\"hplno\" type=text value=\"0\" style=\"HEIGHT: 20px;WIDTH: 50px\"></td>
</tr>


</table>

<table align=center><tr><td><input type=button value=\"Add New Employee\" onClick=\"return add_new()\" language=\"javascript\"></td></form>
</td></tr></table></center>";

?>


