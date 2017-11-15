<?php
require_once (__DIR__.'/DB.class.php');
class category{
public function getcatnamebyid($id)
{
$DBC = new DB();
$con =$DBC->connect();
$qry ="select * from categories where categories_id=? LIMIT 1;";
//$DBC = new DB();
//$result= $DBC->select($qry);
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $id);
$stmt->execute();
$result = $stmt->get_result();
$value = mysqli_fetch_object($result);
return $value->categories_name;
}

}
?>