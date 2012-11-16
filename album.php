<?php

// only if GET params are set
if(!empty($_GET['code']) && !empty($_GET['salt'])){
	
	require('php/db.php');
	
	$code = mysql_real_escape_string($_GET['code']);
	$salt = mysql_real_escape_string($_GET['salt']);
	
	$query = "SELECT * FROM codes WHERE code = '$code' AND salt = '$salt'";
	$result = mysql_query($query);
	$row = mysql_fetch_array($result);
	
	// if row exists, initiate the download
	if($row !== FALSE){
		
		// update the row's "used" value to 1
		$query = "UPDATE codes SET used = 1 WHERE code = '$code' AND salt = '$salt'";
		mysql_query($query);
		
		$file = 'file/album.zip';
		
		if(file_exists($file)){
			
			$file_name = basename($file);
		
			header("Content-Type: application/zip");
			header("Content-Disposition: attachment; filename=$file_name");
			header("Content-Length: " . filesize($file));
			readfile($file);
			exit;
		
		}
	}
	
}

?>