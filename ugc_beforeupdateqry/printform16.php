<?php ob_start(); ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>form16</title>
<style>
	body{
		margin:0px;
		font:"Courier New", Courier, monospace;
	}
	.maintable{
		border:1px solid #333333;
	}
	.maintable td{
		
	}
	.br{
		border-bottom:1px solid #333333;
		border-right:1px solid #333333;
		padding:2px;
	}
	.b{
		border-bottom:1px solid #333333;
		padding:2px;
	}
	@media print {
	input#btnPrint {
		display: none;
	}
	input#btnClose {
		display: none;
	}
}
</style>
<script type="text/javascript">
	function printform16(){
		window.print();
	}
	function form16close(){
		window.location="form16.php";
	}
</script>
</head>
<body>
	
	<table cellpadding="0" cellspacing="0" border="0" width="100%">
	<tr>
			<td align="right">
				<input type="button" id="btnPrint" value="Print" onclick="javascript:printform16();"  />&nbsp;&nbsp;<input id="btnClose" type="button" value="Close" onclick="javascript:form16close();"  /></td>
		</tr>
		<tr>
			<td align="center">
				<p><strong>FORM No 16 A</strong><br/>
			  (See Rule 12 (1) (b)and Rule 31 (1) (a))<br/>
			  <strong>CERTIFICATE FOR TAX DEDUCTED AT SOURCE FROM INCOME<br />
			  CHARGEBALE UNDER THE HEAD SALARIES</strong>
			  </p></td>
		</tr>
		<tr>
			<td align="center">
				<table cellpadding="0" cellspacing="0" border="0" width="100%" class="maintable">
					<tr>
						<td align="left" width="40%" class="br"><font size="2"><b>Name And Address Of Employer</b></font>
						</td>
						<td align="left" width="60%" class="b"><font size="2"><b>Name And Designation Of Employee</b></font>
						</td>
					</tr>
					<tr>
						<td align="left" width="40%" class="br">
						<font size="1">
							<b>REGISTRAR<br />
							MAHATMA GANDHI UNIVERSITY<br />
							PRIYADARSANI HILLS P.O<br />
							KOTTAYAM - 686560<br />
							</b>
						</font>
						</td>
						<td align="left" width="60%" class="b"><font size="1"><b><?php echo $empdetails['empname']."<br/>";  echo  $empdetails1['disig']; ?></b></font>
						</td>
					</tr>
					<tr style="height:30px;">
						<td align="left" width="40%" class="br">
						<font size="1">TAN No : TVDM 00559 G<b><br />
							</b> </font>					  </td>
						<td align="left" width="60%" class="b">
							<font size="2">
								PAN No :&nbsp;<?php echo $empdetails['pannumber']; ?> <b><br />
							    </b> </font>					  </td>
					</tr>
					<tr>
						<td align="left" width="40%" class="br" style="border-bottom:0px;">
						  <font size="2">
						  TDS Circle Where Annual Return/Statement Under Section 206 is to be field salary Ward Kottayam						   						  </font> 
						  </td>
						<td align="left" width="60%" style="border-bottom:0px;">
							<table cellpadding="0" cellspacing="0" border="0" width="100%">
								<tr>
									<td width="50%" style="padding:0px;">
										<table cellpadding="0" cellspacing="0" border="0" width="100%">
											<tr><td colspan="2" align="center" class="br">
											 <font size="2">Period</font>
											 </td></tr>
											<tr>
												<td width="50%" class="br" style="border-bottom:0px" >
												 <font size="2">From : 01/04/2009</font>
												</td>
												<td width="50%" class="br" style="border-bottom:0px">
												 <font size="2">To : 31/03/2010</font>
												</td>
											</tr>
										</table>
									</td>
									<td width="50%" align="center">
										 <font size="2">Assesment Year : 2010 - 2011</font>
									</td>
								</tr>
							</table>
					  </td>
					</tr>
			  </table>		
			</td>
		</tr>
		<tr>
			<td >
				<table cellpadding="0" cellspacing="0" border="0"  width="100%">
					<tr style="height:30px;">
						<td colspan="2">
							<font size="2.5"><b><br /><u>DETAILS OF SALARY PAID AND ANY OTHER INCOME AND TAX DEDUCTED</u></b></font>						</td>
					</tr>
					<tr style="height:30px;">
						<td width="45%"><font size="2">1. Gross Salary</font></td>
						<td width="55%"><font size="2">Rs.&nbsp;<?php echo (int)$gross_total; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">2. Less Allowances to the exempt under Section 10</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$less_allowance; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">3. Balance(1-2)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$balance; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td colspan="2"><font size="2">4. <b><u>Deductions</u></b></font></td>
					</tr>
					<tr >
						<td colspan="2">
							<table cellpadding="0" cellspacing="0" border="0"  width="60%">
								<tr style="height:40px;">
									<td width="5%">&nbsp;</td>
									<td width="45%"><font size="2">a. Entertainment allowance</font></td>
									<td width="50%"><font size="2">Rs.&nbsp;<?php echo (int)$ent_allowance; ?></font></td>
								</tr>
								<tr style="height:30px;">
									<td width="5%">&nbsp;</td>
									<td width="45%"><font size="2">b. Tax on employment</font></td>
									<td width="50%"><font size="2">Rs.&nbsp;<?php echo (int)$tax_employment; ?></font></td>
								</tr>
								<tr style="height:30px;">
									<td width="5%">&nbsp;</td>
									<td width="45%"><font size="2">c. Interest on HBA</font></td>
									<td width="50%"><font size="2">Rs.&nbsp;<?php echo (int)$inthba; ?></font></td>
								</tr>
							</table>						</td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">5. Aggreate of 4 (a to c)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$aggregate; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">6. Income chargable under the head "salaries" (3-5)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$income_salaries; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">7. Add: Any other income reported by the employee</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$other_income; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">8. Gross Total Income (6+7)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$gross_total_income; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td colspan="2"><font size="2.5">9. <b><u>Deductions Under Chapter VI - A</u></b></font></td>
					</tr>
					<tr >
						<td colspan="2">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #333333">
								  <tr >
										<td align="left" width="6%" class="br" >&nbsp;</td>
										<td align="left" width="34%"  class="br" ><span style="font-size:12px;"> <b>Details</b> </span> </td>
										<td align="left" width="20%"  class="br" ><span style="font-size:12px;"> <b>Gross Amount</b> </span> </td>
										<td align="left" width="20%"  class="br" ><span style="font-size:12px;"> <b>Qulifying Amount</b> </span> </td>
										<td align="left" width="20%"  class="b" ><span style="font-size:12px;"> <b>Deductable Amount</b> </span> </td>
									  </tr>
									  <tr >
										<td align="left" class="br" > A </td>
										<td align="left"  class="br" ><span style="font-size:12px;"> Deductions u/s 80 c </span> </td>
										<td align="left"  class="br" ><span style="font-size:12px;"><?php echo $ded_gross; ?></span></td>
										<td align="left"  class="br" ><span style="font-size:12px;"> 1,00,000/- </span> </td>
										<td align="left" class="b" ><span style="font-size:12px;"><?php echo $ded_amt; ?></span></td>
									  </tr>
									  <tr>
										<td align="left" class="br" > B </td>
										<td align="left" class="br" ><span style="font-size:12px;"> Medical Insurence Premia (u/s 80D) </span></td>
										<td align="left" class="br" ><span style="font-size:12px;"><?php echo $med_gross; ?></span></td>
										<td align="left" class="br" ><span style="font-size:12px;"> 15,000/- </span> </td>
										<td align="left" class="b" ><span style="font-size:12px;"><?php echo $med_amt; ?></span></td>
									  </tr>
									  <tr>
										<td align="left" class="br" > C </td>
										<td align="left" class="br" ><span style="font-size:12px;"> Maintenance of handicaped dependents (u/s 80 DD) </span></td>
										<td align="left"  class="br" ><span style="font-size:12px;"><?php echo $maintain_gross; ?></span></td>
										<td align="left"  class="br" ><span style="font-size:12px;"> 75,000/- </span> </td>
										<td align="left" class="b" ><span style="font-size:12px;"><?php echo $maintain_amt; ?></span></td>
									  </tr>
									  <tr>
										<td align="left" class="br" > D </td>
										<td align="left"  class="br" ><span style="font-size:12px;"> Donations	&amp;	Contributions (u/s 80G) </span> </td>
										<td align="left"  class="br" ><span style="font-size:12px;"><?php echo $donation_gross; ?></span></td>
										<td align="left"  class="br" >&nbsp;</td>
										<td align="left" class="b" ><span style="font-size:12px;"><?php echo $donation_amt; ?></span></td>
									  </tr>
									  <tr>
										<td align="left" class="br" > E </td>
										<td align="left"  class="br" ><span style="font-size:12px;"> Others</span> </td>
										<td align="left"  class="br" ><span style="font-size:12px;"><?php echo $other_gross; ?></span></td>
										<td align="left"  class="br" >&nbsp;</td>
										<td align="left" class="b" ><span style="font-size:12px;"><?php echo $other_amt; ?></span></td>
									  </tr>
								</table>						</td>
					</tr>
					<tr style="height:30px;">
                      <td ><font size="2">10. Aggregate of deductable amount under chapter VI-A </font></td>
					  <td ><font size="2">Rs.&nbsp;<?php echo $aggregate_deductable; ?></font></td>
				  </tr>
					<tr style="height:30px;">
						<td ><font size="2">11. Total Income (8-10)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo $total_income; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">12. Tax on total income and Surcharge(Education Cess) there on</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo round($tax_payable)." + ".round($cess_payable); ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">13. Less :Relief Under Section 89 (attach details)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo (int)$less_relife; ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">14. Balance Tax payable (12-13)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo ceil($balance_tax_payable); ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">15. Less :Tax deducted at source</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo round($tax_ded_source); ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td ><font size="2">16. Tax payable/Refundable (14-15)</font></td>
						<td ><font size="2">Rs.&nbsp;<?php echo ceil($tax_payble_refundable); ?></font></td>
					</tr>
					<tr style="height:30px;">
						<td colspan="2"><font size="2.5"><b><u>DETAILS OF TAX DEDUCTED AND DEPOSITED INTO CENTRAL GOVERNMENT ACCOUNT</u></b></font></td>
					</tr>
					<tr >
						<td colspan="2">
							<table border="0" cellpadding="0" cellspacing="0" width="100%" style="border:1px solid #333333">
								  <tr >
										<td align="left" width="15%"  class="br" ><span style="font-size:12px;"> <b>Month</b> </span> </td>
										<td align="left" width="15%"  class="br" ><span style="font-size:12px;"> <b>Amount</b> </span> </td>
										<td align="left" width="30%"  class="br" ><span style="font-size:12px;"> <b>Chellan No. & Date Of Payment</b> </span> </td>
										<td align="left" width="40%"  class="b" ><span style="font-size:12px;"> <b>Name of Bank & Branch Where Tax Deposited</b> </span> </td>
									  </tr>
								  <tr >
                                    <td align="left"  class="br" ><span style="font-size:12px;">MARCH </span> </td>
								    <td align="left"  class="br" ><?php echo $tax_ded_march; ?></td>
								    <td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
								    <td align="left" class="b" >&nbsp;</td>
						      </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">APRIL </span> </td>
									<td align="left"  class="br" ><?php echo $tax_ded_april; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">MAY </span> </td>
									<td align="left"  class="br" ><?php echo $tax_may; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">JUNE </span> </td>
									<td align="left"  class="br" ><?php echo $tax_june; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								  <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">JULY </span> </td>
									<td align="left"  class="br" ><?php echo $tax_july; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">AUGUST </span> </td>
									<td align="left"  class="br" ><?php echo $tax_august; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">SEPTEMPER </span> </td>
									<td align="left"  class="br" ><?php echo $tax_septemper; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">OCTOBER </span> </td>
									<td align="left"  class="br" ><?php echo $tax_octobar; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								    <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">NOVEMBER </span> </td>
									<td align="left"  class="br" ><?php echo $tax_november; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								    <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">DECEMBER </span> </td>
									<td align="left"  class="br" ><?php echo $tax_december; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">JANUARY </span> </td>
									<td align="left"  class="br" ><?php echo $tax_january; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
								   <tr >
									<td align="left"  class="br" ><span style="font-size:12px;">FEBRUARY </span> </td>
									<td align="left"  class="br" ><?php echo $tax_february; ?></td>
									<td align="left"  class="br" ><span style="font-size:12px;"> &nbsp; </span> </td>
									<td align="left" class="b" >&nbsp;</td>
								  </tr>
							</table>						</td>
					</tr>
					<tr style="height:90px;">
						<td colspan="2"><font size="3" style="text-align:justify;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Certified that a sum of Rs.<span style="text-decoration:underline;">&nbsp;&nbsp;<?php echo $tax_ded_source; ?>&nbsp;&nbsp;</span> (in words)<span style="text-decoration:underline;">&nbsp;&nbsp;<?php echo $tax_in_words; ?>&nbsp;&nbsp;</span> had been deducted at source and paid to the credit of the Central Government. Further certified that the above information is true and correct as per records.</font></td>
					</tr>
					<tr >
						<td colspan="2">
							<table border="0" cellpadding="5" cellspacing="0" width="100%" >
								  <tr>
									<td align="left" width="50%">&nbsp;</td>
									<td align="left"  width="50%" ><span style="font-size:12px;">
									<b>Signature of the person responsible for deduction of tax</b></span> </td>
								  </tr>
								 <tr><td colspan="2"></tr>
								 <tr>
									<td align="left" ><span style="font-size:13px;">Place: PD Hills</span></td>
									<td align="left"   ><span style="font-size:13px;">Name : </span> </td>
								  </tr>
								  <tr>
									<td align="left" ><span style="font-size:13px;">Date: <?php echo date('d-m-Y'); ?></span></td>
									<td align="left"   ><span style="font-size:13px;">Joint Registrar For Finance Officer</span> </td>
								  </tr> 
							</table>						</td>
					</tr>
				</table>
			</td>
		</tr>	
	</table>
</body>
</html>
<?php
$contents = ob_get_contents();
$filename	= "print/form16/".$empid.".html";
if(file_exists($filename)){
	unlink($filename);
}
if (!$handle = fopen($filename, 'w')) {
 	print "Cannot open file ($filename)";
 	exit;
}
// Write $somecontent to our opened file.
if (!fwrite($handle, $contents)) {
	print "Cannot write to file ($filename)";
	exit;
}
chmod($filename,0777);
?>