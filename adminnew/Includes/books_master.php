<?php
require_once 'global.inc.php';
//include 'configuration.php';

$action = $_REQUEST['action'];

switch($action) {
case "search":
$isbn = isset( $_REQUEST['isbn']) ? mysql_real_escape_string( $_REQUEST['isbn']) : '';
$query ="SELECT products.products_id, products.products_model, products.products_author, products.products_name, products.products_curid, currencies.symbol_left, currencies.value, products.products_rate, products.product_min_qty, products.products_quantity
FROM currencies RIGHT JOIN products ON currencies.currencies_id = products.products_curid
WHERE products.products_model='$isbn'";
$result = mysql_query($query) or die(mysql_error());
$num_rows = mysql_num_rows($result);
if($num_rows > 0){
while($rows = mysql_fetch_array($result)){
        $response = array( $rows['products_id'], $rows['products_model'], $rows['products_author'], $rows['products_name'],$rows['products_curid'],$rows['symbol_left'],$rows['value'],$rows['products_rate'],$rows['product_min_qty'],$rows['products_quantity']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Book is available with Code ".$isbn);
	echo json_encode($response);
	}
break;
}
?>