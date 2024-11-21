<html>
<head>
<title>Employee Search</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript">

function check_all()
{

for(x=0;x<frm1.length;x++)
{
if (frm1.elements[x].type=="checkbox")
	{
	if (frm1.elements[x].name!="chkoffsel" && frm1.elements[x].name!="chkdesigsel" && frm1.elements[x].name!="chkbpsel" && frm1.elements[x].name!="chkscalesel" && frm1.elements[x].name!="checkall")
		{
		if(!frm1.checkall.checked)
			{
			frm1.elements[x].checked=0;
			}
		else
			{
			frm1.elements[x].checked=1;
			}
		}
	}
}

}
function search_func()
{
var chks=0;
if(frm1.txt.value=="" && !frm1.chkoffsel.checked && !frm1.chkdesigsel.checked && !frm1.chkbpsel.checked && !frm1.chkscalesel.checked)
	{
	alert("You Should Have to Specify Atleast One Criteria for Searching.");
	return;
	}
for(x=0;x<frm1.length;x++)
{
if (frm1.elements[x].type=="checkbox")
	{
	if (frm1.elements[x].checked && frm1.elements[x].name!="chkoffsel" && frm1.elements[x].name!="chkdesigsel" && frm1.elements[x].name!="chkbpsel" && frm1.elements[x].name!="chkscalesel")
		{
		chks=1;
		}
	}
}
if (frm1.chkbpsel.checked)
{
if (isNaN(frm1.bp1.value)||isNaN(frm1.bp2.value))
{
alert("The Basic Pay Should Be a Number, Ok");
return;
}
}
if (chks==0)
	{
	alert("You Should Have to Choose Atleast One Field, Ok");
	}
else	{
	frm1.submit();
	}
}
</script>
</head>

<body bgcolor="#FFFFFF" text="black" >
<table align=center width=600><tr><td colspan=3 bgcolor=#336699><h3><i><font color=white>Online Employee Search</font></i></h3></td></tr></table>
<form name="frm1" method="post" action="empsearch.php">
  <center>
    <font color="#330000" size="4"><b>S<i><font size="3">earch By :
      <select name="select1">
        <option value="empid">PF Number</option>
        <option value="empname">Name</option>
        <option value="auditno">Audit Number</option>
      </select>
      </font></i></b></font> <i><b><font size="3">
      <input type="text" name="txt">
      <input type="button" name="Button" value="Search" onClick="return search_func()">
      <input type="reset" name="resetbut" >
      </font></b></i><br>
    Select Details To Be Displayed<br>
    </center>
  <table width="644" border="1" cellpadding="0" cellspacing="0" bgcolor="#FFFFFF" bordercolor="#000000" align="center">
    <tr>
      <td width="24" bgcolor="#FFFFCC">
        <input type="checkbox" name="auditno" value="1">
      </td>
      <td width="279" bgcolor="#FFFFCC">Audit Number</td>
      <td width="24" bgcolor="#B8C6CB">
        <input type="checkbox" name="dob" value="1">
      </td>
      <td width="307" bgcolor="#B8C6CB">Date of Birth</td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="empname" value="1">
      </td>
      <td bgcolor="#B8C6CB">Name</td>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="doj" value="1">
      </td>
      <td bgcolor="#FFFFCC">Date of Join</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="empoffice" value="1">
      </td>
      <td bgcolor="#FFFFCC">Office</td>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="doret" value="1">
      </td>
      <td bgcolor="#B8C6CB">Date of Retirment</td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="empdesig" value="1">
      </td>
      <td bgcolor="#B8C6CB">Designation</td>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="pfdoj" value="1">
      </td>
      <td bgcolor="#FFFFCC">PF Date of Join</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="add1" value="1">
      </td>
      <td bgcolor="#FFFFCC">Permanent Address</td>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="payscale" value="1">
      </td>
      <td bgcolor="#B8C6CB">Current Pay Scale</td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="add2" value="1">
      </td>
      <td bgcolor="#B8C6CB">Present Address</td>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="bp" value="1">
      </td>
      <td bgcolor="#FFFFCC">Currnet Basic Pay</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="ph1" value="1">
      </td>
      <td bgcolor="#FFFFCC">Perm. Phone</td>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="allows" value="1">
      </td>
      <td bgcolor="#B8C6CB">Allowances</td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="ph2" value="1">
      </td>
      <td bgcolor="#B8C6CB">Present Phone</td>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="mguecsno" value="1">
      </td>
      <td bgcolor="#FFFFCC">MGUECS No</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="sex" value="1">
      </td>
      <td bgcolor="#FFFFCC">Sex</td>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="pan" value="1">
      </td>
      <td bgcolor="#B8C6CB">PAN </td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB">
        <input type="checkbox" name="email" value="1">
      </td>
      <td bgcolor="#B8C6CB">Email</td>
      <td bgcolor="#FFFFCC">
        <input type="checkbox" name="sbtacno" value="1">
      </td>
      <td bgcolor="#FFFFCC">SBT Account No.</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" valign="top" height="21">
        <input type="checkbox" name="bg" value="1">
      </td>
      <td valign="top" bgcolor="#FFFFCC">Blood Group</td>
      <td valign="top" bgcolor="#B8C6CB">
        <input type="checkbox" name="deda" value="1">
      </td>
      <td valign="top" bgcolor="#B8C6CB">Deductions</td>
    </tr>
    <tr>
      <td bgcolor="#B8C6CB" valign="top" height="21">
        <input type="checkbox" name="religion" value="1">
      </td>
      <td valign="top" bgcolor="#B8C6CB">Religion</td>
      <td valign="top" bgcolor="#FFFFCC">
        <input type="checkbox" name="gisno" value="1">
      </td>
      <td valign="top" bgcolor="#FFFFCC">GIS No</td>
    </tr>
    <tr>
      <td bgcolor="#FFFFCC" valign="top" height="21">
        <input type="checkbox" name="caste" value="1">
      </td>
      <td valign="top" bgcolor="#FFFFCC">Caste</td>
      <td valign="top" bgcolor="#B8C6CB"><input type="checkbox" name="checkall" value="1" onclick="return check_all()" language="javascript"></td>
      <td valign="top" bgcolor="#B8C6CB">Select All</td>
    </tr>
  </table>
<table bgcolor=#B8C6CB width=800 align=center cellspacing="0" cellpadding="2" border=1 bordercolor=#FFFFFF>
<tr>
<td><input type="checkbox" name=chkoffsel value=1></td>
<td> <b>&nbsp &nbsp Select an Office :</b></td><td>
<select name="seloff">
<option value=notselected>Select Office</option>
<?php
// connecting to the database
//***********************************************************
$conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest");
	
//selecting the offices
//***********************************************************
$qry = "select name from office_master order by 1";

!$rset = pg_exec($conn,$qry);

for($i=0;$i<pg_numrows($rset);$i++)
	{
	$data=pg_result($rset,$i,0);
	echo "<option value=\"$data\">$data</option>";
	}
//************************************************************
?>

</select></td></tr>
<tr><td><input type="checkbox" name=chkdesigsel value=1></td>
<td> &nbsp &nbsp <b>Select a Designation :</b></td><td>
<select name="seldesig">"
<option value=notselected>Select Designation</option>

<?php
//selecting the designations
//************************************************************
$qry = "select name from desig_master order by 1";

if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);

for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data=pg_result($rset,$i,0);
        echo "<option value=\"$data\">$data</option>";
        }
?>

</select></td></tr>
<tr><td><input type="checkbox" name=chkbpsel value=1></td>
<td> &nbsp &nbsp <b>Enter a Basic Pay Interval :</b></td>
<td><input type=textbox name=bp1> &nbsp - &nbsp<input type=textbox name=bp2></td>
</tr>
<tr><td><input type="checkbox" name=chkscalesel value=1></td>
<td> &nbsp &nbsp <b>Select a Pay Scale :</b></td><td>
<select name="selscale">"
<option value=notselected>Select Pay Scale</option>
<?php
//selecting the Pay Scales
//************************************************************
$qry = "select scale from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='U' and wefdate = (select max(wefdate) from pay_master where stype='U') union select scale from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='S' and wefdate = (select max(wefdate) from pay_master where stype='S')";

if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);

for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data=pg_result($rset,$i,0);
        echo "<option value=\"$data\">$data</option>";
        }
?>

</select></td></tr></table>
</form>
<hr>
<table align="center"><tr><td><img src="emblm.gif" height=40 width=40></td><td> Finance Branch , M G University @ 2009 </td></tr></table>
</body>
</html>
