<?php
//start the session
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
//include(__DIR__.'/classes/error_handler.class.php');
//$handler = new error_handler("127.0.0.1",1,1,NULL,'/error_logs/error.txt');
//set_error_handler(array(&$handler, "handler"));
require_once (__DIR__.'/classes/User.class.php');
require_once (__DIR__.'/classes/UserTools.class.php');
require_once (__DIR__.'/classes/DB.class.php');
require_once ( __DIR__.'/functions.php');
//connect to the database
$db = new DB();
$db->connect();
//initialize UserTools object
$userTools = new UserTools();
//refresh session variables if logged in
if(isset($_SESSION['logged_in'])) {
	$user = unserialize($_SESSION['user']);
	$_SESSION['user'] = serialize($userTools->get($user->Emp_ID));
}

?>