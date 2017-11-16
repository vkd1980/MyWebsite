<?php
/*if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_POST)){/*Detect AJAX and POST request*/
//exit("Unauthorized Access");
//}
require_once (__DIR__.'/classes/global.inc.php');
if((isset($_REQUEST['Token']))&&(!empty($_REQUEST['page']))&&(!empty($_REQUEST['id']))){

	$Addressdata='';
	$mail='';
	$id	= 	filter_var(($_REQUEST['id']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$page=  filter_var(($_REQUEST['page']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);

	switch($page){
case "checkout.php":
			$results = $CustAddress->GetCustAddressbyID($id);
			$num_rows = mysqli_num_rows($results);
			if($num_rows > 0){
				while($rows =  mysqli_fetch_array($results)){
					$Addressdata= array(
				'Cust_id'=>$rows['customers_id'],
				'Entry_gender'=>$rows['entry_gender'],
				'Cust_address_book_id'=>$rows['address_book_id'],
				'Cust_Telephone' => $rows["customers_telephone"],
				'Cust_entry_company'=> $rows["entry_company"],
				'Cust_entry_firstname'=> $rows["entry_firstname"],
				'Cust_entry_lastname'=> $rows["entry_lastname"],
				'Cust_entry_street_address'=> $rows["entry_street_address"],
				'Cust_entry_suburb'=> $rows["entry_suburb"],
				'Cust_entry_postcode'=> $rows["entry_postcode"],
				'Cust_entry_city'=> $rows["entry_city"],
				'Cust_entry_state'=> $rows["entry_state"],
				'Cust_entry_country_id'=> $rows["entry_country_id"],
				'Cust_entry_zone_id'=> $rows["entry_zone_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_country_id'=> $rows["country_id"],
				'Cust_city_id'=> $rows["city_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Isdefault'=> $rows["IsDefault"],
				);
				}
			}
			$data = array(
        'status' => "success",
        'Adetails' => $Addressdata
    );
			$status = "success";
			echo json_encode($data);
break;
case "myprofile.php":
$mail=filter_var(($_REQUEST['mail']), FILTER_SANITIZE_EMAIL, FILTER_FLAG_STRIP_HIGH);
			$results = $CustAddress->GetCustDAddress("'".$mail."'");
			$num_rows = mysqli_num_rows($results);
			if($num_rows > 0){
				while($rows =  mysqli_fetch_array($results)){
					$Addressdata= array(
				'Cust_id'=>$rows['customers_id'],
				'Entry_gender'=>$rows['entry_gender'],
				'Cust_address_book_id'=>$rows['address_book_id'],
				'Cust_Telephone' => $rows["customers_telephone"],
				'Cust_entry_company'=> $rows["entry_company"],
				'Cust_entry_firstname'=> $rows["entry_firstname"],
				'Cust_entry_lastname'=> $rows["entry_lastname"],
				'Cust_entry_street_address'=> $rows["entry_street_address"],
				'Cust_entry_suburb'=> $rows["entry_suburb"],
				'Cust_entry_postcode'=> $rows["entry_postcode"],
				'Cust_entry_city'=> $rows["entry_city"],
				'Cust_entry_state'=> $rows["entry_state"],
				'Cust_entry_country_id'=> $rows["entry_country_id"],
				'Cust_entry_zone_id'=> $rows["entry_zone_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Cust_country_id'=> $rows["country_id"],
				'Cust_city_id'=> $rows["city_id"],
				'Cust_state_id'=> $rows["state_id"],
				'Isdefault'=> $rows["IsDefault"],
				);
				}
			}
			$data = array(
        'status' => "success",
        'Adetails' => $Addressdata
    );
			$status = "success";
			echo json_encode($data);
break;
}//EOF SWITch

}
elseif(!empty($_REQUEST['Cust_id'])&& !empty($_REQUEST['action'])&& !empty($_REQUEST['gender'])&& !empty($_REQUEST['FirstName'])&& !empty($_REQUEST['LastName'])&& !empty($_REQUEST['street_address'])&& $_REQUEST['should_be_empty'] == ''&& !empty($_REQUEST['suburb'])&& !empty($_REQUEST['City'])&& !empty($_REQUEST['State'])&& !empty($_REQUEST['Country'])&& !empty($_REQUEST['pin'])&& !empty($_REQUEST['telephone']) && ((hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/checkout.php', $_SESSION['csrf_token']))) ||(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/myprofile.php', $_SESSION['csrf_token'])))) ){
	$data ='';
	$Cust_address_book_id=filter_var($_REQUEST['Cust_address_book_id'],  FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$Cust_id=filter_var($_REQUEST['Cust_id'],  FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$gender=filter_var($_REQUEST['gender'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$FirstName= filter_var($_REQUEST['FirstName'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$LastName=filter_var($_REQUEST['LastName'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			if (!empty($_REQUEST['company'])){
		$company=filter_var($_REQUEST['company'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
			}
		else{
		$company='';
			}
	$street_address=filter_var($_REQUEST['street_address'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$suburb=filter_var($_REQUEST['suburb'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$City=filter_var($_REQUEST['City'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$State=filter_var($_REQUEST['State'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$Country=filter_var($_REQUEST['Country'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$pin=filter_var($_REQUEST['pin'],  FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$telephone=filter_var($_REQUEST['telephone'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	$Process=filter_var($_REQUEST['action'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
	$Isdefault=filter_var($_REQUEST['Isdefault'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	switch($Process){
		case "Addnew":

		if($CustAddress->InsertCustAddress($Cust_id,"'".$gender."'","'".$company."'","'".$FirstName."'","'".$LastName."'","'".$street_address."'","'".$suburb."'",$pin,$City,$State,$Country,$State)!==0){
			$data = array(
						'status' => 'success',
						'message' => 'Inserted Successfully'
					);
		}
		else{
			$data = array(
						'status' => 'error',
						'message' => 'Something Went wrong'
					);
		}
		break;
		case "Edit":
		if($CustAddress->UpdateCustAddress($Cust_address_book_id,$Cust_id,"'".$gender."'","'".$company."'","'".$FirstName."'","'".$LastName."'","'".$street_address."'","'".$suburb."'",$pin,$City,$State,$Country,$State)==true){
			$data = array(
						'status' => 'success',
						'message' => 'Edited Successfully'
					);
		}
		else{
			$data = array(
						'status' => 'error',
						'message' => 'Something Went wrong'
					);
		}
		break;
		case "Default":
		$passwordnew= $_REQUEST['passwordnew'];
		$customer=new customer();
		$Upcust=$customer->Updatecustomer($Cust_id,"'".$gender."'","'".$FirstName."'","'".$LastName."'",$telephone,"'".$passwordnew."'");
		$UpcustDetails=$CustAddress->UpdateCustAddress($Cust_id,"'".$gender."'","'".$company."'","'".$FirstName."'","'".$LastName."'","'".$street_address."'","'".$suburb."'",$pin,$City,$State,$Country,$State,$Cust_address_book_id);
		if($Upcust || $UpcustDetails ){
			$data = array(
						'status' => 'success',
						'message' => 'Edited Successfully'
					);
		}
		else{
			$data = array(
						'status' => 'error',
						'message' => 'Something Went wrong'
					);
		}

		break;
	}

	echo json_encode($data);
}

else{
	echo 'error';
}
?>
