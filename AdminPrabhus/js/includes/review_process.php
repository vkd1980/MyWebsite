<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');
if ((isset($_REQUEST['Token']))&&(!empty($_REQUEST['custid']))&&(!empty($_REQUEST['prodid']))&&(!empty($_REQUEST['Custname']))&&(!empty($_REQUEST['rating']))&&(!empty($_REQUEST['reviews'])) &&(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/products.php', $_SESSION['csrf_token'])))){

$reviews_text = nl2br(htmlspecialchars($_REQUEST['reviews']));
$customers_id = filter_var($_REQUEST['custid'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$customers_name = filter_var($_REQUEST["Custname"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$reviews_rating = filter_var($_REQUEST['rating'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$prod_id = filter_var($_REQUEST['prodid'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);

 if($review->checkreveiw($prod_id,$customers_id)){

$data = array('status' => "error",'message' => "You have Already Reviewed this Book!! ");
echo json_encode($data);
exit;
	 }
	 else{
	 	$insertreview= $review->savereveiw($prod_id,$customers_id,"'".$customers_name."'",$reviews_rating,"'".date('Y/m/d H:i:s')."'","'".date('Y/m/d H:i:s')."'",1,"'".$reviews_text."'");

		 if($insertreview){

	 $data = array('status' => "success",'message' => "THANK YOU for your Review on this Book!! ");
echo json_encode($data);
exit;
	 }
	 else{
	 $data = array('status' => "error",'message' => "Something Went wrong Please try Again Later");
echo json_encode($data);
exit;
	 }
	 //ok
	 }

/*$data = array('status' => "success",'message' => $reviews_text." / ".$customers_id." / ".$customers_name." / ".$reviews_rating." / ".$prod_id);
echo json_encode($data);
exit;*/
}

 else{

  $data = array('status' => "error",'message' => "Ooops, An Error Occurred!");

    echo json_encode($data);

    exit;

  }



?>
