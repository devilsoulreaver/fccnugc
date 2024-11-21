<?php


$empid = $_POST['empid'];
$pranno = $_POST['pranno'];
$prandoj = $_POST['prandoj'];
//print_r($_POST); exit;

//$conn=pg_connect("dbname=financetest host=localhost port=5432 user=postgres password=1234");
$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
	

$query = "Update emp_master set prannumber='$pranno' , pran_doj='$prandoj' where empid='$empid' ";
$recset2=pg_exec($conn,$query);

if (pg_numrows($recset2)==0)
        {
			echo("N P S Details Updated Successfully"); exit;
		}






?>
