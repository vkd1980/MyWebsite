<?php
if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
exit("Unauthorized Access");
}
require_once (__DIR__.'/classes/global.inc.php');
if((isset($_REQUEST['Token']))&&(!empty($_REQUEST['page']))&&(!empty($_REQUEST['id']))&&(!empty($_REQUEST['type']))){
$str='';
$id	= 	filter_var(($_REQUEST['id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$page=  filter_var(($_REQUEST['page']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$type=  filter_var(($_REQUEST['type']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
switch($page){
case "signup.php" || "checkout.php" || "myprofile.php":
if ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/signup.php', $_SESSION['csrf_token']))) || (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token'])))|| (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/myprofile.php', $_SESSION['csrf_token'])))){
		switch($type){
			case "state":
			$DBC = new DB();
			$stmt = "SELECT * FROM states where country_id=$id";
		$result= $DBC->select($stmt);
			$str=$str."<option value='0'>Select State</option>";


				while ($row = mysqli_fetch_array($result)) {
				$str=$str."<option value='" . $row['state_id'] . "'>" . $row['state_name'] . "</option>";
				}
		echo $str;


			break;//State End
			case "city":
			$DBC = new DB();
			$con =$DBC->connect();
			$stmt = "SELECT * FROM cities where state_id=$id";
			$result = $DBC->select($stmt);
			$str=$str."<option value='0'>Select City</option>";
				while ($row = mysqli_fetch_array($result)) {
				$str=$str."<option value='" . $row['city_id'] . "'>" . $row['city_name'] . "</option>";
				}
		echo $str;
			break;//EOF city


			}//EOF Switch Type
}
else//Hash Checking Failed
{
echo'Invalid Access';
}
break;//Singup.php end

/*checkoutnew*/
case "checkout.php":
if ((hash_equals($_POST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token'])))){
		switch($type){
			case "state":
			$DBC = new DB();
			$stmt = "SELECT * FROM zones where zone_country_id=$id";
			$result = $DBC->select($stmt);
			$str=$str."<option value='0'>Select State</option>";


				while ($row = mysqli_fetch_array($result)) {
				$str=$str."<option value='" . $row['zone_id'] . "'>" . $row['zone_name'] . "</option>";
				}
		echo $str;


			break;//State End
			case "city":
			$DBC = new DB();
			$con =$DBC->connect();
			$stmt = "SELECT * FROM cities where state_id=$id";
			$result = $DBC->select($stmt);
			$str=$str."<option value='0'>Select City</option>";
				while ($row = mysqli_fetch_array($result)) {
				$str=$str."<option value='" . $row['city_id'] . "'>" . $row['city_name'] . "</option>";
				}
		echo $str;
			break;//EOF city


			}//EOF Switch Type
}
else//Hash Checking Failed
{
echo'Invalid Access';
}
break;//checkoutnew.php end

}//EOF Switch



}
else//Param Checking Failed
{
echo 'errr';
exit();
}
?>
