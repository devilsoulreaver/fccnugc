<?php
$host ='192.168.0.1';
$usr ='finance';
$db ='financetest';
$password='hahahihi';
$conn ="host =$host port =5432 dbname = $db user =$usr password =$password";

try{

  $dbhandle = pg_connect($conn);
  if($dbhandle)
  {
    //echo "Connection sucessful";
  }
}
catch(Exception $e)
{
  echo $e->getMessage();
}


 ?>
