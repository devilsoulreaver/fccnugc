<?php
/*********************************************************
File name				:	ugcsalprint.php
Programmer			: vml
Creation Date			:	21-7-2010
Description				:	UGC SALARY BILL Printing
*********************************************************/
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
						
						if($empdesig =='Registrar' or $empdesig =='Pro-Vice-Chancellor' or $empdesig =='Vice-Chancellor' or $empcat=='Teaching Staff'  ){
							$employeebill				=  $ugcObj->getEmployeeBillno($empid,$sdate);
							$employeepaybill			=  $ugcObj->getEmployeepaybill($employeebill['ind_bill_no']);
							$employeegross			=  $ugcObj->getEmployeeAllowTotal($employeebill['ind_bill_no']);
							$employeededuction	=  $ugcObj->getEmployeeDeductionTotal($employeebill['ind_bill_no']);
							//print_r($employeepaybill);

							if($employeepaybill){
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
									}elseif($empdesig=='Professor' ){
										$agp		= 12000;
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
				<td align="left" width="15%">&nbsp;</td>
			</tr>
			<tr><td align="center" colspan="9" style="border-bottom:1px dashed #000000" >&nbsp;</td></tr>
			<tr><td align="center" colspan="9" >&nbsp;</b></td></tr>
			<tr>
				<td align="left">	&nbsp;<?php echo $BP; ?>	</td>
				<td align="left"><?php echo $DA; ?></td>
				<td align="left" ><?php echo $newhra; ?> </td>
				<td align="left">	<?php echo $IHRA; ?> </td>
				<td align="left">	<?php echo $SP; ?></td>
				<td align="left" ><?php echo $employeebill['gross']; ?>	</td>
				<td align="left">	<?php echo  $employeebill['deds']; ?></td>
				<td align="left" ><?php echo  $employeebill['net']; ?></td>
				<td align="left" >&nbsp;	</td>
			</tr>
			<tr><td align="center" colspan="9" style="border-bottom:1px dashed #000000" >&nbsp;</td></tr>
			<tr><td align="left" colspan="9" style="border-bottom:1px solid #000000;font-size:11px" ><?php if($agp) { ?> Remarks:  AGP - <?php echo $agp; ?><?php } ?>&nbsp;</td></tr>
			<tr><td align="left" colspan="9" style="font-size:10px;" >&copy; MG University 2010. All Rights Reserved. Supported by System Administration Team MG university </td></tr>
		</table>
	</td></tr>
</table>
 </body>
</html>
