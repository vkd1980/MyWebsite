<?php
//UserTools.class.php
require_once  (__DIR__.'/User.class.php');
require_once (__DIR__.'/DB.class.php');

class UserTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login($empcode, $password)
	
	{
		global $token;
		$hashedPassword = md5($password);
		$DBC = new DB();
		$qry="SELECT * FROM customers WHERE customers_email_address = '$empcode' AND customers_password = '$hashedPassword'";
		$result = $DBC->select($qry);

		if( mysqli_num_rows($result) == 1)
		{
		while ($row = mysqli_fetch_array($result)) {
    	$username= $row['customers_email_address']  ;
		$userid=$row['customers_id'];
		$Name=$row['customers_firstname'].''.$row['customers_lastname'];
		}
		$myarray=array($userid,$username,$Name);
		$_SESSION['logged_in'] = 1;
		$_SESSION['UserData']=$myarray;
			return true;
		}else{
			return false;
		}
	}
	
	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['UserData']);
		unset($_SESSION['logged_in']);
		session_destroy();
		if (!isset($_SESSION['UserData']) && !isset($_SESSION['UserData']))
		{
		return true;
		}
		else
		{
		return false;
		}
		}

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkUsernameExists($empcode) {
	$DBC = new DB();
		$qry="SELECT Emp_ID FROM tbl_emp_master_new WHERE Emp_Code='$empcode'";
		$result = $DBC->select($qry);
    	if(mysqli_num_rows($result) == 0)
    	{
			return false;
	   	}else{
	   		return true;
		}
	}
	
	//get a user
	//returns a User object. Takes the users id as an input
	public function get($id)
	{
		$db = new DB();
		$result = $db->selectwhere('tbl_emp_master_new', "Emp_ID = $id");
		
		return new User($result);
	}
	
}

?>