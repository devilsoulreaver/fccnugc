<?php

function drawtab2($rset,$rno,$rmlast,$conn)
        {
        $rettab="<table border=0 align=center cellpadding=2 width=785><tr><th>Data</th><th>Current Value</th><th>Update</th><th>New Value Select</th></tr>";
	
        for ($i=0;$i<pg_numfields($rset)-$rmlast;$i++)
        {
                $rettab.="<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>";
                $data=pg_fieldname($rset,$i);
                $rettab.="$data</font></b></td><td>";
                $data=pg_result($rset,$rno,$i);
                $rettab.= "<input name=\"txt$i\" type=text value=\"$data\" style=\"HEIGHT: 20px;WIDTH: 300px\"></td><td><input type=checkbox name=\"chk$i\" value=1></td><td>";
		if ($i==6)
			{
			$rettab.="<select name=\"selcat\">";

			//selecting the designations
			//************************************************************
			$qry="select 'FC' union select 'OBC'union select 'SC' union select 'ST' union select 'OEC'";

			if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);

			for($j=0;$j<pg_numrows($rset1);$j++)
        			{
        			$data1=pg_result($rset1,$j,0);
        			$rettab.="<option value=\"$data1\">$data1</option>";
        			}
			$rettab.="</select></td></tr>";
			}

		elseif ($i==7)
			{
			$rettab.="<select name=\"seloffice\">";

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
			$rettab.="</select></td></tr>";
			}
		elseif ($i==8)
			{
			$rettab.="<select name=\"seldesig\">";

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
			$rettab.="</select></td></tr>";
			}

		elseif ($i==11)
			{
			$qry = "select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='U' and wefdate = (select max(wefdate) from pay_master where stype='U') union select scale,pay_scale.id from pay_scale,pay_master where pay_master.id = pay_scale.payid and pay_master.stype='S' and wefdate = (select max(wefdate) from pay_master where stype='S')";

			$rettab.="<select name=\"selpayscale\">";
			if(!$rset1 = pg_exec($conn,$qry)) die("ERROR :" . $qry);

			for($j=0;$j<pg_numrows($rset1);$j++)
        			{
        			$data1=pg_result($rset1,$j,0);
				$data2=pg_result($rset1,$j,0);
        			$rettab.="<option value=\"$data2\">$data1</option>";
        			}
			$rettab.="</select></td></tr>";

			}
		else 
			{	
			$rettab.="</td></tr>";
			}
        	}
        $rettab.="</table>";
        return $rettab;
        }

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());


$sql="select a.empid as \"PF No.\",a.auditno as \"Audit No.\",empname(a.empid) as \"Name\",a.doj as \"Date of Join\",religion as \"Religion\",caste as \"Caste\",res_category as \"Res. Category\",empoffice(empid) as \"Office\",empdesig(a.empid) as \"Designation\",(select wefdate from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"WEF Date\",(select sanc_date from emp_desig where enddate='01/01/1900' and empid=a.empid) as \"Sanc. Date\",get_payscale(empid) as \"Pay Scale\",(select wefdate from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"WEF Date\",(select sanc_date from emp_scale where enddate='01/01/9999' and empid=a.empid) as \"Sanc.Date\",get_bp(empid) as \"Basic Pay\",(select max(wefdate) from emp_bp_incr where empid=a.empid) as \"Incr. Date\",(select max(sanc_date) from emp_bp_incr  where empid=a.empid) as \"Sanc.Date\",doret as \"Date of Ret.\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='EL'),0) as \"No. of Earned Leave:\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='HPL'),0) as \"No. Half Pay Leave\",dob as \"Date of Birth\" from emp_master a ";

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
	echo "<center><h1>Audit Number Not Found </h1></center><br><form name=frm action=newempdet.html><center><input type=submit value=\"Back\"></center></form>";
	exit();
	}
echo "<form name=frm1 action=\"neweditemp1.php\">";
echo drawtab2($rset,0,0,$conn);
echo "<center><input type=submit value=Update></center></form><form name=frm2 action=newempdet.html><center><input type=submit value=Back></form></center>";
?>



