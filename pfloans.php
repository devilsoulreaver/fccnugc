<?php
include('tabledraws.php');
if(!$empid)
{
echo "<h3>Error :</h3><hr><h2>Please Enter the Audit Number</h2><hr>";
exit();
}
if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error()); 
$qry="select empname as \"Name\",empoffice(empid) as \"Office\",empdesig(empid) as \"Designation\",get_payscale(empid) as \"Pay Scale\",get_bp(empid) as \"Basic Pay\" from emp_master where empid='$empid'";
$qry=stripslashes($qry);
$rset=pg_exec($conn,$qry);
if (pg_numrows($rset)!=0)
{
 echo "<table width=785 align=center><tr bgcolor=#FFF5D1><td><h4>Employee Details</h4></td></tr></table>";
 echo drawtab2($rset,0,0);
}

$sql="select empid,amount::numeric(10,2),totamount::numeric(10,2),(totamount/period)::numeric(10,2),period,(recdamt/(totamount/period))::numeric(10,2),recdamt::numeric(10,2),loandate from pf_loan_rec where empid='$empid' and loandate=(select max(loandate) from pf_loan_rec where empid='$empid')";
$loanset=pg_exec($conn,$sql);
if (pg_numrows($loanset)==0)
{
echo "<center><h1>No Loans for the Employee <br> Verify the Employee PF Number</h1></center>";
exit();
}
$amt=pg_result($loanset,0,1);
$totamt=pg_result($loanset,0,2);
$instamt=pg_result($loanset,0,3);
$instno=pg_result($loanset,0,4);
$recinsts=pg_result($loanset,0,5);
$recdamt=pg_result($loanset,0,6);
$ldate=pg_result($loanset,0,7);


echo "<table align=center width=600 bgcolor=#FFF5D1 border=1><tr><td colspan=2 align=left><b><i>The Recent Refundable PF Loan  Details</b></i></td></tr><tr><td>Total Loan Amount</td><td align=right>$totamt</td></tr><tr><td>Last Withdrawn Amount</td><td align=right>$amt</td></tr><tr><td>Installment Amount</td><td align=right>$instamt</td></tr><tr><td>Total No. of Installments</td><td align=right><b>$instno</b></td></tr><tr><td>No. of Installments Paid</td><td align=right><b>$recinsts</b></td></tr><tr><td>Total Recovered Amount</td><td align=right>$recdamt</td></tr><tr><td>Loan Date</td><td align=right>$ldate</td></tr></table>";

?>
