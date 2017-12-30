<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
//  $response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
  //exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/subject_master.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {

    case "search":
	$catid = isset($_REQUEST['catid']) ? filter_var(($_REQUEST['catid']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
	//$query = "SELECT * FROM categories WHERE categories_id='$catid'";
	$result = $db->selectwhere('categories',"categories_id=$catid");
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
    while($rows = mysqli_fetch_array($result)){
        $response = array( $rows['categories_id'], $rows['parent_id'], $rows['categories_name']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Subject is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;
	case "addnew":
	$categories_name = isset($_REQUEST['categories_name']) ? filter_var(($_REQUEST['categories_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
	$parent_id = isset($_REQUEST['parent_id']) ? filter_var(($_REQUEST['parent_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';


		$query = "INSERT INTO `categories` (`parent_id`,`categories_name`) VALUES ('" .$parent_id. "','" .$categories_name. "')";

	echo json_encode($db->insertdb($query));

	break;
	case "update":
	$categories_id = isset($_REQUEST['categories_id']) ? filter_var(($_REQUEST['categories_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
	$categories_name = isset($_REQUEST['categories_name']) ? filter_var(($_REQUEST['categories_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
	$parent_id = isset($_REQUEST['parent_id']) ? filter_var(($_REQUEST['parent_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';

	$query = "Update `categories` set `categories_name` = '" .$categories_name. "',`parent_id` = '" .$parent_id. "'WHERE `categories_id`='".$categories_id."' ";

echo json_encode($db->updatedb($query));
	break;
  case "All":
  // storing  request (ie, get/post) global array to a variable
  $requestData= $_REQUEST;
  $columns = array(
  // datatable column index  => database column name
  	0 =>'categories_id',
  	2 => 'categories_name',
    3 => 'parent_id');

  // getting total number records without any search

  $sql = "SELECT categories.categories_name AS catname,categories.parent_id AS parentcategory, categories.categories_id AS catid FROM categories ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
  $sql = "SELECT categories_name ,parent_id , categories_id  FROM categories ";
  $sql .="WHERE 1=1";
  //$sql="SET @row_number:=0; SELECT @row_number:=@row_number+1 AS row_number,categories_name,parent_id, categories_id FROM categories WHERE 1=1;"
  if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
  $sql.=" AND ( categories_name LIKE '".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' )";
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
    $nestedData[] = $row["categories_id"];
    $nestedData[] =$i;
  	$nestedData[] = $row["categories_name"];
  	//$nestedData[] = $row["parentcategory"];
    if ($row["parent_id"]==0){
      $nestedData[] = '-';
    }
    else{
      $nestedData[] = $category->getcatnamebyid($row["parent_id"]);
    }

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
