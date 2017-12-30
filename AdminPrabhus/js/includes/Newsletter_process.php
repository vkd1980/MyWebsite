<?php
/*if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  /*exit("Unauthorized Access");
}*/
require_once (__DIR__.'/classes/global.inc.php');

if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/includes/Newsletter.php', $_SESSION['csrf_token'])))){

$email =$_REQUEST['Email'];
$newsletter = new Newsletter();
if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
      	$status = "error";
        $message = "You have entered an invalid email address!";

    }


	 else {			//check whether subscribed or not

	 if($newsletter->checksubscription("'".$email."'")){

			$status = "error";
            $message = "This email address has already been registered!";
	 }
	 else{
	 //Insert
	 $date = date('Y-m-d');
     $time = date('H:i:s');
	$insertSignup= $newsletter->Inssubscription("'".$email."'","'".$date."'","'".$time."'");
	 if($insertSignup){
			$message_html = file_get_contents('../email/Newsletter_sub_Verification.html');
			$message_html = str_replace('%username%', $email, $message_html);
			$message_html = str_replace('%msg%', 'Thank you for Subscribing Newsletter', $message_html);
			$message_html = str_replace('%hash%', md5(md5($email)), $message_html);
			$message_html = str_replace('%type%', 'Newsletter', $message_html);
			$message_html = str_replace('%EMAIL_CONTACT_OWNER%', 'Regds, <br>PRABHUS BOOKS', $message_html);

			if(SendMailSmtp($email,'Verify Your Email',$message_html)){
			$status = "success";
            $message = "Almost Finished ! To Complete the subscription process Please click the Link in the Email we just sent you";

			}
			else
			{
			$status = "error";
            $message = "Ooops, Theres been a technical error!";
			}
               }
         else {
            $status = "error";
            $message = "Ooops, Theres been a technical error!";
           }

	 }

	 }
	//return json response
    $data = array(
        'status' => $status,
        'message' => $message
    );

    echo json_encode($data);

    exit;

}
else{

  			$status = "error";
            $message = "Ooops, Theres been a technical error!";
			$data = array(
        'status' => $status,
        'message' => $message
    );
	echo json_encode($data);
  exit;
}


?>
