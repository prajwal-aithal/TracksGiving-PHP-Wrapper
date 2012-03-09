<?php
	include("response.php");
	if (!isset($helper_flag)) {
	$helper_flag = 1;
	
	function extract_from_xml($input_xml)
	{
		$decoded_str = urldecode($input_xml);
		//echo $decoded_str."<br>";
		$extract_xml = simplexml_load_string($decoded_str);
		$response_obj = new Response($extract_xml->status, $extract_xml->error, $extract_xml->{'tracking-url'}, $extract_xml->{'universal-tracking-url'}, $extract_xml->{'token-for-url'});
		return $response_obj;
	}
	
	function validate_xml($input_xml,$xsdobj)
	{
		$xdoc = new DomDocument;
		$xmlschema = './xsd/'.$xsdobj.'.xsd';
		$xdoc->LoadXML($input_xml);
		if ($xdoc->schemaValidate($xmlschema))
			return true;
		else
			return false;
	}
	
	
	function xml_error($input_xml,$xsdobj)
	{
		$xdoc = new DomDocument;
		$xmlschema = './xsd/'.$xsdobj.'.xsd';
		$xdoc->LoadXML($input_xml);
		
		$error_mes = "Failed XSD validation. The errors are - <br>";
		$errors = libxml_get_errors();
		foreach ($errors as $error) 
		{ 
			switch ($error->level) 
			{ 
				case LIBXML_ERR_WARNING: $error_mes .= "<b>Warning $error->code</b>: "; 
										 break; 
				case LIBXML_ERR_ERROR: $error_mes .= "<b>Error $error->code</b>: "; 
										 break; 
				case LIBXML_ERR_FATAL: $error_mes .= "<b>Fatal Error $error->code</b>: "; 
										 break; 
			} 
			$error_mes .= trim($error->message); 
			$error_mes .= " :: ";
		}
		libxml_clear_errors(); 
		$error_obj = new Response(400,$error_mes);
		return $error_obj;
	}
	
	function api_caller($url, $params = null, $verb = 'GET', $format = 'xml')
	{
		$cparams = array('http' => array('method' => $verb,'ignore_errors' => true, 'header' => "Content-Type: application/x-www-form-urlencoded\r\n"));
		if ($params !== null) 
		{
			$params = http_build_query($params);
			if ($verb == 'POST')
				$cparams['http']['content'] = $params;
			else
				$url .= '?' . $params;
		}

		$context = stream_context_create($cparams);
		$fp = fopen($url, 'rb', false, $context);
		if (!$fp)
			$res = false;
		else
			$res = stream_get_contents($fp);
		
		if ($res === false)
			throw new Exception("$verb $url failed: $php_errormsg");
		
		switch ($format) {
			case 'json':
				$r = json_decode($res);
				if ($r == null)
					throw new Exception("failed to decode $res as json");
				return $res;

			case 'xml':
				$r = simplexml_load_string($res);
				if ($r == null)
					throw new Exception("failed to decode $res as xml");
				return $res;
		}
	}
	}
?>