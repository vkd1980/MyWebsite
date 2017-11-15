<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');


$resultcat=$db->select("Select * from categories order by categories_name " );
$num_rows_cat = mysqli_num_rows($resultcat);
if($num_rows_cat > 0){
while($rows =  mysqli_fetch_array($resultcat)){

echo '<li><a href="/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['categories_id'] .'.html"class="dropdown-toggle disabled" data-toggle="dropdown"  >'.strtoupper($rows['categories_name']).'</a></li><br>';

$result=$db->select("SELECT products.products_id AS prodid,products.products_quantity,products.products_model,products.products_image, 
products.products_curid,products.product_min_qty, FORMAT(products.products_rate,2) AS products_rate,products.products_weight,
products.manufacturers_id,products.master_categories_id,products.products_name,products.products_author,
products.products_edition,products.products_date_added, manufacturers.manufacturers_name, categories.categories_name,manufacturers.manufacturers_id,
categories.categories_id, currencies.currencies_id, currencies.code, FORMAT(currencies.value,2) AS value, FORMAT(products.products_rate*value,2) AS products_price,currencies.symbol_left,products_description.*
FROM (products
LEFT JOIN manufacturers ON products.manufacturers_id = manufacturers.manufacturers_id)
LEFT JOIN categories ON products.master_categories_id = categories.categories_id
LEFT JOIN currencies ON products.products_curid = currencies.currencies_id
LEFT JOIN products_description ON products.products_id = products_description.products_id
WHERE products.master_categories_id='".$rows['categories_id']."'
ORDER BY categories.categories_name AND products.products_name;");
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
while($rowsp =  mysqli_fetch_array($result)){
echo '<li><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rowsp['categories_name']))).'-c-'.$rowsp['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rowsp['products_name']))).'-p-'.$rowsp['products_id'].'.html">'.strtoupper($rowsp['products_name']).'<b></b></a><br></li>';
}

}

}
}
echo'<li><a href="./checkout.html">Checkout<b></b></a><br></li>
<li><a href="./categories.html">Categories<b></b></a><br></li>
<li><a href="./manufacturers.html">Publishers<b></b></a><br></li>
<li><a href="./support.html">Support<b></b></a><br></li>
<li><a href="./contact.html">Contact<b></b></a><br></li>
<li><a href="./search.html">Search<b></b></a><br></li>
<li><a href="./signup.html">Sign Up<b></b></a><br></li>
<li><a href="./login.html">Login<b></b></a><br></li>
<li><a href="./myaccount.html">My Account<b></b></a><br></li>
<li><a href="./myprofile.html">My Profile<b></b></a><br></li>
<li><a href="./cart.html">Shopping Cart<b></b></a><br></li>';
?>
 