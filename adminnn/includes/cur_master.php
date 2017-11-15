<?php
require_once 'global.inc.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
	case "load":
	mysql_query('SET CHARACTER SET utf8');
	$query 	=mysql_query('SELECT * FROM `currencies`  ORDER BY title');
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
              	<th >Title</th>
				<th >Code</th>
				<th >Symbol Left</th>
				<th>Symbol Right</th>
				<th style='text-align:right'>Value</th>
				<th style='text-align:right'>Action</th>
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
			 $responsetext .= "<tr><td>". $i." </td>
			 		<td>". $records['title']."</td>			
					 <td>" . $records['code']  . "</td>
					 <td>" . $records['symbol_left']  . "</td>
					 <td>" . $records['symbol_right']  . "</td>
					 <td align='right'>" . $records['value']  . "</td>
					 				 				<td align='right'><a href='javascript:getvalues(" . $records['currencies_id'] . ")' <button type='submit'  name='submit-login' id='gridder_addnew'class='btn btn-info'>Edit</button></a>
				</td>
            </tr>";
			
			}
			}
			 $responsetext .="</tbody></table></div>";
			 $response= array("OK",$responsetext);
//			  array_map('utf8_encode', $response)
			 echo json_encode($response);
			 
	break;
	case "search":
	$catid = isset($_REQUEST['catid']) ? mysql_real_escape_string($_REQUEST['catid']) : '';
	$query = "SELECT * FROM `currencies` WHERE currencies_id='$catid'";
	mysql_query('SET CHARACTER SET utf8');
	$result = mysql_query($query) or die(mysql_error());
	$num_rows = mysql_num_rows($result);
	if($num_rows > 0){
    while($rows = mysql_fetch_array($result)){
	
        $response = array( $rows['title'], $rows['code'], $rows['symbol_left'],$rows['symbol_right'],$rows['value'],$rows['currencies_id']); // add return data to an array
        echo json_encode($response); // json encode that array
    }
	}
	else
	{
	$response= array("ERROR", "No Currency is Registered with Given ID ".$catid);
	echo json_encode($response);
	}
	break;
	case "addnew":
	//$currencies_id = isset($_REQUEST['currencies_id']) ? mysql_real_escape_string($_REQUEST['currencies_id']) : '';
	$title = isset($_REQUEST['title']) ? mysql_real_escape_string($_REQUEST['title']) : '';
	$code = isset($_REQUEST['code']) ? mysql_real_escape_string($_REQUEST['code']) : '';
	$symbol_left = isset($_REQUEST['symbol_left']) ? mysql_real_escape_string($_REQUEST['symbol_left']) : '';
	$symbol_right = isset($_REQUEST['symbol_right']) ? mysql_real_escape_string($_REQUEST['symbol_right']) : '';
	$decimal_point='.';
	$thousands_point=',';
	$decimal_places=2;
	$value= isset($_REQUEST['value']) ? mysql_real_escape_string($_REQUEST['value']) : '';
		$query_customers = "INSERT INTO `currencies` (`title`,`code`,`symbol_left`,`symbol_right`,`decimal_point`,`thousands_point`,`decimal_places`,`value`,`last_updated`) VALUES ('" .$title. "','" .$code. "','" .$symbol_left. "','" .$symbol_right. "','" .$decimal_point. "','" .$thousands_point. "','" .$decimal_places. "','" .$value."',now())";
	mysql_query($query_customers);
	if(mysql_affected_rows() > 0){
	$response=array("OK",$title." Inserted Successfully ");
	echo json_encode($response);
	}else{
	$response=array( "ERROR","No Record Inserted");
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