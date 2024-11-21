<script language="JavaScript">
function check_func(){
	if(frm1.pranno.value==""){
		alert("Please enter PRAN NUMBER.....");
	} else if(frm1.prandoj.value==""){
		alert("Please enter PRAN Date of joining.....");
	} else{
		frm1.submit();
	}
}
</script>

<?php
//echo $empid;

$empid = $_POST['empid'];
$conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest");
//$conn=pg_connect("dbname=financetest host=localhost port=5432 user=postgres password=1234");

$sql1="select empid as \"EMPID\",empname(empid) as \"NAME\",empdesig(empid) as \"DESIG\",empoffice(empid) as \"OFFICE\",get_payscale(empid) from emp_master where empid='$empid' and empcategoryid(empid)<>'G'";
$recset1=pg_exec($conn,$sql1);
if ( pg_numrows($recset1)==0)
{
	$str="<table align=\"center\" border=\"0\" width=\"50%\">";
	$str.="<tr><td align=\"center\"><font color=\"navy\"><h1>Invalid Empid !!  Try Another........</h1></font></td></tr></table>	";
	print $str;
	return;	
}
else
{
//$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"> LIC Details</td></tr></table><br>";
//print $head;
$str="<table align=\"center\" border=\"0\" width=\"50%\">";
$fields=array("Emp ID","Name","Designation","Office","Pay Scale ");
for ($i=0;$i<pg_numrows($recset1);$i++)
	{
	for ($j=0;$j<pg_numfields($recset1);$j++)
		{
		$str.="<tr bgcolor=#abcdef><td>$fields[$j]</td>";
		$data=pg_result($recset1,$i,$j);
		$str.="<td  bgcolor=#fedcba><b>$data</tr>";
		}
	}
}
print $str . '</table><br> <br>';

$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"> L I C Details</td></tr></table><br>";
print $head;


$sql2="select policyno,premiumamt,mat_mm_yy from lic where empid='$empid' and  mat_mm_yy='01:9999'";

$recset2=pg_exec($conn,$sql2);
if (pg_numrows($recset2)==0)
	{
		$str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\">No Details Available</font></td></tr></table><br><br>";
	print $str;
	}
else
	{
		$str="<table align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"cyan\"> <th>POLICY No.</th><th>PREMIUM AMOUNT</th></tr>";
		for ($i=0;$i<pg_numrows($recset2);$i++)
			{
				$str.="<tr bgcolor=\"cyan\">";
				for($j=0;$j<2;$j++)
					{
						$data=pg_result($recset2,$i,$j);
						$str.="<td align=\"center\">$data";
					}

			}
print $str . '</table> <br> <br>';
	}


$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"> S L I Details</td></tr></table><br>";
print $head;

$sql2="select policyno,premiumamt,mat_mm_yy from sli where empid='$empid' and  mat_mm_yy='01:9999'";
//print $sql2;
$recset2=pg_exec($conn,$sql2);
if (pg_numrows($recset2)==0)
	{
        	$str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\">Details Not Available</font></td></tr></table><br><br>";
		    //print $str;
	}
else
	{

		$str="<table align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"green\"> <th>POLICY No.</th><th>PREMIUM AMOUNT</th></tr>";
		for ($i=0;$i<pg_numrows($recset2);$i++)
			{
        			$str.="<tr bgcolor=\"green\">";
        			for($j=0;$j<2;$j++)
        				{
                				$data=pg_result($recset2,$i,$j);
                				$str.="<td align=\"center\">$data";
       	 				}			

			}	
	}	
print $str . '</table><br><br>';


$head="<table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"> N P S Details</td></tr></table><br>";
print $head;

$sql2="select  prannumber,pran_doj from emp_master where empid='$empid' and prannumber is not null";
//print $sql2;
$recset2=pg_exec($conn,$sql2);

if (pg_numrows($recset2)==0)
        {
                $str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\">Details Not Available</font></td></tr></table><br><br>";
				
				
               // print $str;
        }
else
        {
				               
				$str="<div id='prantable'><table  align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"yellow\"> <th>PRAN NUMBER</th><th>DATE OF JOIN</th></tr>";
                for ($i=0;$i<1;$i++)
                        {
                                $str.="<tr bgcolor=\"yellow\">";
                                for($j=0;$j<2;$j++)
                                        {
                                                $data=pg_result($recset2,$i,$j);
												
												if($data!=""){
                                                	$str.="<td align=\"center\">$data";
												}
                                        }

                        }
        }

		$str.='</tr></table></div>';
		
		
		print $str ;
		
	$head="<br><br><table align=\"center\" border=\"0\" width=\"50%\"><tr bgcolor=#abcdef><td align=\"center\"> G I S Details</td></tr></table><br>";
print $head;

$sql2="select  amount,from_orddate from emp_gi_amts where empid='$empid' ";
//print $sql2;
$recset2=pg_exec($conn,$sql2);

if (pg_numrows($recset2)==0)
        {
                $str="<table align=\"center\"  width=\"50%\"><tr><td align=\"center\" font color=\"navy\">Details Not Available</font></td></tr></table><br><br>";
				
				
               // print $str;
        }
else
        {
				               
				$str="<div id='prantable'><table  align=\"center\" border=\"0\" width=\"80%\"><tr bgcolor=\"#ffccff\"> <th>AMOUNT</th><th>ORDER DATE </th></tr>";
                for ($i=0;$i<1;$i++)
                        {
                                $str.="<tr bgcolor=\"#ffccff\">";
                                for($j=0;$j<2;$j++)
                                        {
                                                $data=pg_result($recset2,$i,$j);
												
												if($data!=""){
                                                	$str.="<td align=\"center\">$data";
												}
                                        }

                        }
        }

		$str.='</tr></table></div>';
		
		
		print $str ;	



?>
<script language="JavaScript">
function makeEdit(){
     
	document.getElementById("prantable").style.display="none";
  	document.getElementById("editDiv").style.display="block";
	
  
}
</script>
