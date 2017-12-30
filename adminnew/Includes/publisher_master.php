<?php
require_once 'global.inc.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
	case "load":
	$query 	= $db->select("SELECT * FROM manufacturers ORDER BY manufacturers_name");
	$count  = mysqli_num_rows($query);
		if($count > 0) {
			while($fetch = mysqli_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		
		 $responsetext="<div class='table-responsive' ><table class='table table-condensed table-striped table-hover' ><thead class='infilterable'><tr class='alert alert-info'><th>Sno</th>
               	<th>Publisher</th>
              	<th>Actions</th>
            		</tr></thead><tbody class='input-filter'>";
               
            if($count <= 0) {
            
            $responsetext .="<tr id='norecords'><td colspan='12' align='center'>No records found <a href='addnew' id='gridder_insert' class='gridder_insert'><img src='includes/images/insert.png' alt='Add New' title='Add New' /></a></td>
            </tr>";
             } else {
            $i = 0;
            foreach($record as $records) {
            $i = $i + 1;
            
           $responsetext .="<tr><td>" . $i."</td><td>" . $records['manufacturers_name']."</td><td><a href='javascript:getvalues(".$records['manufacturers_id'].")' <button type='submit'  name='submit-login' id='gridder_addnew' class='btn btn-info'>Edit</button></a></td>
            </tr>";
           
                }
            }
           
             $responsetext .="</tbody></table></div>";
			 $response= array("OK",$responsetext);
			 echo json_encode($response);
	break;
	
	case "search":
	$catid = isset($_REQUEST['catid']) ? mysql_real_escape_string($_REQUEST['catid']) : '';
	$query = "SELECT * FROM manufacturers WHERE manufacturers_id='$catid'";
	//$result = mysql_query($query) or die(mysql_error());
	$result = $db->selectwhere('manufacturers',"manufacturers_id=$catid");
	$num_rows = mysqli_num_rows($result);
	if($num_rows > 0){
    while($rows = mysqli_fetch_array($result)){
        $response = array( $rows['manufacturers_id'], $rows['manufacturers_name']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Manufacture is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;
	
	case "addnew":
	$manufacturers_name = isset($_REQUEST['manufacturers_name']) ? mysql_real_escape_string($_REQUEST['manufacturers_name']) : '';
	
		$query = "INSERT INTO `manufacturers` (`manufacturers_name`,`date_added`,`last_modified`) VALUES ('" . $manufacturers_name . "', now(),now() )";
		/*mysql_query($query_customers);
		
	if(mysql_affected_rows() > 0){
	$response=array("OK",$manufacturers_name." Inserted Successfully ");
	echo json_encode($response);
	}else{
	$response=array( "ERROR","No Record Inserted");
	echo json_encode($response);
	}*/
	echo json_encode($db->insertdb($query));

	break;
	case "update":
	$manufacturers_id = isset($_REQUEST['manufacturers_id']) ? mysql_real_escape_string($_REQUEST['manufacturers_id']) : '';
	$manufacturers_name = isset($_REQUEST['manufacturers_name']) ? mysql_real_escape_string($_REQUEST['manufacturers_name']) : '';
	
	
	$query = "Update `manufacturers` set `manufacturers_name` = '" .$manufacturers_name. "',`last_modified` = now() Where `manufacturers_id`='".$manufacturers_id."' ";
		
	echo json_encode($db->updatedb($query));
	/*if(mysql_affected_rows() > 0){
	$response=array("OK", $manufacturers_name." Edited Successfully");
	echo json_encode($response);
	}else{
	$response=array("ERROR","No Action Taken");
	echo json_encode($response);
	}*/

	break;
	}
	}
	else
	{$response= array("ERROR", "Hacking attempt");
	echo json_encode($response);}
	}
	else{
	$response= array("ERROR", "Invalid Access");
	echo json_encode($response);
	}
?>