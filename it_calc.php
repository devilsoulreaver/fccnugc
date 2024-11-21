<?php
include 'db_conn.php';
$pfno = $_POST['pfno'];
$selected_val = $_POST['ITEM'];  // Storing Selected Value In Variable
echo "SHOWING  " .$selected_val."  DETAILS";  // Displaying Selected Value
$startBillno= 2021002183;
$endBillno= 2022002181;
#echo $pfno;
?><html><title>INC Details</title>
 <br>
<h1> Salary Details </h1>
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
/*  $sql="select distinct empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", max(cur_bp) as \"BP\",
      max(wefdate) as \"WEF DATE\"
      from emp_bp_incr where sanc_date
					between '{$s_date}'  and '{$e_date}'
          and wefdate < '{$wef}' and empid between '{$s_pf}'
          and '{$e_pf}' group by empid order by empid";*/
if($selected_val =='GROSS')
{
$sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(gross)::int8  as \"GROSS\",
              btype as \"SAL TYPE\"
              from  ind_bills_master ib, bills_det bd where ib.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
        	  and empid ='{$pfno}' and  not btype='ADV' group by empid, btype
        order by 4";
  }

if($selected_val =='NPS')
{
  $sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(amount) as \"NPS\",
                btype as \"SAL TYPE\"
                from  ind_bills_master ib, bills_det bd, paybill pb where ib.ind_bill_no = pb.ind_bill_no and pb.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
          	  and empid ='{$pfno}' and  not btype='ADV' and indid IN ('NPS', 'PEN') group by empid, btype
          order by 4";
}
if($selected_val =='PF')
{
  $sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(amount) as \"PF\",
                btype as \"SAL TYPE\"
                from  ind_bills_master ib, bills_det bd, paybill pb where ib.ind_bill_no = pb.ind_bill_no and pb.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
          	  and empid ='{$pfno}' and  not btype='ADV' and indid IN ('PFS') group by empid, btype
          order by 4";
}
if($selected_val =='INC')
{
  $sql="with t1 as
(select TO_CHAR(ofdate - INTERVAL '1 MONTH','MM\ YYYY') AS \"SAL_Month\", empid, empname(empid), ib.ind_bill_no, sum(gross)::int8 as \"GROSS\", btype
from ind_bills_master ib join bills_det bd on ib.ind_bill_no = bd.ind_billno
where billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='INC' group by empid, ofdate, btype, ib.ind_bill_no),
t2 as
(select empid, pb.ind_bill_no, SUM(amount) as \"LEAVE\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='INC' and GROUPID='DEDLEAVE' GROUP by empid, pb.ind_bill_no),
t3 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"INCTAX\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='INC' and indid='INCTAX' GROUP by empid, pb.ind_bill_no),
t4 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"NPS\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='INC' and indid IN('NPS','PEN') GROUP by empid, pb.ind_bill_no),

t5 AS
 ( SELECT \"SAL_Month\", t1.empid as \"PFNO\", \"GROSS\" as \"INC_GROSS\",
 COALESCE (\"LEAVE\",'0') AS \"LEAVE\",
 COALESCE (\"NPS\",'0') AS \"NPS\",
 COALESCE (\"INCTAX\",'0') AS \"TDS\",
 t1.btype as \"BILL TYPE\"
FROM t1
left join t2 on t1.ind_bill_no = t2.ind_bill_no
left join t3 on t1.ind_bill_no = t3.ind_bill_no
left join t4 on t1.ind_bill_no = t4.ind_bill_no
)
SELECT
*
FROM
t5
UNION
SELECT 'Total' as \"SAL_Month\", '' as empid,
SUM(\"INC_GROSS\") as \"INC GROSS\",
SUM(\"LEAVE\") AS \"LEAVE\",
SUM(\"NPS\") AS \"NPS\",
SUM(\"TDS\") AS \"TDS\",
'' AS btype
from t5 order by 1";
}

if($selected_val =='EXPAY')
{
  $sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(amount) as \"EXCESS PAY REC\",
                btype as \"SAL TYPE\"
                from  ind_bills_master ib, bills_det bd, paybill pb where ib.ind_bill_no = pb.ind_bill_no and pb.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
          	  and empid ='{$pfno}' and  not btype='ADV' and groupid IN ('DEDEXPAY') group by empid, btype
          order by 4";
}
if($selected_val =='LEAVE')
{
  $sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(amount) as \"LEAVE DEDUCTION\",
                btype as \"SAL TYPE\"
                from  ind_bills_master ib, bills_det bd, paybill pb where ib.ind_bill_no = pb.ind_bill_no and pb.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
              and empid ='{$pfno}' and  not btype='ADV' and groupid='DEDLEAVE' group by empid, btype
          order by 4";
}
if($selected_val =='SALARY')
{
  $sql="with t1 as
(select TO_CHAR(ofdate - INTERVAL '1 MONTH','MM/ YYYY') AS \"SAL_Month\", empid, empname(empid), ib.ind_bill_no, sum(gross)::int8 as \"GROSS\", btype
from ind_bills_master ib join bills_det bd on ib.ind_bill_no = bd.ind_billno
where billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' group by empid, ofdate, btype, ib.ind_bill_no),
t2 as
(select empid, pb.ind_bill_no, amount as \"PFS\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='PFS'),
t3 as
(select empid, pb.ind_bill_no, SUM(amount) as \"SLI\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='SLI' GROUP by empid, pb.ind_bill_no),
t4 as
(select empid, pb.ind_bill_no, SUM(amount) as \"GIS\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='GI' GROUP by empid, pb.ind_bill_no) ,
 t5 AS
 (select empid, pb.ind_bill_no, SUM(amount) as \"MEDISEP\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='MEDISEP' GROUP by empid, pb.ind_bill_no),
t6 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"LIC\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='LIC' GROUP by empid, pb.ind_bill_no ),
t7 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"SWF\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='SWF' GROUP by empid, pb.ind_bill_no),
t8 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"INCTAX\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid='INCTAX' GROUP by empid, pb.ind_bill_no),
t9 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"NPS\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid IN('NPS','PEN') GROUP by empid, pb.ind_bill_no),
t10 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"HBA\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid IN('HBA') GROUP by empid, pb.ind_bill_no),
t11 AS
(select empid, pb.ind_bill_no, SUM(amount) as \"FBS\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and indid IN('FBS') GROUP by empid, pb.ind_bill_no),
t14 as
(select empid, pb.ind_bill_no, SUM(amount) as \"LEAVE\" from paybill pb join bills_det bd on pb.ind_bill_no = bd.ind_billno
join ind_bills_master ib on pb.ind_bill_no = ib.ind_bill_no
where empid ='{$pfno}' and billno between '{$startBillno}' and '{$endBillno}'
and empid ='{$pfno}' and btype ='SAL' and GROUPID='DEDLEAVE' GROUP by empid, pb.ind_bill_no),
 t12 AS
 ( SELECT \"SAL_Month\", t1.empid AS \"PF NO\", \"GROSS\",
 COALESCE (\"LEAVE\",'0') AS \"LEAVE\",
 COALESCE (\"PFS\",'0') AS \"PFS\",
 COALESCE (\"LIC\",'0') AS \"LIC\",
 COALESCE (\"SLI\",'0') AS \"SLI\",
 COALESCE (\"GIS\",'0') AS \"GIS\",
 COALESCE (\"MEDISEP\",'0') AS \"MEDISEP\",
 COALESCE (\"SWF\",'0') AS \"SWF\",
 COALESCE (\"FBS\",'0') AS \"FBS\",
 COALESCE (\"HBA\",'0') AS \"HBA\",
 COALESCE (\"NPS\",'0') AS \"NPS\",
 COALESCE (\"INCTAX\",'0') AS \"TDS\",
 t1.btype AS \"BILL TYPE\"
FROM t1
left join t2 on t1.ind_bill_no = t2.ind_bill_no
left join t3 on t1.ind_bill_no = t3.ind_bill_no
left join t4 on t1.ind_bill_no = t4.ind_bill_no
left join t5 on t1.ind_bill_no = t5.ind_bill_no
left join t6 on t1.ind_bill_no = t6.ind_bill_no
left join t7 on t1.ind_bill_no = t7.ind_bill_no
left join t8 on t1.ind_bill_no = t8.ind_bill_no
left join t9 on t1.ind_bill_no = t9.ind_bill_no
left join t10 on t1.ind_bill_no = t10.ind_bill_no
left join t11 on t1.ind_bill_no = t11.ind_bill_no
left join t14 on t1.ind_bill_no = t14.ind_bill_no  )
SELECT
*
FROM
t12
UNION
SELECT 'Total' as \"SAL_Month\", '' as empid,  SUM(\"GROSS\") as \"SAL GROSS\",
sum(\"LEAVE\")  as \"LEAVE DED\",
sum(\"PFS\")  as \"PF\",
sum(\"LIC\") AS \"LIC\",
SUM(\"SLI\") AS \"SLI\",
SUM(\"GIS\") AS \"GIS\",
SUM(\"MEDISEP\") AS \"MEDISEP\",
SUM(\"SWF\") AS \"SWF\",
SUM(\"FBS\") AS \"FBS\",
SUM(\"HBA\") AS \"HBA\",
SUM(\"NPS\") AS \"NPS\",
SUM(\"TDS\") AS \"TDS\",
'' as btype
FROM t12 order by 1";
}

if($selected_val =='INCTAX')
{
  $sql="select  empid as \"PF NO\", empname(empid) as\"NAME\" ,empdesig(empid) as \"Designation\",empoffice(empid) as \"OFFICE\", sum(amount) as \"TDS\",
                btype as \"SAL TYPE\"
                from  ind_bills_master ib, bills_det bd, paybill pb where ib.ind_bill_no = pb.ind_bill_no and pb.ind_bill_no = bd.ind_billno and billno between '{$startBillno}' and '{$endBillno}'
              and empid ='{$pfno}' and  not btype='ADV' and indid='INCTAX' group by empid, btype
          order by 4";
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
