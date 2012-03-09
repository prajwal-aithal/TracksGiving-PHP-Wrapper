<?php
	include("helper_functions.php");
    
    class CustomerDonation
    {
		//Attributes
		var $order_id, $order_comment, $order_payment_trx_details, $order_submission_date, $order_due_date;
        var $order_ipaddress, $order_channel_code;
        var $token, $campaign_key, $donation_amount, $project_id; 
        var $donor_name, $donor_email, $donor_genre, $donor_pan_number, $donor_tax_payer;
        var $donor_addressline, $donor_country_iso2, $donor_state_iso2, $donor_city, $donor_zipcode;
		
		//Methods of the class CustomerDonation
		function CustomerDonation($order_id, $order_comment, $order_payment_trx_details, $order_submission_date, $order_due_date,$order_ipaddress, $order_channel_code,
		$token, $campaign_key, $donation_amount, $project_id,$donor_name, $donor_email, $donor_genre, $donor_pan_number, $donor_tax_payer,$donor_addressline, $donor_country_iso2, $donor_state_iso2, $donor_city, $donor_zipcode)
		{
					$this->order_id = $order_id;
					$this->order_comment = $order_comment;
					$this->order_submission_date = $order_submission_date;
					$this->order_due_date = $order_due_date;
					$this->order_channel_code = $order_channel_code;
					$this->order_payment_trx_details = $order_payment_trx_details;
					$this->token = $token;
					$this->campaign_key = $campaign_key;
					$this->donation_amount = $donation_amount;
					$this->project_id = $project_id;
					$this->order_ipaddress = $order_ipaddress;
					$this->donor_name = $donor_name;
					$this->donor_email = $donor_email;
					$this->donor_genre = $donor_genre;
					$this->donor_pan_number = $donor_pan_number;
					$this->donor_tax_payer = $donor_tax_payer;
					$this->donor_addressline = $donor_addressline;
					$this->donor_country_iso2 = $donor_country_iso2;
					$this->donor_state_iso2 = $donor_state_iso2 ;
					$this->donor_city = $donor_city;
					$this->donor_zipcode = $donor_zipcode;
		}
		
		function Validate()
		{
			if (($this->order_id == NULL) || ($this->order_comment == NULL) || ($this->order_submission_date == NULL) || ($this->order_due_date == NULL) || ($this->order_channel_code == NULL) || ($this->order_payment_trx_details == NULL) || ($this->token == NULL) || ($this->campaign_key == NULL) || ($this->donation_amount == NULL) || ($this->project_id == NULL))
			 	return false;
			else if (($this->order_ipaddress == NULL) || ($this->donor_name == NULL) || ($this->donor_email == NULL) || ($this->donor_genre == NULL) || ($this->donor_pan_number == NULL) || ($this->donor_tax_payer == NULL) || ($this->donor_addressline == NULL) || ($this->donor_country_iso2 == NULL) || ($this->donor_state_iso2 == NULL) || ($this->donor_city == NULL) || ($this->donor_zipcode == NULL))
			 	return false;
		    else if (!preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$this->donor_email))
				return false;
			else if (($this->donor_tax_payer != "TP_O") && ($this->donor_tax_payer != "TP_NRI") && ($this->donor_tax_payer != "TP_RI")) 
				return false;
			else if (!preg_match("/^[A-Z]{4}[CPHFATBLJG][0-9]{4}[A-Z]{1}/",$this->donor_pan_number) && $this->is_pan_required())
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
				$error_mess .= " order_submission_date set;"; 
			if ($this->order_due_date == NULL) 
				$error_mess .= " order_due_date not set;"; 
			if ($this->order_channel_code == NULL) 
				$error_mess .= " order_channel_code not set;"; 
			if ($this->order_payment_trx_details == NULL) 
				$error_mess .= " order_payment_trx_details not set;"; 
			if ($this->token == NULL)  
				$error_mess .= " token not set;";
			if ($this->campaign_key == NULL)  
				$error_mess .= " campaign_key not set;";
			if ($this->donation_amount == NULL)  
				$error_mess .= " donation_amount not set;";
			if ($this->project_id == NULL) 
				$error_mess .= " project_id not set;";
			if ($this->order_ipaddress == NULL)  
				$error_mess .= " order_ipaddress not set;";
			if ($this->donor_name == NULL)  
				$error_mess .= " donor_name not set;";
			if ($this->donor_email == NULL)  
				$error_mess .= " donor_email not set;";
			if ($this->donor_genre == NULL)  
				$error_mess .= " donor_genre not set;";
			if ($this->donor_pan_number == NULL) 
				$error_mess .= " donor_pan_number not set;"; 
			if ($this->donor_tax_payer == NULL)  
				$error_mess .= " donor_tax_payer not set;";
			if ($this->donor_addressline == NULL)  
				$error_mess .= " donor_addressline not set;";
			if ($this->donor_country_iso2 == NULL)  
				$error_mess .= " donor_country_iso2 not set;";
			if ($this->donor_state_iso2 == NULL)  
				$error_mess .= " donor_state_iso2 not set;";
			if ($this->donor_city == NULL)  
				$error_mess .= " donor_city not set;";
			if ($this->donor_zipcode == NULL)
				$error_mess .= " donor_zipcode not set;";
		    if (!preg_match("/^(\w+((-\w+)|(\w.\w+))*)\@(\w+((\.|-)\w+)*\.\w+$)/",$this->donor_email))
				$error_mess .= " donor_email not valid";
			if (($this->donor_tax_payer != "TP_O") && ($this->donor_tax_payer != "TP_NRI") && ($this->donor_tax_payer != "TP_RI"))  
				$error_mess .= " donor_tax_payer not valid";
			if (!preg_match("/^[A-Z]{4}[CPHFATBLJG][0-9]{4}[A-Z]{1}/",$this->donor_pan_number) && $this->is_pan_required())
					$error_mess .= " donor_pan_number not valid";
			if ($this->donation_amount <= 0)
				$error_mess .= " donation amount is negative/zero.";
			
			$error_obj = new Response(400,$error_mess);
			return $error_obj;
		}
		
		function invoke()
		{
			$base_url = "https://secure.tracksgiving.com";
			if ($this->Validate())
			{
				$xmlobject = "<?xml version=\"1.0\" encoding=\"utf-8\"?><customer_donation_request><order><id>".$this->order_id."</id><comment>order_comment}</comment><payment_trx_details>".$this->order_payment_trx_details."</payment_trx_details><submission_date>".$this->order_submission_date."</submission_date><due_date>".$this->order_due_date."</due_date><ipaddress>".$this->order_ipaddress."</ipaddress><channel_code>".$this->order_channel_code."</channel_code></order><donor><name>".$this->donor_name."</name><customer_email>".$this->donor_email."</customer_email><genre>".$this->donor_genre."</genre><pan_number>".$this->donor_pan_number."</pan_number><tax_payer>".$this->donor_tax_payer."</tax_payer><addressline>".$this->donor_addressline."</addressline><country_iso2>".$this->donor_country_iso2."</country_iso2><state_iso2>".$this->donor_state_iso2."</state_iso2><city>".$this->donor_city."</city><zipcode>".$this->donor_zipcode."</zipcode></donor><donation><campaign_key>".$this->campaign_key."</campaign_key><amount>".$this->donation_amount."</amount><project_id>".$this->project_id."</project_id></donation></customer_donation_request>";
				if(validate_xml($xmlobject, "customer_donation"))
				{
					$xmlobject = urlencode($xmlobject);
					$url = $base_url."/api/v1/customer_donations.xml";
					$response_xml = api_caller($url,array('_method'=>"POST",'token'=>$this->token,'xmlobject'=>$xmlobject),'POST','xml');
					return extract_from_xml($response_xml);
				}
				else
				{
					echo "XML validation failed.<br>";
					return xml_error($xmlobject,"customer_donation");
				}   
			}
			else
			{
				echo "Invalid input. <br>";
				return $this->Validate_Message();
			}
		}
		
		function is_pan_required()
		{
			if($this->donor_tax_payer == "TP_RI")
				return true;
			else
				return false;
		}
	}
	
?>
