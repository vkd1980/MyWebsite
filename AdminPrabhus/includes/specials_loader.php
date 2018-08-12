<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  //$response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
  //exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/test.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "All":
    $requestData= $_REQUEST;
    $columns = array(
    // datatable column index  => database column name
      1 => 'specials_id',
      2 => 'products.products_model',
      3 => 'products.products_name',
      4 => 'specials_new_products_price',
      5 => 'expires_date',
    6 => 'status' );
      $OrderMaster= $order->QueryOrderHeader();

  $sql = "SELECT specials_id FROM specials ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;
  $sql="SELECT specials_id,specials.products_id,specials_new_products_price,expires_date,`status`,specials_date_available, products.products_id,products.products_name,products.products_model
FROM (specials
LEFT JOIN products ON specials.products_id = products.products_id)";
$sql .="WHERE specials_id<>0";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( products_model LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR products_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
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
  $nestedData[] = $row["specials_id"];
  $nestedData[] = $row["products_model"];
  $nestedData[] =$row["products_name"];
  //$nestedData[] = $row["customers_lastname"];
  $nestedData[] = $row["specials_new_products_price"];
  $nestedData[] = $row["expires_date"];
  $nestedData[] = $row["status"];
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
  case "search":
$catid = isset($_REQUEST['catid']) ? filter_var(($_REQUEST['catid']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$query = "SELECT specials_id,specials.products_id,specials_new_products_price,expires_date,`status`,specials_date_available, products.products_id,products.products_name,products.products_model,products.products_price,products_author
FROM (specials
LEFT JOIN products ON specials.products_id = products.products_id)WHERE specials_id = '".$catid."' ORDER BY specials_id LIMIT 1";
$result = $db->select($query);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
  while($rows = mysqli_fetch_array($result)){
      $response[] = $rows; // add return data to an array

  }
  echo json_encode($response); // json encode that array
}
else
{
$response= array(0, 0, "Nothing Found");
echo json_encode($response);
}
break;

  }
}
  else{
  $response= array("ERROR","Invalid Access");
  echo json_encode($response);
}
?>
