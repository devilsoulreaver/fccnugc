<?php
include('tabledraws.php');
$empid=$_POST['empid'];
$month = $_POST['month'];
$year = $_POST['year'];
if(!$empid)
{
echo "<h3>Error :</h3><hr><h2>Please Enter the Audit Number</h2><hr>";
exit();
}
 $m1=date("d/m/Y",mktime(0,0,0,4,1,$year));
 $m2=date("d/m/Y",mktime(0,0,0,3,31,$year1));

 if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error()); 
 $qry="select empname as \"Name\",empoffice(empid,'$m1') as \"Office\",empdesig(empid,'$m1') as \"Designation\",get_payscale(empid,'$m1') as \"Pay Scale\",get_bp(empid,'$m1') as \"Basic Pay\" from emp_master where empid='$empid'";
$qry=stripslashes($qry);
$rset=pg_exec($conn,$qry);
if (pg_numrows($rset)!=0)
{
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);

 $qry="select getpfclosure('$empid','$m1','$m2')";
 pg_exec($conn,$qry);
 
 $qry="select amount::numeric(10,2) from pf_open_bal where empid='$empid' and wefdate='$m1'";
 $opbal=pg_exec($conn,$qry);
 if (pg_numrows($opbal)==0)
	{
        echo "<h3>Error :</h3><hr><h2>The Opening Balance for the Year $m1 not Calculated</h2><hr>";
	exit();
	}
 else
	{
	$opbalamt=pg_result($opbal,0,0);
 	echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Opening Balance</b>:  </td><td align=right><b>$opbalamt</b></td></tr></table> ";
        }
 $qry="select monyear as \"Month & Year\",pfs as \"PF Subscription\",pfl as \"PF Loan\",daa as \"DA Arrear\",pfw as \"PF Withdraw\",progtot as \"Prograssive Amount\" from temp_pfclosure ";
 
 $qry=stripslashes($qry);
 $rset=pg_exec($conn,$qry);
 $arr=array(1,2,3,4,5);
 echo drawtab1($rset,$arr);

 $qry="select 'Totals :','PF Sub.  :',sum(pfs)::numeric(10,2),'PF LR.:',sum(pfl)::numeric(10,2),'DA:',sum(daa)::numeric(10,2),'PF Wd:',sum(pfw)::numeric(10,2),'Prog.Amt:',sum(progtot)::numeric(10,2) from temp_pfclosure";
 $qry=stripslashes($qry);
 $sumset=pg_exec($conn,$qry);
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1>";
 for($i=0;$i<pg_numfields($sumset);$i++)
	{
	$data=pg_result($sumset,0,$i);
        if($i%2==0)	echo "<td align=right><b>$data</b></td>";
	else  echo "<td bgcolor=#0E598F align=right><b><font color=white>$data</font></b></td>";
	}
	echo "</tr></table> ";
 $qry="select sum(pfs)+sum(pfl)+sum(daa),sum(progtot),sum(pfw) from temp_pfclosure";
 $totset=pg_exec($conn,$qry);
 
 
 $qry="select rate from pf_interest where wefdate=(select max(wefdate) from  pf_interest where wefdate<'$m2')";
 $pfint=pg_exec($conn,$qry);

 $progtot=pg_result($totset,0,1);
 $intrate=pg_result($pfint,0,0);
 $totcrdamt=pg_result($totset,0,0);
 $totwd=pg_result($totset,0,2);
 $totint=round($progtot*$intrate/1200,0);
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Interest to PF Amount</b>:  </td><td align=right><b>$intrate</b></td></tr></table> ";
  
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Total Interest to Prograssive Total</b>:  </td><td align=right><b>$totint</b></td></tr></table> ";
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Total Credit of The Year</b>:  </td><td align=right><b>$totcrdamt</b></td></tr></table> ";
 $data=$opbalamt+$totcrdamt;
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Gross Amount</b>:  </td><td align=right><b>$data</b></td></tr></table> ";
 
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Total Withdrawal of The Year</b>:  </td><td align=right><b>$totwd</b></td></tr></table> ";
 $data=$data-$totwd;
 echo "<table cellpadding=2 width=600 align=center><TR bgcolor=#FFF5D1><td><b>Closing Amount</b>:  </td><td align=right><b>$data</b></td></tr></table> ";
}
?>
