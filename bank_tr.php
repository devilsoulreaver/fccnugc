<!DOCTYPE html>
<html lang="en" dir="ltr">
  <head>
    <meta charset="utf-8">
<title>NUGC PGE</title>
</head>

<body>
<form action ='tr_bank.php' method="post">
<label>Start BillNO </label>
<input type="number" name="bill_start" />
<label>END BillNO </label>
<input type="number" name="bill_end" /><br><br>
<input type = 'radio' name ='format' checked ='checked' value ='bank'>Bank Format
<input type ='radio' name ='format' value = 'treasury'> Treasury Format
<br>
<br>
<input type="submit" value="Submit" name="submit" />

</form>
</body>
</html>
