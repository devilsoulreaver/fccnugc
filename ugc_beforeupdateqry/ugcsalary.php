<?php
	include_once "libs/ugc_class.php";
	#Object Creation
	$ugcObj		= new ugcSalary();
	if($_POST){
		$empid		= trim($_POST['empid']);
		$month		= trim($_POST['month']);
		$year		    = trim($_POST['year']);
		$sdate = $year.'-'.$month.'-01';
		
		if(!$empid or !$month or !$year){
			$errmsg 	= "Required Information Is Incomplete";
		}elseif($sdate < '2010-07-01'){
			$errmsg 	= "UGC salary date error";
		}else{
			 $empdet		= $ugcObj->getEmployeeDetails($empid);
			//print_r($empdet);
			if($empdet){
				
				$diff 	  = abs(strtotime($sdate) - strtotime($empdet['doj']));
				$diffyears = floor($diff / (365*60*60*24));
				
				$empdesig		=  $ugcObj->getEmployeeDesignation($empid);
				$empcat		=  $ugcObj->getEmployeeCategory($empid);
				$empbp			=  $ugcObj->getEmployeeBP($empid);
				$empofficeid	=  $ugcObj->getEmployeeOffice($empid);
				
				if($empdesig =='Registrar' or $empdesig =='Pro-Vice-Chancellor' or $empdesig =='Vice-Chancellor' or $empcat=='Teaching Staff'  ){
					$employeebill		=  $ugcObj->getEmployeeBillno($empid,$sdate);
					$employeepaybill	=  $ugcObj->getEmployeepaybill($employeebill['ind_bill_no']);
					$employeegross	=  $ugcObj->getEmployeeAllowTotal($employeebill['ind_bill_no']);
					$employeededuction	=  $ugcObj->getEmployeeDeductionTotal($employeebill['ind_bill_no']);
					
					if($employeepaybill){
					
					
							if($empdesig =='Lecturer'){
								$desig	=	'Assistant Professor';
							}elseif($empdesig =='Lecturer Senior Grade'){
								$desig	=	'Assistant Professor';
							}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears<3){
								$desig	=	'Assistant Professor';
								$empdesig = 'Lecturer Selection Grade < 3 years';
							}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears>=3){
								$desig	=	'Associate Professor';
								$empdesig = 'Lecturer Selection Grade with 3 years';
							}
							
							$BP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWBP');
							$DA	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWDA');
							$DP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWDP');
							$SP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWS');
							$HRA	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWHRA');
							
							$newda=round($BP * .27);
							$newdp=0;
							
							if($HRA){
								$IHRA=$HRA	- 150;
								$newhra	=	150;
							}else{
								$IHRA=0;
								$newhra	=	0;
							}
							
							$SP = ($SP)?$SP:0;
							
							$newemployeegross	= $employeegross - ($DA + $DP) + $newda;
							
							$newnet = $newemployeegross - $employeededuction;
					}else{
						$errmsg = "Salary not processed for this employee for selected month";
					}
					//print_r($employeepaybill);
					
					/*if($empdesig =='Lecturer'){
						$agp	=	6000;
					}elseif($empdesig =='Lecturer Senior Grade'){
						$agp	=	7000;
					}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears<3){
						$agp	=	8000;
					}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears>=3){
						$agp	=	9000;
					}elseif($empdesig =='Professor'  ){
						$agp	=	10000;
					}elseif($empdesig =='Pro-Vice-Chancellor'  ){
						$agp	=	10000;
					}elseif($empdesig =='Vice-Chancellor'  ){
						$agp	=	0;
					}*/
					
					
				}else{
					$errmsg = "Non UGC Employee ERROR!!!";
				}
				
								
				
				//print_r($empdesig);
				//echo $empdesig;
				//echo $empbp;
				//echo $empdesig;
			}else{
				$errmsg = "Employee Id Not Exists";
			}
		}
	}
?>

<form name="ugcform" action="" method="post">
	<table border="0" cellpadding="3" cellspacing="0" width="60%" style="border:1px solid #CCCCCC">
		 
		  <tr>
			<td colspan="2" align="left" style="background-color:#006291;height:30px;color:#FFFFFF;" >
				<span style="font-size:12px;"><b>&nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;UGC SCALE Salary</b></span>		</td>
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
			<td width="30%" align="right" class="ltext">Select Month And Year<span style="color:#FF0000">*</span></td>
			<td width="70%" align="left">&nbsp;
				  <select name="month" id="month" >
					<option value="0">--Select Month--</option>
					<option value="01" <?php if($month==01){?> selected="selected" <?php } ?> >January</option>
					<option value="02" <?php if($month==02){?> selected="selected" <?php } ?>>Februvary</option>
					<option value="03" <?php if($month==03){?> selected="selected" <?php } ?>>March</option>
					<option value="04" <?php if($month==04){?> selected="selected" <?php } ?>>April</option>
					<option value="05" <?php if($month==05){?> selected="selected" <?php } ?>>May</option>
					<option value="06" <?php if($month==06){?> selected="selected" <?php } ?>>June</option>
					<option value="07" <?php if($month==07){?> selected="selected" <?php } ?>>July</option>
					<option value="08" <?php if($month==08){?> selected="selected" <?php } ?>>Agust</option>
					<option value="09" <?php if($month==09){?> selected="selected" <?php } ?>>Septemper</option>
					<option value="10" <?php if($month==10){?> selected="selected" <?php } ?>>Octobar</option>
					<option value="11" <?php if($month==11){?> selected="selected" <?php } ?>>November</option>
					<option value="12" <?php if($month==12){?> selected="selected" <?php } ?>>December</option>
				  </select>
					  <select name="year" id="year">
					<option value="0">--Select Year--</option>
					<?php for($i=2009;$i<2021;$i++){?>
						<option value="<?php echo $i; ?>" <?php if($year==$i){?> selected="selected" <?php } ?> ><?php echo $i; ?></option>
					<?php } ?>
				</select>
						  </td>
		  </tr>
		  <tr>
			  <td colspan="2" align="center" style="background-color:#F2F2F2;height:40px;" >
				<input name="Submit" type="submit" class="btn" id="Submit" value="Submit"  />
			  </td>
		 </tr>
	</table>
</form>
<br />
<?php if($employeepaybill) { ?>

<table width="90%" cellpadding="0" cellspacing="0" style="font-size:12px" >
<tr><td align="center"> <b>MAHATMA GANDHI UNIVERSITY KOTTAYAM</b></td></tr>
<tr><td align="center" style="border-bottom:1px solid #000000"> <b>Details for Date: <?php echo$sdate;?></b></td></tr>
<tr><td align="center">&nbsp;</td></tr>
<tr><td align="center">
		<table width="90%" cellpadding="0" cellspacing="0" >
			<tr>
				<td align="left" width="50%">
					PF No : <?php echo $empid;?> 	
				</td>
				<td align="left" width="50%">
					   Name : <?php echo $empdet['empname'];?>
				</td>
			</tr>
			<tr>
				<td align="left" width="50%">
					Designation : <?php echo $desig;?>(<?php echo $empdesig;?>)
				</td>
				<td align="left" width="50%">
					Office :  <?php echo $empofficeid;?>
				</td>
			</tr>
		</table>
</td></tr>
<tr><td align="center">&nbsp;</td></tr>
<tr><td align="center">
		<table width="100%" cellpadding="0" cellspacing="0" >
			<tr>
				<td align="left" width="10%">	&nbsp;BP	</td>
				<td align="left" width="10%"> DA</td>
				<td align="left" width="5%">	HRA</td>
				<td align="left" width="5%">	IHRA </td>
				<td align="left" width="15%">	SP.ALLOW</td>
				<td align="left" width="15%">	GR.Total	</td>
				<td align="left" width="15%">	Total DED</td>
				<td align="left" width="10%">	NET</td>
				<td align="left" width="15%">	&nbsp;	</td>
			</tr>
			<tr><td align="center" colspan="9" style="border-bottom:1px dashed #000000" >&nbsp;</b></td>
			<tr><td align="center" colspan="9" >&nbsp;</b></td>
			<tr>
				<td align="left">	&nbsp;<?php echo $BP; ?>	</td>
				<td align="left"><?php echo $newda; ?></td>
				<td align="left" ><?php echo $newhra; ?> </td>
				<td align="left">	<?php echo $IHRA; ?> </td>
				<td align="left">	<?php echo $SP; ?></td>
				<td align="left" ><?php echo $newemployeegross; ?>	</td>
				<td align="left">	<?php echo $employeededuction; ?></td>
				<td align="left" ><?php echo $newnet; ?></td>
				<td align="left" >&nbsp;	</td>
			</tr>
		</table>
</td></tr>
<tr><td align="center" style="border-bottom:1px dashed #000000">&nbsp;</b></td>
<tr><td align="center" style="border-bottom:1px double #000000">&nbsp;</b></td>
</table>

<?php } ?>