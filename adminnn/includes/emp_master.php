<?php
require_once 'global.inc.php';
//include 'configuration.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {

	case "load":
		$query 	= mysql_query("SELECT tbl_emp_master.*, tblsecurityaccess.AccessTitle FROM tblsecurityaccess RIGHT JOIN tbl_emp_master ON tblsecurityaccess.AccessID = tbl_emp_master.Emp_Role Order by Emp_Code Asc");
		$count  = mysql_num_rows($query);
if($count > 0) {
			while($fetch = mysql_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$responsetext = "<div class='panel panel-primary well'>
            		<table class='table table-condensed table-striped table-hover'>
					<thead><tr class='alert alert-info'><th>Sno</div></th>
               <th>Code</div></th>
              <th>Name</div></th>
               <th>Role</div></th>
              <th>Address</div></th>
              <th>State</div></th>
			  <th>Country</div></th>
              <th>Phone</div></th>
              <th>Email</div></th>
               <th>Actions</div></th>
            </tr></thead><tbody></tr></thead><tbody>";
			if($count <= 0) {
			echo "<tr id='norecords'>
                <td colspan='12' align='center'>No records found <a href='addnew' id='gridder_insert' class='gridder_insert'><img src='includes/images/insert.png' alt='Add New' title='Add New' /></a></td>
            </tr>";
			 } 
			 else {
            $i = 0;
			foreach($record as $records) {
            $i = $i + 1;
			 $responsetext .= "<tr><th>" . $i . "</th><th>" . $records['Emp_Code'] . "</th><th>" . $records['Emp_Name'] . "</th>
				 
				 <th>" . $records['AccessTitle'] . "</th><th>" . $records['Emp_Address'] . "</th><th>" . $records['Emp_State'] . "</th>
				<th>" . $records['Emp_Country'] . "</th><th>" . $records['Emp_Phone'] . "</th><th>" . $records['Emp_Email'] . "</th><th><a href='javascript:getvalues(". $records['Emp_Code'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew' class='btn btn-info'>Edit</button></a></th>
            </tr>";
			
			}
			}
			 $responsetext .="</table></div>";
			 $response= array("OK",$responsetext);
			 echo json_encode($response);
	break;
		
	case "addnew":
	$Emp_Code = isset($_REQUEST['Emp_Code']) ? mysql_real_escape_string($_REQUEST['Emp_Code']) : '';
	$Emp_Name = isset($_REQUEST['Emp_Name']) ? mysql_real_escape_string($_REQUEST['Emp_Name']) : '';
	$Emp_Pass = isset($_REQUEST['Emp_Pass']) ? mysql_real_escape_string($_REQUEST['Emp_Pass']) : '';
	$Emp_Address = isset($_REQUEST['Emp_Address']) ? mysql_real_escape_string($_REQUEST['Emp_Address']) : '';
	$Emp_State = isset($_REQUEST['Emp_State']) ? mysql_real_escape_string($_REQUEST['Emp_State']) : '';
	$Emp_Country = isset($_REQUEST['Emp_Country']) ? mysql_real_escape_string($_REQUEST['Emp_Country']) : '';
	$Emp_Phone = isset($_REQUEST['Emp_Phone']) ? mysql_real_escape_string($_REQUEST['Emp_Phone']) : '';
	$Emp_Email = isset($_REQUEST['Emp_Email']) ? mysql_real_escape_string($_REQUEST['Emp_Email']) : '';
	$Emp_Role = isset($_REQUEST['Emp_Role']) ? mysql_real_escape_string($_REQUEST['Emp_Role']) : '';
	
		$query_customers = "INSERT INTO `tbl_emp_master` (`Emp_Code`,`Emp_Name`,`Emp_Pass`,`Emp_Address`,`Emp_State`,`Emp_Country`,`Emp_Phone`,`Emp_Email`,`Emp_Role`) VALUES ('" .$Emp_Code. "','" .$Emp_Name. "','" .md5($Emp_Pass). "','" .$Emp_Address. "','" .$Emp_State. "','" .$Emp_Country. "','" .$Emp_Phone. "','" .$Emp_Email. "','" .$Emp_Role. "')";
		mysql_query($query_customers);
		$InsertID = mysql_insert_id();
	
	if(mysql_affected_rows() > 0){
	$response=array("OK", $Emp_Code." Inserted Successfully");
	echo json_encode($response);
	}else{
	$response=array("ERROR", $Emp_Code."No Action Taken");
	echo json_encode($response);
	}
	break;
	
	
	case "update":
	$Emp_ID = isset($_REQUEST['Emp_ID']) ? mysql_real_escape_string($_REQUEST['Emp_ID']) : '';
	$Emp_Code = isset($_REQUEST['Emp_Code']) ? mysql_real_escape_string($_REQUEST['Emp_Code']) : '';
	$Emp_Name = isset($_REQUEST['Emp_Name']) ? mysql_real_escape_string($_REQUEST['Emp_Name']) : '';
	$Emp_Pass = isset($_REQUEST['Emp_Pass']) ? mysql_real_escape_string($_REQUEST['Emp_Pass']) : '';
	$Emp_Address = isset($_REQUEST['Emp_Address']) ? mysql_real_escape_string($_REQUEST['Emp_Address']) : '';
	$Emp_State = isset($_REQUEST['Emp_State']) ? mysql_real_escape_string($_REQUEST['Emp_State']) : '';
	$Emp_Country = isset($_REQUEST['Emp_Country']) ? mysql_real_escape_string($_REQUEST['Emp_Country']) : '';
	$Emp_Phone = isset($_REQUEST['Emp_Phone']) ? mysql_real_escape_string($_REQUEST['Emp_Phone']) : '';
	$Emp_Email = isset($_REQUEST['Emp_Email']) ? mysql_real_escape_string($_REQUEST['Emp_Email']) : '';
	$Emp_Role = isset($_REQUEST['Emp_Role']) ? mysql_real_escape_string($_REQUEST['Emp_Role']) : '';
	$query = mysql_query("Update `tbl_emp_master` set `Emp_Code` = '" .$Emp_Code. "',`Emp_Name` = '" .$Emp_Name. "',`Emp_Address` = '" .$Emp_Address. "',`Emp_State` = '" .$Emp_State. "',`Emp_Country` = '" .$Emp_Country. "',`Emp_Phone` = '" .$Emp_Phone. "',`Emp_Email` = '" .$Emp_Email. "',`Emp_Pass` = '" .md5($Emp_Pass). "',`Emp_Role` = '" .$Emp_Role. "'Where `Emp_ID`='".$Emp_ID."' ");
	
	if(mysql_affected_rows() > 0){
	$response=array("OK",$Emp_Code." Edited Successfully");
	echo json_encode( $response);
	}else{
	$response=array("ERROR","No Action Taken");
	echo json_encode($response);
	}

	break;
	
	case "search":
	$selname = isset($_REQUEST['empcode']) ? mysql_real_escape_string($_REQUEST['empcode']) : '';
	$query = "SELECT * FROM tbl_emp_master WHERE Emp_Code='$selname'";
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
    while($rows = mysql_fetch_array($result)){
        $response = array( $rows['Emp_ID'], $rows['Emp_Code'], $rows['Emp_Name'], $rows['Emp_Pass'],$rows['Emp_Address'],$rows['Emp_State'],$rows['Emp_Country'],$rows['Emp_Phone'],$rows['Emp_Email'],$rows['Emp_Role']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Employee is Registered with Employee Code ".$selname);
	echo json_encode($response);
	}
	break;
	
	
case"Check":
$selname = isset($_REQUEST['empcode']) ? mysql_real_escape_string($_REQUEST['empcode']) : '';
$sql = mysql_query("SELECT * FROM tbl_emp_master WHERE Emp_Code='$selname'");

if(mysql_num_rows($sql))
{
echo '<span style="color: red;">The Emp Code <b>'.$selname.'</b> is already in use.</span>';
}
else
{
echo 'OK';
}
break;
	
	}
	
}
	else
	{$response= array("ERROR","Hacking attempt");
	echo json_encode($response);}
	}
	else{
	echo '<h2>' . "Invalid Access" . '</h2>';
	}
?>