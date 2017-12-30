<?php
require_once (__DIR__.'/DB.class.php');
class admin{
  public function checkAdmin($customers_email_address){
$DBC = new DB();
$stmt = "SELECT Emp_ID
FROM 	tbl_emp_master
WHERE Emp_Email=$customers_email_address LIMIT 1;";
$result = $DBC->select($stmt);
if( mysqli_num_rows($result) == 1)
		{
		return true;
		}
		else{
		return false;
		}
}
}
?>
