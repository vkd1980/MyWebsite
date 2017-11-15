<?php 
require_once 'global.inc.php';
    $selname = $_POST['selname'];
    $query = "SELECT * FROM tbl_emp_master WHERE Emp_Code='$selname'";
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
    while($rows = mysql_fetch_array($result)){
        $response = array($rows['Emp_Code'], $rows['Emp_Name'], $rows['Emp_Role']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Employee is Registered with Employee Code ".$selname);
	echo json_encode($response);
	}
	
    ?> 
