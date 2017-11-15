<?php
require_once (__DIR__.'/global.inc.php');
 // I would actually write a class to deal with this,
 // but these functions will hopefully give you an idea or two :-)
class recentview{
//Set recentview

function setRecentlyViewed ( $prodID ) {
if((isset($_SESSION['items'])) &&(!in_array($prodID,$_SESSION['items'],TRUE)))
{
$_SESSION['items'][] = $prodID ;
}
 }
  
  
  
function getRecentlyViewed () {
$product = new products();
$str=	'<!-- Owl Carousel Starts -->
		<div class="container">
		<div class="rp">
		<!-- Recent News Starts -->
		<h4 class="title">'.RECENT_ITEMS.'</h4>
		<div class="recent-news block">
		<!-- Recent Item -->
		<div class="recent-item">
		<div class="custom-nav">
		<a class="prev"><i class="fa fa-chevron-left br-lblue"></i></a>
		<a class="next"><i class="fa fa-chevron-right br-lblue"></i></a>
		</div>
		<div id="owl-recent" class="owl-carousel">';

if ((isset($_SESSION['items'])) && (count($_SESSION['items']) > 0))
{

if(count($_SESSION['items']) >= 8 )
{
array_shift($_SESSION['items']);
}
foreach ($_SESSION['items'] as $value) {
   //connect to db and get detals	
   $results = $product->getprodbyid($value);
   $num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
    /*$str = $str.'<!-- Item -->
	<div class="item">
	<a href="#"><img src="/img/photos/'.$rows['products_image'].'" alt="" class="img-responsive" /></a>
	<!-- Heading -->
	<h4><a href="#">'.strtoupper($rows['products_name']).'<span class="pull-right"><br><span class="fa fa-inr"></span>'.$rows['products_price'].'</span></a></h4>
	<div class="clearfix"></div>
	<!-- Paragraph 
	<p>Nunc adipiscing, metus sollic itun molestie, urna augue dap ibus dui.</p>-->
	</div>';*/
	
	if($product->CheckspecialsbyID($rows['products_id'],date("Y-m-d"))){
	$str = $str.'<div class="item">
							  <!-- Item image -->
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p> -->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>';
	}
	elseif($product->CheckfeaturedbyID($rows['products_id'],date("Y-m-d"))){
	$str = $str.'<div class="item">
							  <!-- Item image -->
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p> -->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>';
	}
	else{
	
							$str = $str.'<div class="item">
							  <!-- Item image -->
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p> -->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>';
}//else product check
	}
  }
  
}

$str=$str.'</div>
			</div>
			</div>
			<!-- Recent News Ends -->
			</div>
		</div>
		<!-- Owl Carousel Ends -->';
		echo $str;
 }
}

 }
  ?>