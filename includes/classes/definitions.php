<?php
require_once (__DIR__.'/DB.class.php');
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT * FROM configuration");
$stmt->execute();
$result = $stmt->get_result();
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($result)){
define($rows["configuration_key"],$rows["configuration_value"]);
}
}
$stmt->close();
$con->close();

define('RECENT_ITEMS','Recently Viewed Items');
define('NEW_ARRIVALS','New Arrivals');
define('FEATURED_NAME','Featured Items');
define('SPECIAL_OFFERS','Special Offers');
define('SPECIALS_NUM_ROWS','8');//Must be Multiples of 3
define('FEATURED_NUM_ROWS','8');//Must be Multiples of 3
define('FEATURED_SIDEBAR_NUM_ROWS','10');//Any Numbers not more than 10
define('NEW_ARRIVALS_NUM_ROWS','8');//Must be Multiples of 3
define('SMTP_SERVER','smtp.prabhusbooks.com');
define('SMTP_USER_NAME','admin@prabhusbooks.com');
define('SMTP_PASSWORD','Vinod123*');
?>