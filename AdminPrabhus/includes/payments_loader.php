<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
//  $response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
//  exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/test.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "All":
    $requestData= $_REQUEST;
    $columns = array(
    // datatable column index  => database column name
      1 => 'Payment_id',
      2 => 'Payment_name',
      3 => 'Payment Method',
      4 => 'Online_Status',
      5 =>  'Status',
      6 =>  'Payment_image',
      7 =>  'date_added',
    8 =>  'date_modified');

  $sql = "SELECT Payment_id FROM payment_modules ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;
  $sql="SELECT Payment_id,Payment_name,`Payment Method`, Online_Status,`Status`,Payment_image,date_added,date_modified
FROM payment_modules ";
$sql .="WHERE Payment_id<>0";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( Payment_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR `Payment Method` LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
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
  $nestedData[] = $row["Payment_id"];
  $nestedData[] = $row["Payment_name"];
  $nestedData[] =$row["Payment Method"];
  //$nestedData[] = $row["customers_lastname"];
  $nestedData[] = $row["Online_Status"];
  $nestedData[] = $row["Status"];
  $nestedData[] = $row["Payment_image"];
  $nestedData[] = $row["date_added"];
  $nestedData[] = $row["date_modified"];
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
$query = "SELECT Payment_id,Payment_name,`Payment Method`,Online_Status,`Status`,Payment_image,date_added,date_modified
FROM payment_modules WHERE Payment_id = '".$catid."' ORDER BY Payment_id LIMIT 1";
//echo $query;
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
case "getconfig":
$catid = isset($_REQUEST['catid']) ? filter_var(($_REQUEST['catid']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$query = "SELECT *
FROM configuration
WHERE configuration_key LIKE '%".$catid."%' AND Module_Id=2";
//echo $query;
$result = $db->select($query);
$num_rows = mysqli_num_rows($result);
$html='';
if($num_rows > 0){
while($rows = mysqli_fetch_array($result)){
    //$response[] = $rows; // add return data to an array
    $html.='<tr><td>'.$rows["configuration_id"].'</td>
      <td contenteditable="true" onBlur="saveToDatabase(this,\'configuration_title\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["configuration_title"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'configuration_key\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["configuration_key"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'configuration_value\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["configuration_value"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'configuration_description\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["configuration_description"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'configuration_group_id\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["configuration_group_id"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'Module_Id\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["Module_Id"].'</td>
        <td contenteditable="true" onBlur="saveToDatabase(this,\'sort_order\','.$rows["configuration_id"].')" onClick="showEdit(this);">'.$rows["sort_order"].'</td>
        <td></td></tr>';


}
echo $html; // json encode that array
}
else
{
$response= array(0, 0, "Nothing Found");
echo json_encode($response);
}
break;
case "update":
$column= isset($_REQUEST['column']) ? filter_var(($_REQUEST['column']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$editval=isset($_REQUEST['editval']) ? filter_var(($_REQUEST['editval']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$configuration_id=isset($_REQUEST['configuration_id']) ? filter_var(($_REQUEST['configuration_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$sql= "UPDATE configuration set " . $column . " = '".$editval."' WHERE  configuration_id=".$configuration_id.";";
$result=$db->updatedb($sql);
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
