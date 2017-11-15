<?php
require_once (__DIR__.'/DB.class.php');
class manufacturers{
public function getmannamebyid($id)
{
$qry ="select * from manufacturers where manufacturers_id=$id LIMIT 1;";
$DBC = new DB();
$result= $DBC->select($qry);
$value = mysqli_fetch_object($result);
return $value->manufacturers_name;
}

}
?>