<?php

include('tabledraws.php');
$empid = $_POST['empid'];
$audino = $_POST['auditno'];
$empname = $_POST['empname'];
$sex = $_POST['sex'];
$add1 = $_POST['add1'];
$add2 = $_POST['add2'];
$dob = $_POST['dob'];
$doj = $_POST['doj'];
$doret = $_POST['doret'];
$pfdoj = $_POST['pfdoj'];
$empoffice = $_POST['empoffice'];
$empdesig = $_POST['empdesig'];
$payscale = $_POST['payscale'];
$bp = $_POST['bp'];
$ph1 = $_POST['ph1'];
$ph2 = $_POST['ph2'];
$email = $_POST['email'];
$bg = $_POST['bg'];
$religion = $_POST['religion'];
$caste = $_POST['caste'];
$sbtacno = $_POST['sbtacno'];
$pan = $_POST['pan'];
$mguecsno = $_POST['mguecsno'];
$gisno = $_POST['gisno'];
$chkscalesel= $_POST['chkscalesel'];
$select1 = $_POST['select1'];
$chkoffsel= $_POST['chkoffsel'];
$chkdesigsel=$_POST['chkdesigsel'];
$chkbpsel=$_POST['chkbpsel'];
$txt=$_POST['txt'];




$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
	
$txt=strtoupper($txt);
// query creation starts here
//************************************************************
$query = "select ";

if ($auditno==1)
	{
	$query.="empid as \"Audit Number\",";
	}

if ($empname==1)
	{
	$query.="empname as \"Name\",";
	}

if ($sex==1)
	{
	$query.="sex as \"Sex\",";
	}

if ($add1==1)
	{
	$query.="address as \"Present Address\",";
	}
if ($add2==1)
	{
	$query.="tempaddress as \"Premenent Address\",";
	}

if ($dob==1)
	{
	$query.="dob as \"Date of Birth\",";
	}
if ($doj==1)
	{
	$query.="doj as \"Date of Join\",";
	}
if ($doret==1)
	{
	$query.="doret as \"Date of Ret.\",";
	}
if ($pfdoj==1)
	{
	$query.="pfdoj as \"PF Date of Join\",";
	}
if ($empoffice==1)
	{
	$query.="empoffice(empid) as \"Current Office\",";
	}
if ($empdesig==1)
	{
	$query.="empdesig(empid) as \"Current Designation\",";
	}
if ($payscale==1)
	{
	$query.="get_payscale(empid) as \"Current Pay Scale\",";
	}
if ($bp==1)
	{
	$query.="get_bp_rev(empid,current_date) as \"Current Basic Pay \",";
	}
if ($ph1==1)
	{
	$query.="presphone as \"Present Phone No. \",";
	}
if ($ph2==1)
	{
	$query.="permphone as \"Premament Phone No. \",";
	}
if ($email==1)
	{
	$query.="emailid as \"Email Address \",";
	}
if ($bg==1)
	{
	$query.="bgroup as \"Blood Group \",";
	}
if ($religion==1)
	{
	$query.="religion as \"Religion \",";
	}
if ($caste==1)
	{
	$query.="caste as \"Caste \",";
	}
if ($sbtacno==1)
	{
	$query.="sbtacno as \"Account Number \",";
	}
if ($pan==1)
	{
	$query.="pannumber as \"PAN \",";
	}
if ($mguecsno==1)
	{
	$query.="get_mguecsno(empid) as \"MGUECS No \",";
	}
if ($gisno==1)
	{
	$query.="get_gisno(empid) as \"GIS No\",";
	}

$query=substr($query,0,strlen($query)-1);
//print $query;
$query=$query.",get_swfno(empid) as \"SWF No.\",";
$query=$query."get_fbsno(empid) as \"FBS No.\",empid from emp_master where ";



if ($select1=="empid" && $txt!="")
{
$query=$query." empid='$txt'";
}
if ($select1=="empname" && $txt!="")
{
$query=$query." empname like '%$txt%' ";
}
if ($select1=="auditno" && $txt!="")
{
$query=$query." auditno='$txt' ";
}


if ($chkoffsel==1)
	{
	if ($txt=="")
	{
	$query.=" empoffice(empid)='$seloff'";
	}
	else
	{
	$query.=" and empoffice(empid)='$seloff'";
	}
	}

if ($chkdesigsel==1)
	{
	if ($txt=="" && $chkoffsel!=1)
        {
        $query.=" empdesig(empid)='$seldesig'";
        }
        else
        {
	$query.=" and empdesig(empid)='$seldesig'";
	}
	}
 
if ($chkbpsel==1)
        {
        if ($txt=="" && $chkoffsel!=1 && $chkdesigsel!=1)
        {
        $query.=" (get_bp(empid)::int4 between $bp1 and $bp2)";
        }
        else
        {
        $query.=" and (get_bp(empid)::int4 between $bp1 and $bp2)";
        }
        }

if ($chkscalesel==1)
	{
	if ($txt=="" && $chkoffsel!=1 && $chkdesigsel!=1 && $chkbpsel!=1)
        {
        $query.=" get_payscale(empid)='$selscale'";
        }
        else
        {
        $query.=" and get_payscale(empid)='$selscale'";
        }
	}

$query.="  and empcategoryid(empid)<>'G' order by empname";
//echo $query;
if(!$rset = pg_exec($conn,$query)) die("ERROR :" . $query);


if( ($rows=pg_numrows($rset)) <= 0)
	{
	echo "No Matching Results<BR>";
	exit();
	}
echo "<html><head><link target=_main>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
</head><body><center><h2>Search Result</h2>
</center><hr><a name=\"top\"><a><table align=center><tr><td bgcolor=#EE4477 colspan=20>Goto Audit Number :</td></tr><tr> ";
for($i=0;$i<pg_numrows($rset);$i++)
	{
	
	$eno=pg_result($rset,$i,0);
	if ($i%2==0)
		{ 
		echo "<td bgcolor=white>&nbsp<a href=\"#$i\">$eno</a>&nbsp</td>";
		}
	else
		{
                echo "<td bgcolor=grey>&nbsp<a href=\"#$i\">$eno</a>&nbsp</td>";
                }
	$p=$i+1;
	if($p%20==0 ) echo "</tr><tr>";
			
	}
echo "</tr></table><h3><i>There is $i Employees matched with the given Criteria</i></h3><hr>";

for ($i=0;$i<pg_numrows($rset);$i++)
	{
	echo "<a name=\"$i\"><a>";
	echo drawtab2($rset,$i,1);
	$empidx=pg_result($rset,$i,pg_numfields($rset)-1);
	if ($allows==1)
		{
		$allowqry="select distinct on(id) name,amount::numeric(10,2),emp_allowance.wefdate from allowance_master,emp_allowance,allowance_amount where allowance_master.id = emp_allowance.allowid and allowance_master.id = allowance_amount.allowid and empid='$empidx' and emp_allowance.enddate>current_date and allowance_amount.enddate>current_date and allowance_amount.wefdate=(select max(wefdate) from allowance_amount where allowid=allowance_master.id)";
		if(!$allowrec=pg_exec($conn,$allowqry)) die("ERROR :" .$allowqry);
		if (pg_numrows($allowrec)>0)
			{
			echo "<table border=0 align=center cellpadding=2 width=400><tr bgcolor=#88C6CB><td colspan=3><font color=black><center><b>Allowances</b></center></font></td></tr><tr bgcolor=#B8C6CB> <td><font color=black><b>Allowance</b></font></td><td><font color=black><b>Amount</b></font></td><td><font color=black><b>With Effect From</b></font></td></tr>";
			for ($y=0;$y<pg_numrows($allowrec);$y++)
				{
				echo "<tr bgcolor=#B8C6CB>";
				for($z=0;$z<pg_numfields($allowrec);$z++)
				{
					$data=pg_result($allowrec,$y,$z);
					if ($z==1)
					  echo "<td align=right><font color=black size=5>$data</font></td>";
					else
					  echo "<td align=left><font color=black size=5>$data</font></td>";
				}
				echo "</tr>";
				}
			echo "</table>";		
			}
		}
	if ($deda==1)
		{
		
		//********************************************************************************
		// taking lic deductions
		//********************************************************************************
		echo "<center><u><h2>Deductions..</h2></u></center>";
		$dedqry="select policyno,premiumamt::numeric(10,2) from lic where empid='$empidx' and getddmmyy(mat_mm_yy)>=current_date";
		if(!$dedrec=pg_exec($conn,$dedqry)) die("Error : ".$dedqry);
		echo "<table border=0 align=center cellpadding=2 width=300>";
		$lictot=0;
		if(pg_numrows($dedrec)>0)
			{
			echo "<tr bgcolor=#88C6CB><td colspan=2><font color=black><center><b>Life Insurances</b></center></font></td></tr><tr><td><b>Policy Number</b></td><td><b>Premium Amount</b></td></tr>";
			for($y=0;$y<pg_numrows($dedrec);$y++)
			{
			 echo "<tr bgcolor=#B8C6CB>";
                                for($z=0;$z<pg_numfields($dedrec);$z++)
                                {
                                        $data=pg_result($dedrec,$y,$z);
                                        echo "<td align=right><font color=black size=5>$data</font></td>";
					if ($z==1) $lictot=$lictot+$data;
                                }
                                echo "</tr>";	
			}
			echo "<tr><td><font color=black size=5>Total Amount :</font></td><td align=right><b><font color=black size=5>$lictot</font></b></td></tr>";
			}
			echo "</table>";
		//*********************************************************************************

		//*********************************************************************************
		// taking Group Insurance,Staff welfare fund, PF Subscription
		//********************************************************************************
		
		$dedqry="select 'Group Insurance' as \"Deduction\",amount::numeric(10,2) as \"Amount\" from emp_gi_amts where empid='$empidx' and wefdate=(select max(wefdate) from emp_gi_amts where empid='$empidx') union select name,amount::numeric(10,2) from common_deds where id not in (select dedid from com_ded_except where empid='$empidx' and enddate='01/01/1900') union select 'PF Subscription',amount::numeric(10,2)  from pf_subscription where empid='$empidx' and wefdate=(select max(wefdate) from pf_subscription where empid='$empidx') union select 'PF Loan Refund',(totamount/period)::numeric(10,2) from pf_loan_rec where empid='$empidx' and loandate=(select max(loandate) from pf_loan_rec where empid='$empidx')";
		$dedqry=stripslashes($dedqry);
		if(!$dedrec=pg_exec($conn,$dedqry)) die("Error :".$dedqry);
		$arr=array(1);
		if (pg_numrows($dedrec)>0)
			{
			echo drawtab1($dedrec,$arr,300);
			for($k=0;$k<pg_numrows($dedrec);$k++)
			{
			$amt=pg_result($dedrec,$k,1);
			$lictot=$lictot+$amt;
			}
		}

		//********************************************************************************
		$arr=array(2);
			
		//********************************************************************************
		//taking the outside recovery requests for an employee
		//********************************************************************************
		$dedqry="select name as \"Rec. Agency\",from_mm_yy as \"From\",amount::numeric(10,2) as \"Amount\" from emp_ded_request,rec_agencies where dedid=id and empid='$empidx' and mat_mm_yy='01:9999';";
                $dedqry=stripslashes($dedqry);
                if(!$dedrec=pg_exec($conn,$dedqry)) die("Error :".$dedqry);
                if (pg_numrows($dedrec)>0)
                        {
			echo "<center><u><h3>Out Side Recovery</h3></u></center>";
                        echo drawtab1($dedrec,$arr,300);
			for($k=0;$k<pg_numrows($dedrec);$k++)
                        {
                        $amt=pg_result($dedrec,$k,2);
                        $lictot=$lictot+$amt;
                        }
                        }
		//********************************************************************************
		$arr=array(1,3,4,5,6);

		//********************************************************************************
		//taking the internal loans if any
		//********************************************************************************	
		
		$dedqry="select name as \"Loan Type\",amount as \"Loan Amount\",wefdate as \"Loan Date\",paidinst as \"Paid. Inst\",(amount - amount/recperiod * paidinst)::numeric(10,2) as \"Balance Amt\",case when (recperiod - paidinst)=999 then 0 else (recperiod - paidinst) end as \"Balance Insts\",(amount/recperiod)::numeric(10,2) as \"Monthly Inst\"  from ded_master,emp_ded_inst where paidinst <> recperiod and empid = '$empidx' and emp_ded_inst.dedid = ded_master.id and ded_type='L'";
                $dedqry=stripslashes($dedqry);
                if(!$dedrec=pg_exec($conn,$dedqry)) die("Error :".$dedqry);
                if (pg_numrows($dedrec)>0)
                        {
			echo "<center><u><h3>Internal Loans</h3></u></center>";
                        echo drawtab1($dedrec,$arr,800);
			for($k=0;$k<pg_numrows($dedrec);$k++)
                        {
                        $amt=pg_result($dedrec,$k,6);
                        $lictot=$lictot+$amt;
                        }
                        }
		echo "<table bgcolor=#B8C6CB border=0 align=center><tr><td><b>Total Recovery Amount :$lictot</b></td></tr></table>";
		}

	echo "<br><a href=\"#top\">Top</a><hr>";
	}	
echo "
<script language=\"javascript\">
theDate=new Date();
document.write(\"<center><b>The Report as On :   \",theDate.getHours(),\" : \",theDate.getMinutes(),\"       \",theDate.getDate(),\" / \",theDate.getMonth()+1,\" / \",theDate.getFullYear(),\"</b></center>\");
</script></html>";		
?>
