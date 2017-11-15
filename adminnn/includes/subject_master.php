<?php
require_once 'global.inc.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
	case "load":
	$query 	=mysql_query('SELECT categories.categories_id AS catid, categories.categories_name AS catname, categories.parent_id AS parentcategory
FROM categories
WHERE categories.parent_id=0 UNION
SELECT ALL categories_1.categories_id AS catid, categories_1.categories_name AS catname, categories.categories_name AS parentcategory
FROM categories
RIGHT JOIN categories AS categories_1 ON categories.categories_id = categories_1.parent_id
WHERE categories.parent_id =0 order by catname ;
') ;
$count  = mysql_num_rows($query);
if($count > 0) {
			while($fetch = mysql_fetch_array($query)) {
				$record[] = $fetch;
			}
		}
		$responsetext="<div class='panel panel-primary well'>
            		<table class='table table-condensed table-striped table-hover' >
					<thead>
					<tr class='alert alert-info'>
              	<th >Sno</div></th>
               	<th >Category</div></th>
              	<th >Parent Category</div></th>
               	<th >Actions</div></th>
            		</tr>
					</thead>
			<tbody>";
			if($count <= 0) {
			echo "<tr id='norecords'>
                <td colspan='12' align='center'>No records found <a href='addnew' id='gridder_insert' class='gridder_insert'><img src='includes/images/insert.png' alt='Add New' title='Add New' /></a></td>
            </tr>";
			 } 
			 else {
            $i = 0;
			foreach($record as $records) {
            $i = $i + 1;
			 $responsetext .= "<tr><td>". $i." </td><td>". $records['catname']."</td>";
			if ($records['parentcategory']=="0")
				{
				 $responsetext .= "<td> - </td>";
						
					}
					else{
					
					 $responsetext .="<td>" . $records['parentcategory']  . "</td>";
						}
						$responsetext .="<td>
				<a href='javascript:getvalues(" . $records['catid'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew'class='btn btn-info'>Edit</button></a></td>
            </tr>
			 </tbody>";
			
			}
			}
			 $responsetext .="</table></div>";
			 $response= array("OK",$responsetext);
			 echo json_encode($response);
	break;
	case "search":
	$catid = isset($_REQUEST['catid']) ? mysql_real_escape_string($_REQUEST['catid']) : '';
	$query = "SELECT * FROM categories WHERE categories_id='$catid'";
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
    while($rows = mysql_fetch_array($result)){
        $response = array( $rows['categories_id'], $rows['parent_id'], $rows['categories_name']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array(0, 0, "No Subject is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;
	case "addnew":
	$categories_name = isset($_REQUEST['categories_name']) ? mysql_real_escape_string($_REQUEST['categories_name']) : '';
	$parent_id = isset($_REQUEST['parent_id']) ? mysql_real_escape_string($_REQUEST['parent_id']) : '';
	
	
		$query_customers = "INSERT INTO `categories` (`parent_id`,`categories_name`) VALUES ('" .$parent_id. "','" .$categories_name. "')";
		mysql_query($query_customers);
		$InsertID = mysql_insert_id();
	
	if(mysql_affected_rows() > 0){
	$response=array("OK",$categories_name." Inserted Successfully ");
	echo json_encode($response);
	}else{
	$response=array( "ERROR","No Record Inserted");
	echo json_encode($response);
	}


	break;
	/*if(mysql_affected_rows() > 0){
	$response=array("OK", $categories_name." Inserted Successfully");
	echo json_encode($response);
	}else{
	$response=array("ERROR", $Emp_Code." Inserted Successfully");
	echo json_encode($response);
	}
	break;*/
	case "update":
	$categories_id = isset($_REQUEST['categories_id']) ? mysql_real_escape_string($_REQUEST['categories_id']) : '';
	$categories_name = isset($_REQUEST['categories_name']) ? mysql_real_escape_string($_REQUEST['categories_name']) : '';
	$parent_id = isset($_REQUEST['parent_id']) ? mysql_real_escape_string($_REQUEST['parent_id']) : '';
	
	$query = mysql_query("Update `categories` set `categories_name` = '" .$categories_name. "',`parent_id` = '" .$parent_id. "'Where `categories_id`='".$categories_id."' ");
	
	if(mysql_affected_rows() > 0){
	$response=array("OK", $categories_name." Edited Successfully");
	echo json_encode($response);
	}else{
	$response=array("ERROR","No Action Taken");
	echo json_encode($response);
	}

	break;
	}
	
}
	else
	{$response= array("ERROR","Hacking attempt");
	echo json_encode($response);}
	}
	else{
	$response= array("ERROR","Invalid Access");
	echo json_encode($response);}
	
	
?>