<?php
if($_SERVER['DOCUMENT_ROOT']=='C:/wamp/www'){
	$hostname='192.168.0.1';
}else{
	$hostname='localhost';
}
$dbconn = pg_pconnect("host=$hostname port=5432 dbname=finance user=finance password=fin123");
if (!$dbconn){
  die("Data Base Connection failed.\n");
}

?>	