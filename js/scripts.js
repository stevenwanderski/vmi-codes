$(function(){
	
	$('#frm-code').submit(function() {
		
		// hide all messages
		$('#frm-code .error, #frm-code .success').hide();
		
		var code = $('#frm-code #code').val();
		
		// if code is empty
		if(code == ''){
			
			// show the "code blank" error message
			$('#frm-code .error-blank').show();
			
		// code is not empty
		}else{
			
			var submitVal = $('#frm-code input[type="submit"]').val();
			$('#frm-code input[type="submit"]').attr('disabled', 'disabled').val('Validating code...');
			
			// ajax call to validate the code
			$.post('/download/php/codes.php', {code: code}, function(data, status, xhr){
				
				$('#frm-code input[type="submit"]').removeAttr('disabled').val(submitVal);
				
				// convert the response data to a json object
				var response = $.parseJSON(data);
				
				// if successful code
				if(response.success){
					
					// redirect to download page with code and salt (security!)
					window.location = '/download/album.php?code=' + response.code + '&salt=' + response.salt;
					
					$('#frm-code .success').show();
					
				}else{
					$('#frm-code .error-' + response.error).show();
				}
				
			});
		}
		return false;
	});
	
});