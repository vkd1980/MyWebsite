<?php
require_once (__DIR__.'/DB.class.php');
class Newsletter{
public function checksubscription($email){
$DBC = new DB();
$stmt = "SELECT * FROM newslettersub WHERE newslettersub_email_address= $email LIMIT 1";
$result= $DBC->select($stmt);
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
$stmt = "INSERT INTO newslettersub (newslettersub_email_address,newslettersub_date,newslettersub_time,newslettersub_hash) VALUES($newslettersub_email_address,$newslettersub_date,$newslettersub_time,md5(md5($newslettersub_email_address)))";
echo $stmt;
$result=$DBC->insertID($stmt);
if ($result <>0)
{
return True;
}
else
{
return False;
}
}
//Verify Subscription
public function VerifySubscription($email,$tkn){
$DBC = new DB();
$stmt = "SELECT * FROM newslettersub WHERE newslettersub_email_address=$email and newslettersub_hash=$tkn and newslettersub_verify=0";
$result= $DBC->select($stmt);
if( mysqli_num_rows($result) == 1)
		{
		$stmt ="UPDATE newslettersub SET newslettersub_verify=TRUE
WHERE newslettersub_email_address=$email AND newslettersub_hash=$tkn;";
		$result= $DBC->updatedb($stmt);
		return true;
		}
		else{
		return false;
		}
}

}

?>
