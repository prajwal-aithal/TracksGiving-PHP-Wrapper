<?php

   require("./src/company_donation.php");
   require("./src/customer_donation.php");
   require("./src/order.php");
   
   //Creates a Company donation with the given attributes.
   $donation1 = new CompanyDonation(345,"Ordered 2 shawls","2012-03-07","2012-03-15","C","scott.tiger@gmail.com","vHgYNS7dbotHjziuPCZQ","8caf7910-247e-012f-e4a5-442c03154814",11981,1);
   $don1 = $donation1->invoke();
   echo $don1->status . " :: ".$don1->error." :: <b>Tracking url</b> - ".$don1->tracking_url;
	   
   echo "<br>";
   
   //Creates a Customer donation with the given attributes.
   $donation2 = new CustomerDonation(56, "Ordered 3 shawls", "VISA Transaction #2394092049", "2012-10-20", "2012-10-29","120.302.03.30", "CHWEB","vHgYNS7dbotHjziuPCZQ", "8c98a1d0-247e-012f-e4a3-442c03154814", 301.9, 2,"Scott Tiger", "scott.tiger92@gmail.com", "UG_P", "AAAAA9999B", "TP_RI","203 Oceanic View", "IN", "MH", "Mumbai", "400001");
   $don2 = $donation2->invoke();
   echo $don2->status . " :: ".$don2->error." :: <b>Tracking url</b> - ".$don2->tracking_url;
   
   echo "<br>";
   
   //Creates an Order instance with the given attributes. Will be used to cancel the 1st donation subsequently.
   $order1 = new Order(345, "vHgYNS7dbotHjziuPCZQ", "cancellation comment", "2012-03-10");
   $ord1 = $order1->cancel();
   echo $ord1->status . " :: ".$ord1->error;
   
   echo "<br>";
   
   //Creates an Order instance with the given attributes. Will be used to reschedule the 2st donation subsequently.
   $order2 = new Order(56, "vHgYNS7dbotHjziuPCZQ", "cancellation comment", "2012-11-10");
   $ord2 = $order2->reschedule();
   echo $ord2->status . " :: ".$ord2->error;
   
?>
