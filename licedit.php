<?php
function drawtab($rset)
        {
        $rettab="";
        $rettab.= "<CENTER><TABLE width=400 BORDER=0 cellpadding=2 ><th bgcolor=#0E598F><font color=white>Sl.No</font></th>";
        for ($j=0;$j<pg_numfields($rset);$j++)
        {
        $hd=pg_fieldname($rset,$j);
        $rettab.="<th bgcolor=#0E598F><font color=white>$hd</font></th>";
        }
        for ($i=0;$i<pg_numrows($rset);$i++)
        {
	$n=$i+1;
        $rettab.= "<TR bgcolor=#FFF5D1><td>$n</td></td>";
        for ($j=0;$j<pg_numfields($rset);$j++)
                {
                $data=pg_result($rset, $i,$j);
                $rettab.="<TD><b>$data</b></TD>";
                }
        }
        $rettab.="</tr>";
        $rettab.="</TABLE></CENTER>";
        return $rettab;
        }

if ($conn = pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
	else die(pg_error());
$sql="select policyno as \"Policy No.\",premiumamt as \"Premium Amount\" from lic where empid='$auditno' and getddmmyy(from_mm_yy)<='01/03/2003'";
$rset=pg_exec($conn,$sql);
echo "<form name=frm1 action=licedit1.php>";
echo drawtab($rset);
$tot=0;
for ($j=0;$j<pg_numrows($rset);$j++)
	{
         $data=pg_result($rset, $j,1);
         $tot=$tot+$data;
         }
echo "<center><h3>Total Amount : $tot</h3></center><br><hr><h3>New Policies</h3><hr>";
echo "<table align=center><th>New Policy No.</th><th>Amount</th>";
for ($k=0;$k<=5;$k++)
	{
	echo "<tr><td><input type=text name=\"pno$k\"></td><td><input type=text name=\"amt$k\"></td></tr>";
	}
echo "</table><center><input type=submit value=\"Add New Policy\"></center><input type=hidden name=empid value=$auditno><input type=hidden name=nopls value=$n></form><center><br><h3><a href=empdet1.html>BACK</a></h3></center>";
?>

