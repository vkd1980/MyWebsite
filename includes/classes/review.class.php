<?php
require_once (__DIR__.'/DB.class.php');
class Review{
public function showreview($prodid)
{
$DBC = new DB();
$stmt = "SELECT reviews.*,reviews_description.*
FROM reviews
LEFT JOIN reviews_description ON reviews.reviews_id = reviews_description.reviews_id
WHERE reviews.products_id=$prodid AND reviews.`status`= TRUE;";
$result= $DBC->select($stmt);
return $result;
}

public function savereviewmaster($products_id,$customers_id,$customers_name,$reviews_rating,$date_added,$last_modified)
{
$DBC = new DB();
$stmt = "INSERT INTO `reviews` (`products_id`, `customers_id`, `customers_name`, `reviews_rating`, `date_added`, `last_modified`) VALUES ($products_id, $customers_id, $customers_name, $reviews_rating, $date_added, $last_modified);";
$id =$DBC->insertID($stmt);
return $id;
}

Public function savereviewdetails($reviews_id,$languages_id,$reviews_text)
{
$DBC = new DB();
$stmt = "INSERT INTO `reviews_description` (`reviews_id`, `languages_id`, `reviews_text`) VALUES ($reviews_id, $languages_id, $reviews_text);";
$result =$DBC->insertID($stmt);
if ($result <>0)
{
return True;
}
else
{
return False;
}
}

public function savereveiw($products_id,$customers_id,$customers_name,$reviews_rating,$date_added,$last_modified,$languages_id,$reviews_text)
{
$reviews_id=$this->savereviewmaster($products_id,$customers_id,$customers_name,$reviews_rating,$date_added,$last_modified);
$this->savereviewdetails($reviews_id,$languages_id,$reviews_text);
return $reviews_id;
}

Public function checkreveiw($products_id,$customers_id)
{
$DBC = new DB();
$stmt = "SELECT reviews.*,reviews_description.*
FROM reviews
LEFT JOIN reviews_description ON reviews.reviews_id = reviews_description.reviews_id
WHERE reviews.products_id=$products_id AND reviews.`status`= TRUE AND customers_id=$customers_id;";
$result= $DBC->select($stmt);
if( mysqli_num_rows($result) == 1)
		{
		return true;
		}
		else{
			return false;
		}
}

}
?>
