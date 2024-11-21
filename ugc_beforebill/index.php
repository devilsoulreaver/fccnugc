<?php
/*********************************************************
File name		:	index.php
Programmer	:   Vimal
Creation Date	:	19-7-2010
Description		:	Index file
*********************************************************/
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