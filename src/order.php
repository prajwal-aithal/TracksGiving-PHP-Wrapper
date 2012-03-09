<?php
	include("helper_functions.php");
	
	class Order
	{
		//Attributes
		var $order_id, $token, $comment, $due_date;
		
		//Methods of the class Order.
		function Order($iid,$itoken,$icomment,$idue_date)
		{
			$this->order_id = $iid;
			$this->token = $itoken;
			$this->comment = $icomment;
			$this->due_date = $idue_date;
		}
		
		function Validate()
		{
			if (($this->order_id == NULL) || ($this->token == NULL) || ($this->comment == NULL) || ($this->due_date == NULL))
				return false;
		    else
				return true;
		}
		
		function Validate_Message()
		{
			$error_mess = "The errors are - ";
			if ($this->order_id == NULL) 
				$error_mess .= " order_id not set;";
			if ($this->token == NULL) 
				$error_mess .= " token not set;"; 
			if ($this->comment == NULL) 
				$error_mess .= " comment not set;"; 
			if ($this->due_date == NULL) 
				$error_mess .= " due_date not set;"; 
			
			$error_obj = new Response(400,$error_mess);
			return $error_obj;
		}
		
		function cancel()
		{ 	$base_url= "https://secure.tracksgiving.com";
			if ($this->Validate())
			{
				$url = $base_url."/api/v1/orders/".$this->order_id.".xml";
				$response_xml = api_caller($url,array('_method'=>"DELETE", 'token'=>$this->token, 'comment'=>$this->comment),'POST','xml');
				return extract_from_xml($response_xml); 
			}
			else
			{
				return $this->Validate_Message();
			}
		}
		
		function reschedule()
		{
			if ($this->Validate())
			{
				$base_url = "https://secure.tracksgiving.com";
				$url = $base_url."/api/v1/orders/".$this->order_id.".xml";
				$response_xml = api_caller($url,array('_method'=>"PUT",'token'=>$this->token,'due_date'=>$this->due_date),'POST','xml');
				return extract_from_xml($response_xml); 
			}
			else 
			{
				return $this->Validate_Message();
			}
		}
	}
?>
