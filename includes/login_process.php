<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');

if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/login.php', $_SESSION['csrf_token'])))){
$Return = array('result'=>array(), 'error'=>'','camefrom'=>'');
$email =$_REQUEST['Email'];
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
	/*if($userTools->login($email, $password))
	{
	$Return['result'] ="ok";
	$Return['camefrom']=$camefrom;
	
	}
	elseif($customer->checkcustauthorisation($email)==false){
	$Return['error'] = 'Please Verify your Email';
		}
	else{
	
		$Return['error'] = 'Invalid Login Credential.';
	}*/
	output($Return);
}
else{
 $Return['error'] = "something went wrong.";
 output($Return);
}

?>