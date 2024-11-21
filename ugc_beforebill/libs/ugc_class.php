<?php
/*********************************************************
File name		:	ugc_salary.php
Programmer	:   Vimal
Creation Date	:	19-7-2010
Description		:	UGC salary db functions
*********************************************************/
	class ugcSalary{
	
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
		
		function getEmployeeBillno($empid,$ofdate){
			$sql	= "SELECT * FROM ind_bills_master WHERE empid='$empid' AND ofdate='$ofdate' and btype='SAL'";
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
		
		function getEmployeepaybill($billno){
			$sql	= "SELECT * FROM paybill WHERE ind_bill_no='$billno'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				while($data = pg_fetch_object($result)) {
					$rec[$i]['ind_bill_no']	= $data->ind_bill_no;
					$rec[$i]['indid']			= $data->indid;
					$rec[$i]['groupid']		= $data->groupid;
					$rec[$i]['amount']		= $data->amount;
					$rec[$i]['effectdate']	= $data->effectdate;
					$rec[$i]['remarks']		= $data->remarks;
					$i++;
				}
				//print_r($rec);
				return $rec;
			}else{
				return false;
			}
		}
		
		function getEmployeeDeductionTotal($billno){
			$sql	= "select sum(amount) as s from paybill where ind_bill_no='$billno' and groupid like 'DED%'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['s']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeAllowTotal($billno){
		$sql	= "select sum(amount) as s from paybill where ind_bill_no='$billno' and groupid like 'ALLOW%'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['s']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeSal($billno,$type){
		 	$sql	= "select amount as amt from paybill where ind_bill_no='$billno' and groupid='$type'";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['amt']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeDesignation($empid){
			$sql	= "select empdesig('".$empid."') as disig";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['disig']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeCategory($empid){
			$sql	= "select empcategory('".$empid."') as cat";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['cat']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeBP($empid){
			$sql	= "select get_bp('".$empid."') as bp";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['bp']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function getEmployeeOffice($empid){
			$sql	= "select empofficeid('".$empid."') as officeid";
			$result = pg_query($sql);
			if(pg_num_rows($result) > 0){ 
				if($data = pg_fetch_array($result)) {
					return trim($data['officeid']);
				}else{
					return false;
				}
			}else{
				return false;
			}
		}
		
		function updateIndbillsmaster($empid,$offdate,$billno,$field,$amt){
			if($empid and $offdate and $billno and $field  and isset($amt) ){
				$sql = "UPDATE ind_bills_master SET ";
				if($field=='gross'){
					$sql .=" gross=$amt ";
				}
				if($field=='net'){
					$sql .=" net=$amt ";
				}
				$sql .=" WHERE empid='$empid' and ofdate='$offdate' and btype='SAL' and ind_bill_no = $billno  ";
				//echo $sql;
				$result = pg_query($sql);
			}
		}
		
		function updatePaybill($billno,$effectdate,$field,$amt){
			if($effectdate and $billno and $field  and isset($amt) ){
				$sql = "UPDATE paybill SET amount=$amt";
				$sql .=" WHERE  effectdate='$effectdate' and indid='$field' and ind_bill_no = $billno  ";
				//echo $sql;
				$result = pg_query($sql);
			}
		}
	}//endclass
?>