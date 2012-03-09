<?php
	include("helper_functions.php");
    
    class CompanyDonation
    {
		//Attributes
		var $order_id,$order_comment,$order_submission_date,$order_due_date,$order_channel_code,$order_customer_email,$token,$campaign_key;
		var $donation_amount,$project_id;
		
		//Methods of the class CompanyDonation
		function CompanyDonation($order_id,$order_comment,$order_submission_date,$order_due_date,$order_channel_code,$order_customer_email,$token,$campaign_key,$donation_amount,$project_id)
		{
		            $this->order_id = $order_id;
					$this->order_comment = $order_comment;
					$this->order_submission_date = $order_submission_date;
		            $this->order_due_date = $order_due_date;
					$this->order_channel_code = $order_channel_code;
					$this->order_customer_email = $order_customer_email;
					$this->token = $token;
					$this->campaign_key = $campaign_key;
					$this->donation_amount = $donation_amount;
					$this->project_id = $project_id;
		}
				
		function Validate()
		{
			if (($this->order_id == NULL) || ($this->order_comment == NULL) || ($this->order_submission_date == NULL) || ($this->order_due_date == NULL) || ($this->order_channel_code == NULL) || ($this->order_customer_email == NULL) || ($this->token == NULL) || ($this->campaign_key == NULL) || ($this->donation_amount == NULL) || ($this->project_id == NULL))
			 	return false;
		    else if (!preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$this->order_customer_email))
				return false;
			else if ($this->donation_amount <= 0)
				return false;
			else
				return true;
		}
		
		function Validate_Message()
		{
			$error_mess = "The errors are - ";
			if ($this->order_id == NULL)
			$error_mess .= " order_id not set;";
			if ($this->order_comment == NULL) 
			$error_mess .= " order_comment not set;";
			if ($this->order_submission_date == NULL) 
			$error_mess .= " order_submission_date not set;";
			if ($this->order_due_date == NULL) 
			$error_mess .= " order_due_date not set;";
			if ($this->order_channel_code == NULL)
			$error_mess .= " order_channel_code not set;"; 
			if ($this->order_customer_email == NULL)
			$error_mess .= " order_customer_email not set;"; 
			if ($this->token == NULL) 
			$error_mess .= " token not set;";
			if ($this->campaign_key == NULL) 
			$error_mess .= " campaign_key not set;";
			if ($this->donation_amount == NULL) 
			$error_mess .= " donation_amount not set;";
			if ($this->project_id == NULL)
			$error_mess .= " project_id not set;";
			if (!preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$this->order_customer_email))
			$error_mess .= " order_customer_email not valid;";
			if ($this->donation_amount <= 0)
				$error_mess .= " donation amount is negative/zero;";
		    
		    $error_obj = new Response(400,$error_mess);
			return $error_obj;
		}	
		
		function invoke()
		{
			$base_url = "https://secure.tracksgiving.com";
			if ($this->Validate())
			{
				$xmlobject = "<?xml version=\"1.0\" encoding=\"utf-8\"?><company_donation_request><order><id>".$this->order_id."</id><comment>".$this->order_comment."</comment><submission_date>".$this->order_submission_date."</submission_date><due_date>".$this->order_due_date."</due_date><channel_code>".$this->order_channel_code."</channel_code><customer_email>".$this->order_customer_email."</customer_email></order><donation><campaign_key>".$this->campaign_key."</campaign_key><amount>".$this->donation_amount."</amount><project_id>".$this->project_id."</project_id></donation></company_donation_request>";
				if (validate_xml($xmlobject, "company_donation"))
				{
					$xmlobject = urlencode($xmlobject);
					$response_xml = api_caller($base_url."/api/v1/company_donations.xml",array('_method'=>'POST','token'=>$this->token,'xmlobject'=>$xmlobject),'POST','xml');
					return extract_from_xml($response_xml);
				}
				else
				{
					echo "XML validation failed.<br>";
					return xml_error($xmlobject,"company_donation");
				}   
			}	
			else
			{
				echo "Invalidate input.<br>";
				return $this->Validate_Message();
			}
		}
	}	
?>
