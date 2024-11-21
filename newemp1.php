<?php
if ($conn = pg_connect("host=192.168.0.1 user=finance password=hahahihi dbname=financetest"));
	else die(pg_error());
	#$sql="select max(empid::text::int4)+1 from emp_master where empid like '2000%'";
	#$maxrec=pg_exec($conn,$sql);
	
	#$maxid=pg_result($maxrec,1,0);
	$sql="begin work";
	pg_exec($conn,$sql);
	
	$sql="select empid from emp_master where empid='$empid'";
	$temprec=pg_exec($conn,$sql);
	
	if (pg_numrows($temprec)>0)
	{
	echo "<h1>The Audit Number Already Existis</h1>";
	exit();
	}
	
	$sql="select empid from emp_master where empid='$empid'";
	$trec=pg_exec($conn,$sql);
	if (pg_numrows($trec)>0){
		$sql="select max(empid::text::int4)+1 from emp_master where empid like '20___'";
		$maxrec=pg_exec($conn,$sql);
        	$maxid=pg_result($maxrec,0,0);
		$empid=$maxid;
		print "sdgfdgdfgdfg";
		print $empid;
	}
	$sql="select current_date";
	$wdaterec=pg_exec($conn,$sql);
	$wdate=pg_result($wdaterec,0,0);	
	$sql="insert into emp_master (empid,empname,dob,sex,bgroup,religion,caste,res_category,doj,salwdtype,sbtacno,address,edu_qual,presphone,mobno,pannumber,joining_ordno,joining_orddate,handicapped) values('$empid','$empname','$dob','$sex','$bg','$religion','$caste','$selcat','$doj','$selpayment','$sbtacno','$presadd','$quali','$phno','$mobno','$panno','$joinorder','$jorddate','$hand')";
	//print $sql;
	pg_exec($conn,$sql);

	$sql="insert into emp_payoption (empid,option,acno,actype,branch_name,wefdate,bankingtype) values ('$empid','$selpayment','$sbtacno','SB','M.G.Campus','$wdate','CBS')";
	pg_exec($conn,$sql);


	$sql="insert into emp_transfer values('$empid','$seloffice','01/07/2008','01/01/1900')";
	pg_exec($conn,$sql);

	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_desig where length(refid::text)<=9");
	$refid=pg_result($refidrec,0,0);

	$sql="insert into emp_desig (empid,desigid,wefdate,sanc_date,enddate,refid) values('$empid','$seldesig','$desigwef','$desigsanc','01/01/1900',$refid)";
	pg_exec($conn,$sql);
	
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_scale where length(refid::text)<=9");
	$refid=pg_result($refidrec,0,0);
	$scalerec=pg_exec($conn,"select id,payid from pay_scale where scale='$selpayscale'");
	$sid=pg_result($scalerec,0,0);
	$payid=pg_result($scalerec,0,1);
	//echo $sid;
	//echo $payid;

	$sql="insert into emp_scale (empid,pay_id,payscale_id,wefdate,enddate,sanc_date,refid) values('$empid','$payid','$sid','$scalewef','01/01/9999','$scalesanc',$refid)";
	pg_exec($conn,$sql);
	//echo $sql;
	$refidrec=pg_exec($conn,"select max(refid)+1 from emp_bp_incr where length(refid::text)<=10");
	$refid=pg_result($refidrec,0,0);


	$sql="insert into emp_bp_incr (empid,cur_bp,wefdate,sanc_date,refid) values('$empid','$bp','$incrdate','$incrsanc',$refid)";
	pg_exec($conn,$sql);
	//echo $sql;
	$sql="insert into leave_account values('$empid','EL',$elno,'31/12/2002')";
	pg_exec($conn,$sql);

	$sql="insert into leave_account values('$empid','HPL',$hplno,'31/12/2002')";
	pg_exec($conn,$sql);
	
	$conv=01;
	$conv.=substr($doj,2);
	$sql="update emp_master set conv_date='$conv' where empid='$empid'";
	pg_exec($conn,$sql);
	
	//emp_society
	$sql="insert into emp_society values('$empid','MGUECS','$mguecsno','01/03/2009')";
	pg_exec($conn,$sql);

	//emp_gi_amts
	$sql="select coalesce(amount,0) from gi_rate where scale_id='$sid'";
	$girec=pg_exec($conn,$sql);
	$gi_amt=pg_result($girec,0);
	$sql="insert into emp_gi_amts(empid,amount,wefdate,from_ordno,from_orddate,licid) values('$empid','$gi_amt','01/03/2009','Admin','01/03/2009','$gisno')";
	pg_exec($conn,$sql);
	
	//emp_swf_amts
	$sql="insert into emp_swf_amts(empid,amount,wefdate,from_ordno,from_orddate,swfno) values('$empid','50','01/03/2009','Admin','01/03/2009','$swfno')";
	pg_exec($conn,$sql);

	//emp_fbs_amts
	$sql="insert into emp_fbs_amts(empid,amount,wefdate,from_ordno,from_orddate,fbsno) values('$empid','50','01/03/2009','Admin','01/03/2009','$fbsno')";
	pg_exec($conn,$sql);	
	pg_exec($conn,"commit");



	echo "<center><h1>Details of $empname is Added to The Database</h1></center><br><form name=frm action=newemp.php><center><input type=submit value=\"Next\"></center></form>";

?>
