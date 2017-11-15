<?php
//start the session
session_name('Admin');
session_start();
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once (__DIR__.'/classes/UserTools.class.php');
require_once (__DIR__.'/classes/DB.class.php');
require_once (__DIR__.'/classes/numtochar.class.php');
//require_once ( __DIR__.'/functions.php');
//connect to the database
$db = new DB();
$spellnum = new num_to_string();
$db->connect();
if(isset($_SESSION['logged_in'])) {
$token = $_SESSION['token'];}
//initialize UserTools object
//$userTools = new UserTools();
//refresh session variables if logged in
//if(isset($_SESSION['logged_in'])) {
//	$user = unserialize($_SESSION['user']);
//	$_SESSION['user'] = serialize($userTools->get($user->Emp_ID));
//}

?>