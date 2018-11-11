<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  $response= array("ERROR","Hacking attempt");
	echo json_encode($response);
  exit();
}
require_once (__DIR__.'/classes/global.inc.php');
require_once (__DIR__.'/classes/HTMLPuri/HTMLPurifier.auto.php');
$config = HTMLPurifier_Config::createDefault();
$purifier = new HTMLPurifier($config);
if(!empty($_REQUEST['Token']) && ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/book_master.php', $_SESSION['csrf_token'])))||(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/specials.php', $_SESSION['csrf_token'])))||(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/featured.php', $_SESSION['csrf_token'])))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "ModSearch":
	$catid = isset($_REQUEST['catid']) ? filter_var(($_REQUEST['catid']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
	$query = "SELECT products_model FROM products where products_model like '".$catid."%' ORDER BY products_model LIMIT 10";
	$result = $db->select($query);
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
    while($rows = mysqli_fetch_array($result)){
        $response[] = $rows['products_model']; // add return data to an array
    }
    echo json_encode($response); // json encode that array
	}
	else
	{
	$response= array(0, 0, "Nothing Found");
	echo json_encode($response);
}
	break;

  case "All":
  // storing  request (ie, get/post) global array to a variable
  $requestData= $_REQUEST;
  $columns = array(
  // datatable column index  => database column name
    0 =>'products_id',
    2 => 'products_model',
    3 => 'products_author',
    4 => 'products_name',
    5 =>'categories_name',
    6 =>'symbol_left',
    7 =>'products_rate',
    8 =>'value');

  // getting total number records without any search

  $sql = "SELECT products_id FROM products ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;  // when there is no search parameter then total number rows = total number filtered rows.
  $sql = "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products_rate,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id ";
  $sql .="WHERE 1=1";
  //$sql="SET @row_number:=0; SELECT @row_number:=@row_number+1 AS row_number,categories_name,parent_id, categories_id FROM categories WHERE 1=1;"
  if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( products.products_model LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR products.products_author LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR products.products_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR manufacturers.manufacturers_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR categories.categories_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' )";

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
    $nestedData[] = $row["products_id"];
    $nestedData[] =$i;
    $nestedData[] = $row["products_model"];
    $nestedData[] = $row["products_author"];
    $nestedData[] = $row["products_name"];
    $nestedData[] = $row["manufacturers_name"];
    $nestedData[] = $row["categories_name"];
    $nestedData[] = $row["symbol_left"];
    $nestedData[] = $row["products_rate"];
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
$query = "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,products.products_price,products.products_curid,products.product_min_qty,products.products_rate,products.products_weight,products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,products.products_edition,
products_description.products_description FROM (products
LEFT JOIN products_description ON products.products_id = products_description.products_id) WHERE products_model = '".$catid."' ORDER BY products_model LIMIT 1";
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
$products_quantity=isset($_REQUEST['products_quantity']) ? filter_var(($_REQUEST['products_quantity']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_model=isset($_REQUEST['products_model']) ? filter_var(($_REQUEST['products_model']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_image=isset($_REQUEST['products_image']) ? filter_var(($_REQUEST['products_image']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_price=isset($_REQUEST['products_price']) ? filter_var(($_REQUEST['products_price']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$products_curid=isset($_REQUEST['products_curid']) ? filter_var(($_REQUEST['products_curid']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$product_min_qty=isset($_REQUEST['product_min_qty']) ? filter_var(($_REQUEST['product_min_qty']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$products_rate=isset($_REQUEST['products_rate']) ? filter_var(($_REQUEST['products_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
//products_date_added
//products_last_modified
$products_weight=isset($_REQUEST['products_weight']) ? filter_var(($_REQUEST['products_weight']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$manufacturers_id=isset($_REQUEST['manufacturers_id']) ? filter_var(($_REQUEST['manufacturers_id']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$master_categories_id=isset($_REQUEST['master_categories_id']) ? filter_var(($_REQUEST['master_categories_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$products_name=isset($_REQUEST['products_name']) ? filter_var(($_REQUEST['products_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_author=isset($_REQUEST['products_author']) ? filter_var(($_REQUEST['products_author']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_edition=isset($_REQUEST['products_edition']) ? filter_var(($_REQUEST['products_edition']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$qry="INSERT INTO products (`products_quantity`,`products_model`,`products_image`,`products_price`,`products_curid`,`products_rate`,`products_weight`,`manufacturers_id`,`master_categories_id`,`products_name`,`products_author`,`products_edition`,`products_date_added`,`product_min_qty`)
VALUES('".$products_quantity."','".$products_model."','".$products_image."','".$products_price."','".$products_curid."','".$products_rate."','".$products_weight."','".$manufacturers_id."','".$master_categories_id."','".$products_name."','".$products_author."','".$products_edition."',now(),'".$product_min_qty."');";
$lastid=$db->insertID($qry);

if(!$lastid==0){
  if(!empty($_REQUEST['products_description'])){
  //$products_description=  $_REQUEST['products_description'];
  $products_description=  $purifier->purify($_REQUEST['products_description']);
    $qry="INSERT INTO `products_description` (`products_id`,`products_description`) VALUES ('".$lastid."','".$products_description."');";
  echo json_encode($db->insertdb($qry));
  }
  else{
    $response=array("OK", " Inserted Successfully",$lastid);
    echo json_encode($response);
  }
}
else{
  $response= array("ERROR","Something Went Wrong !");
	echo json_encode($response);
}

break;
/* bof Edit */
case "update":
$products_id=isset($_REQUEST['products_id']) ? filter_var(($_REQUEST['products_id']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_quantity=isset($_REQUEST['products_quantity']) ? filter_var(($_REQUEST['products_quantity']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_model=isset($_REQUEST['products_model']) ? filter_var(($_REQUEST['products_model']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_image=isset($_REQUEST['products_image']) ? filter_var(($_REQUEST['products_image']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_price=isset($_REQUEST['products_price']) ? filter_var(($_REQUEST['products_price']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$products_curid=isset($_REQUEST['products_curid']) ? filter_var(($_REQUEST['products_curid']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$product_min_qty=isset($_REQUEST['product_min_qty']) ? filter_var(($_REQUEST['product_min_qty']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$products_rate=isset($_REQUEST['products_rate']) ? filter_var(($_REQUEST['products_rate']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
//products_date_added
//products_last_modified
$products_weight=isset($_REQUEST['products_weight']) ? filter_var(($_REQUEST['products_weight']), FILTER_SANITIZE_NUMBER_FLOAT, FILTER_FLAG_ALLOW_FRACTION) : '';
$manufacturers_id=isset($_REQUEST['manufacturers_id']) ? filter_var(($_REQUEST['manufacturers_id']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$master_categories_id=isset($_REQUEST['master_categories_id']) ? filter_var(($_REQUEST['master_categories_id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$products_name=isset($_REQUEST['products_name']) ? filter_var(($_REQUEST['products_name']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_author=isset($_REQUEST['products_author']) ? filter_var(($_REQUEST['products_author']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$products_edition=isset($_REQUEST['products_edition']) ? filter_var(($_REQUEST['products_edition']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$data = array(
    "products_quantity" => "'$products_quantity'",
"products_model" => "'$products_model'",
"products_image" => "'$products_image'",
"products_price" => "'$products_price'",
"products_curid" => "'$products_curid'",
"products_rate" => "'$products_rate'",
"products_weight" => "'$products_weight'",
"manufacturers_id" => "'$manufacturers_id'",
"master_categories_id" => "'$master_categories_id'",
"products_name" => "'$products_name'",
"products_author" => "'$products_author'",
"products_edition" => "'$products_edition'",
"product_min_qty" => "'$product_min_qty'"  );
$result=$db->update($data, 'products', 'products_id = '.$products_id);
if($result==true){
  if(!empty($_REQUEST['products_description'])){
  //$products_description=  $_REQUEST['products_description'];
  $products_description=  $purifier->purify($_REQUEST['products_description']);
    $qry="UPDATE `products_description` SET`products_description`='".$products_description."' WHERE  `products_id`='".$products_id."';";
  $db->updatedb($qry);
  $response=array("OK", " Edited Successfully");
  echo json_encode($response);
  }
  else{
    $response=array("OK", " Inserted Successfully");
    echo json_encode($response);
  }
}
else{
  $response= array("ERROR","Something Went Wrong !");
	echo json_encode($response);
}

break;
/* eof Edit */


  }
}
else{
  $response= array("ERROR","Invalid Access");
	echo json_encode($response);
}

?>
