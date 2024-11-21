<?php
function paptot($regno,$pcode,$dateofexa)
{
$qry="select coalesce(extobt,'200'),coalesce(moderation,'0'),coalesce(intobt,'0') from marks where regno='$regno' and papcode='$pcode' and dateofexam='$dateofexa' ";
//print $qry;
return $qry;
/*$conn=pg_connect("host=btech dbname=btech port=5432 user=sun password=moon");
$papmarkset=pg_exec($conn,$qry);
$extobt=pg_fetch_result($papmarkset,0,0);
$modobt=pg_fetch_result($papmarkset,0,1);
if ($extobt=='200')
{
	$retval='-';
	return $retval;
}
elseif($extobt=='A')
{
	$retval='A';
	return $retval;
}
else
{
	$retval=$extobt+$modobt;
	return $retval;
}
}
pg_close($conn);*/
}
function monthintowords($month)
{
switch ($month)
{
case 1:
	return "January";
	break; 
case 2:
	return "February";
	break; 

case 3:
	return "March";
	break; 

case 4:
	return "April";
	break; 

case 5:
	return "May";
	break; 

case 6:
	return "June";
	break; 

case 7:
	return "July";
	break; 

case 8:
	return "August";
	break; 

case 9:
	return "September";
	break; 

case 10:
	return "October";
	break; 

case 11:
	return "November";
	break; 
case 12:
	return "December";
	break; 
}
 
}


?>
