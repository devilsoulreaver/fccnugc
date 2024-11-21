<?php

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
        else die(pg_error());
function put_desig_combo($cmbname,$sel_desig="XXX")
{
        if ($conn1 = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=finance"));
	        else die(pg_error());
	$retcmb="<select name=\"$cmbname\">";
	//selecting the designations
	//************************************************************
	$qry = "select name,id from desig_master order by 1";
        if(!$rset = pg_exec($conn1,$qry)) die("ERROR :" . $qry);
        for($i=0;$i<pg_numrows($rset);$i++)
	        {
	        $data1=pg_result($rset,$i,1);
	        $data2=pg_result($rset,$i,0);
	        if ($data2==$sel_desig)  $retcmb.="<option value=$data1 selected>$data2</option>";
	        else $retcmb.="<option value=$data1>$data2</option>";
	        }
	        $retcm.="</select>";
														        return $retcmb;
}


																  
	
