<?php
Header("Cache-Control: must-revalidate,Content-Type: application/json");
$offset = 60 * 60 * 24 * 3;
$ExpStr = "Expires: " . gmdate("D, d M Y H:i:s", time() + $offset) . " GMT";
Header($ExpStr);
//start the session
session_name('Admin');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
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

include(__DIR__.'/error_handler.class.php');
require_once (__DIR__.'/UserTools.class.php');
require_once (__DIR__.'/DB.class.php');
require_once (__DIR__.'/class.order.php');
require_once (__DIR__.'/definitions.php');
require_once (__DIR__.'/Functions.php');
require_once (__DIR__.'/category.class.php');
require_once (__DIR__.'/admin.class.php');
require_once (__DIR__.'/class.smtp.php');
require_once (__DIR__.'/class.phpmailer.php');
$path = $_SERVER['DOCUMENT_ROOT'];
$handler = new error_handler("127.0.0.1",1,6,NULL,$path.'/AdminPrabhus/error_logs/error.txt');
set_error_handler(array(&$handler, "handler"));
//require_once ( __DIR__.'/functions.php');
//connect to the database
$db = new DB();
$Admin = new admin();
$category = new category();
$order = new Order();
?>
