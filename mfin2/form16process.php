<?php
 include_once "includes/config.php";
 include_once "includes/functions.php";
 include_once "libs/form16_class.php";
 #Object Creation
 $form16Obj		= new form16();
 if($_POST){
 
 	foreach ($_POST as $key => $value) {
    	$_POST[$key] = trim($value);
 	}
	$gross_total		= 0;
	$less_allowance		= 0;
	$balance			= 0;
	$ent_allowance		= 0;
	$tax_employment		= 0;
	$aggregate			= 0;
	$income_salaries	= 0;
	$other_income		= 0;
	$other_income		= 0;
	$gross_total_income	= 0;
	$aggregate_deductable	= 0;
	$total_income		= 0;
	$tax_total_income	= 0;
	$less_relief		= 0;
	$balance_tax		= 0;
	$tax_deducted		= 0;
	$tax_payable		= 0;
	$qualifing_amt		= 0;
	$total_tax_payable	= 0;
	$less_relife		= 0;
	$balance_tax_payable = 0;
	$tax_ded_total		= 0;
	$tax_may			= 0;
	$tax_june			= 0;
	$tax_july			= 0;
	$tax_august			= 0;
	$tax_septemper 		= 0;
	$tax_octobar 		= 0;
	$tax_november		= 0;
	$tax_december		= 0;
	$tax_january 		= 0;
	$tax_february 		= 0;
	$tax_march		 	= 0;
	
	$empid			= $_POST['empid'];
	$grossmarch		= ($_POST['grossmarch'])?$_POST['grossmarch']:0;
	$grossapril		= ($_POST['grossapril'])?$_POST['grossapril']:0;
	$daa			= ($_POST['daa'])?$_POST['daa']:0;
	$inthba			= ($_POST['inthba'])?$_POST['inthba']:0;
	$other_income	= ($_POST['other_income'])?$_POST['other_income']:0;
	$tax_ded_march	= ($_POST['tax_ded_march'])?$_POST['tax_ded_march']:0;
	$tax_ded_april	= ($_POST['tax_ded_april'])?$_POST['tax_ded_april']:0;
	$ded_gross		= ($_POST['ded_gross'])?$_POST['ded_gross']:0;
	$ded_amt		= ($_POST['ded_amt'])?$_POST['ded_amt']:0;
	$med_gross		= ($_POST['med_gross'])?$_POST['med_gross']:0;
	$med_amt		= ($_POST['med_amt'])?$_POST['med_amt']:0;
	$maintain_gross	= ($_POST['maintain_gross'])?$_POST['maintain_gross']:0;
	$maintain_amt	= ($_POST['maintain_amt'])?$_POST['maintain_amt']:0;
	$donation_gross	= ($_POST['donation_gross'])?$_POST['donation_gross']:0;
	$donation_amt	= ($_POST['donation_amt'])?$_POST['donation_amt']:0;
	$other_gross	= ($_POST['other_gross'])?$_POST['other_gross']:0;
	$other_amt		= ($_POST['other_amt'])?$_POST['other_amt']:0;
	
	if(!$empid || strlen($_POST['grossmarch'])==0 || strlen($_POST['grossapril'])==0){
		$errmsg="Required Information Is Incomplete";
	}elseif(!is_numeric($empid) || !is_numeric($grossmarch) || !is_numeric($grossapril)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($inthba) && !is_numeric($inthba)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($daa) && !is_numeric($daa)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($tax_ded_march) && !is_numeric($tax_ded_march)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($tax_ded_april) && !is_numeric($tax_ded_april)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($other_income) && !is_numeric($other_income)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($ded_gross) && !is_numeric($ded_gross)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($ded_amt) && !is_numeric($ded_amt)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($med_gross) && !is_numeric($med_gross)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($med_amt) && !is_numeric($med_amt)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($maintain_gross) && !is_numeric($maintain_gross)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($maintain_amt) && !is_numeric($maintain_amt)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($donation_gross) && !is_numeric($donation_gross)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($donation_amt) && !is_numeric($donation_amt)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($other_gross) && !is_numeric($other_gross)){
		$errmsg="Enter Numeric Values Only";
	}elseif(($other_amt) && !is_numeric($other_amt)){
		$errmsg="Enter Numeric Values Only";
	}else{
	
		$empdetails		= $form16Obj->getEmployeeDetails($empid);
		//print_r($empdetails);
		if(!$empdetails){
			$errmsg="Employee Id Not Exists";
		}else{
		
			$grossDetails		= $form16Obj->getGrossSalaryDetails($empid);
			if($grossDetails){
				foreach($grossDetails as $gross){
					$gross_total	+= $gross['gross'];
					$ind_bill_nos	.=  $gross['ind_bill_no'].",";
				}
			}
			$gross_total	+=$grossmarch + $grossapril + $daa;
			$balance	= $gross_total - $less_allowance;
			$prof_taxs	= $form16Obj->getProfTaxDetails(trim($ind_bill_nos,','));
			
			foreach($prof_taxs as $prof_tax){
				$tax_employment	+= $prof_tax['amount'];
			}
			
			$aggregate			= $ent_allowance + $tax_employment + $inthba;
			$income_salaries 	= $balance - $aggregate;
			$gross_total_income = $income_salaries + $other_income;
			
			if($ded_gross){
				$ded_amt = ($ded_gross>100000)?100000:$ded_gross;
			}
			if($med_gross){
				$med_amt = ($med_gross>10000)?10000:$med_gross;
			}
			if($maintain_gross){
				$maintain_amt = ($maintain_gross>75000)?75000:$maintain_gross;
			}
			if($donation_gross){
				$donation_amt = $donation_gross;
			}
			if($other_gross){
				$other_amt = $other_gross;
			}
			if($ded_gross){
				$qualifing_amt	= 100000;
			}
			if($med_gross){
				$qualifing_amt	= $qualifing_amt + 10000;
			}
			if($med_gross){
				$qualifing_amt	= $qualifing_amt + 75000;
			}
			if($donation_gross){
				$qualifing_amt	= $qualifing_amt + $donation_gross;
			}
			if($other_gross){
				$qualifing_amt	= $qualifing_amt + $other_gross;
			}
			$aggregate_deductable	= $ded_gross + $med_gross + $maintain_gross + $donation_gross + $other_gross;
			$aggregate_deductable   = ($aggregate_deductable > $qualifing_amt)?$qualifing_amt:$aggregate_deductable;
			
			$total_income 	= 	$gross_total_income - $aggregate_deductable;
			
			if($empdetails['sex']=='M'){
				$taxlimit	= 160000;
			}
			if($empdetails['sex']=='F'){
				$taxlimit	= 190000;
			}
			
			if($total_income < $taxlimit){
				$tax_payable	= 0;
				$cess_payable	= 0;
			}
			else{
				if($total_income < 300001){
					$tax_calc_amt   = $total_income - $taxlimit;
					$tax_payable	= $tax_calc_amt * .1;
				}
				if(($total_income > 300000) and ($total_income < 500001)){
					$tax_calc_amt   = $total_income - 300000;
					$tax_payable	= 14000 + ($tax_calc_amt * .2);
				}
				if($total_income > 500000){
					$tax_calc_amt   = $total_income - 500000;
					$tax_payable	= 54000 + ($tax_calc_amt * .3);
				}
				$cess_payable	= $tax_payable * .03;
			}
			$total_tax_payable	= $tax_payable + $cess_payable;
			$balance_tax_payable = $total_tax_payable - $less_relife;
			
			$tax_deducted	= $form16Obj->getTaxDeducted(trim($ind_bill_nos,','));
			//print_r($tax_deducted);
			if($tax_deducted){
				foreach($tax_deducted as $taxdeds){
					$tax_ded_total += $taxdeds['amount'];
					if($taxdeds['effectdate']=='01/06/2009'){
						$tax_may	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/07/2009'){
						$tax_june	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/08/2009'){
						$tax_july	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/09/2009'){
						$tax_august	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/10/2009'){
						$tax_septemper	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/11/2009'){
						$tax_octobar	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/12/2009'){
						$tax_november	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/01/2010'){
						$tax_december	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/02/2010'){
						$tax_january	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/03/2010'){
						$tax_february	= $taxdeds['amount'];
					}elseif($taxdeds['effectdate']=='01/04/2010'){
						$tax_march	= $taxdeds['amount'];
					}
				}
			}
			$tax_ded_total  += $tax_ded_march + $tax_ded_april;
			$tax_ded_source = $tax_ded_total;
			$tax_payble_refundable 	= $balance_tax_payable - $tax_ded_source;
			$tax_in_words = convert_number($tax_ded_source);
			
			//print_r($tax_deducted);
			//echo $grossTotal;
			//echo $tax_employment;
		}
		
	}
	if($errmsg){
		include_once "form16.php";
	}else{
		include_once "printform16.php";
	}
	
 }
?>
