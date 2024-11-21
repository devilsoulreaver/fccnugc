<?php
$conn=pg_connect("host=192.168.0.1 port=5432 dbname=financetest user=finance password=hahahihi");
$sql1="select max(empid::text::int4)+1 from emp_master where empid like '21___'";
$empid_rec=pg_exec($conn,$sql1);
$empid=pg_result($empid_rec,0,0);
$sql2="select current_date";
$cur_date=pg_exec($conn,$sql2);
$doj=pg_result($cur_date,0,0);

$retval="<html>
<head>
<title>New Employee </title>
<script language=\"JavaScript\">
function f1()
{
for (i=0;i<document.frm1.length;i++)
	{
		if (frm1.elements[i].type==\"text\")
			{
				if (frm1.elements[i].value==\"\")
					{
					alert(\"No Field Can't Be Empty\");
					document.frm1.elements[i].focus();
					return false;
					}
				else
					continue;
			}	
	}
return true;
}
function f2()
{
	window.document.frm1.empname.focus()
	dat=new Date();
	h=dat.getHours()
	if (h<12)
	{
		str=\"Hello Goodmorning Everybody\";
	}
	else
	{
		str=\"Hello Good Afternoon - This is MGUFIN\";
	}
	alert(str);
	document.empname.focus();
}
</script></head>
<body  onLoad=\"return f2()\" language=\"JavaScript\">
<table align=\"center\"  cellpadding=\"2\"  border=\"0\" width=\"70%\" bgcolor=\"pink\" ><form action=\"new_guest1.php\" name=\"frm1\" method=\"post\" OnSubmit=\"return f1()\" language=\"JavaScript\">
<tr ><th  align=center> &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp GUEST/CONTRACT EMPLOYEE DETAILS</td colspan=\"1\" ></th></tr> 

<tr ><td >Employee ID<td colspan=\"2\"><input name=\"empid\" type=\"text\" value=\"$empid\" style=\"HEIGHT: 25px;width:100\"></tr> 
<tr><td>Employee name<td colspan=\"2\"><input name=\"empname\" type=\"text\" style=\"width:300\"></tr>
<tr><td >Designation<td colspan=\"2\"><select name=\"desig\">";
$sql3="select id,name from desig_master where catid='G' order by 2";
$desig_rec=pg_exec($conn,$sql3);
for ($i=0;$i<pg_numrows($desig_rec);$i++)
        {
		$desig_name=pg_result($desig_rec,$i,1);
		$desig_id=pg_result($desig_rec,$i,0);
		$retval.="<option value=\"$desig_id\">$desig_name</option>";
	}
$retval.="</select></tr>";
$retval.="<tr><td >Office<td colspan=\"2\"><select name=\"office\">";
$sql4="select id,name from office_master order by 2";
$office_rec=pg_exec($conn,$sql4);
for($i=0;$i<pg_numrows($office_rec);$i++)
	{
		$office_id=pg_result($office_rec,$i,0);
		$office_name=pg_result($office_rec,$i,1);
		$retval.="<option value=\"$office_id\">$office_name";
	}
$retval.="</select></tr>";

$retval.="<tr><td>Educational Qualification<td colspan=\"2\"><input width=\"60%\" name=\"eduqual\" type=\"text\" style=\"width:300\"></tr>";


$retval.="<tr><td>Present  Address<td colspan=\"2\"><input width=\"60%\" name=\"presaddress\" type=\"text\" style=\"width:300\"></tr>
<tr><td>Permanant  Address<td colspan=\"2\"><input width=\"60%\" name=\"permaddress\" type=\"text\" style=\"width:300\"></tr>
<tr><td>Telephone No.<td colspan=\"2\"><input width=\"60%\" name=\"phone\" type=\"text\" style=\"width:150\"></tr>
<tr><td>Mobile No.<td colspan=\"2\"><input width=\"60%\" name=\"mob\" type=\"text\" style=\"width:150\"></tr>

<tr><td>Sex<td <select name=\"sex\"><option value=M>Male</option><option value=F>Female</option></select></tr>
<tr><td>Date of birth<td colspan=\"2\"><input name=\"dob\" type=\"\" value=$doj  style=\"width:100\"  ></tr>
<tr><td>Religion<td colspan=\"2\"><input name=\"religion\" type=\"text\"  style=\"width:150\"></tr>
<tr><td>Caste<td colspan=\"2\"><input name=\"caste\" type=\"text\" style=\"width:150\" ></tr>
<tr><td>Date of Joining in the present post<td colspan=\"2\"><input name=\"doj\" type=\"\" value=$doj style=\"width:100\" ></tr>

<tr><td>Appontment Order Number<td colspan=\"2\"><input  name=\"ordno\" type=\"text\" style=\"width:300\"></tr>
<tr><td>Order Date<td colspan=\"2\"><input type=\"text\" name=\"orddate\" value=\"$doj\" style=\"width:100\"></tr>

<tr><td >Term Of Appointment<td ><input name=\"termdays\" type=\"text\" value=\"1\"  
<td><select name=term>
<option value=\"year\">Year</option>
<option value=\"month\">Month</option>
<option value=\"days\">Days</option>
</select></tr>
<tr><td>Consolidated Remuneration<td colspan=\"2\"><input name=\"pay\" type=\"text\"  style=\"width:100\"></tr>
<tr><td>SBT MG University Acc.No<td colspan=\"2\"><input name=\"sbtacno\" type=\"text\"  style=\"width:150\"></tr>
<tr><td>PAN No<td colspan=\"2\"><input name=\"panno\" type=\"text\"  style=\"width:150\" value=\"--\" ></tr>
";

print $retval;
?>
<tr><td colspan="3"> &nbsp;<tr><td colspan="3">&nbsp;<tr><td align="center" colspan="3"><input type="submit" value="Submit">
</tr>
</form>
</table>

