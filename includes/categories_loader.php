<?php
$item_per_page =9;
require_once (__DIR__.'/classes/global.inc.php');
/* testing begin*/
if(isset($_SERVER['HTTP_X_REQUESTED_WITH']) && !empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest'){
  //Request identified as ajax request
  if ((isset($_REQUEST['Token']))&&(!empty($_REQUEST['page'])) &&(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/categories1.php', $_SESSION['csrf_token'])))){

  /*********************/
  if(isset($_REQUEST['page'])){

    if(empty($_REQUEST['page'])){
      $page_number = 1;
    }
    elseif(!is_numeric($_REQUEST['page'])){
	 echo 'page must be numeric';
	 exit();
	 }
	else
	{
	$page_number = filter_var($_REQUEST["page"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	}
}
//check Token is empty
if(isset($_REQUEST['Token'])){

    if(empty($_REQUEST['Token'])){
      exit();
    }
    //elseif (hash_equals($_REQUEST['Token'] ,hash_hmac('sha256', $_SERVER['SERVER_NAME'].'categories.php', $_SESSION['csrf_token'])){
	elseif(hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/categories1.php', $_SESSION['csrf_token']))){


		}
	else{
	echo 'Token Error';
	exit();
	}
}
//check manufacturers_id is empty
if(isset($_REQUEST["categories_id"])){

    if((empty($_REQUEST["categories_id"]))||(!is_numeric($_REQUEST["categories_id"]))){
      	  $where = "master_categories_id LIKE '%'";
    }
    else{
	$where = "master_categories_id=".filter_var($_REQUEST["categories_id"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
	}
}
else{
 $categories_id= "'%'";
}

$srt = filter_var($_REQUEST["sortt"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
switch($srt){
case "all":
$position = (($page_number-1) * $item_per_page);
$results = $product->getprodbyallsort($position,$item_per_page,'products_id ASC',$where);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){

 if($product->CheckspecialsbyID($rows['products_id'],"'".date("Y-m-d")."'"))
{
$sp=$product->GetspecialPrice($rows['products_id'],"'".date("Y-m-d")."'");
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->
							   <!--deal sticket-->
		<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>

							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left" style="text-decoration: line-through"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								  <h6>Special Price : <span class="fa fa-inr"></span> '.$sp.' </h6>
								</div>
								</div>
								</div>';

}
elseif($product->CheckfeaturedbyID($rows['products_id'],"'".date("Y-m-d")."'")) {
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->

							  <!--deal sticket-->
		<div class="newarrival"> <img src="img/Featured.png"/></div>
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>
								</div>';
}
else{
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
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
								</div>
								</div>';
}

    }
    echo '<input type="hidden" class="nextpage" value="'.($page_number+1).'"><input type="hidden" class="isload" value="true">';
	}
break;
case "a2z":
$position = (($page_number-1) * $item_per_page);
$results = $product->getprodbyallsort($position,$item_per_page,'products_name ASC',$where);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){

        					if($product->CheckspecialsbyID($rows['products_id'],"'".date("Y-m-d")."'"))
{
$sp=$product->GetspecialPrice($rows['products_id'],"'".date("Y-m-d")."'");
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->
							   <!--deal sticket-->
		<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>

							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left" style="text-decoration: line-through"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								  <h6>Special Price : <span class="fa fa-inr"></span> '.$sp.' </h6>
								</div>
								</div>
								</div>';

}
elseif($product->CheckfeaturedbyID($rows['products_id'],"'".date("Y-m-d")."'")) {
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->

							  <!--deal sticket-->
		<div class="newarrival"> <img src="img/Featured.png"/></div>
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>
								</div>';
}
else{
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
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
								</div>
								</div>';
}
    }
    echo '<input type="hidden" class="nextpage" value="'.($page_number+1).'"><input type="hidden" class="isload" value="true">';
	}
break;
case "z2a":
$position = (($page_number-1) * $item_per_page);
$results = $product->getprodbyallsort($position,$item_per_page,'products_name DESC',$where);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){

        					if($product->CheckspecialsbyID($rows['products_id'],"'".date("Y-m-d")."'"))
{
$sp=$product->GetspecialPrice($rows['products_id'],"'".date("Y-m-d")."'");
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->
							   <!--deal sticket-->
		<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>

							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left" style="text-decoration: line-through"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								  <h6>Special Price : <span class="fa fa-inr"></span> '.$sp.' </h6>
								</div>
								</div>
								</div>';

}
elseif($product->CheckfeaturedbyID($rows['products_id'],"'".date("Y-m-d")."'")) {
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->

							  <!--deal sticket-->
		<div class="newarrival"> <img src="img/Featured.png"/></div>
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>
								</div>';
}
else{
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
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
								</div>
								</div>';
}
    }
    echo '<input type="hidden" class="nextpage" value="'.($page_number+1).'"><input type="hidden" class="isload" value="true">';
	}
break;
case "l2h":
$position = (($page_number-1) * $item_per_page);
$results = $product->getprodbyallsort($position,$item_per_page,'products_price DESC',$where);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){

        					if($product->CheckspecialsbyID($rows['products_id'],"'".date("Y-m-d")."'"))
{
$sp=$product->GetspecialPrice($rows['products_id'],"'".date("Y-m-d")."'");
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->
							   <!--deal sticket-->
		<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>

							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left" style="text-decoration: line-through"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								  <h6>Special Price : <span class="fa fa-inr"></span> '.$sp.' </h6>
								</div>
								</div>
								</div>';

}
elseif($product->CheckfeaturedbyID($rows['products_id'],"'".date("Y-m-d")."'")) {
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->

							  <!--deal sticket-->
		<div class="newarrival"> <img src="img/Featured.png"/></div>
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>
								</div>';
}
else{
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
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
								</div>
								</div>';
}
    }
    echo '<input type="hidden" class="nextpage" value="'.($page_number+1).'"><input type="hidden" class="isload" value="true">';
	}
break;
case "h2l":
$position = (($page_number-1) * $item_per_page);
$results = $product->getprodbyallsort($position,$item_per_page,'products_price ASC',$where);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){

        					if($product->CheckspecialsbyID($rows['products_id'],"'".date("Y-m-d")."'"))
{
$sp=$product->GetspecialPrice($rows['products_id'],"'".date("Y-m-d")."'");
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->
							   <!--deal sticket-->
		<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>

							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left" style="text-decoration: line-through"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								  <h6>Special Price : <span class="fa fa-inr"></span> '.$sp.' </h6>
								</div>
								</div>
								</div>';

}
elseif($product->CheckfeaturedbyID($rows['products_id'],"'".date("Y-m-d")."'")) {
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
							  <!-- Item image -->

							  <!--deal sticket-->
		<div class="newarrival"> <img src="../img/Featured.png"/></div>
							  <div class="item-image"><a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt=""  /></a></div>
								<!-- Item details -->
								<div class="item-details">
								  <!-- Name -->
								  <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
								  <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'<b></b></a></h5>
								  <div class="clearfix"></div>
								  <!-- Para. Note more than 2 lines.
								  <p>'.$rows['products_name'].'.</p>-->
								  <hr />
								  <!-- Price -->
								  <div class="item-price pull-left"><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>
								  <!-- Add to cart -->
								  <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">Details</a></div>
								  <div class="clearfix"></div>
								</div>
								</div>
								</div>';
}
else{
							echo'<!-- Item #1 -->
							  <div class="col-md-4 col-sm-6">
							  <!-- Each item should be enclosed in "item" class -->
							  <div class="item">
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
								</div>
								</div>';
}
    }
    echo '<input type="hidden" class="nextpage" value="'.($page_number+1).'"><input type="hidden" class="isload" value="true">';
	}
break;

}


  /*******************************************/

  }
  else{
  echo 'Error Occurred';
  }

  }

else
{
echo 'Invalid Request Type';
}
/*Testing end*/
//check page is empty

	?>
