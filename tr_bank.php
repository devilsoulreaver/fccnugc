<style>
.button-3 {
  appearance: none;
  background-color:#0099CC;
  border: 1px solid rgba(27, 31, 35, .15);
  border-radius: 6px;
  box-shadow: rgba(27, 31, 35, .1) 0 1px 0;
  box-sizing: border-box;
  color: #fff;
  cursor: pointer;
  display: inline-block;
  font-family: -apple-system,system-ui,"Segoe UI",Helvetica,Arial,sans-serif,"Apple Color Emoji","Segoe UI Emoji";
  font-size: 14px;
  font-weight: 600;
  line-height: 20px;
  padding: 4px 20px;
  position: relative;
  text-align: center;
  text-decoration: none;
  user-select: none;
  -webkit-user-select: none;
  touch-action: manipulation;
  vertical-align: middle;
  white-space: nowrap;
  margin-right:15px;
  
}

.button-3:focus:not(:focus-visible):not(.focus-visible) {
  box-shadow: none;
  outline: none;
}

.button-3:hover {
  background-color: #2c974b;
}

.button-3:focus {
  box-shadow: rgba(46, 164, 79, .4) 0 0 0 3px;
  outline: none;
}

.button-3:disabled {
  background-color: #94d3a2;
  border-color: rgba(27, 31, 35, .1);
  color: rgba(255, 255, 255, .8);
  cursor: default;
}

.button-3:active {
  background-color: #298e46;
  box-shadow: rgba(20, 70, 32, .2) 0 1px 0 inset;
}
</style><!-- HTML !-->



<?php

$db_handle = pg_connect("dbname=financetest host=192.168.0.1 port=5432 user=finance password=hahahihi");
if (!$db_handle) {
echo 'Connection attempt failed.';
}

if(isset($_POST['submit']) ){

$csv_head='';
$c_csvdata='';
$csv_FileData='';
$bill_name='';
$bill_1 = $_POST['bill_start'];
$bill_2 = $_POST['bill_end'];
	if($bill_1!='' && $bill_2!='' )
	{
	
					if($_POST['format'] == 'bank')
					{
						echo "Bank Payment Report!!!!";
					 $sql='select  '."'".' CBS'."'".' as "CBS", '."'".'SB'."'".' as "SB",emppayto_acno(ib.empid) as "ACCOUNT NO"
					,empname(ib.empid) as "NAME",NET AS "AMOUNT" from emp_master em,ind_bills_master ib, bills_det bd
					where ib.empid=em.empid
					and bd.ind_billno=ib.ind_bill_no
					and billno between '.$bill_1.'  and '.$bill_2.' and btype ='."'".'SAL'."'".'order by 4';
					}
					else
					{
					echo 'Treasury payement Report!!!!';
					$sql='select ib.empid as "PF NO",empname(ib.empid) as "NAME",
em.mobno as "MOBILE", 
'."'".'BANK ACCOUNT'."'".' as "CREDIT TO" ,emppayto_brname(ib.empid) as "IFSC",
emppayto_acno(ib.empid) as "ACCOUNT NO", 
NET AS "AMOUNT" from emp_master em,ind_bills_master ib, bills_det bd 
where ib.empid=em.empid 
and bd.ind_billno=ib.ind_bill_no  
and billno between '.$bill_1.'  and '.$bill_2.' and btype ='."'".'SAL'."'".'order by 2';
					}
					
					$result = pg_query($sql);
	   
						if($bill_2 < $bill_1)
						{
						
						?>
						<label style=" color:#FF0000">Start BillNO must be less than  END BillNO</label>
						<br><br><a class="button-3" href="javascript:history.go(-1)">Back</a>  <br><br>
						<?php
						
						}
						else
						{
						$rowcount = pg_num_rows($result);
	
						
						?>
						<br><br>
						<?php if($rowcount>0){?> <input type="button" name="export" value="Export" class="button-3"   onClick="download_csv_file()" ><?php } ?>
						<a href="javascript:history.go(-1)" class="button-3">Back</a>
						
						<br><br>
						<?php	}
	

	
	$i = 0;
	?>
	
	<html><body>
	
	<table border =1><tr>
	
	<?php
	
	while ($i < pg_num_fields($result))
	{
		$fieldName = pg_field_name($result, $i);
		echo '<td>' . $fieldName . '</td>';
		$csv_head.=$fieldName.',';
		$i = $i + 1;
	}
	
	echo '</tr>';
	$i = 0;
	
	while ($row = pg_fetch_row($result))
	{
		echo '<tr>';
		$count = count($row);
		$y = 0;
		while ($y < $count)
		{
		$c_row = current($row);
		echo '<td>' . $c_row . '</td>';
		$c_csvdata.="'".$c_row."',";
		next($row);
		$y = $y + 1;
		
		}
		
		echo '</tr>';
		$c_csvdata= substr(trim($c_csvdata), 0, -1);
		$csv_FileData.='['.$c_csvdata.'],';
		$c_csvdata='';
		$i = $i + 1;
	}
		
		
	pg_free_result($result);
	
	echo '</table></body></html>';
	
	$csv_head= substr(trim($csv_head), 0, -1).'\n';
	/*echo 'jjjj'.$csv_head;
	echo "<br>";*/
	 $csv_FileData=substr(trim($csv_FileData), 0, -1);
$bill_name='Bill_'.$bill_1.'_to_'.$bill_2;
	}
	else
	{
	
	?>
	<label style=" color:#FF0000">Start BillNO  and  END BillNO are Required</label>
	<br><br><a href="javascript:history.go(-1)"  class="button-3">Back</a><br><br>
	<?php
	}
	
}
	//echo $csv_FileData;
?>

<script>

  //create CSV file data in an array  
    var csvFileData = [  
     <?php echo $csv_FileData;?>
    ]; 
	//alert(csvFileData);

/*  var csvFileData = [  
       ['Alan Walker', 'Singer'],  
       ['Cristiano Ronaldo', 'Footballer'],  
       ['Saina Nehwal', 'Badminton Player'],  
       ['Arijit Singh', 'Singer'],  
       ['Terence Lewis', 'Dancer']  
    ]; */
//create a user-defined function to download CSV file   
    function download_csv_file() {  
      
        //define the heading for each row of the data  
        var csv = '<?php echo $csv_head;?>'; 
        // alert(csv);
		  //alert(csvFileData);
        //merge the data with CSV  
        csvFileData.forEach(function(row) {  
                csv += row.join(',');  
                csv += "\n";  
        });  
      // alert(csv);
        //display the created CSV data on the web browser   
      // document.write(csv);  
      
         
        var hiddenElement = document.createElement('a');  
        hiddenElement.href = 'data:text/csv;charset=utf-8,' + encodeURI(csv);  
        hiddenElement.target = '_blank';  
          
        //provide the name for the CSV file to be downloaded  
		var bill_name='<?php echo $bill_name;?>'+'.csv';
        hiddenElement.download = bill_name;  
        hiddenElement.click();  
    }  
</script>





