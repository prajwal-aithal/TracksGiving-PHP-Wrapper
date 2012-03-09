<?php
	if(!isset($resp_flag)) {
	$resp_flag = 1;
	
	class Response
	{
		//Attributes
		var $status, $error, $tracking_url, $universal_tracking_url, $token_for_url;
		
		//Methods of the class Response.
		function Response($status,$error,$tracking_url,$universal_tracking_url,$token_for_url)
		{
			$this->status = $status;
			$this->error = $error;
			$this->tracking_url = $tracking_url;
			$this->universal_tracking_url = $universal_tracking_url;
			$this->token_for_url = $token_for_url;
		}
		
		function success()
		{
			if ($this->status == 200)
				return true;
			else
				return false;
		}
	}
	}
?>