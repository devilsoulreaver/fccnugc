<html>
<head>
<title>
</title>
</head>
<body bgcolor=#778899>

<object classid='clsid:D27CDB6E-AE6D-11cf-96B8-444553540000'
codebase='http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0' 
width='468' height='60'>
    <param name='movie' value='radar-banner.swf' />
    <param name='quality' value='high' />
		<!--[if !IE]> <-->
		<object
			type='application/x-shockwave-flash' data='radar-banner.swf' 
			width='468' height='60'>
			<param name='movie' value='radar-banner.swf' />
			<!--<a href='http://www.web-candy.co.uk'>www.web-candy.co.uk</a>-->
		</object>
    	<!--> <![endif]-->
  </object>









<tr bgcolor=#171769><td><a href="tappalsatus.php" target="mainFrame"><font color=red ><h3><b><i>TAPPAL STATUS</i></b></h3><tr bgcolor=#FFF2FF></a></td></tr>
<?php
include('datefunc.php');
 if ($conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=fin123"));
 else die(pg_error());

 //****************************
 
	//print $refid;
 //************************************

 //*************************************
 
 $sql="select * from tappal_types order by 2";
 $tappal_types=pg_exec($conn,$sql);
//   $sql="select name from office_master order by 1";
// 	$name=pg_exec($conn,$sql)
	
 //*********************************

 $tappal_select="<select name=\"seltappal_type\">";

 //selecting the designations
 //************************************************************
 for($j=0;$j<pg_numrows($tappal_types);$j++)
 	{
        $data1=pg_result($tappal_types,$j,0);
        $data2=pg_result($tappal_types,$j,1);
        $tappal_select.="<option value=\"$data1\">$data2</option>";
        }
 $tappal_select.="</select>"; 
	$sql1="select * from office_master order by 2";
	$name=pg_exec($conn,$sql1);
	$office_select="<select name=\"seloffice\">";

 //selecting the designations
 //************************************************************
 for($j=0;$j<pg_numrows($name);$j++)
 	{
        $data1=pg_result($name,$j,0);
        $data2=pg_result($name,$j,1);
        $office_select.="<option value=\"$data1\">$data2</option>";
        }
 $office_select.="</select>";
	//if (isset($reg)
	//{
$sql="select get_tappal_refid()";
 $refidrec=pg_exec($conn,$sql);
 $refid=pg_result($refidrec,0,0);
if (isset($reg))
	{
	$sql="insert into tappal_register (refid,type,received_on,description,nameid,orderdate,office) values (";
     $sql.="$refid,'$seltappal_type',now(),'$description','$nameid','$orderdate','$seloffice')";

     pg_exec($conn,$sql);
	
  print "<table align=center bgcolor=#C87861>
  <tr><td colspan=2>File Registeration Sucessful. </td></tr>
  <tr><td>File Reference Number :</td><td>$refid</td></tr>
  </table>";
	 }
?>
<form name=frmtappal method=post>
<table border=1 align=center>
<tr><td colspan=2 bgcolor=#171769 border=2 align=center><b><i><font color =red><i>REGISTER TAPPAL</i></b></i></font></td></tr>
<tr bgcolor=#b3cff3>
<td>FILE TYPE </td><td><?php echo $tappal_select;?></td>
<tr bgcolor=#b3cff3>
<td>OFFICE </td><td><?php echo $office_select;?></td>
</tr>
</tr>
<tr  bgcolor=#b3cff3>
<td>FROM[OTHER THAN OFFICE]</td><td><textarea name=description style="width=500px" cols="60"></textarea></td>
</tr>
<tr  bgcolor=#b3cff3>
<td>NAME & ID</td><td><textarea name=nameid style="width=500px" cols="60"></textarea></td>
</tr>
<tr  bgcolor=#b3cff3>
<td>ORDER DATE</td><td><textarea name=orderdate style="width=500px" cols="60"></textarea></td>
</tr>
<tr><td colspan=2 align=center border=20 BGCOLOR=#171769><input name="reg" type=submit value="Register"> &nbsp; &nbsp; <!--<input type=reset></tr>-->
<tr bgcolor=#FFF2FF ><td><a href="tappal_distribute.php" target="mainFrame"><font color=red ><h3><i>TAPPAL DISTRIBUTE</i></h3><tr bgcolor=#171769></a></td></tr>
</table>
</form>
</body>
</html>
