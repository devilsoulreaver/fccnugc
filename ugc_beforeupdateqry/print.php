<?php
	if($_POST){
		$empid		= trim($_POST['empid']);
		$printtype	= trim($_POST['printtype']);
		if(!$empid or !$printtype){
			$errmsg 	= "Required Information Is Incomplete";
		}elseif(!is_numeric($empid)){
			$errmsg		= "Invalid Employee Number";
		}else{
			$path	= 'print/'.$printtype.'/'.$empid.'.html';
			if(!file_exists('print/'.$printtype.'/'.$empid.'.html')){
				$errmsg 	= "First you should process the form";
			}else{
				$id	=	base64_encode($empid);
			 ?>
				<script>
					window.open('showform16.php?id=<?php echo $id; ?>&type=<?php echo $printtype; ?>','Form16 for PF NO - <?php echo $id; ?>','width=900,height=500,scrollbars=yes,menubar=yes');
				</script>
			<?php }
		}
	}
?>
<form name="printforms" action="" method="post">
	
	<table border="0" cellpadding="3" cellspacing="0" width="60%" style="border:1px solid #CCCCCC">
		 
		  <tr>
			<td colspan="2" align="left" style="background-color:#006291;height:30px;color:#FFFFFF;" >
				<span style="font-size:12px;"><b>&nbsp;&nbsp;&raquo;&raquo;&nbsp;&nbsp;Print Forms </b></span>		</td>
		  </tr>
		  <?php if($errmsg){ ?>
		  <tr>
			<td colspan="2" align="center" style="background-color:#FFFFFF;height:30px;color:#FF0000;" >
				<?php echo $errmsg; ?>		</td>
		  </tr>
		 <?php } ?>
		  <tr>
			<td width="30%" align="right" class="ltext">Select Type<span style="color:#FF0000">*</span></td>
			<td width="70%" align="left">&nbsp;
				 <input type="radio" name="printtype" checked="checked" value="form16" /> Form16        </td>
		  </tr>
		  <tr>
			<td width="30%" align="right" class="ltext">Employee Id<span style="color:#FF0000">*</span></td>
			<td width="70%" align="left">&nbsp;
				  <input type="text" name="empid" class="inputbox" value="<?php echo $empid; ?>" />        </td>
		  </tr>
		  <tr>
			  <td colspan="2" align="center" style="background-color:#F2F2F2;height:40px;" >
				<input name="Submit" type="submit" class="btn" id="Submit" value="Submit"  />
			  </td>
		 </tr>
	</table>
</form>