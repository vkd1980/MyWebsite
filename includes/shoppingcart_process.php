<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest')){
 exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');
if ((!empty($_REQUEST['action'])))
{
$action = nl2br(htmlspecialchars($_REQUEST['action']));
switch($action){
case "addToCart":
	if ((isset($_REQUEST['Token']))&&(!empty($_REQUEST['action']))&&(!empty($_REQUEST['ProdName']))&&(!empty($_REQUEST['ProdId']))&&(!empty($_REQUEST['ProdPrice']))&&(!empty($_REQUEST['ProQty']))&&(!empty($_REQUEST['ProWeight']))&&(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/products.php', $_SESSION['csrf_token'])))){
	$ProdName= filter_var($_REQUEST["ProdName"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$action = nl2br(htmlspecialchars($_REQUEST['action']));
	
	$ProductID = filter_var($_REQUEST['ProdId'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	//$ProdPrice = filter_var($_REQUEST['ProdPrice'], FILTER_VALIDATE_FLOAT, FILTER_FLAG_STRIP_HIGH);
	$ProdPrice = $_REQUEST['ProdPrice'];
	$ProdQty = filter_var($_REQUEST['ProQty'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$ProWeight = filter_var($_REQUEST['ProWeight'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	
		if($product->CheckspecialsbyID($ProductID,date("Y-m-d"))){
	
		$res= $product->getspecialsbyID($ProductID,date("Y-m-d"));
			if(mysqli_num_rows($res) > 0){
				while($rows =  mysqli_fetch_array($res)){
				$itemData = array(
				'id' => $ProductID,
				'name' => $rows['products_name'],
				'products_model' => $rows['products_model'],
				'price' => str_replace(',', '',$rows["special_price"]),
				'weight'=>$rows['products_weight'],
				'qty' => $ProdQty
			);
				}
			}
	
	}
		elseif($product->CheckfeaturedbyID($ProductID,date("Y-m-d"))){
			$res=$product->getfeaturedbyID($ProductID,date("Y-m-d"));
					if(mysqli_num_rows($res) > 0){
						while($rows =  mysqli_fetch_array($res)){
							$itemData = array(
							'id' => $ProductID,
							'name' => $rows['products_name'],
							'products_model' => $rows['products_model'],
							'price' => str_replace(',', '',$rows["products_price"]),
							'weight'=>$rows['products_weight'],
							'qty' => $ProdQty
							);
						}
				}
		}
		else{
		$res=$product->getprodbyid($ProductID);
				if(mysqli_num_rows($res) > 0){
						while($rows =  mysqli_fetch_array($res)){
							$itemData = array(
							'id' => $ProductID,
							'name' => $rows['products_name'],
							'products_model' => $rows['products_model'],
							'price' => str_replace(',', '',$rows["products_price"]),
							'weight'=>$rows['products_weight'],
							'qty' => $ProdQty
							);
						}
				}

		}
	
	
	
			
					if ($product->CheckQty($ProductID,$ProdQty))
					{
					$insertItem = $cart->insert($itemData);
					$redirectLoc = $insertItem?$data = array('status' => "Success",'message' => "Added ".$ProdName." to Your Cart"):$data = array('status' => "error",'message' => "An Error Has occured");;
					echo json_encode($data);
					exit;
					}
						else{
						$data = array('status' => "error",'message' => "Sorry this Product Is unavailable");;
						echo json_encode($data);
						exit;
						}
	
	
	}
	else//check all Post values
	{
	$data = array('status' => "error",'message' => "An Error Has occured");
	echo json_encode($data);
	exit;
	}
break;//Add to cart 
case "ShowCart":
echo ShowCartModal();
break;

case "removeCartItem":
if ($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id']) && ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/cart.php', $_SESSION['csrf_token'])))||(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token']))) ) ){

$deleteItem = $cart->remove(filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH));
echo $deleteItem?'ok':'err';die;
}
		else
		{
		echo'err';die;
		}
		
break;

case "updateCartItem":
if ($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id']) && !empty($_REQUEST['prodid']) && ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/cart.php', $_SESSION['csrf_token'])))||(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token']))) )){

$itemData = array(
            'rowid' => filter_var($_REQUEST['id'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH),
            'qty' => filter_var($_REQUEST['qty'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)
        );
				if ($product->CheckQty(filter_var($_REQUEST['prodid'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH),filter_var($_REQUEST['qty'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)))
					{
					$updateItem = $cart->update($itemData);
        			echo $updateItem?'ok':'err';die;
					}
					else
					{
					echo 'Stkerr';die;
					}
        
		}
		else
		{
		echo'err';die;
		}
break;		
		
case "ShowCartTotal":
$html='<span >';
if($cart->total_items() > 0){
		  $html= $html.'<a href="#cartModal" role="button" data-toggle="modal"> '.$cart->total_items().' Item(s) in your <i class="fa fa-shopping-cart " ></i> </a> - <span class="bold"><span class="fa fa-inr"></span> '.$cart->total().' </span> ';
		 }
		 else{
		  $html= $html.'<a href="#cartModal" role="button" data-toggle="modal"> Your cart is empty.....</a> - <span class="bold"><span class="fa fa-inr"></span> 0.00 </span> ';
		 }
	$html=$html.'</span >';
	echo $html;
break;
}//switch End
}//If action end

else//action
{
$data = array('status' => "error",'message' => "An Error Has occured");
echo json_encode($data);
exit;
}

/*
if(isset($_REQUEST['action']) && !empty($_REQUEST['action'])){
    if($_REQUEST['action'] == 'addToCart' && !empty($_REQUEST['id'])){
	 $action = nl2br(htmlspecialchars($_REQUEST['action']));
	 $productID = filter_var($_REQUEST['prodid'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
        // get product details
        $query = $db->query("SELECT * FROM products WHERE id = ".$productID);
        $row = $query->fetch_assoc();
        $itemData = array(
            'id' => $row['id'],
            'name' => $row['name'],
            'price' => $row['price'],
            'qty' => 1
        );
        
        $insertItem = $cart->insert($itemData);
        $redirectLoc = $insertItem?'viewCart.php':'index.php';
        header("Location: ".$redirectLoc);
    }elseif($_REQUEST['action'] == 'updateCartItem' && !empty($_REQUEST['id'])){
        $itemData = array(
            'rowid' => $_REQUEST['id'],
            'qty' => $_REQUEST['qty']
        );
        $updateItem = $cart->update($itemData);
        echo $updateItem?'ok':'err';die;
    }elseif($_REQUEST['action'] == 'removeCartItem' && !empty($_REQUEST['id'])){
        $deleteItem = $cart->remove($_REQUEST['id']);
        header("Location: viewCart.php");
    }elseif($_REQUEST['action'] == 'placeOrder' && $cart->total_items() > 0 && !empty($_SESSION['sessCustomerID'])){
        // insert order details into database
        $insertOrder = $db->query("INSERT INTO orders (customer_id, total_price, created, modified) VALUES ('".$_SESSION['sessCustomerID']."', '".$cart->total()."', '".date("Y-m-d H:i:s")."', '".date("Y-m-d H:i:s")."')");
        
        if($insertOrder){
            $orderID = $db->insert_id;
            $sql = '';
            // get cart items
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
                $sql .= "INSERT INTO order_items (order_id, product_id, quantity) VALUES ('".$orderID."', '".$item['id']."', '".$item['qty']."');";
            }
            // insert order items into database
            $insertOrderItems = $db->multi_query($sql);
            
            if($insertOrderItems){
                $cart->destroy();
                header("Location: orderSuccess.php?id=$orderID");
            }else{
                header("Location: checkout.php");
            }
        }else{
            header("Location: checkout.php");
        }
    }else{
        header("Location: index.php");
    }
}else{
    header("Location: index.php");
}*/