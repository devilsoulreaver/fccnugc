<?php
	class ugcSalary{
	
		function getEmployeeDetails($empid){
			$sql	= "SELECT * FROM emp_master WHERE empid=$empid";
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