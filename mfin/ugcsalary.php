<?php
	include_once "libs/ugc_class.php";
	#Object Creation
	$ugcObj		= new ugcSalary();
	if($_POST){
		$empid		= trim($_POST['empid']);
		$month		= trim($_POST['month']);
		$year		= trim($_POST['year']);
		if(!$empid or !$month or !$year){
			$errmsg 	= "Required Information Is Incomplete";
		}elseif(!is_numeric($empid)){
			$errmsg		= "Invalid Employee Number";
		}else{
			$empdet		= $ugcObj->getEmployeeDetails($empid);
			if($empdet){
			print_r($empdet);
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
					<option value="1" <?php if($month==1){?> selected="selected" <?php } ?> >January</option>
					<option value="2" <?php if($month==2){?> selected="selected" <?php } ?>>Februvary</option>
					<option value="3" <?php if($month==3){?> selected="selected" <?php } ?>>March</option>
					<option value="4" <?php if($month==4){?> selected="selected" <?php } ?>>April</option>
					<option value="5" <?php if($month==5){?> selected="selected" <?php } ?>>May</option>
					<option value="6" <?php if($month==6){?> selected="selected" <?php } ?>>June</option>
					<option value="7" <?php if($month==7){?> selected="selected" <?php } ?>>July</option>
					<option value="8" <?php if($month==8){?> selected="selected" <?php } ?>>Agust</option>
					<option value="9" <?php if($month==9){?> selected="selected" <?php } ?>>Septemper</option>
					<option value="10" <?php if($month==10){?> selected="selected" <?php } ?>>Octobar</option>
					<option value="11" <?php if($month==11){?> selected="selected" <?php } ?>>November</option>
					<option value="12" <?php if($month==12){?> selected="selected" <?php } ?>>December</option>
				  </select>
					  <select name="year" id="year">
					<option value="0">--Select Year--</option>
					<?php for($i=2010;$i<2021;$i++){?>
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