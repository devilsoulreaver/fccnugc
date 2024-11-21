<?php
$auditno=$_POST['auditno'];
$selid = $_POST['selid'];
function put_desig_combo($cmbname,$sel_desig="XXX")
{
	if ($conn1 = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
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
	if ($conn2 = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
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

function put_scale_combo($cmbname,$sel_scale="XXX")
{
	if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());
	$retcmb="<select name=\"$cmbname\">";
	//selecting the scales
	//************************************************************
	$qry = "select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='U' and wefdate = (select max(wefdate) from pay_master where stype='U') union select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='S' and wefdate = (select max(wefdate) from pay_master where stype='S')";
	if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);

	for($i=0;$i<pg_numrows($rset);$i++)
        {
        $data1=pg_result($rset,$i,0);
	$data2=pg_result($rset,$i,0);
	if ($data2==$sel_scale)  $retcmb.="<option value=$data1 selected>$data2</option>";
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
       		if ($i==18)
			{
			$rettab.=put_office_combo("seloffice",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
		elseif ($i==2)
			{
			$rettab.=put_desig_combo("seldesig",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}

		elseif ($i==5)
			{
			$rettab.=put_scale_combo("selpayscale",$data);
			$rettab.="</td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";

			}
		else 
			{
			$rettab.= "<input name=\"txt$i\" type=text value=\"$data\" style=\"HEIGHT: 20px;WIDTH: 300px\"></td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			 
			}
        	}
        $rettab.="</table>";
        return $rettab;
        }

if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());


//$sql="select a.empid as \"PF No.\",a.auditno as \"Audit No.\",empname(a.empid) as \"Name\",a.doj as \"Date of Join\",religion as \"Religion\",caste as \"Caste\",res_category as \"Res. Category\",empoffice(empid) as \"Office\",empdesig(a.empid) as \"Designation\",(select wefdate from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"WEF Date\",(select sanc_date from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"Sanc. Date\",get_payscale(empid) as \"Pay Scale\",(select wefdate from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"WEF Date\",(select sanc_date from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"Sanc.Date\",get_bp(empid) as \"Basic Pay\",(select max(wefdate) from emp_bp_incr where empid=a.empid) as \"Incr. Date\",(select max(sanc_date) from emp_bp_incr  where empid=a.empid) as \"Sanc.Date\",doret as \"Date of Ret.\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='EL'),0) as \"No. of Earned Leave:\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='HPL'),0) as \"No. Half Pay Leave\",dob as \"Date of Birth\" from emp_master a ";
$sql="select a.empid as \"PF No.\",empname(a.empid) as \"Name\",empdesig(a.empid) as \"Designation\",(select max(wefdate) from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"WEF Date\",(select max(sanc_date) from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"Sanc. Date\",get_payscale(empid) as \"Pay Scale\",(select max(wefdate) from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"WEF Date\",(select max(sanc_date) from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"Sanc.Date\",dob as \"Date of Birth\",doret as \"Date of Ret.\",sex as \"Sex\",a.bgroup as \"Blood Group\",religion as \"Religion\",caste as \"Caste\",edu_qual as \"Edu.Quali.\",get_bp(empid) as \"Basic Pay\",(select max(wefdate) from emp_bp_incr where empid=a.empid) as \"WEF Date\",(select max(sanc_date) from emp_bp_incr  where empid=a.empid) as \"Sanc.Date\",empoffice(empid) as \"Office\",emppayto_acno(empid) as \"SBT Account No\",a.doj as \"Date of Join\",joining_ordno as \"Order No.\",joining_orddate as \"Order Date\",get_mguecsno(empid) as \"MGUECS No\" ,get_gisno(empid) as \"GIS No\",get_swfno(empid) as \"SWF No \",get_fbsno(empid) as \"FBS No \" from emp_master a ";
if($selid=="auditno")
	{
	$sql=$sql." where a.auditno='$auditno'";
	}
elseif ($selid=="empid")
	{
	$sql=$sql." where a.empid='$auditno'";
	}

$sql=stripslashes($sql);
//echo $sql;
//exit();
if(!$rset = pg_exec($conn,$sql)) die("ERROR :" . $query);
if (pg_numrows($rset)==0)
	{
	echo "<center><h1>Audit Number Not Found </h1></center><br><form name=frm action=empdet.html method=post><center><input type=submit value=\"Back\"></center></form>";
	exit();
	}
echo "<form name=frm1 action=\"editemp1.php\" method=post >";
echo drawtab2($rset,0,0,$conn);
echo "<center><input type=submit value=Update></center></form><form name=frm2 action=empdet.html method=post><center><input type=submit value=Back></form></center>";
?>



