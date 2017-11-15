<?php

require_once (__DIR__.'/DB.class.php');

class products{



public function getprodbyid($products_id)

{

$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) as value,FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE products.products_id= ? LIMIT 1;");
$stmt->bind_param('s', $products_id);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
//$result= $DBC->select($qry);
return $result;

}

public function getprodSearchid($criteria)
{
$DBC = new DB();
//$con =$DBC->connect();
$qry="SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) as value,FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE $criteria ORDER BY products.products_id LIMIT 8 ;";
//$stmt->bind_param('s', $criteria);
//$stmt->execute();
$result= $DBC->select($qry);
return $result;
}


public function getprodbyisbn($isbn)
{
$DBC = new DB();
$con =$DBC->connect();
$qry= "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) as value,FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE products.products_model = ? ";
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $isbn);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}

public function getprodbycatid($catid)
{
$DBC = new DB();
$con =$DBC->connect();
$qry= "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) as value,FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE products.master_categories_id = ?";
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $catid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}


public function getprodbymanid($manid)
{
$DBC = new DB();
$con =$DBC->connect();
$qry= "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) as value,FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE products.manufacturers_id = ?;";
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $manid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}

public function getprodbyallsort($position,$item_per_page,$sort,$where)
{
$DBC = new DB();
$con =$DBC->connect();
$position=mysqli_real_escape_string($con, $position);
$item_per_page=mysqli_real_escape_string($con, $item_per_page);
//$sort=mysqli_real_escape_string($con, $sort);
//$where=mysqli_real_escape_string($con, $where);
$qry= "SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid, FORMAT(products.products_rate,2) AS products_rate,products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,categories.categories_id,categories.categories_name, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
WHERE $where
ORDER BY $sort
LIMIT $position,$item_per_page" ;
$result= $DBC->select($qry);
return $result;



}



public function getspecials($limit,$date)
{
$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT specials.*, products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,products.products_name,products.products_author,
products.products_edition,products.master_categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value,
FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,categories.categories_name,categories.categories_id
FROM (specials
LEFT JOIN products ON products.products_id = specials.products_id)
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
WHERE DATE(specials.expires_date) >= ? AND specials.`status`= TRUE AND specials_date_available <= ?
ORDER BY RAND()
LIMIT ?";
$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $limit);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}



public function getspecialsbyID($Pid,$date)

{

$DBC = new DB();

$con =$DBC->connect();

$qry="SELECT  products.products_id as prodid,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,
specials.*,FORMAT(specials.specials_new_products_price,2) AS special_price,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN specials ON products.products_id = specials.products_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE DATE(specials.expires_date) >= ? AND specials.`status`= TRUE AND specials_date_available <= ?
AND specials.products_id= ? LIMIT 1;";

$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $Pid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;

}

public function GetspecialPrice($Pid,$date)

{

$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT  products.products_id,products.products_curid,products.manufacturers_id,products.master_categories_id,
manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id,FORMAT(specials.specials_new_products_price,2) AS special_price
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN specials ON products.products_id = specials.products_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE DATE(specials.expires_date) >= ? AND specials.`status`= TRUE AND specials_date_available <= ?
AND specials.products_id= ? LIMIT 1;";
$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $Pid);
$stmt->execute();
$result = $stmt->get_result();
$value = mysqli_fetch_object($result);
$stmt->close();
$con->close();
return $value->special_price;

}



public function CheckspecialsbyID($Pid,$date)

{

$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT  products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,
specials.*,FORMAT(specials.specials_new_products_price,2) AS special_price,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN specials ON products.products_id = specials.products_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE DATE(specials.expires_date) >= ? AND specials.`status`= TRUE AND specials_date_available <= ?
AND specials.products_id= ? LIMIT 1;";

//$stmt = $con->prepare($qry);
if ($stmt = $con->prepare($qry)) {
$stmt->bind_param('sss', $date, $date, $Pid);
    // execute it and all...
} else {
    die("Errormessage: ". $con->error);
}
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
return True;
}
else
{
return False;
}

}





public function getfeatured($limit,$date)
{
$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT featured.*, products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,products.products_name,products.products_author,
products.products_edition,products.master_categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value,
FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,categories.categories_name,categories.categories_id
FROM (featured
LEFT JOIN products ON products.products_id = featured.products_id)
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
WHERE featured.expires_date >=? AND featured.`status`= TRUE AND featured_date_available <= ?
ORDER BY RAND()
LIMIT ?;";
$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $limit);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;

}



public function getfeaturedbyID($Pid,$date)

{

$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT products.products_id as prodid,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,
featured.*,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN featured ON products.products_id = featured.products_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE featured.expires_date >= ? AND featured.`status`= TRUE AND featured_date_available <=?
and products.products_id= ? LIMIT 1;";
$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $Pid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;

}



public function CheckfeaturedbyID($Pid,$date)
{
$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT  products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,
featured.*,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN featured ON products.products_id = featured.products_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE featured.expires_date >= ? AND featured.`status`= TRUE AND featured_date_available <=?
and products.products_id= ? LIMIT 1;";
$stmt = $con->prepare($qry);
$stmt->bind_param('sss', $date, $date, $Pid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
return True;
}
else
{
return False;
}

}



public function getNewarrivals($limit)

{

$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT products.products_id,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
ORDER BY DATE (products.products_date_added) DESC
LIMIT ? ;";
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $limit);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}



public function getproduct($pid)

{
$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT products.products_id as prodid,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE products.products_id=?;";
$stmt = $con->prepare($qry);
$stmt->bind_param('s', $pid);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}

	Public function CheckQty($pid,$qty)

	{
	$DBC = new DB();
	$con =$DBC->connect();
	$qry="SELECT products.products_id as prodid,products.products_quantity from products WHERE products.products_id=? LIMIT 1;";
	$stmt = $con->prepare($qry);
	$stmt->bind_param('s', $pid);
	$stmt->execute();
	$result = $stmt->get_result();
	$stmt->close();
	$con->close();
	$num_rows = mysqli_num_rows($result);
		if($num_rows > 0){

				while($rows =  mysqli_fetch_array($result)){
					if ($rows['products_quantity']>=$qty)
					{
					return true;
					}
					else
					{
					return false;
					}
				}
		}
		else
		{
		return FALSE;

		}
	}
public function getallproduct()

{
$DBC = new DB();
$con =$DBC->connect();
$qry="SELECT products.products_id AS prodid,products.products_quantity,products.products_model,products.products_image,
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
ORDER BY categories.categories_name AND products.products_name;";
$stmt = $con->prepare($qry);
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
return $result;
}


}



?>
