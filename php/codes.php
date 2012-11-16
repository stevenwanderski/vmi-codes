<?php

if(!empty($_POST['code'])){
	
	require(__FILE__ . '/../db.php');

	$code = mysql_real_escape_string($_POST['code']);

	// code query
	$query = "SELECT * FROM codes WHERE code = '$code'";

	// if mysql query executed properly
	if($result = mysql_query($query, $link)){
	
		$row = mysql_fetch_array($result);
		$response = array();
	
		// code exists
		if($row !== FALSE){
			
			// code has been used already
			if($row['used'] == 1){
				
				$response['success'] = FALSE;
				$response['error'] = 'used';
			
			// code is valid and has not been used - score!
			}else{
		
				// build a json object with code and salt
				$response['success'] = TRUE;
				$response['code'] = $code;
				$response['salt'] = $row['salt'];
			
			}
		
		// code does not exist
		}else{
			$response['success'] = FALSE;
			$response['error'] = 'invalid';
		}
	
		// return a json string
		echo json_encode($response);
	
	}else{
		echo mysql_error();
	}

}

?>