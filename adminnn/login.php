<?php
//login.php

require_once 'includes/global.inc.php';

$error = "";
$username = "";
$password = "";
$FYid= "";

//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 

	$username = $_POST['username'];
	$password = $_POST['password'];
	$FYid= $_POST['cmbfinyear'];

	$userTools = new UserTools();
	if($userTools->login($username, $password,$FYid)){
		//successful login, redirect them to a page
		header("Location: index.php");
	}else{
		$error = "Incorrect username or password. Please try again.";
	}
}
?>

<html>
<head>
	<title>Login</title>
</head>
<body>
<?php
if($error != "")
{
    echo $error."<br/>";
}
?>
	<form action="login.php" method="post">
	    <p>Username: 
	      <input type="text" name="username" value="<?php echo $username; ?>" />
	      <br/>
	    Password: 
	    <input type="password" name="password" value="<?php echo $password; ?>" />
	    <br/>
		 FinYear:
		<?php
		$sql = "SELECT Finyear_ID,Finyear FROM tbl_finyear_master 	";
		
$result = mysql_query($sql);

echo "<select name='cmbfinyear'>";
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Finyear_ID'] . "'>" . $row['Finyear'] . "</option>";
}
echo "</select>";
?>
		<br/>
	      
          <input type="submit" value="Login" name="submit-login" />
      </p>
</form>
</body>
</html>