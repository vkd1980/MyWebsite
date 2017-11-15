<?php
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['action'])&& !empty($_REQUEST['gender'])&& !empty($_REQUEST['FirstName'])&& !empty($_REQUEST['LastName'])&& !empty($_REQUEST['street_address'])&& $_REQUEST['should_be_empty'] == ''&& !empty($_REQUEST['suburb'])&& !empty($_REQUEST['City'])&& !empty($_REQUEST['State'])&& !empty($_REQUEST['Country'])&& !empty($_REQUEST['pin'])&& !empty($_REQUEST['telephone'])&& !empty($_REQUEST['dob'])&& !empty($_REQUEST['Emaill'])&& !empty($_REQUEST['passwordnew'])&& !empty($_REQUEST['terms']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/signup.php', $_SESSION['csrf_token'])))){

$gender=filter_var($_REQUEST['gender'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$FirstName= filter_var($_REQUEST['FirstName'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$LastName=filter_var($_REQUEST['LastName'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
if (!empty($_REQUEST['company'])){
$company=filter_var($_REQUEST['company'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
} 
else{
$company='';
}
$street_address=filter_var($_REQUEST['street_address'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$suburb=filter_var($_REQUEST['suburb'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$City=filter_var($_REQUEST['City'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$State=filter_var($_REQUEST['State'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$Country=filter_var($_REQUEST['Country'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$pin=filter_var($_REQUEST['pin'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$telephone=filter_var($_REQUEST['telephone'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$dob=date("Y-m-d", strtotime($_REQUEST['dob']));
$Emaill=filter_var($_REQUEST['Emaill'],FILTER_SANITIZE_EMAIL);
$passwordnew=md5($_REQUEST['passwordnew']);
$terms=filter_var($_REQUEST['terms'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
//if (){
if (isset($_REQUEST['newsletter']) && !empty ($_REQUEST['newsletter']) && filter_var($_REQUEST['newsletter'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)=="on"){
	$newsl=true;
} 
else
{
$newsl=false;
}

//check whether User Name exists
if (!$customer->checkcustomer($Emaill)){
//Insert to Customer Table
$lastid=$customer->Insertcustomer($gender,$FirstName,$LastName,$dob,$Emaill,$telephone,$passwordnew,$newsl,false);
if ($lastid>0){
$CustAddress->InsertCustAddress($lastid,$gender,$company,$FirstName,$LastName,$street_address,$suburb,$pin,$City,$State,$Country,$State,'0');

//check whether Newsletter is subscribed 
			if($newsletter==true){
			//insert  and Send Mail for both
			//Insert 
			$newsletter = new Newsletter();
			$date = date('Y-m-d');
			$time = date('H:i:s');
			if(!$newsletter->checksubscription($Emaill)){
			$insertSignup= $newsletter->Inssubscription($Emaill,$date,$time);
			if($insertSignup){
				$message_html = file_get_contents('../email/Newsletter_sub_Verification.html');
				$message_html = str_replace('%username%', $Emaill, $message_html);
				$message_html = str_replace('%msg%', 'Thank you for Signing Up and Subscribing Newsletter', $message_html);
				$message_html = str_replace('%hash%', md5(md5($Emaill)), $message_html);
				$message_html = str_replace('%type%', 'Both', $message_html);
				$message_html = str_replace('%EMAIL_CONTACT_OWNER%', 'Regds, <br>PRABHUS BOOKS', $message_html);
					if(SendMailSmtp('admin@prabhusbooks.com','Admin-Prabhus Books',$Emaill,'Verify Your Email',$message_html,'','')){
						$Service="Signup";
						$status = "success";
						$message = "Almost Finished ! To Complete the Signing Process and subscription process Please click the Link in the Email we just sent you";
						   
					}
					else{
						$Service="Signup";
						$status = "error";
						$message = "Ooops, Theres been a technical error!"; 
						}
			}
			else {
			$Service="Signup";
            $status = "error";
            $message = "Ooops, Theres been a technical error!";  
           }
			////EOF 
			}
			
			else{

						
			//Send mail for Email Verification for Account Only
				$message_html = file_get_contents('../email/Newsletter_sub_Verification.html');
				$message_html = str_replace('%username%', $Emaill, $message_html);
				$message_html = str_replace('%msg%', 'Thank you for Signing Up', $message_html);
				$message_html = str_replace('%hash%', md5(md5($Emaill)), $message_html);
				$message_html = str_replace('%type%', 'Account', $message_html);
				$message_html = str_replace('%EMAIL_CONTACT_OWNER%', 'Regds, <br>PRABHUS BOOKS', $message_html);
				
						if(SendMailSmtp('admin@prabhusbooks.com','Admin-Prabhus Books',$Emaill,'Verify Your Email',$message_html,'','')){
							$Service="Signup";
							$status = "success";
							$message = "Almost Finished ! To Complete the Signing process Please click the Link in the Email we just sent you";
							   
						}
						else{
							$Service="Signup";
							$status = "error";
							$message = "Ooops, Theres been a technical error!"; 
							}
			////
			}
 }
}
else{
		$Service="Signup";
		$status = "info";
        $message = "Ooops, Theres been a technical error!";
		
}
}
else{
		$Service="Signup";
		$status = "error";
        $message = "This email address has already been registered!";
		
}
		
	//header("Location: ../message.php?service=".$Service."&status=".$status."&message=".$message);
	header("Location: ../message/msg-".preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $message))."-".$status."-".$Service.".html");
	  }
 
 else{//checkiing all post values
		$Service="Signup";
		$status = "error";
        $message = "Data missing !";
		header("Location: ../message/msg-".preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $message))."-".$status."-".$Service.".html");
		//header("Location: ../message.php?service=".$Service."&status=".$status."&message=".$message);
  		exit;
		
}

?>	