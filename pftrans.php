<?php
 include('tabledraws.php');
 if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
        else die(pg_error());

 $m1=date("d/m/Y",mktime(0,0,0,$month1,1,$year1));
 $m2=date("d/m/Y",mktime(0,0,0,$month2,31,$year2));

 $qry="select empname as \"Name\",empoffice(empid,'$m1') as \"Office\",empdesig(empid,'$m1') as \"Designation\",get_payscale(empid,'$m1') as \"Pay Scale\",get_bp(empid,'$m1') as \"Basic Pay\" from emp_master where empid='$empid'";
 $qry=stripslashes($qry);
 $rset=pg_exec($conn,$qry);
 if (pg_numrows($rset)!=0)
 {
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);
 }
 else exit();

 $qry="select case when typeid='PFS' then 'PF Subscription' else case when typeid='PFL' then 'PF Loan Refund' else 'DA Arrear' end end as \"Type of Deposite\",amount::numeric(10,2) as \"Amount\",initcap(to_char(insdate-1,'month-yyyy')) as \"Month of Deposite\" from pf_trans where empid='$empid' and insdate between '$m1' and '$m2'";
 $rset=pg_exec($conn,$qry);
 if (pg_numrows($rset)==0)
  {
  echo "<center><h1>No Transactions for the period $m1 to $m2</h1></center>"; 
  }
 else
  {
  $arr=array(1);
  echo drawtab1($rset,$arr);
  }
?>
