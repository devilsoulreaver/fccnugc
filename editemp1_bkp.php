<?php
$chk1 = $_POST['chk1'];
$chk2 = $_POST['chk2'];
$chk4 = $_POST['chk4'];
$chk3 = $_POST['chk3'];
$chk5 = $_POST['chk5'];
$chk6 = $_POST['chk6'];
$chk7 = $_POST['chk7'];
$chk8 = $_POST['chk8'];
$chk9 = $_POST['chk9'];
$chk10 = $_POST['chk10'];
$chk11 = $_POST['chk11'];
$chk12 = $_POST['chk12'];
$chk13 = $_POST['chk13'];
$chk14 = $_POST['chk14'];
$chk15 = $_POST['chk15'];
$chk16 = $_POST['chk16'];
$chk17 = $_POST['chk17'];
$chk18 = $_POST['chk18'];
$chk19 = $_POST['chk19'];
$chk20 = $_POST['chk20'];
$chk21 = $_POST['chk21'];
$chk22 = $_POST['chk22'];
$chk23 = $_POST['chk23'];
$chk24 = $_POST['chk24'];
$chk25 = $_POST['chk25'];
$chk26 = $_POST['chk26'];

$txt0 = $_POST['txt0'];
$txt1 = $_POST['txt1'];
$txt2 = $_POST['txt2'];
$txt3 = $_POST['txt3'];
$txt4 = $_POST['txt4'];
$txt5 = $_POST['txt5'];
$txt6 = $_POST['txt6'];
$txt7 = $_POST['txt7'];
$txt8 = $_POST['txt8'];
$txt9 = $_POST['txt9'];
$txt10 = $_POST['txt10'];
$txt11 = $_POST['txt11'];
$txt12= $_POST['txt12'];
$txt13= $_POST['txt13'];
$txt14= $_POST['txt14'];
$txt15= $_POST['txt15'];
$txt16= $_POST['txt16'];
$txt17= $_POST['txt17'];
$txt18= $_POST['txt18'];
$txt19= $_POST['txt19'];
$txt20= $_POST['txt20'];
$txt21= $_POST['txt21'];
$txt22= $_POST['txt22'];
$txt23= $_POST['txt23'];
$txt24= $_POST['txt24'];
$txt25= $_POST['txt25'];
$txt26= $_POST['txt26'];

$seloffice = $_POST['seloffice'];
$seldesig = $_POST['seldesig'];
$selpayscale = $_POST['selpayscale'];

if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());
$flag=0;
$sql="update emp_master set ";
if ($chk1==1) { $sql.=" empname='$txt1',";$flag=1;}
if ($chk20==1) { $sql.=" doj='$txt20',";$flag=1;}
if ($chk12==1) { $sql.=" religion='$txt12',"; $flag=1;}
if ($chk13==1) { $sql.=" caste='$txt13',"; $flag=1;}
if ($chk8==1) { $sql.=" dob='$txt8',"; $flag=1;}
if ($chk9==1) { $sql.=" doret='$txt9',"; $flag=1;}
if ($chk11==1) { $sql.=" bgroup='$txt11',"; $flag=1;}
if ($chk14==1) { $sql.=" edu_qual='$txt14',"; $flag=1;}
if ($chk21==1) { $sql.=" joining_ordno='$txt21',"; $flag=1;}
if ($chk22==1) { $sql.=" joining_orddate ='$txt22',"; $flag=1;}
if ($chk10==1) { $sql.=" sex ='$txt10',"; $flag=1;}

$sql=substr($sql,0,-1);
$sql.=" where empid='$txt0'";
if ($flag==1) pg_exec($conn,$sql);

if ($chk18==1) 
	{ 
	$sql="update emp_transfer set enddate='01/03/2003' where empid='$txt0' and enddate='01/01/1900'";
	pg_exec($conn,$sql);
	$sql="insert into emp_transfer values('$txt0','$seloffice','01/03/2004','01/01/1900')";
	pg_exec($conn,$sql);
	}
if ($chk2==1||$chk3==1||$chk4==1)
	{
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_desig where length(refid::text)<=9");
	$refid=pg_result($refidrec,0,0);

	$sql="delete from emp_desig where empid='$txt0' and enddate='01/01/1900'";
	pg_exec($conn,$sql);

	$sql="insert into emp_desig (empid,desigid,wefdate,sanc_date,enddate,refid) values('$txt0','$seldesig','$txt3','$txt4','01/01/1900',$refid)";
	pg_exec($conn,$sql);
	}

if ($chk5==1||$chk6==1||$chk7==1)
	{
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_scale where length(refid::text)<=9");
	$refid=pg_result($refidrec,0,0);
	$scalerec=pg_exec($conn,"select id,payid from pay_scale where scale='$selpayscale'");
	$sid=pg_result($scalerec,0,0);
	$payid=pg_result($scalerec,0,1);
	//echo $sid;
	//echo $payid;
	$sql="delete from emp_scale where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);

	$sql="insert into emp_scale (empid,pay_id,payscale_id,wefdate,enddate,sanc_date,refid) values('$txt0','$payid','$sid','$txt6','01/01/9999','$txt7',$refid)";
	pg_exec($conn,$sql);

	$sql="select coalesce(amount,0) from gi_rate where scale_id=(select get_payscaleid1('$txt0',current_date))";
	$girec=pg_exec($conn,$sql);
	$gi_amt=pg_result($girec,0);

	$sql="select * from emp_gi_amts where empid='$txt0' and wefdate=(select max(wefdate) from emp_gi_amts where empid='$txt0')";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into emp_gi_amts(empid,amount,wefdate,enddate,from_ordno,from_orddate,licid) values('$txt0','$gi_amt','01/03/2009','01/01/9999','Admin','01/03/2009','$txt24')";
		pg_exec($conn,$sql);
		}
	else
		{
		$sql="update emp_gi_amts set amount=$gi_amt where empid='$txt0' and enddate='01/01/9999'";
		pg_exec($conn,$sql);
		}
 	}

if ($chk15==1||$chk16==1||$chk17==1)
	{
// 	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_bp_incr where length(refid::text)<=10");
// 	$refid=pg_result($refidrec,0,0);
// 
// 	$sql="delete from emp_bp_incr where empid='$txt0' and wefdate=(select max(wefdate) from emp_bp_incr where empid='$txt0')";
// 	pg_exec($conn,$sql);
// 	//echo $sql;
// 	$sql="insert into emp_bp_incr (empid,cur_bp,wefdate,sanc_date,refid) values('$txt0','$txt15','$txt16','$txt17',$refid)";
// 	//echo $sql;
// 	pg_exec($conn,$sql);
	echo "YOU CAN'T CHANGE BASIC PAY";
	
	}
if ($chk19==1)
	{
	$sql="select * from emp_payoption where empid='$txt0' and wefdate=(select max(wefdate) from emp_payoption where empid='$txt0')";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into emp_payoption(empid,option,acno,actype,branch_name,wefdate,bankingtype) values('$txt0','1','$txt19','SB','M.G.Campus',current_date,'CBS')";
		pg_exec($conn,$sql);
		}
	$sql="update  emp_payoption set acno='$txt19' where empid='$txt0' and wefdate=(select max(wefdate) from emp_payoption where empid='$txt0')";
	pg_exec($conn,$sql);
	//echo $sql;
	}

if ($chk23==1)
	{
	$sql="select * from emp_society where empid='$txt0' and enddate='01/01/9999'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into emp_society values('$txt0','MGUECS','$txt23','01/03/2009')";
		pg_exec($conn,$sql);
		}
	$sql="update emp_society set socno='$txt23' where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);
	//echo $sql;
	}

if ($chk24==1)
	{
	$sql="select * from emp_gi_amts where empid='$txt0' and enddate='01/01/9999'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="select coalesce(amount,0) from gi_rate where scale_id=(select get_payscaleid1('$txt0',current_date))";
		//echo $sql;
		$girec=pg_exec($conn,$sql);
		$gi_amt=pg_result($girec,0);
		$sql="insert into emp_gi_amts(empid,amount,wefdate,enddate,from_ordno,from_orddate,licid) values('$txt0','$gi_amt','01/03/2009','01/01/9999','Admin','01/03/2009','$txt24')";
		//echo $sql;
		pg_exec($conn,$sql);
		}
	$sql="update emp_gi_amts set licid='$txt24' where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);
	//echo $sql;
	}

if ($chk25==1)
	{
	$sql="select * from emp_swf_amts where empid='$txt0' and enddate='01/01/9999'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into emp_swf_amts(empid,amount,wefdate,enddate,from_ordno,from_orddate,swfno) values('$txt0','50','01/03/2009','01/01/9999','Admin','01/03/2009','$txt25')";
		pg_exec($conn,$sql);
		}
	$sql="update emp_swf_amts set swfno='$txt25' where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);
	//echo $sql;
	}

if ($chk26==1)
	{
	$sql="select * from emp_fbs_amts where empid='$txt0' and enddate='01/01/9999'";
	$tempres=pg_exec($conn,$sql);
	if(pg_numrows($tempres)==0)
		{
		$sql="insert into emp_fbs_amts(empid,amount,wefdate,enddate,from_ordno,from_orddate,fbsno) values('$txt0','50','01/03/2009','01/01/9999','Admin','01/03/2009','$txt26')";
		pg_exec($conn,$sql);
		}
	$sql="update emp_fbs_amts set fbsno='$txt26' where empid='$txt0' and enddate='01/01/9999'";
	pg_exec($conn,$sql);
	#echo $sql;
	}


echo "<center><h1>Successfully Updated the Details of $txt2</h1></center><br><form name=frm action=empdet.html><center><input type=submit value=\"Next\"></center></form>";



?>

