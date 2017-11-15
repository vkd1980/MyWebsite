<?php
require_once 'global.inc.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
	
	case "search":
	$catid = isset($_REQUEST['catid']) ? mysql_real_escape_string($_REQUEST['catid']) : '';
	$query = "SELECT products.products_id, products.products_model,
 products_description.products_author, products_description.products_name,products.products_rate,
 products.products_quantity,products.master_categories_id
FROM products
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE products.products_id=$catid;";
	//$result = mysql_query($query) or die(mysql_error());
	$result = $db->select($query );
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
    while($rows = mysql_fetch_array($result)){
        $response = array( $rows['products_id'], $rows['products_model'],$rows['products_author'],$rows['products_name'],$rows['products_quantity'],$rows['products_rate']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Manufacture is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;
	
	
	case "update":
	$products_id = isset($_REQUEST['products_id']) ? mysql_real_escape_string($_REQUEST['products_id']) : '';
	$products_quantity = isset($_REQUEST['products_quantity']) ? mysql_real_escape_string($_REQUEST['products_quantity']) : '';
	
	$query = "Update `products` set `products_quantity` = '" .$products_quantity. "' Where `products_id`='".$products_id."' ";
		
	echo json_encode($db->updatedb($query));
	/*if(mysql_affected_rows() > 0){
	$response=array("OK", $manufacturers_name." Edited Successfully");
	echo json_encode($response);
	}else{
	$response=array("ERROR","No Action Taken");
	echo json_encode($response);
	}*/

	break;
	}
	}
	else
	{$response= array("ERROR", "Hacking attempt");
	echo json_encode($response);}
	}
	else{
	$response= array("ERROR", "Invalid Access");
	echo json_encode($response);
	}
?>