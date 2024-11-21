<?php
include 'db_conn1.php';
$pfno = $_POST['pfno'];
$selected_val = $_POST['ITEM'];  // Storing Selected Value In Variable
echo "SHOWING  " .$selected_val."  DETAILS";  // Displaying Selected Value
#echo $pfno;

 ?>
 <html><title>PAYBILL DETAILS</title>
  <br>
 <h1>PAYBILL VIEW</h1>
 <h2><?php echo 'PF NO:'.$pfno.''; ?></h2>
  <br>
  </html>
  <?php
  echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">« Go back</a></p>';
  /*$sql =('select distinct empid, empname(empid),empoffice(empid), max(cur_bp), max(wefdate)
  from emp_bp_incr where sanc_date
 					between '."'".'01/10/2022'."'".' and '."'".'31/10/2022'."'".' and
           wefdate <'."'".'01/10/2022'."'".' and
           empid between '."'".'3200'."'".' and '{.$e_pf.}' group by empid';);*/
 if($pfno=='')
 {?>
   <script type="text/javascript">alert("I don't Accept Empty fields!!!");history.go(-1);</script>
 <?php
 }
 else{
   /*$sql="select empid as \"PF NO\", empname(empid)\"NAME\", gross \"GROSS\", deds\"DEDUCTIONS\", net\"NET\",
    ofdate AS \"SAL DATE\", ind_bill_no as \"INDBILL NO\", ofdate as \"SAL DATE\"
   from ind_bills_master where empid = '{$pfno}' and ofdate between '01/08/2019' and '28/02/2021'  ";*/
if($selected_val =='PF')
{
   $sql="select ROW_NUMBER() OVER(ORDER BY (SELECT 1)) AS \"SL NO\",empid as \"PF NO\", empname(empid)\"NAME\", sum(amount) as \"PF AMOUNT\"
  from ind_bills_master join paybill using(ind_bill_no)  where  empid = '{$pfno}'
  and indid='DAAPF' and remarks ='PRARR_2019_PF' group by empid";
}
if($selected_val =='NPS')
{
   $sql="select  ROW_NUMBER() OVER(ORDER BY (SELECT 1)) AS \"SL NO\", empid as \"PF NO\", empname(empid)\"NAME\", sum(amount) as \"PF AMOUNT\"
  from ind_bills_master join paybill using(ind_bill_no)  where  empid = '{$pfno}'
  and indid='NPS' and remarks ='PRARR_2019_NPS' group by empid";
}
$result = pg_query($sql);
}
$rowcount = pg_num_rows($result);
$i = 0;
//echo $rowcount;
?>
<html>
<head>
  <style media="screen">
  td, th {
  border: 1px solid #777;
  padding: 0.5rem;
  text-align: center;
}
table {
    border-collapse: collapse;
    width:auto;
}

tbody tr:nth-child(odd) {
    background: #eee;
}
caption {
    font-size: 0.8rem;
}
  </style>
</head>
<body>

<table border =1 class="tb1"><tr>

<?php

	while ($i < pg_num_fields($result))
	{
		$fieldName = pg_field_name($result, $i);
		echo '<td>' . $fieldName . '</td>';
		//$csv_head.=$fieldName.',';
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
		//$c_csvdata.="'".$c_row."',";
		next($row);
		$y = $y + 1;

		}

		echo '</tr>';
		//$c_csvdata= substr(trim($c_csvdata), 0, -1);
		//$csv_FileData.='['.$c_csvdata.'],';
		//$c_csvdata='';
		$i = $i + 1;
	}


	pg_free_result($result);

	echo '</table></body></html>';
pg_close($dbhandle);
  ?>
