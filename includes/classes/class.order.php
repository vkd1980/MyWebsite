<?php
require_once (__DIR__.'/global.inc.php');
class Order{

	function QueryOrderMaster($order_id) {
		$DBC = new DB();
		$con =$DBC->connect();
		$order_query = "select * from orders
								where orders_id = '" . (int)$order_id . "'";
		$stmt = $con->prepare($order_query);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$con->close();
		return $result;

	}
	function QueryOrderDetails($order_id) {
		$DBC = new DB();
		$con =$DBC->connect();
		$orders_products_query = "select * from orders_products
                                  where orders_id = '" . (int)$order_id . "'
                                  order by orders_products_id";
		$stmt = $con->prepare($orders_products_query);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$con->close();
		return $result;
	}
	function QueryOrderHeader(){
		$DBC = new DB();
		$con =$DBC->connect();
		$orders_header = "SELECT orders.orders_id,orders.date_purchased,orders.order_total,orders_status.orders_status_name,orders_status_history.orders_id,orders_status_history.orders_status_id
FROM (orders_status_history
LEFT JOIN orders ON orders.orders_id = orders_status_history.orders_id)
LEFT JOIN orders_status ON orders_status.orders_status_id = orders_status_history.orders_status_id WHERE orders_status.orders_status_id<>0";
		$stmt = $con->prepare($orders_header);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$con->close();
		return $result;
	}
	function Save_Order($Ordertotal,$IP){
	/**/
	$cart=new ShoppingCart();
			$DBC= new DB();
			$order = new Order();
				if(isset($_SESSION['Coupon'])){
				$Coupon= $_SESSION['Coupon']['CouponName'];
				}
				else
				{
				$Coupon='0';
				}
			$OrderMaster ='';
			$OrderMaster = array(
				'`customers_id`' => $_SESSION['Address']['Cust_id'],
				'`customers_name`'=>"'".$_SESSION['Address']['Cust_entry_firstname'].' '.$_SESSION['Address']['Cust_entry_lastname']."'",
				'`customers_company`' => "'".$_SESSION['Address']['Cust_entry_company']."'",
				'`customers_street_address`'=>"'". $_SESSION['Address']['Cust_entry_street_address']."'",
				'`customers_suburb`' =>"'".$_SESSION['Address']['Cust_entry_suburb']."'",
				'`customers_city`' =>"'".$_SESSION['Address']['Cust_city_name']."'",
				'`customers_postcode`' =>"'".$_SESSION['Address']['Cust_entry_postcode']."'",
				'`customers_state`' =>"'".$_SESSION['Address']['Cust_state_name']."'",
				'`customers_country`' =>"'India'",
				'`customers_telephone`' =>"'".$_SESSION['Address']['Cust_Telephone']."'",
				'`customers_email_address`' =>"'".$_SESSION['UserData'][1]."'",
				'`delivery_name`' =>"'".$_SESSION['Address']['Cust_entry_firstname'].''.$_SESSION['Address']['Cust_entry_lastname']."'",
				'`delivery_company`' => "'".$_SESSION['Address']['Cust_entry_company']."'",
				'`delivery_street_address`' => "'".$_SESSION['Address']['Cust_entry_street_address']."'",
				'`delivery_suburb`' =>"'".$_SESSION['Address']['Cust_entry_suburb']."'",
				'`delivery_city`' =>"'".$_SESSION['Address']['Cust_city_name']."'",
				'`delivery_postcode`' =>"'".$_SESSION['Address']['Cust_entry_postcode']."'",
				'`delivery_state`' =>"'".$_SESSION['Address']['Cust_state_name']."'",
				'`delivery_country`' =>"'India'",
				'`billing_name`' =>"'".$_SESSION['Address']['Cust_entry_firstname'].''.$_SESSION['Address']['Cust_entry_lastname']."'",
				'`billing_company`' => "'".$_SESSION['Address']['Cust_entry_company']."'",
				'`billing_street_address`' => "'".$_SESSION['Address']['Cust_entry_street_address']."'",
				'`billing_suburb`' =>"'".$_SESSION['Address']['Cust_entry_suburb']."'",
				'`billing_city`' =>"'".$_SESSION['Address']['Cust_city_name']."'",
				'`billing_postcode`' =>"'".$_SESSION['Address']['Cust_entry_postcode']."'",
				'`billing_state`' =>"'".$_SESSION['Address']['Cust_state_name']."'",
				'`billing_country`' =>"'India'",
				'`payment_method`' =>"'".$_SESSION['Payment']['Payment Method']."'",
				'`shipping_cost`' =>"'".$_SESSION['Shipping']['Shipping_Cost']."'",
				'`shipping_method`' =>"'".$_SESSION['Shipping']['Shipping Method']."'",
				'`date_purchased`' => "'".date("Y-m-d H:i:s",time())."'",
				'`orders_status`' =>"'1'",
				'`coupon_code`' =>$Coupon,
				'`order_total`' => $Ordertotal,
				'`ip_address`' =>"'".$IP."'"
				);
				$OrderDetails[]=  array("orders_id","products_id","products_model","products_name","products_price","final_price","products_quantity");
				$InsertID = $DBC->insert($OrderMaster, 'orders');

				if (!$InsertID==0){
				/*Loop thru Cart Items and save Order Products*/
				$OrderDetails[] =  array("`orders_id`","`products_id`","`products_model`","`products_name`","`products_price`","`final_price`","`products_quantity`");
				$cartItems = $cart->contents();
				foreach($cartItems as $item){
				$OrderDetails[]= array($InsertID,$item['id'],"'".$item['products_model']."'","'".$item['name']."'",$item['price'],$item['price']*$item['qty'],$item['qty']);
				}
				if ($DBC->Mulltinsert($OrderDetails,'orders_products')==true){
					return $InsertID;
					}
					else{
					return 0;
					}
				}
				else{
				return 0;
				}



	}
	function SaveOrderStatusHistory($orders_id,$orders_status_id,$comments)
	{
		$DBC = new DB();
		$OrderStatus = array('`orders_id`' => $orders_id,
		'`orders_status_id`' => $orders_status_id,
		'`date_added`' =>"'".date("Y-m-d H:i:s",time())."'",
		'`customer_notified`' => "'1'",
		'`comments`' => "'".$comments."'"
		);
		$InsertID = $DBC->insert($OrderStatus, 'orders_status_history');

		if (!$InsertID==0){
					return true;
					}
					else{
					return false;
					}

	}
	function SavePaymentDetails($order_id,$tracking_id,$Order_id_cca,$bank_ref_no,$order_status,$payment_mode,$card_name,$status_code,$status_message,$amount){
		$DBC = new DB();
		$SavePaymentDetails=array(
			'`order_id`' =>$order_id,
			'`tracking_id`' =>"'".$tracking_id."'",
			'`Order_id_cca`' =>"'".$Order_id_cca."'",
			'`bank_ref_no`' =>"'".$bank_ref_no."'",
			'`order_status`' =>"'".$order_status."'",
			'`payment_mode`' =>"'".$payment_mode."'",
			'`card_name`' =>"'".$card_name."'",
			'`status_code`' =>"'".$status_code."'",
			'`status_message`' =>"'".$status_message."'",
			'`amount`' =>"'".$amount."'"
		);
		$InsertID = $DBC->insert($SavePaymentDetails, 'payment_details');

		if (!$InsertID==0){
					return true;
					}
					else{
					return false;
					}
	}

}
?>
