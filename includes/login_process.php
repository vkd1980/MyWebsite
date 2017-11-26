<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');

if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/login.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['process']) ){
  $process=filter_var($_REQUEST['process'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
  switch ($process) {
    case 'logging':
    $Return = array('result'=>array(), 'error'=>'','camefrom'=>'');
    //$email =$_REQUEST['Email'];
    $email =filter_var(($_REQUEST['Email']), FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
    $password =$_REQUEST['Password'];
    $camefrom = filter_var($_REQUEST['camefrom'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
    $userTools = new UserTools();
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
            $Return['error'] = "Please enter a valid Email address.";

        }elseif($password===''){
            $Return['error'] = "Please enter Password.";
        }
        if($Return['error']!=''){
            output($Return);
        }
    		if ($customer->checkcustomer($email)){
    					if($userTools->login($email, $password))
    					{
    					$Return['result'] ="ok";
    					$Return['camefrom']=$camefrom;

    					}
    					else{

    						$Return['error'] = 'Invalid Login Credential.';
    					}
    		}
    		else{
    			$Return['error'] = 'You have not registered with us!';
    		}
    	output($Return);
      break;

    case 'forgetpwd':
      $email =filter_var(($_REQUEST['ForgotEmail']), FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
      if ($customer->checkcustomer($email)){
        $newpwdstring=generateRandomString('6');
        $message_html = file_get_contents('../email/email_forget_password.html');
        $message_html = str_replace('%newpassword%', $newpwdstring, $message_html);
        $newpwd= md5($newpwdstring);
            if($customer->updatepassword("'".$newpwd."'","'".$email."'") && SendMailSmtp($email,'Your New Password',$message_html)){
              ;
              $status = "success";
              $message = "We have send an Email containing new password to ".hideEmail($email);
            }
            else{
              $status = "Error";
              $message = "Something Went Wrong !";
            }

      }
      else{
        $status = "Error";
        $message = "You have not registered with us!";
      }
      $data = array(
            'status' => $status,
            'message' => $message
        );

        echo json_encode($data);
      break;
  }

}
else{
 $Return['error'] = "something went wrong.";
 output($Return);
}

?>
