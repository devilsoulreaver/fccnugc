<?php
if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());


if (trim($pno0)<>"")
	{
	$sql="insert into lic values('$empid','$pno0','$amt0','03:2003','01:2040')";
	pg_exec($conn,$sql);
	}
else
	{
	exit();
	}

if (trim($pno1)<>"")
	{
	$sql="insert into lic values('$empid','$pno1','$amt1','03:2003','01:2040')";
	pg_exec($conn,$sql);
	}
else
	{
	echo "<center><h1>Updated the Lic Policy </h1><br><h3><a href=empdet1.html>BACK</a></h3></center>";
	exit();
	}

if (trim($pno2)<>"")
	{
	$sql="insert into lic values('$empid','$pno2','$amt2','03:2003','01:2040')";
	pg_exec($conn,$sql);
	}
else
	{
	echo "<center><h1>Updated the Lic Policy </h1><br><h3><a href=empdet1.html>BACK</a></h3></center>";
	exit();
	}

if (trim($pno3)<>"")
	{
	$sql="insert into lic values('$empid','$pno3','$amt3','03:2003','01:2040')";
	pg_exec($conn,$sql);
	}
else
	{
	echo "<center><h1>Updated the Lic Policy </h1><br><h3><a href=empdet1.html>BACK</a></h3></center>";
	exit();
	}

if (trim($pno4)<>"")
	{
	$sql="insert into lic values('$empid','$pno4','$amt4','03:2003','01:2040')";
	pg_exec($conn,$sql);
	}
else
	{
	echo "<center><h1>Updated the Lic Policy </h1><br><h3><a href=empdet1.html>BACK</a></h3></center>";
	exit();
	}

