<?php
require_once (__DIR__.'/global.inc.php');
class Order{

	function QueryOrderMaster($order_id) {
		$DBC = new DB();
		$order_query = "select * from orders
								where orders_id = '" . (int)$order_id . "'";
		$result = $DBC->select($order_query);
		return $result;

	}
	function QueryOrderDetails($order_id) {
		$DBC = new DB();
		$orders_products_query = "select * from orders_products
                                  where orders_id = '" . (int)$order_id . "'
                                  order by orders_products_id";
			$result = $DBC->select($orders_products_query);
			return $result;
	}
	function QueryOrderHeader(){
		$DBC = new DB();
		$orders_header = "SELECT orders.orders_id,orders.date_purchased,orders.order_total,orders_status.orders_status_name,orders_status_history.orders_id,orders_status_history.orders_status_id
FROM (orders_status_history
LEFT JOIN orders ON orders.orders_id = orders_status_history.orders_id)
LEFT JOIN orders_status ON orders_status.orders_status_id = orders_status_history.orders_status_id WHERE orders_status.orders_status_id<>0";
	$result = $DBC->select($orders_header);
		return $result;
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
	function UpdateOrderStatus()
	{
		$DBC = new DB();
	}
	function getorderHistory($orderid){
		$DBC = new DB();
		/*$Order_history="SELECT *
FROM orders_status_history
WHERE orders_id='" . (int)$orderid."'";*/
$Order_history="SELECT orders_status.orders_status_id,orders_status_name,orders_id,orders_status_history.orders_status_id,date_added,comments
FROM (orders_status_history
LEFT JOIN orders_status ON orders_status.orders_status_id =orders_status_history.orders_status_id )
WHERE orders_id='" . (int)$orderid."' ORDER BY date_added";
		$result = $DBC->select($Order_history);
		return $result;
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
function getorderstatus(){
	$DBC = new DB();
	$qry ="SELECT *
FROM orders_status";
$result= $DBC->select($qry);
  return $result;
}
}
?>
