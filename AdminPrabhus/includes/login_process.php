<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
  exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/AdminPrabhus/login.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['process']) ){
  $process=filter_var($_REQUEST['process'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
   switch ($process) {
     case 'logging':
  $status='';
  $message ='';
    $email =filter_var(($_REQUEST['Email']), FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
    $password =$_REQUEST['Password'];
    $Location ='' ;
    $userTools = new UserTools();
    if(filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
        $status = "Error";
        $message = "Please enter a valid Email address.";

        }elseif($password===''){
            $status = "Error";
            $message = "Please enter Password.";
        }
        if($status =="Error"){
          $data = array(
            'status' => $status,
            'message' => $message
        );

        echo json_encode($data);
        }
    		if ($Admin->checkAdmin("'".$email."'")){
    					if($userTools->login($email, $password))
    					{
               $status = "success";
    					$message = "Logged In";
              $Location ="./index.php";
    					}
    					else{
                $status = "Error";
                $message = 'Invalid Login Credential.';
    					}
    		}
    		else{
          $status = "Error";
          $message = 'You have not registered with us!';
    		}
        $data = array(
          'status' => $status,
          'message' => $message,
          'Location'=>$Location
      );

      echo json_encode($data);
      break;

   }
}
else{
  $status = "Error";
  $message = "something went wrong.";
  $data = array(
    'status' => $status,
    'message' => $message
  );

  echo json_encode($data);
}

?>
