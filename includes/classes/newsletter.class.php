<?php
require_once (__DIR__.'/DB.class.php');
class Newsletter{
public function checksubscription($email){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT * FROM newslettersub WHERE newslettersub_email_address= ? LIMIT 1");
$stmt->bind_param('s', $email);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
if( mysqli_num_rows($result) == 1)
		{
		return true;
		}
		else{
			return false;
		}
}
//Insert to DB
public function Inssubscription($newslettersub_email_address,$newslettersub_date,$newslettersub_time){
$DBC = new DB();
$con =$DBC->connect();
$md=md5($newslettersub_email_address);
$stmt = $con->prepare("INSERT INTO newslettersub (newslettersub_email_address,newslettersub_date,newslettersub_time,newslettersub_hash) VALUES(?,?,?,md5(?))");
$stmt->bind_param('ssss', $newslettersub_email_address,$newslettersub_date,$newslettersub_time,$md);
$stmt->execute();
//$result = $stmt->get_result();
$result=mysqli_affected_rows($con);
$stmt->close();
$con->close();
if ($result ==1)
{
return True;
}
//$result= $DBC->InsertDBphp($qry);
else
{
return False;
}		
}
//Verify Subscription
public function VerifySubscription($email,$tkn){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT * FROM newslettersub WHERE newslettersub_email_address=? and newslettersub_hash=? and newslettersub_verify=0");
$stmt->bind_param('ss', $email,$tkn);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
//$con->close();
if( mysqli_num_rows($result) == 1)
		{
		$stmt = $con->prepare("UPDATE newslettersub SET newslettersub_verify=TRUE
WHERE newslettersub_email_address=? AND newslettersub_hash=?;");
		$stmt->bind_param('ss', $email,$tkn);
		$stmt->execute();
		$result = $stmt->get_result();
		$stmt->close();
		$con->close();
		return true;
		}
		else{
		return false;
		}
}

}

?>
