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
		$DBC= new DB();
		$result = $DBC->select("SELECT * FROM tbl_emp_master WHERE Emp_Code = '$empcode' AND Emp_Pass = '$hashedPassword'");
		if(mysqli_num_rows($result) == 1)
		{
		while ($row = mysqli_fetch_array($result)) {
    	$username= $row['Emp_Name']  ;
		$userid=$row['Emp_ID'];
		}
			$_SESSION['logged_in'] = 1;
			$_SESSION['login_time'] = date('d-m-Y h:i:s');
			//$_SESSION['FinYearID']= $FYid;
			$_SESSION['token'] = md5(rand(1000,9999));
			$_SESSION['username']=$username;
			$_SESSION['userid']=$userid;
			//$_SESSION["user"] = serialize(new User(mysql_fetch_assoc($result)));
			$token=$_SESSION['token'];
			setcookie('username', $username, time() + 1*24*60*60);
            setcookie('password', md5($password), time() + 1*24*60*60);
			return true;
		}else{
			return false;
		}
	}

	//Log the user out. Destroy the session variables.
	public function logout() {
		unset($_SESSION['logged_in']);
		unset($_SESSION['login_time']);
		//unset($_SESSION["FinYearID"]);
		unset($_SESSION['token'] );
		unset($_SESSION['username']);
		unset($_SESSION['userid']);
		session_destroy();
		setcookie('username', '', time() - 1*24*60*60);
        setcookie('password', '', time() - 1*24*60*60);
			}

	//Check to see if a username exists.
	//This is called during registration to make sure all user names are unique.
	public function checkUsernameExists($empcode) {
		$result = mysql_query("SELECT Emp_ID FROM tbl_emp_master_new WHERE Emp_Code='$empcode'");
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
		$result = $db->selectwhere('tbl_emp_master_new', "Emp_ID = $id");

		return new User($result);
	}

}

?>
