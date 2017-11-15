<?php
require_once (__DIR__.'/DB.class.php');
class Review{
public function showreview($prodid)
{
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT reviews.*,reviews_description.*
FROM reviews
LEFT JOIN reviews_description ON reviews.reviews_id = reviews_description.reviews_id
WHERE reviews.products_id=? AND reviews.`status`= TRUE;");
$stmt->bind_param('s', $prodid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}

public function savereviewmaster($products_id,$customers_id,$customers_name,$reviews_rating,$date_added,$last_modified)
{
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("INSERT INTO `reviews` (`products_id`, `customers_id`, `customers_name`, `reviews_rating`, `date_added`, `last_modified`) VALUES (?, ?, ?, ?, ?, ?);");
$stmt->bind_param('ssssss', $products_id,$customers_id,$customers_name,$reviews_rating,$date_added,$last_modified);
$stmt->execute();
$id =$stmt->insert_id;
return $id;
$stmt->close();
$con->close();
}

Public function savereviewdetails($reviews_id,$languages_id,$reviews_text)
{
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("INSERT INTO `reviews_description` (`reviews_id`, `languages_id`, `reviews_text`) VALUES (?, ?, ?);");
$stmt->bind_param('sss', $reviews_id,$languages_id,$reviews_text);
$stmt->execute();
$result=mysqli_affected_rows($con);
$stmt->close();
$con->close();
if ($result ==1)
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
$con =$DBC->connect();
$stmt = $con->prepare("SELECT reviews.*,reviews_description.*
FROM reviews
LEFT JOIN reviews_description ON reviews.reviews_id = reviews_description.reviews_id
WHERE reviews.products_id=? AND reviews.`status`= TRUE AND customers_id=?;");
$stmt->bind_param('ss', $products_id,$customers_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
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