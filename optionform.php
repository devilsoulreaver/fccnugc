<?php
function put_desig_combo($cmbname,$sel_desig="XXX")
{
	if ($conn1 = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error());
	$retcmb="<select name=\"$cmbname\">";
	//selecting the designations
	//************************************************************
	$qry = "select name,id from desig_master order by 1";

	if(!$rset = pg_exec($conn1,$qry)) die("ERROR :" . $qry);

	for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data1=pg_result($rset,$i,1);
	$data2=pg_result($rset,$i,0);
	if ($data2==$sel_desig)  $retcmb.="<option value=$data1 selected>$data2</option>";
	else $retcmb.="<option value=$data1>$data2</option>";
        }
	$retcm.="</select>";
	return $retcmb;

  }

function put_office_combo($cmbname,$sel_office="XXX")
{
	if ($conn2 = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=finance"));
        else die(pg_error());
	$retcmb="<select name=\"$cmbname\">";
	//selecting the designations
	//************************************************************
	$qry = "select name,id from office_master order by 1";

	if(!$rset = pg_exec($conn2,$qry)) die("ERROR :" . $qry);

	for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data1=pg_result($rset,$i,1);
	$data2=pg_result($rset,$i,0);
	if ($data2==$sel_office)  $retcmb.="<option value=$data1 selected>$data2</option>";
	else $retcmb.="<option value=$data1>$data2</option>";
        }
	$retcm.="</select>";
	return $retcmb;

  }

function put_payment_combo($cmbname,$sel_payment="XXX")
{
	if ($conn2 = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=finance"));
        else die(pg_error());
	$retcmb="<select name=\"$cmbname\">";
	//selecting the designations
	//************************************************************
	$qry = "select * from payment_agency order by 1";

	if(!$rset = pg_exec($conn2,$qry)) die("ERROR :" . $qry);

	for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data1=pg_result($rset,$i,0);
	$data2=pg_result($rset,$i,1);
	if ($data2==$sel_payment)  $retcmb.="<option value=$data1 selected>$data2</option>";
	else $retcmb.="<option value=$data1>$data2</option>";
        }
	$retcm.="</select>";
	return $retcmb;

  }

function drawtab2($rset,$rno,$rmlast,$conn)
        {
        $rettab="<table border=0 align=center cellpadding=2 width=550><tr><th>Data</th><th>Current Value</th><th>Update</th></tr>";
	
        for ($i=0;$i<pg_numfields($rset)-$rmlast;$i++)
        {
                $rettab.="<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>";
                $data=pg_fieldname($rset,$i);
                $rettab.="$data</font></b></td><td>";
                $data=pg_result($rset,$rno,$i);
	
		if ($i==4)
			{
			$rettab.=put_office_combo("seloffice",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
		elseif ($i==3)
			{
			$rettab.=put_desig_combo("seldesig",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
		elseif ($i==5)
			{
			$rettab.=put_payment_combo("selpayment",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
		elseif ($i==7)
			{
			$qry = "select code from budget_code_master order by code";

			$rettab.="<select name=\"selbudcode\">";
			if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);

			for($j=0;$j<pg_numrows($rset1);$j++)
        			{
				$data1=pg_result($rset1,$j,0);
				if ($data1==$data)
					$rettab.="<option value=\"$data1\" selected>$data1</option>";
				else
					$rettab.="<option value=\"$data1\">$data1</option>";					      }
			$rettab.="</select></td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";

			}
		else 
			{	
                	$rettab.= "<input name=\"txt$i\" type=text value=\"$data\" style=\"HEIGHT: 20px;WIDTH: 300px\"></td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
        	}
        $rettab.="</table>";
        return $rettab;
        }

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=finance"));
	else die(pg_error());

$sql="select auditno as \"Audit Number\",empid as \"PF Number\",empname as \"Name\",empdesig(empid) as \"Designation\",empoffice(empid) as \"Office\",emppayto_name(empid) as \"Payment Through\",sbtacno as \"S.B Number\",budgetcode as \"Budget Code\" from emp_master ";

if($selid=="auditno")
	{
	$sql=$sql." where auditno='$auditno'";
	}
elseif ($selid=="empid")
	{
	$sql=$sql." where empid='$auditno'";
	}

$sql=stripslashes($sql);
//echo $sql;
if(!$rset = pg_exec($conn,$sql)) die("ERROR :" . $query);
if (pg_numrows($rset)==0)
	{
	echo "<center><h1>Audit Number Not Found </h1></center><br><form name=frm action=optionform.html><center><input type=submit value=\"Back\"></center></form>";
	exit();
	}
echo "<html>
<head>
<script language=\"javascript\">
function change_func()
{
budcodes.value=seloffice1.value;
}
</script>
</head>
<body>
<form name=frm1 action=\"optionform1.php\">";
echo drawtab2($rset,0,0,$conn);
echo "<table align=center><tr><td><input type=submit value=\"  Update Details \"></td></form><td><form name=frm2 action=optionform.html><input type=submit value=\"  Back  \"></form></td></tr></table>";

echo "<center><select name=\"seloffice1\" onchange=\"return change_func()\" language=\"javascript\">";
//selecting the designations
//************************************************************
$qry = " select x.id,x.name,w.budcodes from office_master x,office_budget w where  w.offid=x.id and w.update_on=(select max(update_on) from office_budget where offid=x.id) order by 2";
if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);
for($j=0;$j<pg_numrows($rset1);$j++)
	{
        $data1=pg_result($rset1,$j,1);
	$data2=pg_result($rset1,$j,2);
	//$data3=pg_result($rset1,$j,3);
        echo "<option value='$data2\'>$data1</option>\n";
        }
	echo "</select><input type=text name=budcodes style=\"HEIGHT: 20px;WIDTH: 300px\" ></center>";

?>
