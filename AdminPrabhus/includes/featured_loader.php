<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  $response= array("ERROR","Hacking attempt");
	echo json_encode($response);
  exit();
}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/featured.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "All":
    $requestData= $_REQUEST;
    $columns = array(
    // datatable column index  => database column name
      1 => 'featured_id',
      2 => 'products.products_model',
      3 => 'products.products_name',
      4 => 'expires_date',
      5 =>  'status');

  $sql = "SELECT featured_id FROM featured ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;
  $sql="SELECT featured_id,featured.products_id,expires_date,`status`,featured_date_available, products.products_id,products.products_name,products.products_model
FROM (featured
LEFT JOIN products ON featured.products_id = products.products_id)";
$sql .="WHERE featured_id<>0";
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
  $nestedData[] = $row["featured_id"];
  $nestedData[] = $row["products_model"];
  $nestedData[] =$row["products_name"];
  //$nestedData[] = $row["customers_lastname"];
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
$query = "SELECT featured_id,featured.products_id,expires_date,`status`,featured_date_available, products.products_id,products.products_name,products.products_model,products.products_price,products_author
FROM (featured
LEFT JOIN products ON featured.products_id = products.products_id)WHERE featured_id = '".$catid."' ORDER BY featured_id LIMIT 1";
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
case "addnew":
$products_id=isset($_REQUEST['products_id']) ? filter_var(($_REQUEST['products_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$expires_date=date("Y-m-d", strtotime($_REQUEST['expires_date']));
$status=isset($_REQUEST['status']) ? filter_var(($_REQUEST['status']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$featured_date_available=date("Y-m-d", strtotime($_REQUEST['date_available']));
$query= "select featured_id from featured where products_id = $products_id LIMIT 1";
$result= $db->select($query);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
  $response= array("ERROR","Product Already Exists in featured");
  echo json_encode($response);
}
else{
$qry="INSERT INTO `featured` ( `products_id`, `featured_date_added`, `featured_last_modified`, `expires_date`)
VALUES ('".$products_id."', now(), now(), '".$expires_date."');";
echo json_encode($db->insertdb($qry));
}

break;
case "update":
$featured_id= isset($_REQUEST['featured_id']) ? filter_var(($_REQUEST['featured_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$products_id=isset($_REQUEST['products_id']) ? filter_var(($_REQUEST['products_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$expires_date=date("Y-m-d", strtotime($_REQUEST['expires_date']));
$status=isset($_REQUEST['status']) ? filter_var(($_REQUEST['status']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$featured_date_available=date("Y-m-d", strtotime($_REQUEST['date_available']));
$data = array(
"featured_last_modified" => "now()",
"expires_date" => "'$expires_date'",
"status" => "'$status'",
"featured_date_available" => "'$featured_date_available'"  );
$result=$db->update($data, 'featured', 'featured_id = '.$featured_id);
if($result==true){
  $response=array("OK", " Edited Successfully");
  echo json_encode($response);
}
else{
  $response=array("OK", " Inserted Successfully");
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
