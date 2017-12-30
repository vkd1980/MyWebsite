<?php
require_once (__DIR__.'/DB.class.php');
class category{
public function getcatnamebyid($id)
{
$DBC = new DB();
//$con =$DBC->connect();
$qry ="SELECT * FROM categories WHERE categories_id=$id LIMIT 1;";
$result= $DBC->select($qry);
$value = mysqli_fetch_object($result);
return $value->categories_name;
}

}
?>
