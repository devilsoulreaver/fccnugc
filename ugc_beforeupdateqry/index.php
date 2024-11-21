<?php
	include_once "includes/config.php";
	
	$process	= trim($_REQUEST['process']);
	$action		= trim($_REQUEST['action']);
	
	switch($process){
		case "print":
			$pageName	= "print";
		break;
		case "ugcsalary":
			$pageName	= "ugcsalary";
		break;
		default:{
			$pageName	= "home";
		}
	
	}
	
	include_once "body.php"; 
?>