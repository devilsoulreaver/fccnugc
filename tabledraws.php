<?php

//*****************************************************************
// the function the return the table with field names in the fisrt column
//and data in the 'rno'th row in second row
//*****************************************************************
function drawtab2($rset,$rno,$rmlast,$width=785)
        {
        $rettab="<table border=0 align=center cellpadding=2 width=$width>";
        for ($i=0;$i<pg_numfields($rset)-$rmlast;$i++)
        {
                $rettab.="<tr bgcolor=#88C6FF><td bgcolor=#0E598F width=200><b><font color=white>";
                $data=pg_fieldname($rset,$i);
                $rettab.="$data</font></b></td><td><b>";
                $data=pg_result($rset,$rno,$i);
                $rettab.= "$data</b></td></tr>";
        }
        $rettab.="</table>";
        return $rettab;
        }

/**********************************************************************
 *********************************************************************/
function drawtab($rset)
        {
        $rettab="";
        $rettab.= "<CENTER><TABLE BORDER=0 cellpadding=2 >";
        for ($j=0;$j<pg_numfields($rset);$j++)
        {
        $hd=pg_fieldname($rset,$j);
        $rettab.="<th bgcolor=#0E598F><font color=white>$hd</font></th>";
        }
        for ($i=0;$i<pg_numrows($rset);$i++)
        {
        $rettab.= "<TR bgcolor=#FFF5D1>";
        for ($j=0;$j<pg_numfields($rset);$j++)
                {
                $data=pg_result($rset, $i,$j);
                $rettab.="<TD><pre>$data</pre></TD>";
                }
        }
        $rettab.="</tr>";
        $rettab.="</TABLE></CENTER>";
        return $rettab;
        }

//*****************************************************************
// the function that returns the table in the actual layout of row and column
//*****************************************************************
function drawtab1($rset,$rjarray=array(),$twid=600)
        {
        $rettab="";

        $rettab.= "<CENTER><TABLE BORDER=0 cellpadding=2 width=$twid><th>Sl.No</th>";
        for ($j=0;$j<pg_numfields($rset);$j++)
        {
        $hd=pg_fieldname($rset,$j);
        $rettab.="<th bgcolor=#0E598F><font color=white>$hd</font></th>";
        }
        for ($i=0;$i<pg_numrows($rset);$i++)
        {
	$rno=$i+1;
        $rettab.= "<TR bgcolor=#FFF5D1><td>$rno</td>";
        for ($j=0;$j<pg_numfields($rset);$j++)
                {
                $data=pg_result($rset, $i,$j);
		if(in_array($j,$rjarray))
                	$rettab.="<TD align=right>$data</TD>";
		else
                	$rettab.="<TD align=left>$data</TD>";
			
                }
        }
        $rettab.="</tr>";
        $rettab.="</TABLE></CENTER>";
        return $rettab;
        }
function drawtab10($rset,$rjarray=array(),$twid=600)
	{
	        $rettab="";

		$rettab.= "<br><br><CENTER><TABLE BORDER=0 cellpadding=2 width=$twid>";
		for ($j=0;$j<pg_numfields($rset);$j++)
		        {
		$hd=pg_fieldname($rset,$j);
		$rettab.="<th align=left bgcolor=#0E598F><font color=white>$hd</font></th>";
		        }
		for ($i=0;$i<pg_numrows($rset);$i++)
		        {
		$rettab.= "<TR bgcolor=#FFF5D1>";
		for ($j=0;$j<pg_numfields($rset);$j++)
		        {
		        $data=pg_result($rset, $i,$j);
		        if(in_array($j,$rjarray))
		               $rettab.="<TD align=left>$data</TD>";
		        else
		               $rettab.="<TD align=left>$data</TD>";
	                }
	        }
	        $rettab.="</tr>";
	        $rettab.="</TABLE></CENTER>";
	        return $rettab;
	        }
?>
