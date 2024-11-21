<?php

function drawtab2($rset,$rno,$rmlast,$conn)
        {
        $rettab="<table border=0 align=center cellpadding=2 width=550><tr><th>Data</th><th>Current Value</th><th>Update</th></tr>";
	
        for ($i=0;$i<pg_numfields($rset)-$rmlast;$i++)
        {
                $rettab.="<tr bgcolor=#88C6FF><td bgcolor=#0E598F ><font color=white><b>";
                $data=pg_fieldname($rset,$i);
                $rettab.="$data</font></b></td><td>";
                $data=pg_result($rset,$rno,$i);
       		if ($i<>5 && $i<>6 && $i<>7 && $i<>8)
			{
			if ($i==0) $rettab.="<input type=hidden name=empid value=$data>";
			$rettab.="<b>$data</b>";
			$rettab.="</td><td></td></tr>";
			}
		else 
			{
			$rettab.= "<input name=\"txt$i\" type=text value=\"$data\" style=\"HEIGHT: 20px;WIDTH: 100px\"></td><td><input type=checkbox name=\"chk$i\" value=1></td></tr>";
			}
        	}
        $rettab.="</table>";
        return $rettab;
        }

if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());


$sql="select a.empid as \"PF No.\",a.auditno as \"Audit No.\",empname(a.empid) as \"Name\",empoffice(empid) as \"Office\",empdesig(a.empid) as \"Designation\",hpl_crd_date as \"HPL Due On\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='EL' and update_on in (select max(update_on)from leave_account where empid=a.empid)),0) as \"No. of Earned Leave:\",coalesce((select creditamt from leave_account where empid=a.empid and leaveid='HPL' and update_on in (select max(update_on)from leave_account where empid=a.empid)),0) as \"No. Half Pay Leave\",coalesce((select max(update_on)::date from leave_account where empid=a.empid),'31/07/2003') as \"As On :\" from emp_master a ";

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
	echo "<center><h1>Audit Number Not Found </h1></center><br><form name=frm action=leaveupdate.html><center><input type=submit value=\"Back\"></center></form>";
	exit();
	}
echo "<form name=frm1 action=\"leaveupdate1.php\">";
echo drawtab2($rset,0,0,$conn);
echo "<center><input type=submit value=Update></center></form><form name=frm2 action=leaveupdate.html><center><input type=submit value=Back></form></center>";
?>



