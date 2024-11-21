<?php
function putdates($day=1,$month=1,$year=1,$dname="date",$mname="month",$yname="year")
{
$dst="";
if ($day==1)
	{
	$dst.="<select name=$dname>";
	for($i=1;$i<=31;$i++)
		{
		$d=str_pad($i,2,"0",STR_PAD_LEFT);
		$dst.="<option value=$i>$d</option>";
		}
	$dst.="</select> &nbsp";
	}
if($month==1)
	{
	$dst.="<select name=$mname>";
	for($i=1;$i<=12;$i++)
		{
		$m=date("F",mktime(0,0,0,$i,1,2000));
		$dst.="<option value=$i>$m</option>";
		}
	$dst.="</select> &nbsp";
	}
if($year==1)
	{
	$dst.="<select name=$yname>";
	for($i=2009;$i<=2030;$i++)
        {
        $dst.="<option value=$i>$i</option>";
        }
	$dst.="</select>";
	}
	
return $dst;	
}
?>

