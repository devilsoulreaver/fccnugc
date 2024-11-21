<html>
<head>

<title>
</title>

<SCRIPT ID=clientEventHandlersJS LANGUAGE=javascript>
<!--

function seltappal_type_onclick() {
//alert("dsgdfgdfgdf");
	var s=document.frmdistribute.selrefid.value.split("|");
	document.frmdistribute.filerefno.value=s[0]
	document.frmdistribute.filetypeid.value=s[1]
	document.frmdistribute.description.value=s[2]
	document.frmdistribute.receivedon.value=s[3]
	}

//-->
</SCRIPT>
</head>
<body>
<form name=frmdistribute method=post>
<TABLE border=1 cellPadding=1 cellSpacing=1 bgcolor=#CFAC9D width="75%" align=center>
  <TR>
    <TD width="104" valign="top" rowspan="5">
<?php
 if ($conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=fin123"));
 else die(pg_error());

 if (isset($allot)){
  $sql="update tappal_register set given_to='$seluser',gave_on=now() where refid=$filerefno";
 pg_exec($conn,$sql);
}

 $sql="select refid,refid||'|'||name||'|'||description||'|'||received_on from tappal_register,tappal_types where tappal_types.id=tappal_register.type and coalesce(given_to,'XXX')='XXX' order by 1";
 $tappal_types=pg_exec($conn,$sql);
 //*********************************

 $tappal_select="<select name=\"selrefid\" language=javascript onchange=\"return seltappal_type_onclick()\" size=10>";

 //selecting the designations
 //************************************************************
 for($j=0;$j<pg_numrows($tappal_types);$j++)
        {
        $data1=pg_result($tappal_types,$j,0);
        $data2=pg_result($tappal_types,$j,1);
        $tappal_select.="<option value=\"$data2\">$data1</option>";
        }
 $tappal_select.="</select>";
 print $tappal_select;

 $sql="select userid,username from users order by 2";
 $usrset=pg_exec($conn,$sql);
 $user_select="<select name=\"seluser\">";

 //selecting the designations
 //************************************************************
 for($j=0;$j<pg_numrows($usrset);$j++)
        {
        $data1=pg_result($usrset,$j,0);
        $data2=pg_result($usrset,$j,1);
        $user_select.="<option value=\"$data1\">$data2</option>";
	}

 $user_select.="</select>";

?>
 </TD>
    <TD>File.Ref.No:</td><td>
      <input type="text" name="filerefno">
    </TD></tr><tr>
    <TD>Descrption</td><td>
      <textarea name="description" style="width:200px"></textarea>
    </TD>
  </TR>
  <TR>
    <TD>File Type:</td><td>
      <input type="text" name="filetypeid" style="width:250px">
    </TD>
  </TR>
 <TR>
    <TD>Recevied on:</td><td>
      <input type="text" name="receivedon" style="width:250px">
    </TD>
  </TR>
  <TR>
    <TD >GIve To</TD>
    <TD ><?php print $user_select;?></TD>
  </TR>
  <TR>
    <TD colspan="3" align=center><input type=submit name=allot value="ALLOT"></TD>
  </TR>
  <tr bgcolor=#FFF2FF><td><a href="tappalsatus.php" target="mainFrame"><font color=red ><h3>tappal status</h3><tr bgcolor=#FFF2FF></a></td></tr>
</table>
</form>
</body>
</html>
