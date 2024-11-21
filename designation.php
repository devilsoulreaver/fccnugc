<?php
$st="<html> 
<head>
<script language=\"Javascript\">
function f1()
{
document.frm1.empid.focus();
}
</script>
</head>
<body Onload =\"return f1()\" language=\"Javascript\">

<table width=50% border=0 align=\"center\">
<tr bgcolor=\"navy\"><td><b><font color=\"ffffff\">Enter A Pf No:</b><td><form name=\"frm1\" action=\"empdesignation.php\" method=\"get\">
<input type=\"text\" name=\"empid\"></tr><tr><td colspan=\"2\" align=\"center\"><input type=\"submit\" value=\"Submit\"></tr></form></table> 
</body>
</html>";
print $st;
?>
