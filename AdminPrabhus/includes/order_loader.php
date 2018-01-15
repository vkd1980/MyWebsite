<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  //$response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
  //exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/orders.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "All":
    $requestData= $_REQUEST;
    $columns = array(
    // datatable column index  => database column name
      1 => 'orders.orders_id',
      2 => 'date_purchased',
      3 => 'customers_firstname',
      4 => 'order_total',
      5 => 'orders_status_name');
      $OrderMaster= $order->QueryOrderHeader();

  $sql = "SELECT orders_id FROM orders ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;
  $sql="SELECT orders.orders_id,orders.customers_id,orders.date_purchased,orders.order_total,orders_status.orders_status_name,orders_status_history.orders_id,orders_status_history.orders_status_id,customers.customers_firstname,customers.customers_lastname
FROM (orders_status_history
LEFT JOIN orders ON orders.orders_id = orders_status_history.orders_id)
LEFT JOIN orders_status ON orders_status.orders_status_id = orders_status_history.orders_status_id
LEFT JOIN customers ON customers.customers_id = orders.customers_id
WHERE orders_status.orders_status_id<>0";
//$sql .="WHERE 1=1";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( customers.customers_firstname LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR customers.customers_lastname LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR orders_status.orders_status_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
}
$query=$db->select($sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[filter_var(($requestData['order'][0]['column']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)]."   ".filter_var(($requestData['order'][0]['dir']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."  LIMIT ".filter_var(($requestData['start']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ,".filter_var(($requestData['length']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ";
//echo $sql;
$query=$db->select($sql);
$data = array();
$i=1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();
  $nestedData[] =$i;
  $nestedData[] = $row["orders_id"];
  $nestedData[] = $row["date_purchased"];
  $nestedData[] =$row["customers_firstname"];
  $nestedData[] = $row["customers_lastname"];
  $nestedData[] = $row["order_total"];
  $nestedData[] = $row["orders_status_name"];
  $data[] = $nestedData;
  $i++;
}
$json_data = array(
      //"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );
echo json_encode($json_data);  // send data as json format
    break;
  }
}

else{
$response= array("ERROR","Invalid Access");
echo json_encode($response);
}
?>
