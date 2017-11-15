<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_POST['Token']) && !empty($_POST['senderName'])&& !empty($_POST['senderEmail'])&& !empty($_POST['PhoneNumber'])&& !empty($_POST['message'])&& isset($_POST['url']) && $_POST['url'] == '' && (hash_equals($_POST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/contact.php', $_SESSION['csrf_token'])))){

$senderName = isset( $_POST['senderName'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['senderName'] ) : "";
$senderEmail = isset( $_POST['senderEmail'] ) ? preg_replace( "/[^\.\-\_\@a-zA-Z0-9]/", "", $_POST['senderEmail'] ) : "";
//$message = isset( $_POST['message'] ) ? preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "", $_POST['message'] ) : "";
$message = nl2br(htmlspecialchars($_POST['message']));
$message=preg_replace( "/(From:|To:|BCC:|CC:|Subject:|Content-Type:)/", "",$message);
$phone=isset( $_POST['PhoneNumber'] ) ? preg_replace( "/[^\.\-\' a-zA-Z0-9]/", "", $_POST['PhoneNumber'] ) : "";

if(filter_var($_POST['senderEmail'], FILTER_VALIDATE_EMAIL) === false) {
		$status = "error";
        $message = "You have entered an invalid email address!";
}

else{
//send mail
			$message_html = file_get_contents('../email/email_contact_us.html');
			$message_html = str_replace('%FROM%', $senderName, $message_html);
			$message_html = str_replace('%PHONE%', $phone, $message_html);
			$message_html = str_replace('%EMAIL%', $senderEmail, $message_html);
			$message_html = str_replace('%MESSAGE%', $message, $message_html);
			if(isset($_SESSION['logged_in'])){
			$message_html = str_replace('%LOGIN%', $_SESSION['UserData'][2], $message_html);
			$message_html = str_replace('%LOGIN MAIL%', $_SESSION['UserData'][1], $message_html);
			}
			else
			{
			$message_html = str_replace('%LOGIN%', 'Not Logged in', $message_html);
			$message_html = str_replace('%LOGIN MAIL%', 'Not Logged in', $message_html);
			}
			$message_html = str_replace('%IPADDRESS%', get_ip_address(), $message_html);
			$message_html = str_replace('%DATE%',  date('Y-m-d H:i:s') , $message_html);
			if(SendMailSmtp('admin@prabhusbooks.com','Admin-Prabhus Books','admin@prabhusbooks.com','Website Inquiry from Prabhus Books',$message_html,$senderEmail,$senderName)){
			$status = "success";
            $message = "Thanks for sending your message! We'll get back to you shortly.";
			   		   
			}
			else
			{
			$status = "error";
            $message = "There was a problem sending your message. Please try again!"; 
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

else{//checkiing all post values

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


