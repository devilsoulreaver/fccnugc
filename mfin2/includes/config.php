<?php
$dbconn = pg_pconnect("host=localhost port=5432 dbname=finance user=finance password=fin123");
if (!$dbconn){
  die("Data Base Connection failed.\n");
}

?>	