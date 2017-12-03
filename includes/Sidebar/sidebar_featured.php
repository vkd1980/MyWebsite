<?php
$results = $product->getfeatured(FEATURED_SIDEBAR_NUM_ROWS,"'".date("Y-m-d")."'");
				$str='<!-- Sidebar items (featured items)-->

				  <div class="sidebar-items">

					<h5 class="title">'.FEATURED_NAME.'</h5>';
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
 $str = $str.'<!-- Item #1 -->
					<div class="sitem">
					  <!-- Dont forget the class "onethree-left" and "onethree-right" -->
					  <div class="onethree-left">
						<!-- Image -->
						<a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html"><img src="../img/photos/'.$rows['products_image'].'" alt="" class="img-responsive" /></a>
					  </div>
					  <div class="onethree-right">
						<!-- Title -->
						<a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a>
						<!-- Para
						<p>Aenean ullamcorper justo tincidunt justo aliquet.</p>-->
						<!-- Price -->
						<p class="bold"><span class="fa fa-inr"></span> '.$rows['products_price'].'
						</p>
					  </div>
					  <div class="clearfix"></div>
					</div>';
}
$str = $str.'</div>';
}
echo $str;
?>
