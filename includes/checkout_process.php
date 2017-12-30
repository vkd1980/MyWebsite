<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
 // exit("Unauthorized Access");
//}
require_once (__DIR__.'/classes/global.inc.php');
include(__DIR__.'/classes/Crypto.php');
	if(!empty($_REQUEST['Token']) && !empty($_REQUEST['Add_ID'])&& !empty($_REQUEST['process'])&&  ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token']))) || (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/myaccount.php', $_SESSION['csrf_token']))))){

$Add_id= filter_var($_REQUEST['Add_ID'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$Process= filter_var($_REQUEST['process'],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
switch($Process){
	case "SelectedAddress":
	$results = $CustAddress->GetCustAddressbyID($Add_id);
	$num_rows = mysqli_num_rows($results);
	if($num_rows > 0){
	while($rows =  mysqli_fetch_array($results)){
			if(isset($_SESSION['Address'])){
				unset($_SESSION['Address']);
				$Addressdata= array(
				'Cust_id' =>$rows['customers_id'],
				'Cust_address_book_id'=>$rows['address_book_id'],
				'Cust_Telephone' => $rows["customers_telephone"],
				'Cust_entry_company'=> $rows["entry_company"],
				'Cust_entry_firstname'=> $rows["entry_firstname"],
				'Cust_entry_lastname'=> $rows["entry_lastname"],
				'Cust_entry_street_address'=> $rows["entry_street_address"],
				'Cust_entry_suburb'=> $rows["entry_suburb"],
				'Cust_entry_postcode'=> $rows["entry_postcode"],
				'Cust_entry_city'=> $rows["entry_city"],
				'Cust_entry_state'=> $rows["entry_state"],
				'Cust_entry_country_id'=> $rows["entry_country_id"],
				'Cust_entry_zone_id'=> $rows["entry_zone_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_country_id'=> $rows["country_id"],
				'Cust_state_name'=> $rows["state_name"],
				'Cust_city_id'=> $rows["city_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_city_name'=> $rows["city_name"]
				);
			 $_SESSION['Address']= $Addressdata;
			 $status = "success";
			 $message = "Address Selected";

			   }
				  else{
				  $Addressdata= array(
				'Cust_id' =>$rows['customers_id'],
				'Cust_address_book_id'=>$rows['address_book_id'],
				'Cust_Telephone' => $rows["customers_telephone"],
				'Cust_entry_company'=> $rows["entry_company"],
				'Cust_entry_firstname'=> $rows["entry_firstname"],
				'Cust_entry_lastname'=> $rows["entry_lastname"],
				'Cust_entry_street_address'=> $rows["entry_street_address"],
				'Cust_entry_suburb'=> $rows["entry_suburb"],
				'Cust_entry_postcode'=> $rows["entry_postcode"],
				'Cust_entry_city'=> $rows["entry_city"],
				'Cust_entry_state'=> $rows["entry_state"],
				'Cust_entry_country_id'=> $rows["entry_country_id"],
				'Cust_entry_zone_id'=> $rows["entry_zone_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_country_id'=> $rows["country_id"],
				'Cust_state_name'=> $rows["state_name"],
				'Cust_city_id'=> $rows["city_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_city_name'=> $rows["city_name"]
				);
			 $_SESSION['Address']= $Addressdata;
				  $status = "success";
				  $message = "Address Selected";
				  }

	}

	}
	$data = array(
        'status' => $status,
        'message' => $message
    );

    echo json_encode($data);
	break;//EOF SelectedAddress

	case "SelectedShipping":
	$Shipping_Cost= $_REQUEST['ShippingCost'];
	$qry="SELECT * FROM shipping_modules WHERE Shipping_Id=$Add_id";
	$result = $DBC->select($qry);

	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
		while($rows =  mysqli_fetch_array($result)){
				if(isset($_SESSION['Shipping'])){
					unset($_SESSION['Shipping']);
					$Shippingdata= array(
					'Shipping_Id' =>$rows['Shipping_Id'],
					'Shipping Name'=>$rows['Shipping Name'],
					'Shipping Method'=>$rows['Shipping Method'],
					'Shipping_Image' => $rows["Shipping_Image"],
					'Shipping_Cost'=> $Shipping_Cost
					);
				 $_SESSION['Shipping']= $Shippingdata;
				 $status = "success";
				 $message = "Shipping Selected";

				   }
					  else{
					  $Shippingdata= array(
					'Shipping_Id' =>$rows['Shipping_Id'],
					'Shipping Name'=>$rows['Shipping Name'],
					'Shipping Method'=>$rows['Shipping Method'],
					'Shipping_Image' => $rows["Shipping_Image"],
					'Shipping_Cost'=> $Shipping_Cost
					);
				 $_SESSION['Shipping']= $Shippingdata;
					  $status = "success";
					  $message = "Shipping Selected";
					  }

		}

	}
	$data = array(
			'status' => $status,
			'Location'=>'../checkout.html?process=Select_Payment',
			'message' => $message
		);

		echo json_encode($data);
	break;//EOF SelectedShipping

	case "SelectedPayment":
	$Action= filter_var($_REQUEST['PymntName'],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$Ordertotal=$_REQUEST['Ordertotal'];
	$qry="SELECT * FROM payment_modules WHERE Payment_id=$Add_id";
	$result = $DBC->select($qry);
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
		while($rows =  mysqli_fetch_array($result)){
				if(isset($_SESSION['Payment'])){
					unset($_SESSION['Payment']);
					$Paymentdata= array(
					'Payment_id' =>$rows['Payment_id'],
					'Payment_name'=>$rows['Payment_name'],
					'Payment Method'=>$rows['Payment Method'],
					'Payment_image' => $rows["Payment_image"]
					);
				 $_SESSION['Payment']= $Paymentdata;
				 $status = "success";
				 $message = "Payment Selected";

				   }
					  else{
					 $Paymentdata= array(
					'Payment_id' =>$rows['Payment_id'],
					'Payment_name'=>$rows['Payment_name'],
					'Payment Method'=>$rows['Payment Method'],
					'Payment_image' => $rows["Payment_image"]
					);
				 $_SESSION['Payment']= $Paymentdata;
					  $status = "success";
					  $message = "Payment Selected";
					  }

		}

	}
			switch($Action){
			case "Cash On Delivery":
				//Save order , send Mail and redirect to order Confirmatiion page
				$Order_ID='';
				$Order_ID=$order->Save_Order($Ordertotal,get_ip_address());
				//Insert Payment details
				//Insert Order status
				$order->SaveOrderStatusHistory($Order_ID,'1','Cash On Delivery');
				if (!$Order_ID ==0){

						$status = "success";
						$message = "Order Confirmed";
			//$order_ID= $InsertID;
						}
						$data = array(
						'status' => $status,
						'message' => $message,
						'order_ID'=>$Order_ID,
						'Location'=>"../checkout.html?process=Order_Summary"
					);

						echo json_encode($data);

					break;//EOF Cash On Delivery
			case "CCAvenue":

			$working_key=MODULE_PAYMENT_CCAVENUE_WORKING_KEY;//Shared by CCAVENUES
			$access_code=MODULE_PAYMENT_CCAVENUE_ACCESS_CODE;//Shared by CCAVENUES
			$merchant_data='tid='.date('YmdHis').'&merchant_id='.MODULE_PAYMENT_CCAVENUE_MERCHANT_ID.'&order_id='.$_SESSION['Address']['Cust_id'].'-'.date('YmdHis').'&amount='.($_SESSION['Shipping']['Shipping_Cost']+$cart->total()).'&currency=INR&redirect_url='.(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/checkout.php&cancel_url='.(isset($_SERVER['HTTPS']) ? "https" : "http") . "://$_SERVER[HTTP_HOST]".'/checkout.php&language=EN&billing_name='.$_SESSION['Address']['Cust_entry_firstname'].' '.$_SESSION['Address']['Cust_entry_lastname'].'&billing_address= '.$_SESSION['Address']['Cust_entry_street_address'].'&billing_city='.$_SESSION['Address']['Cust_city_name'].'&billing_state='.$_SESSION['Address']['Cust_state_name'].'&billing_zip='.$_SESSION['Address']['Cust_entry_postcode'].'&billing_country=India&billing_tel='.$_SESSION['Address']['Cust_Telephone'].'&billing_email='.$_SESSION['UserData'][1].'&delivery_name='.$_SESSION['Address']['Cust_entry_firstname'].''.$_SESSION['Address']['Cust_entry_lastname'].'&delivery_address='.$_SESSION['Address']['Cust_entry_street_address'].'&delivery_city='.$_SESSION['Address']['Cust_city_name'].'&delivery_state='.$_SESSION['Address']['Cust_state_name'].'&delivery_zip='.$_SESSION['Address']['Cust_entry_postcode'].'&delivery_country=India&delivery_tel='.$_SESSION['Address']['Cust_Telephone'].'&integration_type=iframe_normal&';

			//foreach ($_POST as $key => $value){
			//$merchant_data.=$key.'='.$value.'&';
			//}
			$encrypted_data=encrypt($merchant_data,$working_key); // Method for encrypting the data.
			//$production_url='https://secure.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;
			$production_url='https://test.ccavenue.com/transaction/transaction.do?command=initiateTransaction&encRequest='.$encrypted_data.'&access_code='.$access_code;

			$data = array(
						'status' => "success",
						'message' => "Payment processed",
						'production_url'=>$production_url
					);

						echo json_encode($data);


			break;//EOF CCAvenue

			}

	break;//EOF SelectedPayment
	//
	case "OrderSummary":
		$summary='';
		$Order_ID='';
		$err='';
		$Order_ID= filter_var($_REQUEST['Add_ID'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
		//BOF Order Confirmation
		$EmailOrderMstr=$order->QueryOrderMaster($Order_ID);
		$EmailOrderDet=$order->QueryOrderDetails($Order_ID);
		$rows =  mysqli_fetch_array($EmailOrderMstr);
		$SubTotal=0;
		$Odetails='';

					// BOF Send Mail

					$message_html = file_get_contents('../email/email_checkout.html');
					$message_html = str_replace('%customers_name%', strtoupper($rows['customers_name']), $message_html);
					$message_html = str_replace('%orders_id%', $rows['orders_id'], $message_html);
					$message_html = str_replace('%date_purchased%', $rows['date_purchased'], $message_html);
					$message_html = str_replace('%customers_company%', strtoupper($rows['customers_company']), $message_html);
					$message_html = str_replace('%customers_street_address%', strtoupper($rows['customers_street_address']), $message_html);
					$message_html = str_replace('%customers_suburb%', strtoupper($rows['customers_suburb']), $message_html);
					$message_html = str_replace('%customers_city%', strtoupper($rows['customers_city']), $message_html);
					$message_html = str_replace('%customers_state%', strtoupper($rows['customers_state']), $message_html);
					$message_html = str_replace('%customers_postcode%', $rows['customers_postcode'], $message_html);
					$message_html = str_replace('%customers_telephone%', $rows['customers_telephone'], $message_html);

					$message_html = str_replace('%delivery_name%', strtoupper($rows['delivery_name']), $message_html);
					$message_html = str_replace('%delivery_company%',strtoupper( $rows['delivery_company']), $message_html);
					$message_html = str_replace('%delivery_street_address%', strtoupper($rows['delivery_street_address']), $message_html);
					$message_html = str_replace('%delivery_suburb%',strtoupper( $rows['delivery_suburb']), $message_html);
					$message_html = str_replace('%delivery_city%', strtoupper($rows['delivery_city']), $message_html);
					$message_html = str_replace('%delivery_state%', strtoupper($rows['delivery_state']), $message_html);
					$message_html = str_replace('%delivery_postcode%', $rows['delivery_postcode'], $message_html);
					$message_html = str_replace('%customers_telephone%', $rows['customers_telephone'], $message_html);

					$message_html = str_replace('%ip_address%', $rows['ip_address'], $message_html);
					$message_html = str_replace('%payment_method%', $rows['payment_method'], $message_html);
					$message_html = str_replace('%shipping_method%', $rows['shipping_method'], $message_html);
					$message_html = str_replace('%shipping_cost%', number_format($rows['shipping_cost'],2), $message_html);
					$message_html = str_replace('%order_total%', number_format($rows['order_total'],2), $message_html);
					$EmailBody='';
					while($rowsD=mysqli_fetch_array($EmailOrderDet)){
							$SubTotal=$SubTotal+$rowsD['final_price'];
							$EmailBody=$EmailBody.'
										 <tr>
										   <td width="50%" height="18" align="left" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737"> '.strtoupper($rowsD['products_name']).'</td>
										   <td width="10%" height="18" align="center" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.strtoupper($rowsD['products_quantity']).'</td>
										   <td width="20%" height="18" align="right" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.number_format($rowsD['products_price'],2).'</td>
										   <td width="20%" height="18" align="right" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.number_format($rowsD['final_price'],2).'</td>
										 </tr>';
										 $Odetails=$Odetails.'<tr>
    								<td><h7>'.strtoupper($rowsD['products_name']).'</h7></td>
    								<td class="text-center"><h7>'.$rowsD['products_quantity'].'</h7></td>
									<td class="text-right"><h7><span class="fa fa-inr"></span>'.number_format($rowsD['products_price'],2).'</h7></td>
    								<td class="text-right"><h7><span class="fa fa-inr"></span> '.number_format($rowsD['final_price'],2).'</h7></td>
    							</tr>';
										 }

						$message_html = str_replace('%details%', $EmailBody, $message_html);
						$message_html = str_replace('%SubTotal%', number_format($SubTotal,2), $message_html);


					//EOF Send Mail
$summary= '<!--BOF Order Confirmation-->
    <div class="row">
	<!-- Bof Message-->
<div class="clearfix"></div>
	  <div class="clearfix"></div>

	<div class="container">
    <div class="row">

	  </div>
	  </div>
<!-- Eof Message-->
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # '.$rows['orders_id'].'</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address><h6>
    				<strong>Billed To:</strong><br></h6>
    					<h7>'.strtoupper($rows['customers_name']).'<br>';

						if ((!empty($rows['customers_company']))){
						$summary= $summary.strtoupper($rows['customers_company']).'<br>';
						}
    					$summary= $summary.strtoupper($rows['customers_street_address']).' ,'.strtoupper($rows['customers_suburb']).'<br>';
    					 $summary= $summary.strtoupper($rows['customers_city']).' , '.strtoupper($rows['customers_state']).' - '.$rows['customers_postcode'].'
    				</h7></address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address><h6>
        			<strong>Shipped To:</strong><br></h6><h7>'.
    					strtoupper($rows['delivery_name']).'<br>';


						if ((!empty($rows['customers_company']))){
						$summary= $summary. strtoupper($rows['delivery_company']).'<br>';
						}

    					$summary= $summary. strtoupper($rows['delivery_street_address']).' , '.strtoupper($rows['delivery_suburb']).'<br>';
    					$summary= $summary. strtoupper($rows['delivery_city']).' ,'.strtoupper($rows['delivery_state']).' - '.$rows['delivery_postcode'].'
    				</h7></address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br><h7>
    					'.$rows['payment_method'].'<br></h7>

    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Shipping Method:</strong><br><h7>
    					'.$rows['shipping_method'].'<br></h7>

    				</address>
    			</div>
    		</div>

    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order Details</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
									<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Price</strong></td>

        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>';


							$summary= $summary.$Odetails;


    							$summary= $summary. '<tr>
    								<td class="thick-line"></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-center"><h6><strong>Subtotal</strong></h6></td>
    								<td class="thick-line text-right"><h6><span class="fa fa-inr"></span>'.number_format($SubTotal,2).'</h65></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><h6><strong>Shipping</strong></h6></td>
    								<td class="no-line text-right"><h6><span class="fa fa-inr"></span> '.number_format($rows['shipping_cost'],2).'</h6></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><h6><strong>Total</strong></h6></td>
    								<td class="no-line text-right"><h6><span class="fa fa-inr"></span>'.number_format($rows['order_total'],2).'</h6></td>
    							</tr>
    						</tbody>
    					</table>
    				</div>
    			</div>
    		</div>
    	</div>
    </div>

<!--Eof Order Confirmation-->';
if($_REQUEST['notification']=='true'){
$mail = new PHPMailer();
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->IsSMTP();
$mail->Host = SMTP_SERVER;
$mail->SMTPAuth = true;
$mail->Username = SMTP_USER_NAME;
$mail->Password = SMTP_PASSWORD;
$mail->SetFrom('admin@prabhusbooks.com', 'Prabhus Books Online');
$mail->addReplyTo('admin@prabhusbooks.com', 'Prabhus Books Online');
$mail->AddAddress($_SESSION['UserData'][1]);
$mail->Subject = 'Order Confirmation ..::Prabhus Books Online::..';
$mail->AddBCC('admin@prabhusbooks.com', 'Administrator');
$mail->MsgHTML($message_html);
if(!$mail->Send()) {
$err ='Unable to Send Email !'. $mail->ErrorInfo;

}
elseif(!sendsms($rows['customers_telephone'],"Dear ".$rows['customers_name']." ,Thank you for your Order No ".$rows['orders_id']." placed with prabusbooks.com for Rs ".number_format($rows['order_total'],2)." . We are currently processing your order we will soon notify you with further Updates.")==true)
			{
			$err=$err.'<div class ="alert alert-warning" align="center"><h4>Unable to Send SMS !</h4></div>';
			}
			else
			{
			$err='<div class ="panel panel-success" align="center"><h4>An Email and SMS Sent You !</h4></div>';
			}


			if (!empty($err))
			{
				echo $err .$summary;
				//destroy Sessions
				unset($_SESSION['Address']);
				unset($_SESSION['Shipping']);
				unset($_SESSION['Payment']);
				$cart->destroy();
			
			}
			else{
				echo $summary;
				//destroy Sessions
				unset($_SESSION['Address']);
				unset($_SESSION['Shipping']);
				unset($_SESSION['Payment']);
				$cart->destroy();
			
			}
}
else
{

echo $summary;
}
	break;//EOF OrderSummary

	case "OrderStatus":
	$Msg=filter_var($_REQUEST['Msg'],FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	!isset($_REQUEST['orders_status_id']) ? $orders_status_id=0 : $orders_status_id=filter_var($_REQUEST['orders_status_id'],FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

		if($order->SaveOrderStatusHistory($Add_id,$orders_status_id,$Msg)==true)
		{
					$status = "success";
					$message = "Your Comments Saved!";
		}
		else{
					$status = "Error";
					$message = "Something Went Wrong";
		}
					$data = array(
						'status' => $status,
						'message' => $message);
					echo json_encode($data);
	break;//EOF OrderStatus

}//EOF Switch Process

	}//Eof IF Post

	elseif(isset($_REQUEST["encResp"]) && !empty($_REQUEST["encResp"])&&  (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token'])))){//Else of If Post
	$Ordertotal=filter_var($_REQUEST['Ordertotal'],FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_STRIP_HIGH);
	$workingKey= MODULE_PAYMENT_CCAVENUE_WORKING_KEY;		//Working Key should be provided here.
	$order=new Order();
	//$workingKey='73A292936FE7E433D671007B35DF410F';//Sandbox
	$encResponse=$_REQUEST["encResp"];			//This is the response sent by the CCAvenue Server
	$rcvdString=decrypt($encResponse,$workingKey);		//Crypto Decryption used as per the specified working key.
	$order_status="";
	$decryptValues=explode('&', $rcvdString);
	$dataSize=sizeof($decryptValues);
	for($i = 0; $i < $dataSize; $i++)
	{
		$information=explode('=',$decryptValues[$i]);
		if($i==3)	$order_status=$information[1];
	}

	parse_str($rcvdString, $outputArray);
	//print_r($outputArray);

	if($order_status==="Success")
	{
					$Order_ID='';
					$Order_ID=$order->Save_Order($Ordertotal,get_ip_address());
			//Insert Payment details
			$order->SavePaymentDetails($Order_ID,$outputArray['tracking_id'],$outputArray['order_id'],$outputArray['bank_ref_no'],	$outputArray['order_status'],$outputArray['payment_mode'],$outputArray['card_name'],$outputArray['status_code'],$outputArray['status_message'],$outputArray['mer_amount']);
				//Insert Order status
				$order->SaveOrderStatusHistory($Order_ID,'1',$outputArray['status_message']);


					if (!$Order_ID ==0){
						//$cart->destroy();
						$status = "success";
						$message = "Payment Confirmed";
						}
						$data = array(
						'status' => $status,
						'message' => $message,
						'order_ID'=>$Order_ID,
						'Location'=>"../checkout.html?process=Order_Summary"
					);

	}
	else if($order_status==="Aborted")
	{
						$status = "Aborted";
						$message = $outputArray['status_message'];
						$data = array(
						'status' => $status,
						'message' => $message
					);
	}
	else if($order_status==="Failure")
	{
						$status = "Failure";
						$message = $outputArray['status_message'];
						$data = array(
						'status' => $status,
						'message' => $message
					);
	}
	else
	{
						$status = "Failure";
						$message = "Security Error. Illegal access detected";
						$data = array(
						'status' => $status,
						'message' => $message
					);
	}

	echo json_encode($data);

	}//EOF CCAvenue Post Check

	else{
	echo"Error";

	}
?>
