<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>MG University Finance</title>
<style>
body{
	margin:0px;
	font:Verdana, Arial, Helvetica, sans-serif;
	
}
.inputbox{
	border:1px solid #A6D2FF;
	height:24px;
	color:#4B4B4B;
	font-size:14px;
}
.ltext{
	color:#272727;
	font-size:12px;
}
.btn{
	border:2px solid #0080C0;
	background:#0080C0;
	color:#FFFFFF;
	height:30px;
	font-size:14px;
}
.menulink{
	color:#FFFFFF;
	font-size:16px;
}
.menulink:hover{
	color:#800040;
	font-size:16px;
}
.menucell{
	background-color:#0080C0;
	height:30px;
}
</style>
</head>
	
<body >
	<table border="0" cellpadding="0" cellspacing="0" width="100%"  >
	  <tr>
		<td  colspan="2" align="center" style="background-color:#0080C0;height:60px;color:#FFFFFF;" >
		<span style="font-size:20px;">MG University Finance</span> </td>
	  </tr>
	  <tr>
		<td colspan="2">&nbsp;</td>
	  </tr>
	  <tr>
	    <td width="20%" align="center" style="padding:5px;vertical-align:top" >
			<table border="0" cellpadding="0" cellspacing="1" width="100%" bgcolor="#DBDBDB" >
			<tr>
				<td  colspan="2" align="left" class="menucell" >
					&nbsp;&nbsp;<a href="index.php" target="_blank" class="menulink">Home</a>
				</td>
			</tr>
			<tr>
				<td  colspan="2" align="left" class="menucell" >
					&nbsp;&nbsp;<a href="form16.php" target="_blank" class="menulink">Form 16</a>
				</td>
			</tr>
			
			<!--<tr>
				<td  colspan="2" align="left" class="menucell" >
					&nbsp;&nbsp;<a href="index.php?process=ugcsalary" class="menulink">UGC Salary</a>
				</td>
			</tr>-->
			<tr>
				<td  colspan="2" align="left" class="menucell" >
					&nbsp;&nbsp;<a href="index.php?process=print" class="menulink">Print</a>
				</td>
			</tr>
			</table>
	    </td>
	   <td width="80%" align="center" >
	   		<?php
				include_once $pageName.".php";
				
			?>
	   </td>
	  </tr>
	  <tr><td colspan="2">&nbsp;</td></tr>
	  <tr>
		<td colspan="2" align="center" style="background-color:#F3F3F3;height:20px;color:#6A6A6A;" >
		<span style="font-size:10px;font-family:Arial, Helvetica, sans-serif">&copy; MG University 2010. All Rights Reserved. Supported by System Administration Team MG university </span> </td>
	  </tr>
	</table>
</body>
</html>
