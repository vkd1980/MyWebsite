<?php
require_once (__DIR__.'/includes/classes/global.inc.php');
if(!empty($_REQUEST['id']) && !empty($_REQUEST['Token'])&& !empty($_REQUEST['Type']) ){
$Service='';
$status='';
$message ='';
$type=filter_var($_REQUEST['Type'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$tkn = filter_var($_REQUEST['Token'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
switch($type){
case "Newsletter":
if(filter_var($_REQUEST['id'], FILTER_VALIDATE_EMAIL) === false) {
		$Service="NewsLetter";
      	$status = "error";
        $message = "You have entered an invalid email address!";
		
    }
	elseif(!hash_equals($tkn,md5(md5($_REQUEST['id']))))
	{
		$Service="NewsLetter";
		$status = "error";
        $message = "Invalid Access!";
	}
	elseif($newsletter->VerifySubscription($_REQUEST['id'],$tkn)){
		$Service="NewsLetter";
		$status = "success";
        $message = "You have Successfully Verified Email and Subscribed to our NewsLetter!";
		}
		else
		{
		$Service="NewsLetter";
		$status = "info";
        $message = "You have Already Verified Email and Subscribed to our NewsLetter!";
		}
		

break;
case "Account":
//Verify Customer Account Only
if(filter_var($_REQUEST['id'], FILTER_VALIDATE_EMAIL) === false) {
		$Service="Signup";
      	$status = "error";
        $message = "You have entered an invalid email address!";
		
    }
	elseif(!hash_equals($tkn,md5(md5($_REQUEST['id']))))
	{
		$Service="Signup";
		$status = "error";
        $message = "Invalid Access!";
	}
	else{
	if($customer->checkcustauthorisation($_REQUEST['id'])){
		$Service="Signup";
		$status = "info";
        $message = "You have Already Verified Email and Subscribed to our NewsLetter!";
	}
	elseif($customer->verifyaccount($_REQUEST['id']))
	{
		$Service="Signup";
		$status = "success";
        $message = "You have Successfully Verified your Email";
	}
	
	}
			
break;
case "Both":
//Verify both Account and Newsletter
if(filter_var($_REQUEST['id'], FILTER_VALIDATE_EMAIL) === false) {
		$Service="Signup";
      	$status = "error";
        $message = "You have entered an invalid email address!";
		
    }
	elseif(!hash_equals($tkn,md5(md5($_REQUEST['id']))))
	{
		$Service="Signup";
		$status = "error";
        $message = "Invalid Access!";
	}
	else{
	if($newsletter->VerifySubscription($_REQUEST['id'],$tkn)&& $customer->verifyaccount($_REQUEST['id']))
	{
		$Service="Signup";
		$status = "success";
        $message = "You have Successfully Verified Email and Subscribed to our NewsLetter!";
	}
	else
	{
		$Service="Signup";
		$status = "info";
        $message = "Something Went Wrong ";
	}
	}
	/*elseif($newsletter->VerifySubscription($_REQUEST['id'],$tkn)){
		$Service="Signup";
		$status = "success";
        $message = "You have Successfully Verified Email and Subscribed to our NewsLetter!";
		}
		else
		{
		$Service="Signup";
		$status = "info";
        $message = "You have Already Verified Email and Subscribed to our NewsLetter!";
		}*/
break;
}
header("Location: ../message/msg-".preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $message))."-".$status."-".$Service.".html");
}
?>