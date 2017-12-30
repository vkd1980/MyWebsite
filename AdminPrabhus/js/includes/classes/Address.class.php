<?php
require_once (__DIR__.'/DB.class.php');
class CustAddress{
//Insert
public function InsertCustAddress($customers_id,$entry_gender,$entry_company,$entry_firstname,$entry_lastname,$entry_street_address,$entry_suburb,$entry_postcode,$entry_city,$entry_state,$entry_country_id,$entry_zone_id,$IsDefault)
{
$DBC = new DB();
//$con =$DBC->connect();
$stmt = "INSERT INTO `address_book` (`customers_id`, `entry_gender`, `entry_company`, `entry_firstname`, `entry_lastname`, `entry_street_address`, `entry_suburb`, `entry_postcode`, `entry_city`, `entry_state`, `entry_country_id`, `entry_zone_id`,`IsDefault`) VALUES ( $customers_id, $entry_gender, $entry_company, $entry_firstname, $entry_lastname, $entry_street_address, $entry_suburb,$entry_postcode,$entry_city, $entry_state, $entry_country_id, $entry_zone_id, $IsDefault);";
$result= $DBC->insertID($stmt);
return $result;
}
//Update
public function UpdateCustAddress($add_book_id,$customers_id,$entry_gender,$entry_company,$entry_firstname,$entry_lastname,$entry_street_address,$entry_suburb,$entry_postcode,$entry_city,$entry_state,$entry_country_id,$entry_zone_id)
{
$DBC = new DB();
$stmt = "UPDATE `address_book` SET `customers_id`=$customers_id,`entry_gender`=$entry_gender,`entry_company`=$entry_company,`entry_firstname`=$entry_firstname,`entry_lastname`=$entry_lastname,`entry_street_address`=$entry_street_address,`entry_suburb`=$entry_suburb,`entry_postcode`=$entry_postcode,`entry_city`=$entry_city,`entry_state`=$entry_state,`entry_country_id`=$entry_country_id,`entry_zone_id`=$entry_zone_id WHERE `address_book_id`=$add_book_id;";
$result=$DBC->updatedb($stmt);
return $result;
}
//Check
public function CheckCustAddress($customers_email_address)
{
$DBC = new DB();
$stmt = 'SELECT customers.customers_id,customers_email_address,address_book.address_book_id
FROM (address_book
LEFT JOIN customers ON customers.customers_id = address_book.customers_id)
WHERE customers_email_address=$customers_email_address;';
$result = $DBC->select($stmt);
if( mysqli_num_rows($result) == 1)
		{
		return true;
		}
		else{
		return false;
		}
}

//Get Address
Public function GetCustAddressbyID($customer_ID){
$db = new DB();
$stmt = "SELECT customers.*,address_book.*,states.*,cities.*
FROM (address_book
LEFT JOIN customers ON customers.customers_id = address_book.customers_id
LEFT JOIN states ON address_book.entry_state = states.state_id
LEFT JOIN cities ON address_book.entry_city = cities.city_id)
WHERE address_book_id=$customer_ID;";
$result = $db->select($stmt);
return $result;

}
//Get Address
Public function GetCustDAddress($customer_email_address){
$db = new DB();
$stmt = "SELECT customers.*,address_book.*,states.*,cities.*
FROM (address_book
LEFT JOIN customers ON customers.customers_id = address_book.customers_id
LEFT JOIN states ON address_book.entry_state = states.state_id
LEFT JOIN cities ON address_book.entry_city = cities.city_id)
WHERE IsDefault=true AND customers_email_address=$customer_email_address;";
$result = $db->select($stmt);
return $result;
}
//Get Address
Public function GetCustAddress($customer_email_address){
$DBC = new DB();
$stmt ="SELECT customers.*,address_book.*,states.*,cities.*
FROM (address_book
LEFT JOIN customers ON customers.customers_id = address_book.customers_id
LEFT JOIN states ON address_book.entry_state = states.state_id
LEFT JOIN cities ON address_book.entry_city = cities.city_id)
WHERE customers_email_address=$customer_email_address;";
$result = $DBC->select($stmt);
return $result;

}
}
?>
