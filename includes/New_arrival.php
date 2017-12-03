<?php
/*$url = $_SERVER["SCRIPT_NAME"];
$break = Explode('/', $url);
$file = $break[count($break) - 1];
$cachefile = 'cache/cached-'.substr_replace($file ,"",-4).'.html';
$cachetime = 18000;

// Serve from the cache if it is younger than $cachetime
if (file_exists($cachefile) && time() - $cachetime < filemtime($cachefile)) {
    echo "<!-- Cached copy, generated ".date('H:i', filemtime($cachefile))." -->\n";
    include($cachefile);
    exit;
}
ob_start("ob_gzhandler"); // Start the output buffer*/
//$product = new products();
$results = $product->getNewarrivals(NEW_ARRIVALS_NUM_ROWS);
$str=	'<html><div class="items">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h3 class="title">'.NEW_ARRIVALS.'</h3>
      </div>';
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
 $str = $str.'<!-- Item #1 -->
      <div class="col-md-3 col-sm-4">

        <div class="item">
		<!--deal sticket-->
		<div class="newarrival"> <img src="../img/neww.png"/></div>

          <!-- Item image -->
          <div class="item-image"> <a href="#responsive"><img src="../img/photos/'.$rows['products_image'].'" alt="" /></a> </div>

          <!-- Item details -->
          <div class="item-details">

            <!-- Name -->
            <!-- Use the span tag with the class "ico" and icon link (hot, sale, deal, new) -->
            <h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">'.$rows['products_name'].'</a></h5>
            <div class="clearfix"></div>
            <!-- Para. Note more than 2 lines.
            <p>Something about the product goes here. Not More than 2 lines. Something about the product goes here. Not More than 2 lines</p>-->
            <hr />
            <!-- Price -->
            <div class="item-price pull-left "><span class="fa fa-inr"></span> '.$rows['products_price'].'</div>

            <!-- Add to cart -->

            <div class="button pull-right"><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">Details</a></div>
            <div class="clearfix"></div>
          </div>
        </div>
      </div>';
}
 $str = $str.'</div>
  </div>
</div>
<!--/ Items end --></html>';
}
echo $str;
?>

<?php
// Cache the contents to a file
/*$cached = fopen($cachefile, 'w');
fwrite($cached, ob_get_contents());
fclose($cached);
ob_end_flush(); // Send the output to the browser*/
?>
