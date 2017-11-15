<?php 
require_once 'global.inc.php';
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
	case "search":
	echo'test Search';
	break;
	case "addnew":
	$Cashbill_No = ($db->selectmax('Cashbill_No', 'tbl_cashsale_master', 'Finyear_ID='.$_SESSION["FinYearID"])+1);
	$Bill_Date= isset($_REQUEST['Bill_Date']) ? mysql_real_escape_string($_REQUEST['Bill_Date']) : '';
	$Finyear_ID= isset($_REQUEST['Finyear_ID']) ? mysql_real_escape_string($_REQUEST['Finyear_ID']) : '';
	$Emp_ID = $_SESSION['userid'];
	$Account_Code= isset($_REQUEST['Account_Code']) ? mysql_real_escape_string($_REQUEST['Account_Code']) : '';
	$Name= isset($_REQUEST['Name']) ? mysql_real_escape_string($_REQUEST['Name']) : '';
	$Address= isset($_REQUEST['Address']) ? mysql_real_escape_string($_REQUEST['Address']) : '';
	$Mob_No= isset($_REQUEST['Mob_No']) ? mysql_real_escape_string($_REQUEST['Mob_No']) : '';
	$Add= isset($_REQUEST['Add']) ? mysql_real_escape_string($_REQUEST['Add']) : '';
	$Less= isset($_REQUEST['Less']) ? mysql_real_escape_string($_REQUEST['Less']) : '';
	$Discount= isset($_REQUEST['Discount']) ? mysql_real_escape_string($_REQUEST['Discount']) : '';
	$Amount= isset($_REQUEST['Amount']) ? mysql_real_escape_string($_REQUEST['Amount']) : '';
	$Remark= isset($_REQUEST['Remark']) ? mysql_real_escape_string($_REQUEST['Remark']) : '';
	$qrymaster="INSERT INTO tbl_cashsale_master(`Cashbill_No`,`Bill_Date`,`Finyear_ID`,`Emp_ID`,`Account_Code`,`Name`,`Address`,`Mob_No`, `ADD`, `LESS`,`Discount`,`Amount`,`Remark`,`Timestamp`) VALUES('". $Cashbill_No . "','" . $Bill_Date . "','" . $Finyear_ID . "','" . $Emp_ID . "','" . $Account_Code . "','" . $Name . "','" . $Address . "','" . $Mob_No . "','" . $Add . "','" . $Less . "','" . $Discount ."','" . $Amount . "','" . $Remark ."',now())";
	 
	$lastinsertid="#";
	//Save Cash Sale Details
	$itemCount = count($_POST["slno"]);
   $itemValues=0;
   $query_details ="INSERT INTO tbl_cashsale_details(`CashBill_ID`,`Product_ID`,`Finyear_ID`,`Cur_ID`,`Qty`,`Price`,`Ex_Rate`,`Disc`,`Amt`,`Timestamp`) VALUES ";
   $queryValue = "";
   for($i=0;$i<$itemCount;$i++) {
      if(!empty($_POST["slno"][$i]) || !empty($_POST["Product_ID"][$i])) {
         $itemValues++;
	 if($queryValue!="") $queryValue .= ",";
	 
  	 $queryValue .= "('" .$lastinsertid . "', '" . mysql_real_escape_string($_POST["Product_ID"][$i] ). "','" . $Finyear_ID. "','" . mysql_real_escape_string($_POST["Cur_ID"][$i] ). "','" . mysql_real_escape_string($_POST["Qty"][$i] ). "','" . mysql_real_escape_string($_POST["price"][$i] ). "','" . mysql_real_escape_string($_POST["rate"][$i] ). "','" . mysql_real_escape_string($_POST["disc"][$i] ). "','" . mysql_real_escape_string($_POST["Amt"][$i] ). "',now())";
      }
   }
   	$sql = $query_details.$queryValue;  
		
		if($itemValues!=0) {
		$result_master= $db->insertdb($qrymaster);
	    $lastinsertid=$result_master[2];
		$sql_details= str_replace("#", $lastinsertid, $sql);
      	$result_details = $db->insertdb($sql_details);
		$response=array($result_details[0],$result_master[0],$result_master[2]);
	  	echo json_encode($response);
   }
	break;
	
	case "update":
	echo'test Addnew';
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