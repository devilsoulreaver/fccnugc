<html><head><link target=_main>
<meta http-equiv=\"Content-Type\" content=\"text/html; charset=iso-8859-1\">
<link rel=\"stylesheet\" href=\"manual.css\" type=\"text/css\">
</head><body>

<table width=75% bgcolor=#B6FFFA>
<tr>
<td>
<h2>The Tables in Finance Database</h2>
</td>
</tr>
</table>
<?php

function drawtab1($rset)
        {
        $rettab="";
        $rettab.= "<CENTER><TABLE BORDER=1 width=500>";
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
                $rettab.="<TD>$data</TD>";
                }
        }
        $rettab.="</tr>";
        $rettab.="</TABLE></CENTER>";
        return $rettab;
        }

function drawtab2($rset)
        {
        $rettab="";
        $rettab.= "<pre>";
        for ($j=0;$j<pg_numfields($rset);$j++)
        	{
        	$hd=pg_fieldname($rset,$j);
        	$rettab.=str_pad($hd,20," ");
        	}
        for ($i=0;$i<pg_numrows($rset);$i++)
        {
        $rettab.= "\n";
        for ($j=0;$j<pg_numfields($rset);$j++)
                {
                $data=pg_result($rset, $i,$j);
                $rettab.=str_pad($data,20," ");
                }
        }
        return $rettab."</pre>";
        }


if ($conn=pg_connect("host=192.168.0.1 user=finance password=fin123 dbname=financetest"));
else   die(pg_error());

$qry1="SELECT c.relname as \"Name\", 'table'::text as \"Type\", u.usename as \"Owner\" FROM pg_class c, pg_user u WHERE c.relowner = u.usesysid AND c.relkind = 'r' AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\", 'table'::text as \"Type\", NULL as \"Owner\" FROM pg_class c WHERE c.relkind = 'r' AND not exists
(select 1 from pg_user where usesysid = c.relowner) AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\", 'view'::text as \"Type\", u.usename as \"Owner\" FROM pg_class c, pg_user u WHERE c.relowner = u.usesysid AND c.relkind = 'v' AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\", 'view'::text as \"Type\", NULL as \"Owner\" FROM pg_class c WHERE c.relkind = 'v' AND not exists (select 1 from pg_user where usesysid = c.relowner) AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\",(CASE WHEN relkind = 'S' THEN 'sequence'::text ELSE 'index'::text END) as \"Type\",u.usename as \"Owner\" FROM pg_class c, pg_user u WHERE c.relowner = u.usesysid AND relkind in ('S') AND c.relname !~ '^pg_' UNION SELECT c.relname as \"Name\",(CASE WHEN relkind =
'S' THEN 'sequence'::text ELSE 'index'::text END) as \"Type\",NULL as \"Owner\" FROM pg_class c WHERE not exists (select 1 from pg_user where usesysid = c.relowner) AND relkind in ('S') AND c.relname !~ '^pg_' ORDER BY \"Name\"";
$qry1=stripslashes($qry1);
if(!$rset1 = pg_exec($conn,$qry1)) die("ERROR :" . $qry1);
print "<ul>";
for($x=0;$x<pg_numrows($rset1);$x++)
	{
	$tabs=pg_result($rset1,$x,0);
	echo "<li><a href=\"#$tabs\">$tabs</a></li>";
	}
print "</ul>";
for ($x=0;$x<pg_numrows($rset1);$x++)
	{
	$tabs=pg_result($rset1,$x,0);
	$qry="SELECT a.attnum as \"Field No.\",a.attname as \"Field Name\", format_type(a.atttypid, a.atttypmod) as \"Type\", case when a.attnotnull='t' then 'Not Null' else ' ' end||' , '||(SELECT substring(d.adsrc for
128) FROM pg_attrdef d, pg_class c WHERE c.relname ='$tabs' AND c.oid = d.adrelid AND d.adnum = a.attnum) as \"Modifiers\" FROM pg_class c, pg_attribute a WHERE c.relname = '$tabs' AND a.attnum > 0 AND a.attrelid = c.oid ORDER BY a.attnum";
        $qry=stripslashes($qry);
	$y=$x+1;
        if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);
        echo "<a name=\"$tabs\"></a><pre> =======================================================================\n $y : The Details of The Table :  $tabs</pre>";
        echo drawtab1($rset);
	
	$qry="SELECT c2.relname as \"Indexes\" FROM pg_class c, pg_class c2, pg_index i WHERE c.relname = '$tabs' AND c.oid = i.indrelid AND i.indexrelid = c2.oid ORDER BY c2.relname";
        $qry=stripslashes($qry);
        if(!$rset = pg_exec($conn,$qry)) die("ERROR :" . $qry);
	if (pg_numrows($rset)>0)   echo drawtab2($rset);
	}
?>

</body>
</html>
