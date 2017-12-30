<?php
Header("Cache-Control: must-revalidate,Content-Type: application/json");
$offset = 60 * 60 * 24 * 3;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
Header($ExpStr);
//start the session
session_name('Shop');
session_start();
date_default_timezone_set('Asia/Kolkata');
/*if(empty($_SESSION['token'])){
$_SESSION['token'] = md5(session_id());
}*/
if (empty($_SESSION['csrf_token'])) {
    if (function_exists('mcrypt_create_iv')) {
        $_SESSION['csrf_token'] = bin2hex(mcrypt_create_iv(32, MCRYPT_DEV_URANDOM));
    } else {
        $_SESSION['csrf_token'] = bin2hex(openssl_random_pseudo_bytes(32));
    }
}
Global $Token;
Global $title;
Global $meta;
//$Token = $_SESSION['token'];
//ob_start("ob_gzhandler");

/*error_reporting(E_ALL);
ini_set('display_errors', '1');*/
include(__DIR__.'/error_handler.class.php');
require_once (__DIR__.'/UserTools.class.php');
require_once (__DIR__.'/DB.class.php');
require_once (__DIR__.'/products.class.php');
require_once (__DIR__.'/category.class.php');
require_once (__DIR__.'/manufacturers.class.php');
require_once (__DIR__.'/recentview.class.php');
require_once (__DIR__.'/numtochar.class.php');
require_once (__DIR__.'/newsletter.class.php');
require_once (__DIR__.'/Functions.php');
require_once (__DIR__.'/definitions.php');
require_once (__DIR__.'/class.smtp.php');
require_once (__DIR__.'/customer.class.php');
require_once (__DIR__.'/Address.class.php');
require_once (__DIR__.'/review.class.php');
require_once (__DIR__.'/class.phpmailer.php');
require_once (__DIR__.'/shoppingcart.class.php');
require_once (__DIR__.'/class.order.php');
$path = $_SERVER['DOCUMENT_ROOT'];
$handler = new error_handler("127.0.0.1",1,6,NULL,$path.'/error_logs/error.txt');
set_error_handler(array(&$handler, "handler"));
//require_once ( __DIR__.'/functions.php');
//connect to the database
$db = new DB();
$product = new products();
$category = new category();
$newsletter =new  Newsletter();
$manufacturers = new manufacturers();
$recentview = new recentview();
$spellnum = new num_to_string();
$customer= new customer();
$CustAddress= new CustAddress();
$review= new Review();
$cart= new ShoppingCart();
$order= new Order();
//$customer= new User();
$db->connect();

//$_SESSION['logged_in'] = 1;

//if(isset($_SESSION['logged_in'])) {
//$token = $_SESSION['token'];}
//initialize UserTools object
//$userTools = new UserTools();
//refresh session variables if logged in
//if(isset($_SESSION['logged_in'])) {
//	$user = unserialize($_SESSION['user']);
//	$_SESSION['user'] = serialize($userTools->get($user->Emp_ID));
//}

?>
