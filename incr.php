<?php

//test page by sreejuks
//echo "welcome";
/*$host ='localhost';
$db ='financetest';
$pwd ='fin123';
$usr='postgres';
$conn = "host=$host port=5432 dbname=$db user=$usr password=$pwd";


try
{
  $db_handle = pg_connect($conn);
  if($db_handle)
  {
    echo "NUGC";
  }
}
  Catch (Exception $e) {
   Echo $e->getMessage();

 }*/
 include 'db_conn.php';
 $s_pf = $_POST['s_pf'];
 $e_pf = $_POST['e_pf'];
 $s_date = $_POST['s_date'];
 $e_date = $_POST['e_date'];
 $wef =$_POST['wef'];
?><html><title>INC Details</title>
 <br>
<h1>Increment Arrear List</h1>
 <br>

 </html>
 <?php
 echo '<p><a href="javascript:history.go(-1)" title="Return to previous page">« Go back</a></p>';
 /*$sql =('select distinct empid, empname(empid),empoffice(empid), max(cur_bp), max(wefdate)
 from emp_bp_incr where sanc_date
					between '."'".'01/10/2022'."'".' and '."'".'31/10/2022'."'".' and
          wefdate <'."'".'01/10/2022'."'".' and
          empid between '."'".'3200'."'".' and '{.$e_pf.}' group by empid';);*/
if($s_pf=='' || $e_pf==''||$s_date==''||$e_date==''|| $wef=='')
{?>
  <script type="text/javascript">alert("I don't Accept Empty fields!!!");history.go(-1);</script>
<?php
}
else{
  $sql="select distinct empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", max(cur_bp) as \"BP\",
      max(wefdate) as \"WEF DATE\"
      from emp_bp_incr where sanc_date
					between '{$s_date}'  and '{$e_date}'
          and wefdate < '{$wef}' and empid between '{$s_pf}'
          and '{$e_pf}' group by empid order by empid";

$result = pg_query($sql);}
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
