<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  //exit("Unauthorized Access");
//}
require_once (__DIR__.'/classes/global.inc.php');
if($_REQUEST)
{
$q=filter_var($_REQUEST['search'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$sql_res=$product->getprodSearchid("products_name like '%$q%' or products_author like '%$q%' or manufacturers_name like '%$q%' or categories_name like '%$q%'");
$num_rows = mysqli_num_rows($sql_res);
if($num_rows > 0){
while($row=mysqli_fetch_array($sql_res))
{
$prod_name= strtoupper($row['products_name']);
$prod_author=strtoupper($row['products_author']);
$prod_cat=strtoupper($row['categories_name']);
$prod_man=strtoupper($row['manufacturers_name']);
$b_prod_name = str_ireplace($q, '<strong>'.$q.'</strong>', $prod_name);
$b_prod_author = str_ireplace($q, '<strong>'.$q.'</strong>', $prod_author);
$b_prod_cat = str_ireplace($q, '<strong>'.$q.'</strong>', $prod_cat);
$b_prod_man = str_ireplace($q, '<strong>'.$q.'</strong>', $prod_man);

echo'<div class="show" align="left">
 <img src="../img/photos/'.$row['products_image'].'" />
 <p><b>TITLE :- </b><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $row['categories_name']))).'-c-'.$row['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $row['products_name']))).'-p-'.$row['products_id'].'.html">'.strtoupper($b_prod_name).'<b></b></a></p>
<b>AUTHOR :- </b>'.strtoupper($b_prod_author).'&nbsp;
<b>SUBJECT :- </b>'.strtoupper($b_prod_cat).'<br/>
<b>PUBLISHER :- </b>'.strtoupper($b_prod_man).'

</div>';


}
}
else{
  echo'<div class="show" align="left">
   <p><b>No produts found !</b></p>


  </div>';
}
}
?>
