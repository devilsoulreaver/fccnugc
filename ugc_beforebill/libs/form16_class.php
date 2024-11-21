<?php
	class form16{
	
		function getEmployeeDetails($empid){
			$sql	= "SELECT * FROM emp_master WHERE empid='$empid'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				$i =0;
				if($data = pg_fetch_array($result)) {
					return $data;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getGrossSalaryDetails($empid){
			$sql	= "SELECT * FROM ind_bills_master WHERE empid = '$empid' AND ofdate > '2009-05-31' AND ofdate < '2010-04-01' AND btype NOT IN('ADV','MISC','DAA')";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				$i =0;
				while($data = pg_fetch_object($result)) {
					$rec[$i]['gross']	= $data->gross;
					$rec[$i]['ind_bill_no']	= $data->ind_bill_no;
					$rec[$i]['deds']	= $data->deds;
					$rec[$i]['net']		= $data->net;
					$rec[$i]['ofdate']	= $data->ofdate;
					$rec[$i]['btype']	= $data->btype;
					$i++;
				}
				return $rec;
			}else{
				return false;
			}
		}
		
		function getProfTaxDetails($ind_bill_nos){
			$sql	= "select * from paybill where ind_bill_no in($ind_bill_nos) AND indid='PROFTAX'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				$i =0;
				while($data = pg_fetch_object($result)) {
					$rec[$i]['ind_bill_no']	= $data->ind_bill_no;
					$rec[$i]['indid']		= $data->indid;
					$rec[$i]['amount']		= $data->amount;
					$rec[$i]['effectdate']	= $data->effectdate;
					$i++;
				}
				return $rec;
			}else{
				return false;
			}
		}
		
		function getTaxDeducted($ind_bill_nos){
			$sql	= "SELECT * FROM paybill where ind_bill_no in($ind_bill_nos) and effectdate < '2010-03-01' and effectdate > '2009-05-31' and indid='INCTAX' ORDER BY effectdate ASC";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				$i =0;
				while($data = pg_fetch_object($result)) {
					$rec[$i]['ind_bill_no']	= $data->ind_bill_no;
					$rec[$i]['indid']		= $data->indid;
					$rec[$i]['amount']		= $data->amount;
					$rec[$i]['effectdate']	= $data->effectdate;
					$i++;
				}
				return $rec;
			}else{
				return false;
			}
		}
		
		function getEmployeeDesignation($empid){
			$sql	= "select empdesig('".$empid."') as disig";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				$i =0;
				if($data = pg_fetch_array($result)) {
					return $data;
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
	}//endclass
?>