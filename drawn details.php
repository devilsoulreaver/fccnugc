<?php

include('tabledraws.php');
if(!$empid)
{
echo "<h3>Error :</h3><hr><h2>Please Enter the Audit Number</h2><hr>";
exit();
}
//******************************************************
// the ofdates
$year=$_REQUEST['year'];
$month=$_REQUEST['month'];
$year=2007;
$month=6;

$year2=2007;
$month2=10;
 $m1=date("d/m/Y",mktime(0,0,0,$month,1,$year));
 $effectdate=date("d/m/Y",mktime(0,0,0,$month+1,1,$year));
$m2=date("d/m/Y",mktime(0,0,0,$month2,1,$year2));
 $effectdate2=date("d/m/Y",mktime(0,0,0,$month2+1,1,$year2));
//echo $m1."-".$effectdate;
 //****************************************************
 
 $arr=array(1);

//require_once('connpf.php');
if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());
 //****************************************************
$qry="select empname as \"Name\",empoffice(empid,'$m1') as \"Office\",empdesig(empid,'$m1') as \"Designation\",get_payscale(empid,'$m1') as \"Pay Scale\",get_bp(empid,'$m1') as \"Basic Pay\" from emp_master where empid='$empid'";
//print $qry;
//$qry="select empname as \"Name\",empoffice(empid,'$m1') as \"Office\",empdesig(empid,'$m1') as \"Designation\",get_payscale(empid,'$m1') as \"Pay Scale\",get_bp(empid,'$m1') as \"Basic Pay\" from emp_master where empid='$_SESSION['user']'";
$qry=stripslashes($qry);
$rset=pg_exec($conn,$qry);
?>
<table width=97% align=center><tr><td align=right><a href="signout.php" title="Sign Out"><font color="#ff0000">Sign Out</font></a></td></tr></table>
<?php
if (pg_numrows($rset)!=0)
{
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);

 $qry="select saldetails('$empid','$m1','$effectdate')";
  $trec=pg_exec($conn,$qry);
 $msg=pg_result($trec,0,0);
 if (strlen($msg)>10){
	echo "<h3>Information :</h3><hr><h2>$msg</h2><hr>";
	exit();
 }
$rettab.="<TD align=left width=$tdwid>Total</TD>";


//echo "<table align=center><tr bgcolor=#b3cff3><td><b>GROSS</b></td><td>$bno</td><td><b>DEDUCTION</b></td><td>$bdate</td></tr></table>";
 //****************************************************
 $qry="select distinct ofdate from ind_bills_master where ofdate>'01/03/2004' and ofdate like '01%';";
 //print $qry;
  $rsetj=pg_exec($conn,$qry);
  //for ($k=0;$k<pg_numrows($rsetj);$k++)
  // {
  // $effectdate=pg_result($rsetj,$k,0);
  print $effectdate;
  //print 'ssssssssssssssss';

 	$allowqry="select case when indid in ('LEAVEEX','LEAVESPL')='t' then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"SALARY\",amount::numeric(10,2) as \"DETAILS\" from temp_sal_det  where empid='$empid' and groupid like 'ALLOW%' and ofdate between '$effectdate' and '$effectdate2' and groupid<>'TAXPRED'";
 //print $allowqry;
 	$rset=pg_exec($conn,$allowqry);
 	if (pg_numrows($rset)!=0)
 	{
 	//echo drawtab1($rset,$arr);
	 	$rettab="";
		$twid=100/18;
		$tdwid=$twid."%";
        	$rettab.= "<CENTER><table><tr><td width=50% align=center>GROSS</td><td width=50% align=center>DEDUCTION</td></tr></table><TABLE BORDER=0 cellpadding=2 width=100%>";
		for ($j=0;$j<pg_numfields($rset);$j++)
		{
		$hd=pg_fieldname($rset,$j);
		$rettab.="<th bgcolor=#0E598F><font color=white>$hd</font></th>";
		}
	//$tcol1=pg_numfields($rset);
	//echo $tcol1;
	//$tcol2=pg_numfields($rset3);
//$rettab.= "<TR bgcolor=#FFF5D1><td colspan=$tcol1>Gross</td><td colspan=$tcol2>Deduction</td></tr>";
		$rettab.= "<TR bgcolor=#FFF5D1>";
		for ($i=0;$i<pg_numrows($rset);$i++)
		{
			$rno=$i+1;
			//$rettab.= "<TR bgcolor=#FFF5D1>";

			for ($j=0;$j<pg_numfields($rset);$j++)
			{

			$data=pg_result($rset, $i,$j);
				if(in_array($j,$arr))
				{
				}
				else
					$rettab.="<TD align=left width=$tdwid>$data</TD>";
				
			}

		}
		$rettab.="<TD align=left width=$tdwid title=GROSS>Total</TD>";



$dedqry="select case when indid in ('LEAVEBP','LEAVEDA','LEAVEHRA') then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"Deductions\",amount::numeric(10,2) as \"Amount\" from temp_sal_det where empid='$empid' and groupid like 'DED%' and ofdate between '$effectdate' and '$effectdate2' and groupid<>'TAXPRED'";
//print $dedqry;
 $rset2=pg_exec($conn,$dedqry);
 		for ($i=0;$i<pg_numrows($rset2);$i++)
		{
		$rno=$i+1;
		//$rettab.= "<TR bgcolor=#FFF5D1>";

			for ($j=0;$j<pg_numfields($rset2);$j++)
			{

			$data=pg_result($rset2, $i,$j);
				if(in_array($j,$arr))
				{
				}
				else
					$rettab.="<TD align=left width=$tdwid>$data</TD>";

			}

		}
$rettab.="<TD align=left width=$tdwid title=DEDUCTION>Total</TD>";
$rettab.="<TD align=left width=$tdwid>Net Amount</TD>";
$rettab.="<TD align=left width=$tdwid>Bill No</TD>";
$rettab.="<TD align=left width=$tdwid>Bill Date</TD>";
$rettab.="</tr>";
		for ($i=0;$i<pg_numrows($rset);$i++)
		{
		$rno=$i+1;
		//$rettab.= "<TR bgcolor=#FFF5D1>";


			 //$rettab.="</tr>";
			//$rettab.= "<TR bgcolor=#FFF5D1>";
			for ($j=0;$j<pg_numfields($rset);$j++)
			{

			$data=pg_result($rset, $i,$j);
			if(in_array($j,$arr))
					$rettab.="<TD align=right width=$tdwid>$data</TD>";


			}
			//$rettab.="</tr>";
		}
		$allowtot=0.00;
		for($i=0;$i<pg_numrows($rset);$i++)
		{
		$allowtot+=pg_result($rset,$i,1);
		}
		$rettab.="<TD align=right width=$tdwid><b>$allowtot.00</b></TD>";


		$dedqry="select case when indid in ('LEAVEBP','LEAVEDA','LEAVEHRA') then (getdedallowname(groupid,indid)::text||' for '||initcap(to_char(effectdate-1,'mon'))||':'||to_char(effectdate-1,'yyyy')) else getdedallowname(groupid,indid) end as \"Deductions\",amount::numeric(10,2) as \"Amount\" from temp_sal_det where empid='$empid' and groupid like 'DED%' and ofdate between '$effectdate' and '$effectdate2' and groupid<>'TAXPRED'";
 $rset2=pg_exec($conn1,$dedqry);
		for ($i=0;$i<pg_numrows($rset2);$i++)
		{
		$rno=$i+1;
		//$rettab.= "<TR bgcolor=#FFF5D1>";


			 //$rettab.="</tr>";
			//$rettab.= "<TR bgcolor=#FFF5D1>";
			for ($j=0;$j<pg_numfields($rset2);$j++)
			{

			$data=pg_result($rset2, $i,$j);
			if(in_array($j,$arr))
					$rettab.="<TD align=right width=$tdwid>$data</TD>";


			}
			//$rettab.="</tr>";
		}
		$dedtot=0;
		for($i=0;$i<pg_numrows($rset2);$i++)
		{
		$dedtot+=pg_result($rset2,$i,1);
		}

		$rettab.="<TD align=right width=$tdwid><b>$dedtot.00</b></TD>";
		$sql="select a.billno,a.billdate from bills a,bills_det b,ind_bills_master c where c.empid='$empid' and c.ofdate between '$effectdate' and '$effectdate2' and a.billno=b.billno and b.ind_billno=c.ind_bill_no ";
		$trec=pg_exec($conn1,$sql);
		$bno=pg_result($trec,0,0);
		$bdate=pg_result($trec,0,1);
		$net_amt=$allowtot-$dedtot;
		$rettab.="<TD align=right width=$tdwid><b>$net_amt.00</b></TD>";
		$rettab.="<TD align=right width=$tdwid>$bno</TD>";
		$rettab.="<TD align=right width=$tdwid>$bdate</TD>";
			$rettab.="</tr>";
		$rettab.="</TABLE></CENTER>";
		echo $rettab;
 	}

$allowtot=$allowtot-$dedtot;
//echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b><font size=5>Net Amount  </font></b>:  </td><td align=right><font size=5><b>$allowtot.00</b></font></td></tr></table> ";
	//}//end for
}
else
{
echo "<h3>Error :</h3><hr><h2>Audit Number Not Found </h2><hr>";
exit();
}


?>
