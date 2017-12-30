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
		$qry="SELECT * FROM tbl_emp_master WHERE Emp_Email = '$empcode' AND Emp_Pass = '$password'";
		$result = $DBC->select($qry);

		if( mysqli_num_rows($result) == 1)
		{
		while ($row = mysqli_fetch_array($result)) {
    $username= $row['Emp_Code']  ;
		$userid=$row['Emp_ID'];
		$Name=$row['Emp_Name'];
		}
		$myarray=array($userid,$username,$Name);
		$_SESSION['Adm_logged_in'] = 1;
		$_SESSION['Adm_UserData']=$myarray;
			return true;
		}else{
			return false;
		}
	}

	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['Adm_logged_in']);
		unset($_SESSION['Adm_UserData']);
		session_destroy();
		if (!isset($_SESSION['Adm_UserData']) && !isset($_SESSION['Adm_UserData']))
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
		$qry="SELECT Emp_ID FROM tbl_emp_master WHERE Emp_Code='$empcode'";
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
		$result = $db->selectwhere('tbl_emp_master', "Emp_ID = $id");

		return new User($result);
	}

}

?>
