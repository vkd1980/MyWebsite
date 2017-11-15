<?php 
include(__DIR__.'/classes/Crypto.php');



	error_reporting(0);
	
	$workingKey='5EBC8B54D96000004502FDFF5CBEA7EA';		//Working Key should be provided here.
	$encResponse=$_POST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	echo "<center>";

	for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}
	parse_str($rcvdString, $outputArray);
	echo $outputArray['card_name'];
	echo $outputArray['status_message'];

/*0cca_order_id	2-20171029081253
1cca_tracking_id	106293352113
2cca_bank_ref_no	null
3cca_order_status	Aborted
4cca_failure_message	
5cca_payment_mode	Credit Card
6cca_card_name	Visa
7cca_status_code	null
8cca_status_message	Transaction aborted at the bank end.
9cca_currency	INR
10cca_amount	9340.0
11billing_name	Vinodkumar D
12billing_address	UAE Exchange 6
13billing_city	Cherthala
14billing_state	Kerala
15billing_zip	682011
16billing_country	India
17billing_tel	9895755667
18billing_email	vkd1980@gmail.com
19delivery_name	VinodkumarD
20delivery_address	UAE Exchange 6
21delivery_city	Cherthala
22delivery_state	Kerala
23delivery_zip	682011
24delivery_country	India
25delivery_tel	9895755667
26merchant_param1	
27merchant_param2	
28merchant_param3	
29merchant_param4	
30merchant_param5	
31vault	N
32offer_type	null
33offer_code	null
34discount_value	0.0
35mer_amount	9340.0
36eci_value	null
37retry	N
38response_code	953
39billing_notes	
40cca_trans_date	29/10/2017 12:47:51
41bin_country	INDIA*/

	if($order_status==="Success")
	{
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
		
	}
	else if($order_status==="Aborted")
	{
		echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
	}
	else if($order_status==="Failure")
	{
		echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	}
	else
	{
		echo "<br>Security Error. Illegal access detected";
	
	}

	echo "<br><br>";

	echo "<table cellspacing=4 cellpadding=4>";
	/*for($i = 0; $i < $dataSize; $i++) 
	{
		$information=explode('=',$decryptValues[$i]);
	    	echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
	}
*/
	echo "</table><br>";
	echo "</center>";
?>
