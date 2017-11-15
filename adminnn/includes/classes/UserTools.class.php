<?php
//UserTools.class.php

require_once  (__DIR__.'/User.class.php');
require_once (__DIR__.'/DB.class.php');

class UserTools {

	//Log the user in. First checks to see if the 
	//username and password match a row in the database.
	//If it is successful, set the session variables
	//and store the user object within.
	public function login($empcode, $password,$FYid)
	
	{
		
		$hashedPassword = md5($password);
		$result = mysql_query("SELECT * FROM tbl_emp_master WHERE Emp_Code = '$empcode' AND Emp_Pass = '$hashedPassword'");

		if(mysql_num_rows($result) == 1)
		{
			$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$_SESSION["login_time"] = time();
			$_SESSION["logged_in"] = 1;
			$_SESSION["FinYearID"]= $FYid;
			  //you can use any encryption
			$_SESSION['token'] = md5(rand(1000,9999));
			return true;
		}else{
			return false;
		}
	}
	
	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['user']);
		unset($_SESSION['login_time']);
		unset($_SESSION['logged_in']);
		unset($_SESSION["FinYearID"]);
		unset($_SESSION['start']);
		unset($_SESSION['expire']);
		unset($_SESSION['token'] );
		session_destroy();
			}

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkUsernameExists($empcode) {
		$result = mysql_query("SELECT Emp_ID FROM tbl_emp_master WHERE Emp_Code='$empcode'");
    	if(mysql_num_rows($result) == 0)
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
		$result = $db->select('tbl_emp_master', "Emp_ID = $id");
		
		return new User($result);
	}
	
}

?>