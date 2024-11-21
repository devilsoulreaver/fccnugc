<html>
<head>
<title>
</title>
</head>
<body bgcolor=#778899>
<?php
include('datefunc.php');
 if ($conn=pg_connect("dbname=financetest host=192.168.0.1 user=finance password=fin123"));
 else die(pg_error());


?>

<form name=itfrm method=post name=det action=testpdf.php > 
<table border=1 align=center>
<tr><td colspan=2 bgcolor=171769 border=2 align=center><b><font color =white >INCOME TAX</b></font></td></tr>

</table>
<br></br><br></br>

<table border=1 align=center  width=80%>
<tr><td colspan=2 bgcolor=#778899 border=0 align=center><b><font color =white ></b></font></td></tr>
<tr><td align=center>EMPID <input name=empid size=20 type=text value="" ></input></td> 
    <td><b>Select Year :</b>

<select name="selyear">
<option value=2008>2008</option>
</select>
                                          </td>
</tr>
<br></br>
<tr> &nbsp </tr>
<tr> &nbsp</tr>
<tr>
<td colspan=2 align=center border=20 BGCOLOR=#778899><input name="det" type=submit  value="GET DETAILS" method=post >

</tr>  
</table>

</form>
</body>
</html>
