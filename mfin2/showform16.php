<?php
	$id 		= trim(base64_decode($_REQUEST['id']));
	$type 		= trim($_REQUEST['type']);
	$path		= 'print/'.$type.'/'.$id.'.html';
	if(file_exists($path)){
	$contents 	= file_get_contents($path);
		echo $contents; 
	}else{
		echo "File Not Found!!!!!";
	}
?>
<script>
	document.getElementById('btnClose').style.display='none';
</script>