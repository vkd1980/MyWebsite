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

public function GetAllCategoriesP(){
  $DBC = new DB();
  $qry ="SELECT categories.categories_id AS catid, categories.categories_name AS catname, categories.parent_id AS parentcategory
FROM categories
WHERE categories.parent_id=0 UNION
SELECT ALL categories_1.categories_id AS catid, categories_1.categories_name AS catname, categories.categories_name AS parentcategory
FROM categories
RIGHT JOIN categories AS categories_1 ON categories.categories_id = categories_1.parent_id
WHERE categories.parent_id =0 order by catname";
  $result= $DBC->select($qry);
  return $result;
}
public function GetAllCategories(){
  $DBC = new DB();
  $qry ="SELECT categories_id,categories_name FROM categories WHERE parent_id='0' ORDER BY categories_name";
  $result= $DBC->select($qry);
  return $result;
}
}
?>
