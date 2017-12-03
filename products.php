<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//? I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
$pid='';
$Type='';
if(isset($_REQUEST['Pid']) && $_REQUEST['Pid'] != ""){

$pid = filter_var($_REQUEST["Pid"],  FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$Type = filter_var($_REQUEST["Type"], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
$actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
$recentview->setRecentlyViewed($pid);
$html='<!-- Main content -->
      <div class="col-md-9 col-sm-9">
	 <b> <div id ="display_cart_message" align="center"></div></b>
               <!-- Product details -->
        <div class="product-main">
          <div class="row">
            <div class="col-md-6 col-sm-6">
              ';
			  $meta='';
			  $title='';
	  switch($Type){
case "Featured":
$results = $product->getfeaturedbyID($pid,"'".date("Y-m-d")."'");
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
 $meta= $meta.'<meta property=og:type content=books.book /><meta property=og:title content='.$rows["products_name"].' /><meta property="books:isbn" content="'.$rows["products_model"].'" /><meta property= og:url content='.curPageURL().'/><meta property=og:description content="ISBN/CODE : '.$rows["products_model"].' Author : '.$rows["products_author"].' Publisher : '.$rows["manufacturers_name"].' Subject : '.$rows["categories_name"].'" /><meta property=og:image content=http://'.$_SERVER["SERVER_NAME"].'/img/photos/'.$rows["products_image"].' />';
 $title=$rows["products_name"].' ['.$rows["products_model"].'] -&#8377; '.$rows["products_price"] ;
$html.='<!-- Image. Flex slider -->

              <div class="product-slider">

                <div class="product-image-slider flexslider">
				     <ul class="slides">
                    <!-- Each slide should be enclosed inside li tag. -->
                    <!-- Slide #1 -->
                    <li>
                      <!-- Image --><!-- Image --><img src="../img/photos/'.$rows["products_image"].'" alt=""/> </li>

                                      </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <!-- Title -->
			  <form  name="frmproduct" id="frmproduct" method="post" action="/includes/shoppingcart_process.php">
			  <input type="hidden" id="ProdId" name="ProdId" value="'.$rows["prodid"].'" />
			  <input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
			   <input type="hidden" name="ProdName" id="ProdName" value="'.$rows["products_name"].'" />
			   <input type="hidden" name="action" id="action" value="addToCart" />
			  <input type="hidden" id="ProdPrice" name="ProdPrice" value="'.str_replace(',', '',$rows["products_price"]).'" />
			  <input type="hidden" id="ProQty" name="ProQty" value="1" />
			  <input type="hidden" id="ProWeight" name="ProWeight" value="'.$rows["products_weight"].' />
			  <h4 class="title">'.$rows["products_name"].'</h4>

              <p>ISBN/CODE : '.$rows["products_model"].'</p>
			  <p>Author : '.$rows["products_author"].'</p>
			  <p>Edn : '.$rows["products_edition"].'</p>
              <p>Publisher : '.$rows["manufacturers_name"].'</p>
			  <p>Subject : '.$rows["categories_name"].'</p>
			  <h5>Price : <span class="fa fa-inr"></span> '.$rows["products_price"].' </h5>';
			 if( $rows["products_quantity"] <=0) {
			 $html.='<p>Availability : <b>Out of Stock</b></p>
			 <!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">

                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>
                </div>
              </div>
             </div>';
			  }
			  else{
			  $html.='<p>Availability : In Stock</p><!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                   <!-- <input type="text" id="prodqty" name="prodqty" class="form-control input-sm" value="1">-->
                    <span class="input-group-btn">
                   <button class="btn btn-primary btn-sm" type="submit">Add to Cart</button>
				     <!-- Add to wish list -->
					<button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>
                </div>
              </div>
            </div>';
			  }
			  $html.='</div>
        </div>
        <br />
		 </form>
       <!-- Description, specs and review -->
		<ul class="nav nav-tabs">
          <!-- Use uniqe name for "href" in below anchor tags -->';
		  if(!empty($rows["products_description"]))
		  {

           $html.='<li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
          <li><a href="#tab3" data-toggle="tab">Review <b>Featured</b> (5)</a></li>
        </ul>
		  <div class="tab-content">
          <div class="tab-pane active" id="tab1">

            <p>'.$rows["products_description"].'</p>

			</div>
			<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">';
			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span>Rating <span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}
			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
              <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">
                <!-- Name-->
				<div id="display_error_review" style="display:none" ><b></b></div>

                <div class="form-group">

                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  	<input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'" readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
					                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
               <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>

              </form>
            </div>
			</div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div>
		</div>';
  }
			}
			else{
			$html.='<li class="active"><a href="#tab3" data-toggle="tab">Review <b>Featured</b>(5)</a></li>
        </ul>
		<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">
			';

			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span><span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}

			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
               <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">

                <!-- Name -->
				<div id="display_error_review" style="display:none" ><b></b></div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  <input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'" readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >

                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
                   <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
				 </div>
              </form>
            </div></div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div></div>';
  }


			}

    }
	}
	else
	{
	echo "No Such Product";
	}

break;
case "Specials":
$results = $product->getspecialsbyID($pid,"'".date("Y-m-d")."'");
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
$meta= $meta.'<meta property=og:type content=books.book /><meta property=og:title content='.$rows["products_name"].' /><meta property="books:isbn" content="'.$rows["products_model"].'" /><meta property= og:url content='.curPageURL().'/><meta property=og:description content="ISBN/CODE : '.$rows["products_model"].' Author : '.$rows["products_author"].' Publisher : '.$rows["manufacturers_name"].' Subject : '.$rows["categories_name"].'" /><meta property=og:image content=http://'.$_SERVER["SERVER_NAME"].'/img/photos/'.$rows["products_image"].' />';
 $title=$rows["products_name"].' ['.$rows["products_model"].'] -&#8377; '.$rows["products_price"] ;
$disc=(100-( str_replace("," , "", $rows["specials_new_products_price"])/ str_replace("," , "", $rows["products_price"]))*100);
$html.='<!-- Image. Flex slider -->

              <div class="product-slider">

                <div class="product-image-slider flexslider">
				<div class="newarrival"> <img src="../img/SpecialPrice.png"/></div>
                  <ul class="slides">
                    <!-- Each slide should be enclosed inside li tag. -->
                    <!-- Slide #1 -->
                    <li>
                      <!-- Image --><!-- Image --><img src="../img/photos/'.$rows["products_image"].'" alt=""/> </li>


                                      </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <!-- Title -->
			  <form  name="frmproduct" id="frmproduct" method="post" action="/includes/shoppingcart_process.php">
			  <input type="hidden" id="ProdId" name="ProdId" value="'.$rows["prodid"].'" />
			  <input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
			  <input type="hidden" name="ProdName" id="ProdName" value="'.$rows["products_name"].'" />
			  <input type="hidden" name="action" id="action" value="addToCart" />
			   <input type="hidden" id="ProdPrice" name="ProdPrice" value="'.str_replace(',', '',$rows["special_price"]).'" />
			    <input type="hidden" id="ProQty" name="ProQty" value="1" />
				<input type="hidden" id="ProWeight" name="ProWeight" value="'.$rows["products_weight"].' />
			 <h4 class="title">'.$rows["products_name"].'</h4>
              <p>ISBN/CODE : '.$rows["products_model"].'</p>
			  <p>Author : '.$rows["products_author"].'</p>
			  <p>Edn : '.$rows["products_edition"].'</p>
              <p>Publisher : '.$rows["manufacturers_name"].'</p>
			  <p>Subject : '.$rows["categories_name"].'</p>
			  <h5 style="text-decoration: line-through">Regular Price : <span class="fa fa-inr"></span> '.$rows["products_price"].' </h5>
			  <h5 > You Save '.(round($disc,2)).' % </h5>
			   <h5>Price : <span class="fa fa-inr"></span> '.$rows["special_price"].' </h5>';

			  if( $rows["products_quantity"] <=0) {
			 $html.='<p>Availability : <b>Out of Stock</b></p>
			 <!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">

                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>
                </div>
              </div>
             </div>';
			  }
			  else{
			  $html.='<p>Availability : In Stock</p><!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">
                    <!-- <input type="text" id="prodqty" name="prodqty" class="form-control input-sm" value="1">-->
                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="submit">Add to Cart</button>
					<button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>
                </div>
              </div>
              </div>';
			  }


             $html.='</div>
        </div>
        <br />
		</form>
        <!-- Description, specs and review -->
		<ul class="nav nav-tabs">
          <!-- Use uniqe name for "href" in below anchor tags -->';
		  if(!empty($rows["products_description"]))
		  {

           $html.='<li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
          <li><a href="#tab3" data-toggle="tab">Review <b>Specials</b> (5)</a></li>
        </ul>
		  <div class="tab-content">
          <div class="tab-pane active" id="tab1">

            <p>'.$rows["products_description"].'</p>

			</div>
			<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">';
			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span>Rating <span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}
			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
              <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">
                <!-- Name-->
				<div id="display_error_review" style="display:none" ><b></b></div>

                <div class="form-group">

                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  	<input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'" readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
					                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
               <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>

              </form>
            </div>
			</div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div>
		</div>';
  }
			}
			else{
			$html.='<li class="active"><a href="#tab3" data-toggle="tab">Review <b>Specials</b>(5)</a></li>
        </ul>
		<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">
			';

			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span><span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}

			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
               <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">

                <!-- Name -->
				<div id="display_error_review" style="display:none" ><b></b></div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  <input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'" readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >

                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
                   <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>

                </div>
              </form>
            </div></div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div></div>';
  }


			}

    }
	}
	else
	{
	echo "<h2>No Such Product</h2>";
	}

break;
default:
$results = $product->getproduct($pid);
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
$meta= $meta.'<meta property=og:type content=books.book /><meta property=og:title content='.$rows["products_name"].' /><meta property="books:isbn" content="'.$rows["products_model"].'" /><meta property= og:url content='.curPageURL().'/><meta property=og:description content="ISBN/CODE : '.$rows["products_model"].' Author : '.$rows["products_author"].' Publisher : '.$rows["manufacturers_name"].' Subject : '.$rows["categories_name"].'" /><meta property=og:image content=http://'.$_SERVER["SERVER_NAME"].'/img/photos/'.$rows["products_image"].' />';
 $title=$rows["products_name"].' ['.$rows["products_model"].'] -&#8377; '.$rows["products_price"] ;
$html.='<!-- Image. Flex slider -->

              <div class="product-slider">

                <div class="product-image-slider flexslider">
				     <ul class="slides">
                    <!-- Each slide should be enclosed inside li tag. -->
                    <!-- Slide #1 -->
                    <li>
                      <!-- Image --><img src="../img/photos/'.$rows["products_image"].'" alt=""/> </li>

                                      </ul>
                </div>
              </div>
            </div>
            <div class="col-md-6 col-sm-6">
              <!-- Title -->
			   <form name="frmproduct" id="frmproduct" method="post" action="/includes/shoppingcart_process.php">
			  <input type="hidden" id="ProdId" name="ProdId" value="'.$rows["prodid"].'" />
			  <input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
			  <input type="hidden" name="ProdName" id="ProdName" value="'.$rows["products_name"].'" />
			   <input type="hidden" name="action" id="action" value="addToCart" />
			  <input type="hidden" id="ProdPrice" name="ProdPrice" value="'.str_replace(',', '',$rows["products_price"]).'" />
			  <input type="hidden" id="ProQty" name="ProQty" value="1" />
			  <input type="hidden" id="ProWeight" name="ProWeight" value="'.$rows["products_weight"].' />
			 <h4 class="title">'.$rows["products_name"].'</h4>
              <p>ISBN/CODE : '.$rows["products_model"].'</p>
			  <p>Author : '.$rows["products_author"].'</p>
			  <p>Edn : '.$rows["products_edition"].'</p>
              <p>Publisher : '.$rows["manufacturers_name"].'</p>
			  <p>Subject : '.$rows["categories_name"].'</p>
			  <h5>Price : <span class="fa fa-inr"></span> '.$rows["products_price"].' </h5>';
			 if( $rows["products_quantity"] <=0) {
			 $html.='<p>Availability : <b>Out of Stock</b></p>
			 <!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">

                    <span class="input-group-btn">
                    <button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>
                </div>
              </div>
             </div>';
			  }
			  else{
			  $html.='<p>Availability : In Stock</p><!-- Quantity and add to cart button -->
              <div class="row">
                <div class="col-md-6">
                  <div class="input-group">

                    <span class="input-group-btn">

                    <button class="btn btn-primary btn-sm" type="submit">Add to Cart</button>
					<button class="btn btn-primary btn-sm" type="button">Add to Wish List</button>
                    </span> </div>

                </div>
              </div>
              <!-- Add to wish list
              <a href="wish-list.php">+ Add to Wish List</a> </div> -->';
			  }
			  $html.='</div>
        </div>
        <br />
		</form>
        <!-- Description, specs and review -->
		<ul class="nav nav-tabs">
          <!-- Use uniqe name for "href" in below anchor tags -->';
		  if(!empty($rows["products_description"]))
		  {

           $html.='<li class="active"><a href="#tab1" data-toggle="tab">Description</a></li>
          <li><a href="#tab3" data-toggle="tab">Review <b>Defaultt</b> (5)</a></li>
        </ul>
		  <div class="tab-content">
          <div class="tab-pane active" id="tab1">

            <p>'.$rows["products_description"].'</p>

			</div>
			<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">';
			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span>Rating <span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}
			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
              <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">
                <!-- Name-->
				<div id="display_error_review" style="display:none" ><b></b></div>

                <div class="form-group">

                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  	<input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'"readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
					                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
               <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>

              </form>
            </div>
			</div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div>
		</div>';
  }
			}
			else{
			$html.='<li class="active"><a href="#tab3" data-toggle="tab">Review <b>Defaultt</b>(5)</a></li>
        </ul>
		<div class="tab-pane" id="tab3">
			 <h5>Product Reviews</h5>
            <hr />
			<div id="accordion">
			';

			$resultreview = $review->showreview($pid);
			$num_rows_review = mysqli_num_rows($resultreview);
			if($num_rows_review > 0){
			while($review_rows =  mysqli_fetch_array($resultreview)){
			 $html.='<h3>'.$review_rows["customers_name"].' - <span class="color"></span><span class="stars">'. $review_rows["reviews_rating"].'</span></h3>
 <div>

              <p class="rmeta">'.$review_rows["date_added"].'</p>
              <p id="para" >'.$review_rows["reviews_text"].'</p>
		 </div>';
			}

			}

  $html.='</div>';
			if(isset($_SESSION['logged_in'])){
$html.='<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">

              <!-- Review form (not working)-->
               <form class="form-horizontal" name="frmreview" id="frmreview" method="post" action="/includes/review_process.php" autocomplete="off">

                <!-- Name -->
				<div id="display_error_review" style="display:none" ><b></b></div>
                <div class="form-group">
                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  <input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" name="Custname" id="Custname" value="'.$_SESSION['UserData'][2].'"readonly="true">
					<input type="hidden" name="Token" value="'.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >

                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
                   <textarea class="form-control" id="reviews" name="reviews" placeholder="Write Review"  required > </textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" id="reset" class="btn btn-default">Reset</button>
                  </div>

                </div>
              </form>
            </div></div>';
  }
  else
  {
  $html.='<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html?camefrom='.$actual_link.'">Login</a> to Write Review</h5>
        </div>
        </div></div>';
  }


			}

    }
	}
	else
	{
	echo "<h2>No Such Product</h2>";
	}
break;
}

 }
 else
 {
 			$status = "error";
            $message = "Ooops, Theres been a technical error!";
			$data = array(
        		'status'.$pid => $status,
        		'message'.$Type => $message
    );
	//header("Location: index.php");
	echo json_encode($data);

  exit;
 }
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/menu.php');



?>
<!-- Items -->
<div class="items">
  <div class="container">
    <div class="row">
      <!-- Sidebar -->
      <div class="col-md-3 col-sm-3 hidden-xs">
        <?php
				//require_once(__DIR__.'/includes/Sidebar/sidebar_menu.php');
				require_once(__DIR__.'/includes/Sidebar/sidebar_featured.php');
				 			?>
        <br />
      </div>

	  <?php

echo $html;
	  ?>


        </div>
	   </div>
    </div>
  </div>
</div>
<script>

$( function() {
    $( "#accordion" ).accordion({
	  animate: 1200,
	  heightStyle: "content"
    });

  } );
  /*/////////////////////*/
  $.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});
/****************************/
(function(a){
    a.fn.codexworld_rating_widget = function(p){
        var p = p||{};
        var b = p&&p.starLength?p.starLength:"5";
        var c = p&&p.callbackFunctionName?p.callbackFunctionName:"";
        var e = p&&p.initialValue?p.initialValue:"0";
        var d = p&&p.imageDirectory?p.imageDirectory:"img";
        var r = p&&p.inputAttr?p.inputAttr:"";
        var f = e;
        var g = a(this);
        b = parseInt(b);
        init();
        g.next("ul").children("li").hover(function(){
            $(this).parent().children("li").css('background-position','0px 0px');
            var a = $(this).parent().children("li").index($(this));
            $(this).parent().children("li").slice(0,a+1).css('background-position','0px -28px')
			/////////////////
			var a = $(this).parent().children("li").index($(this));
            var attrVal = (r != '')?g.attr(r):'';
            f = a+1;
            g.val(f);
            if(c != ""){
                eval(c+"("+g.val()+", "+attrVal+")")
            }
			////////////////
        },function(){});
        g.next("ul").children("li").click(function(){
            var a = $(this).parent().children("li").index($(this));
            var attrVal = (r != '')?g.attr(r):'';
            f = a+1;
            g.val(f);
            if(c != ""){
                eval(c+"("+g.val()+", "+attrVal+")")
            }
        });
        g.next("ul").hover(function(){},function(){
            if(f == ""){
                $(this).children("li").slice(0,f).css('background-position','0px 0px')
            }else{
                $(this).children("li").css('background-position','0px 0px');
                $(this).children("li").slice(0,f).css('background-position','0px -28px')
            }
        });
        function init(){
            $('<div style="clear:both;"></div>').insertAfter(g);
            g.css("float","left");
            var a = $("<ul>");
            a.addClass("codexworld_rating_widget");
            for(var i=1;i<=b;i++){
                a.append('<li style="background-image:url('+d+'/widget_star.gif)"><span>'+i+'</span></li>')
            }
            a.insertAfter(g);
            if(e != ""){
                f = e;
                g.val(e);
                g.next("ul").children("li").slice(0,f).css('background-position','0px -28px')
            }
        }
    }
})(jQuery);
$(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '',
        //callbackFunctionName: 'processRating',
        imageDirectory: '../img/',
        //inputAttr: 'postID'
    });
});
</script>
<script>
$(document).ready(function(){
    $('#frmreview').submit(function(){

    //check the form is not currently submitting
    if($(this).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $(this),
         formData = form.serialize()+ "&prodid=" + $('#ProdId').val(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
         responseMsg = $('#display_error_review');

         //add status data to form
         form.data('formstatus','submitting');

         //show response message - waiting
         responseMsg.hide()
                    .addClass('alert alert-info fade in')
                    .text('Please Wait...')
                    .fadeIn(200);

         //send data to server for validation
         //send data to server for validation
         $.ajax({
             url: formUrl,
             type: formMethod,
             data: formData,
             success:function(data){

                //setup variables
                var responseData = jQuery.parseJSON(data),
                    klass = '';

                //response conditional
                switch(responseData.status){
                    case 'error':
                        klass = 'alert alert-danger fade in';
						$("#reviews").val('');
						$("#rating_star").val('0');
                    break;
                    case 'success':
                        klass = 'alert alert-success fade in';
						$("#reviews").val('');
						$("#rating_star").val('0');
                    break;
                }

                //show reponse message
                responseMsg.fadeOut(200,function(){
                   $(this).removeClass('alert alert-info fade in')
                          .addClass(klass)
                          .text(responseData.message)
                          .fadeIn(200,function(){
                              //set timeout to hide response message
                              setTimeout(function(){
                                  responseMsg.fadeOut(200,function(){
                                      $(this).removeClass(klass);
                                      form.data('formstatus','idle');
                                  });
                               },3000)
                           });
                });
           }
      });
    }

    //prevent form from submitting
    return false;

    });
	//
	$('#frmproduct').submit(function(){

    //check the form is not currently submitting
    if($(this).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $(this),
         formData = form.serialize(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
         responseMsg = $('#display_cart_message');

         //add status data to form
         form.data('formstatus','submitting');

          //send data to server for validation
            $.ajax({
             url: formUrl,
             type: formMethod,
             data: formData,
             success:function(data){

                //setup variables
                var responseData = jQuery.parseJSON(data);

                //response conditional
                switch(responseData.status){
                    case 'error':
                       alert(responseData.message);
					   form.data('formstatus','idle');
					   location.reload();
					break;
                    case 'Success':
					$.ajax({
							type: "POST",
							url: "../includes/shoppingcart_process.php",
							data: 'action=ShowCart',
							cache: false,
							success: function(html)
							{
							$('#cartModal').empty();
							$('#cartModal').html(html);
							$('#cartModal').modal('show');
							}
							});
							$.ajax({
							type: "POST",
							url: "../includes/shoppingcart_process.php",
							data: 'action=ShowCartTotal',
							cache: false,
							success: function(html)
							{
							$('#Carttotal').empty();
							$('#Carttotal').html(html).show();
								}
							});
                       form.data('formstatus','idle');
					break;
                }


           }
      });
    }

    //prevent form from submitting
    return false;

    });
	//
	$( "#reset" ).click(function() {
	 var form = $('#frmreview');
  $("#reviews").val('');
  $("#rating_star").val('0');
  form.data('formstatus','idle');
});


})
</script>
<style>
span.stars, span.stars span {
    display: block;
	background: url(../img/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}
.codexworld_rating_widget{
    padding: 0px;
    margin: 0px;
    float: left;
}
.codexworld_rating_widget li{
    line-height: 0px;
    width: 28px;
    height: 28px;
    padding: 0px;
    margin: 0px;
    margin-left: 2px;
    list-style: none;
    float: left;
    cursor: pointer;
}
.codexworld_rating_widget li span{
    display: none;
}
</style>
<?php
require_once (__DIR__.'/includes/recent.php');
include(__DIR__.'/includes/footer.php');
?>
