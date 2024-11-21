<?php
include_once "includes/config.php";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MG University Finance Form16</title>
<style>
body{
	margin:0px;
	font:Verdana, Arial, Helvetica, sans-serif;
}
.inputbox{
	border:1px solid #A6D2FF;
	height:24px;
	color:#4B4B4B;
	font-size:14px;
}
.ltext{
	color:#272727;
	font-size:12px;
}
.btn{
	border:2px solid #0080C0;
	background:#0080C0;
	color:#FFFFFF;
	height:30px;
	font-size:14px;
}

</style>
</head>
	
<body>
<form name="form16" action="form16process.php" method="post">
	<table border="0" cellpadding="0" cellspacing="0" width="100%" >
	  <tr>
		<td align="center" style="background-color:#0080C0;height:60px;color:#FFFFFF;" >
		<span style="font-size:20px;">MG University Finance</span> </td>
	  </tr>
	  <tr>
		<td>&nbsp;</td>
	  </tr>
	  <tr>
		<td align="center">
		<table border="0" cellpadding="3" cellspacing="0" width="60%" style="border:1px solid #CCCCCC">
		 	
		  <tr>
			<td colspan="2" align="left" style="background-color:#006291;height:30px;color:#FFFFFF;" >
				<span style="font-size:12px;"><b>&nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;Employee Details</b></span>		</td>
		  </tr>
			<?php if($errmsg){ ?>
		  <tr>
			<td colspan="2" align="center" style="background-color:#FFFFFF;height:30px;color:#FF0000;" >
				<?php echo $errmsg; ?>		</td>
		  </tr>
		 <?php } ?>
		  <tr>
			<td width="30%" align="right" class="ltext">Employee Id<span style="color:#FF0000">*</span></td>
			<td width="70%" align="left">&nbsp;
				  <input type="text" name="empid" class="inputbox" value="<?php echo $empid; ?>" />        </td>
		  </tr>
		  <tr>
            <td align="right" class="ltext">Gross Salary<span style="color:#FF0000">*</span></td>
		    <td align="left">&nbsp;
                <input type="text" name="gross_salary" class="inputbox" value="<?php echo $gross_salary; ?>" />
            </td>
	      </tr>
			<tr>
			<td align="right" class="ltext">Tax on employment</td>
			<td align="left">&nbsp;
				  <input type="text" name="tax_employment" class="inputbox" value="<?php echo $tax_employment; ?>" />        </td>
		  </tr>
		  <!--
		  <tr>
            <td align="right" class="ltext">Gross Salary On April<span style="color:#FF0000">*</span></td>
		    <td align="left">&nbsp;
                <input type="text" name="grossapril" class="inputbox" value="<?php echo $grossapril; ?>">
            </td>
	      </tr>
		 
		  <tr>
			<td align="right" class="ltext">DAA</td>
			<td align="left">&nbsp;
				  <input name="daa" type="text" class="inputbox" id="daa" value="<?php echo $grossapril; ?>"  />        </td>
		  </tr>-->
		   <tr>
			<td align="right" class="ltext">Interest On HBA</td>
			<td align="left">&nbsp;
				<input type="text" name="inthba" class="inputbox" value="<?php echo $inthba; ?>" />			</td>
		  </tr>
		  <tr>
			<td align="right" class="ltext">Less Allowances to the exempt under Section 10</td>
			<td align="left">&nbsp;
				<input type="text" name="less_allowance" class="inputbox" value="<?php echo $less_allowance; ?>" />			</td>
		  </tr>
		  <tr>
            <td align="right" class="ltext">Any Other Income Reported By Employee </td>
		    <td align="left">&nbsp;
                <input name="other_income" type="text" class="inputbox" id="other_income" value="<?php echo $other_income; ?>" /></td>
	      </tr>
		  <tr>
            <td align="right" class="ltext">Tax Deducted On March  </td>
		    <td align="left">&nbsp;
                <input name="tax_ded_march" type="text" class="inputbox" id="tax_ded_march" value="<?php echo $tax_ded_march; ?>" /></td>
	      </tr>
		  
		  <tr>
            <td align="right" class="ltext">Tax Deducted On April </td>
		    <td align="left">&nbsp;
                <input name="tax_ded_april" type="text" class="inputbox" id="tax_ded_april" value="<?php echo $tax_ded_april; ?>" /></td>
	      </tr>
		</table>
		<table border="0" cellpadding="2" cellspacing="0" width="60%" style="border:1px solid #CCCCCC">
		  <tr>
			<td align="left" style="background-color:#006291;height:30px;color:#FFFFFF;" >
				<span style="font-size:12px;"><b>&nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;Deductions Under Chapter VI-A</b></span>
			</td>
		  </tr>
		  <tr>
			<td height="198"><table border="0" bordercolor="#CCCCCC" cellpadding="2" cellspacing="1" width="100%"  >
			  <tr>
				<td align="left" width="6%" style="background-color:#CCCCCC;height:30px;color:#313131;" >&nbsp;</td>
				<td align="left" width="34%" style="background-color:#CCCCCC;height:30px;color:#313131;" ><span style="font-size:12px;"> <b>Details</b> </span> </td>
				<td align="left" width="20%" style="background-color:#CCCCCC;height:30px;color:#313131;" ><span style="font-size:12px;"> <b>Gross Amount</b> </span> </td>
				<td align="left" width="20%" style="background-color:#CCCCCC;height:30px;color:#313131;" ><span style="font-size:12px;"> <b>Qulifying Amount</b> </span> </td>
				<td align="left" width="20%" style="background-color:#CCCCCC;height:30px;color:#313131;" ><span style="font-size:12px;"> <b>Deductable Amount</b> </span> </td>
			  </tr>
			  <tr>
				<td height="45" align="left" style="height:30px;color:#313131;" > A </td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> Deductions u/s 80 c </span> </td>
				<td align="left"  style="height:30px;color:#313131;" ><input name="ded_gross" type="text" class="inputbox" id="ded_gross" value="<?php echo $ded_gross; ?>">
				</td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> 1,00,000/- </span> </td>
				<td align="left" style="height:30px;color:#313131;" ><input name="ded_amt" type="text" class="inputbox" id="ded_amt" value="<?php echo $ded_amt; ?>">
				</td>
			  </tr>
			  <tr>
				<td height="45" align="left" style="height:30px;color:#313131;" > B </td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> Medical Insurence Premia (u/s 80D) </span></td>
				<td align="left"  style="height:30px;color:#313131;" ><input name="med_gross" type="text" class="inputbox" id="med_gross" value="<?php echo $med_gross; ?>">
				</td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> 15,000/- </span> </td>
				<td align="left" style="height:30px;color:#313131;" ><input name="med_amt" type="text" class="inputbox" id="med_amt" value="<?php echo $med_amt; ?>">
				</td>
			  </tr>
			  <tr>
				<td height="45" align="left" style="height:30px;color:#313131;" > C </td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> Maintenance of handicaped dependents (u/s 80 DD) </span></td>
				<td align="left"  style="height:30px;color:#313131;" ><input name="maintain_gross" type="text" class="inputbox" id="maintain_gross" value="<?php echo $maintain_gross; ?>" >
				</td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> 75,000/- </span> </td>
				<td align="left" style="height:30px;color:#313131;" ><input name="maintain_amt" type="text" class="inputbox" id="maintain_amt" value="<?php echo $maintain_amt; ?>">
				</td>
			  </tr>
			  <tr>
				<td height="45" align="left" style=";height:30px;color:#313131;" > D </td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> Donations	&amp;	Contributions (u/s 80G) </span> </td>
				<td align="left"  style="height:30px;color:#313131;" ><input name="donation_gross" type="text" class="inputbox" id="donation_gross" value="<?php echo $donation_gross; ?>">
				</td>
				<td align="left"  style="height:30px;color:#313131;" >&nbsp;</td>
				<td align="left" style="height:30px;color:#313131;" ><input name="donation_amt" type="text" class="inputbox" id="donation_amt" value="<?php echo $donation_amt; ?>">
				</td>
			  </tr>
			  <tr>
				<td height="45" align="left" style=";height:30px;color:#313131;" > E </td>
				<td align="left"  style="height:30px;color:#313131;" ><span style="font-size:12px;"> Others</span> </td>
				<td align="left"  style="height:30px;color:#313131;" ><input name="other_gross" type="text" class="inputbox" id="other_gross" value="<?php echo $other_gross; ?>">
				</td>
				<td align="left"  style="height:30px;color:#313131;" >&nbsp;</td>
				<td align="left" style="height:30px;color:#313131;" ><input name="other_amt" type="text" class="inputbox" id="other_amt" value="<?php echo $other_amt; ?>" >
				</td>
			  </tr>
			</table></td>
		  </tr>
		</table>
	  <table border="0" cellpadding="2" cellspacing="0" width="60%" style="border:1px solid #CCCCCC">
		<tr>
		  <td align="center" style="background-color:#F2F2F2;height:50px;" >
			<input name="Submit" type="submit" class="btn" id="Submit" value="Submit"  />
		  </td>
		</tr>
	  </table>
	   </td>
	  </tr>
	  <tr><td>&nbsp;</td></tr>
	  <tr>
		<td align="center" style="background-color:#F3F3F3;height:20px;color:#6A6A6A;" >
		<span style="font-size:10px;font-family:Arial, Helvetica, sans-serif">&copy; MG University 2010. All Rights Reserved. Supported by System Administration Team MG university </span> </td>
	  </tr>
	</table>
</form>
</body>
</html>
