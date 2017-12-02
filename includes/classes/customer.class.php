<?php
//User.class.php

require_once (__DIR__.'/DB.class.php');


class customer{

public function Insertcustomer($customers_gender,$customers_firstname,$customers_lastname,$customers_dob,$customers_email_address,$customers_telephone,$customers_password,$customers_newsletter,$customers_authorization){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("INSERT INTO `customers` (`customers_gender`, `customers_firstname`, `customers_lastname`, `customers_dob`, `customers_email_address`, `customers_telephone`, `customers_password`, `customers_newsletter`, `customers_authorization`) VALUES ( ?, ?, ?, ?, ?, ?, ?, ?, ?)");
$stmt->bind_param('sssssssss', $customers_gender,$customers_firstname,$customers_lastname,$customers_dob,$customers_email_address,$customers_telephone,$customers_password,$customers_newsletter,$customers_authorization);
$stmt->execute();
$result = $stmt->insert_id;
return $result;
$stmt->close();
$con->close();
}

//Update
public function Updatecustomer($customers_id,$customers_gender,$customers_firstname,$customers_lastname,$customers_telephone,$customers_password)
{
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("UPDATE `customers` SET customers_gender=?,customers_firstname=?,customers_lastname=?,customers_telephone=?,customers_password=? WHERE  `customers_id`=?;");
$stmt->bind_param('ssssss',$customers_gender,$customers_firstname,$customers_lastname,$customers_telephone,$customers_password,$customers_id);
$stmt->execute();
$result=mysqli_affected_rows($con);
$stmt->close();
$con->close();
if ($result ==1)
{
return true;
}

else
{
return false;
}	}


public function checkcustomer($customers_email_address){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT customers_id
FROM 	customers
WHERE customers_email_address=?;");
$stmt->bind_param('s', $customers_email_address);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
if( mysqli_num_rows($result) == 1)
		{
		$con->close();
		return true;
		}
		else{
		$con->close();
		return false;
		}
}
public function checkcustauthorisation($customers_email_address){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT customers_authorization
FROM 	customers
WHERE customers_email_address=? AND customers_authorization=true;");
$stmt->bind_param('s', $customers_email_address);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();

if( mysqli_num_rows($result) == 1)
		{
		$con->close();
		return true;
		}
		else{
		$con->close();
		return false;
		}
}
public function verifyaccount($email){
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("UPDATE customers SET customers_authorization=TRUE
WHERE customers_email_address=?;");
$stmt->bind_param('s', $email);
$stmt->execute();
$result=mysqli_affected_rows($con);
$stmt->close();
$con->close();
if ($result ==1)
{
return true;
}
else
{
return false;
}
}

function updatepassword($newpwd,$custemail){
  $DBC = new DB();
  $stmt ="UPDATE customers SET customers_password= $newpwd WHERE customers_email_address=$custemail;";
  $result=$DBC->updatedb($stmt);
  return $result;
}
function getMobNumber($custemail){
  $DBC = new DB();
  $stmt ="SELECT customers_telephone
FROM customers
WHERE customers_email_address=$custemail
LIMIT 1";
  $result=$DBC->select($stmt);
	$value = mysqli_fetch_object($result);
  return $value->customers_telephone;
}
function getCustName($custemail){
  $DBC = new DB();
  $stmt ="SELECT customers_firstname
FROM customers
WHERE customers_email_address=$custemail
LIMIT 1";
  $result=$DBC->select($stmt);
	$value = mysqli_fetch_object($result);
  return $value->customers_firstname;
}

}

?>
