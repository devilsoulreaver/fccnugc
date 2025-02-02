<?php
/*********************************************************
File name				:	ugcsalprint.php
Programmer			:	vml
Creation Date			:	21-7-2010
Description				:	UGC SALARY BILL Printing
*********************************************************/
	error_reporting(0);
	include_once "includes/config.php";
	include_once "libs/ugc_class.php";
	#Object Creation
	$ugcObj		= new ugcSalary();
	
	$empid		= trim(base64_decode($_REQUEST['id']));
	$sdate		= trim(base64_decode($_REQUEST['dt']));
	
	if($empid and $sdate and $sdate >= '2010-08-01' ){ 
			$empdet		= $ugcObj->getEmployeeDetails($empid);
				if($empdet){
				
						$diff 	  = abs(strtotime($sdate) - strtotime($empdet['doj']));
						$diffyears = floor($diff / (365*60*60*24));
						
						$empdesig		=  $ugcObj->getEmployeeDesignation($empid);
						$empcat		=  $ugcObj->getEmployeeCategory($empid);
						$empbp			=  $ugcObj->getEmployeeBP($empid);
						$empofficeid	=  $ugcObj->getEmployeeOffice($empid);
						
						if($empdesig =='Registrar' or $empdesig =='Pro-Vice-Chancellor' or $empdesig =='Vice-Chancellor' or $empcat=='Teaching Staff' or $empdesig=='Assistant Librarian Selection Grade' or $empdesig =='Deputy Librarian' or  $empdesig =='Assistant Librarian (Grade II)' or  $empdesig =='Assistant Librarian Senior SCale' ){
							$employeebill				=  $ugcObj->getEmployeeBillno($empid,$sdate);
							
							//print_r($employeepaybill);

							if($employeebill){
							
									$employeepaybill			=  $ugcObj->getEmployeepaybill($employeebill['ind_bill_no']);
									$employeepaybillDeductions	=  $ugcObj->getEmployeepaybill($employeebill['ind_bill_no'],'DED');
									$employeegross			=  $ugcObj->getEmployeeAllowTotal($employeebill['ind_bill_no']);
									$employeededuction	=  $ugcObj->getEmployeeDeductionTotal($employeebill['ind_bill_no']);
									
									if($empdesig =='Lecturer'){
										$desig	=	'Assistant Professor';
										$agp		= 6000;
									}elseif($empdesig =='Lecturer Senior Grade'){
										$desig	=	'Assistant Professor';
										$agp		= 7000;
									}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears<3){
										$desig	=	'Assistant Professor';
										$empdesig = 'Lecturer Sel. Grade < 3 years';
										$agp		= 8000;
									}elseif($empdesig =='Lecturer Selection Grade'  and $diffyears>=3){
										$desig	=	'Associate Professor';
										$empdesig = 'Lecturer Sel. Grade with 3 years';
										$agp		= 9000;
									}elseif($empdesig=='Registrar' ){
										$agp		= 12000;
										$desig	= 'Registrar';
									}elseif($empdesig=='Professor' ){
										$agp		= 12000;
										$desig	= 'Professor';
									}elseif($empdesig=='Vice-Chancellor' ){
										$desig	= 'Vice-Chancellor';
									}elseif($empdesig=='Pro-Vice-Chancellor' ){
										$desig	= 'Pro-Vice-Chancellor';
									}
									
									
									$BP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWBP');
									$DA	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWDA');
									$DP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWDP');
									$SP	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWS');
									$HRA	=  $ugcObj->getEmployeeSal($employeebill['ind_bill_no'],'ALLOWHRA');
									if($sdate == '2010-08-01'){
										$darate=.27;
									}else{
										$darate=.35;
									}
									$newda=round($BP * $darate);
									$newdp=0;
									
									if($HRA){
										$IHRA=$HRA	- 150;
										$newhra	=	150;
									}else{
										$IHRA=0;
										$newhra	=	0;
									}
									
									$SP = ($SP)?$SP:0;
									
									//$newemployeegross	= $employeegross - ($DA + $DP) + $newda;
									
									//$newnet = $newemployeegross - $employeededuction;
									$url='ugcsalprint.php?id='. base64_encode($empid).'&dt='.base64_encode($sdate);
							}
			}else{
				echo "############ ERROR !!!!!!!";
			}
		}
	}
?>
<html >
<head>
<title>UGC SAL</title>
<style type="text/css">
	@media print {
		input#btnPrint {
		display: none;
		}
	}
</style>
</head>
<body>
<table cellpadding="0" cellspacing="0" border="0" width="100%" > 
	<tr><td align="right"><input type="button" id="btnPrint" onClick="window.print();" value="Print" /></td></tr>
	<tr><td align="center">
		<table width="90%" cellpadding="0" cellspacing="0" style="font-size:12px" >
		<tr><td align="center"><b>MAHATMA GANDHI UNIVERSITY KOTTAYAM</b></td></tr>
		<tr><td align="center" style="border-bottom:1px solid #000000"><b>Details for Date: <?php echo $sdate;?></b></td></tr>
		<tr><td align="center">&nbsp;</td></tr>
		<tr><td align="center">
				<table width="100%" cellpadding="0" cellspacing="0"  style="font-size:12px">
					<tr>
						<td align="left" width="60%">
							PF No : <?php echo $empid;?> 	
						</td>
						<td align="left" width="40%">
							Name : <?php echo $empdet['empname'];?>
						</td>
					</tr>
					<tr>
						<td align="left" >
							Designation : <?php echo $desig;?>
						</td>
						<td align="left" >
							Department :  <?php echo $empofficeid;?>
						</td>
					</tr>
				</table>
		</td></tr>
		<tr><td align="center" style="border-bottom:1px dashed #000000">&nbsp;</td></tr>
		<tr><td align="center">
			<table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px" >
				<tr >
					<td width="50%"><b>Allowances</b></td>
					<td width="50%"><b>Deductions</b></td>
				</tr>
				<tr><td colspan="2" align="left" >&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px" >
							<tr height="20px;">
								<td width="50%">BP</td>
								<td width="30%" align="right"><?php echo $BP; ?></td>
								<td width="20%">&nbsp;</td>
							</tr>
							<tr  height="20px;">
								<td >DA</td>
								<td align="right"><?php echo $DA; ?></td>
								<td >&nbsp;</td>
							</tr>
							<tr  height="20px;">
								<td >HRA</td>
								<td align="right"><?php echo $newhra; ?></td>
								<td >&nbsp;</td>
							</tr>
							<tr  height="20px;">
								<td >IHRA</td>
								<td align="right" ><?php echo $IHRA; ?></td>
								<td >&nbsp;</td>
							</tr>
							<tr  height="20px;">
								<td >SP. Allowance</td>
								<td align="right"><?php echo $SP; ?></td>
								<td>&nbsp;</td>
							</tr>
						</table>
					</td>
					<td>
						<table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px" >
						<?php foreach($employeepaybillDeductions as $eded) {?>
							<tr height="20px;">
								<td width="50%"><?php echo $eded['indid']; ?></td>
								<td width="30%" align="right"><?php echo $eded['amount']; ?></td>
								<td width="20%">&nbsp;</td>
							</tr>
							<?php } ?>
						</table>
					</td>
			</table>
		</td></tr>
		<tr><td align="center" style="border-bottom:1px dashed #000000">&nbsp;</td></tr>
		
		<tr><td align="center">
			<table width="100%" cellpadding="0" cellspacing="0" style="font-size:12px" >
				<tr>
								<td width="25%">Gross amount</td>
								<td width="15%" align="right"><?php echo  $employeebill['gross']; ?>	</td>
								<td width="10%">&nbsp;</td>
								<td width="25%">Total Deductions</td>
								<td width="15%" align="right"><?php echo  $employeebill['deds']; ?>	</td>
								<td width="10%">&nbsp;</td>
				</tr>
				<tr height="20px">
								<td width="25%">&nbsp;</td>
								<td width="15%" align="right">&nbsp;	</td>
								<td width="10%">&nbsp;</td>
								<td width="25%"><b>NET Amount</b></td>
								<td width="15%" align="right"><b><?php echo  $employeebill['net']; ?></b>	</td>
								<td width="10%">&nbsp;</td>
				</tr>
			</table>
		</td></tr>	
		<tr><td align="center" style="border-bottom:1px dashed #000000">&nbsp;</b></td></tr>
		<tr><td align="left" colspan="9" style="border-bottom:1px solid #000000;font-size:11px" ><?php if($agp) { ?> Remarks: BP Includes AGP <?php echo $agp; ?>/-<?php } ?>&nbsp;</td></tr>
		<tr><td align="left" style="font-size:10px">&copy; MG University 2010. All Rights Reserved.Software And Support by <b>System Administration Team</b> MG University </td></tr>
		
		</table>
	</td></tr>
</table>
 </body>
</html>
