<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  //$response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
//  exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/publisher_master.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "search":
	$catid = isset($_REQUEST['catid']) ? filter_var(($_REQUEST['catid']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
	$query = "SELECT * FROM manufacturers WHERE manufacturers_id='$catid'";
	//$result = mysql_query($query) or die(mysql_error());
	$result = $db->selectwhere('manufacturers',"manufacturers_id=$catid");
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
    while($rows = mysqli_fetch_array($result)){
        $response = array( $rows['manufacturers_id'], $rows['manufacturers_name']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Manufacture is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;

	case "addnew":
	$manufacturers_name = isset($_REQUEST['manufacturers_name']) ? filter_var(($_REQUEST['manufacturers_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';

		$query = "INSERT INTO `manufacturers` (`manufacturers_name`,`date_added`,`last_modified`) VALUES ('" . $manufacturers_name . "', now(),now() )";

	echo json_encode($db->insertdb($query));

	break;
	case "update":
	$manufacturers_id = isset($_REQUEST['manufacturers_id']) ? filter_var(($_REQUEST['manufacturers_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
	$manufacturers_name = isset($_REQUEST['manufacturers_name']) ? filter_var(($_REQUEST['manufacturers_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';


	$query = "Update `manufacturers` set `manufacturers_name` = '" .$manufacturers_name. "',`last_modified` = now() Where `manufacturers_id`='".$manufacturers_id."' ";

	echo json_encode($db->updatedb($query));


	break;
  case "All":
  // storing  request (ie, get/post) global array to a variable
  $requestData= $_REQUEST;
  $columns = array(
  // datatable column index  => database column name
    0 =>'manufacturers_id',
    2 => 'manufacturers_name');

  // getting total number records without any search

  $sql = "SELECT manufacturers_name ,manufacturers_id FROM manufacturers ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
  $sql = "SELECT manufacturers_name ,manufacturers_id FROM manufacturers ";
  $sql .="WHERE 1=1";
  //$sql="SET @row_number:=0; SELECT @row_number:=@row_number+1 AS row_number,categories_name,parent_id, categories_id FROM categories WHERE 1=1;"
  if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( manufacturers_name LIKE '".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' )";
    //$sql.=" OR parent_id LIKE '".$requestData['search']['value']."%' )";
  }
  //$db->select($ssql);
  $query=$db->select($sql);
  $totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
  $sql.=" ORDER BY ". $columns[filter_var(($requestData['order'][0]['column']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)]."   ".filter_var(($requestData['order'][0]['dir']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."  LIMIT ".filter_var(($requestData['start']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ,".filter_var(($requestData['length']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ";
  /* $requestData['order'][0]['column'] contains colmun index, $requestData['order'][0]['dir'] contains order such as asc/desc  */
  $query=$db->select($sql);

  $data = array();
  $i=1;
  while( $row=mysqli_fetch_array($query) ) {  // preparing an array
    $nestedData=array();
    $nestedData[] = $row["manufacturers_id"];
    $nestedData[] =$i;
    $nestedData[] = $row["manufacturers_name"];
    $data[] = $nestedData;
    $i++;
  }
  $json_data = array(
        "draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
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
