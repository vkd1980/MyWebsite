<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//? I biz Info Solutions

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<!-- Title here -->
<?php echo ("<title>$title ..::: Prabhus Books Online :::.. Books, Buy Books,Book Shop,Bookstore,Online Bookstore, Online Shopping,India </title>")?>
<!-- Description, Keywords and Author -->
<meta name="csrf-token" content="<?= $_SESSION['csrf_token'] ?>">
<meta name="description" content="Your description">
<meta name="keywords" content="Online Bookstore, Online Shopping, online shopping ">
<meta name="author" content="IBiz Info Solutions&reg">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<?php echo ("$meta")?>
<?php $actual_link = "http://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";?>
<link rel="stylesheet" type="text/css" href="../css/animate.min.css" />
<link rel="stylesheet" type="text/css" href="../css/blue.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap-dropdownhover.min.css" />
<link rel="stylesheet" type="text/css" href="../css/bootstrap.min.css" />
<link rel="stylesheet" type="text/css" href="../css/flexslider.css" />
<link rel="stylesheet" type="text/css" href="../css/font-awesome.min.css" />
<link rel="stylesheet" type="text/css" href="../css/jquery-ui.min.css" />
<link rel="stylesheet" type="text/css" href="../css/owl.carousel.css" />
<link rel="stylesheet" type="text/css" href="../css/settings.css" />
<link rel="stylesheet" type="text/css" href="../css/sidebar-nav.css" />
<link rel="stylesheet" type="text/css" href="../css/style.css" />
</head>
<body>
<!-- Javascript files -->
<!-- jQuery -->
<script src="../js/jquery.min.js"></script>
<script src="../js/jquery-ui.min.js"></script>
<!-- Bootstrap JS -->
<script src="../js/bootstrap.min.js"></script>
<!-- SLIDER REVOLUTION 4.x SCRIPTS -->
<script src="../js/jquery.themepunch.tools.min.js"></script>
<script src="../js/jquery.themepunch.revolution.min.js"></script>
<script src="../js/owl.carousel.min.js"></script>
<script src="../js/filter.min.js"></script>
<!-- Flex slider -->
<script src="../js/jquery.flexslider-min.js"></script>
<!-- Respond JS for IE8 -->
<script src="../js/respond.min.js"></script>
<script src="../js/jquery.md5.js"></script>
<!-- Sidebar navigation -->
<script src="../js/nav.js"></script>
<!-- HTML5 Support for IE -->
<script src="../js/html5shiv.js"></script>
<!-- Custom JS-->
<script src="../js/bootstrap-dropdownhover.min.js"></script>

	
<div class="col-md-8 pull-right">

</div>

<!-- Cart Modal starts -->
		<div id="cartModal" class="modal fade">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal" aria-hidden="true">x</button>
						<h4>Shopping Cart</h4>
						</div>
					<div class="modal-body">
						<table class="table table-striped tcart">
							<thead>
								<tr>
								  <th>Name</th>
								  <th>Quantity</th>
								  <th>Price</th>
								  <th>Total</th>
								  
								</tr>
							</thead>
							<tbody>
							<?php
        if($cart->total_items() > 0){
            //get cart items from session
            $cartItems = $cart->contents();
            foreach($cartItems as $item){
        ?>
								<tr>
								  <td><?php echo $item["name"]; ?></td>
								  <td><?php echo $item["qty"]; ?></td>
								  <td align="right"><?php echo '<span class="fa fa-inr"></span> '.number_format( (float) $item["price"], 2, '.', '').''; ?></td>
								  <td align="right"><?php echo '<span class="fa fa-inr"></span> '.number_format( (float) $item["subtotal"], 2, '.', '').''; ?></td>
								  	</tr>
								<?php } }else{ ?>
        <tr><td colspan="5"><p>Your cart is empty.....</p></td></tr>
        <?php } ?>
								<tr>
								  <th align="right">Total Weight:</th>
								  <th><?php echo $cart->total_weight()?>Kg</th>
								  <th>Total</th>
								  <th align="right"> <?php echo '<span class="fa fa-inr"></span> '.number_format( (float) $cart->total(), 2, '.', '').''; ?></th>
								  
								</tr>
							</tbody>
						</table>
					</div>
					<div class="modal-footer">
						<a  class="btn btn-warning cartclose" data-dismiss="modal"><i class="glyphicon glyphicon-menu-left"></i> Continue Shopping</a>
						<a href="../checkout.html" class="btn btn-success ">Checkout <i class="glyphicon glyphicon-menu-right"></i></a>
					</div>
				</div>
			</div>
		</div>
		<!--/ Cart modal ends -->
		
<!-- Header starts -->
<header>
  <div class="container">
    <div class="row">
      <div class="col-md-4">
        <!-- Logo. Use class "color" to add color to the text. -->
        <div class="logo"> <img src="../img/logo.png" alt="Shop @ Prabhus Books Online" title=" Shop @ Prabhus Books Online " width="400" height="100" class="img-responsive">
          <!--<h1><a href="#">Mac<span class="color bold">Kart</span></a></h1>
<p class="meta">online shopping is fun!!!</p>-->
        </div>
      </div>
      <div class="col-md-4 col-md-offset-4">
        <!-- Search form 
        <form role="form">
        <div class="input-group">
            <input type="email" class="form-control" id="search1" placeholder="Search">
			<input type="text" class="search" id="searchid" placeholder="Keywords of Book Name, Author, Category, Publisher" />
            <span class="input-group-btn">
            <button type="submit" class="btn btn-default">Search</button>
          </span> </div>
        </form>-->
        <div class="hlinks"id="Carttotal"> <span >
		<!-- item details with price -->
		<?php
		 if($cart->total_items() > 0){
		  echo '<a href="#cartModal" role="button" data-toggle="modal"> '.$cart->total_items().' Item(s) in your <i class="fa fa-shopping-cart " ></i> </a> - <span class="bold"><span class="fa fa-inr"></span> '.number_format( (float) $cart->total(), 2, '.', '').' </span> ';
		 }
		 else{
		 echo '<a href="#cartModal"  role="button" data-toggle="modal"> Your cart is empty.....</a> - <span class="bold"><span class="fa fa-inr"></span> 0.00 </span> ';
		 }
		?>
		</span>
		</div>
      </div>
    </div>
  </div>
  <!------------BOF Image Modal------------->
  <div id="imagemodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   <div class="modal-body modalimg">
    <img src="" class="imagepreview">
   </div>
   <div class="modal-footer">
   
  
  </div>
  </div>

 </div>
 </div>
  <!-----------EOF Image Modal----------------->
</header>

 <!-- for Ajax Loader-->
<div id="Addre" class="modal fade in" data-backdrop="static" data-keyboard="false" >
  <div class="loader"><img src="../img/loader.gif" align="absmiddle" style="top: 50%;left: 50%;"/></div>
</div>
<!--/ Header ends -->
<?php
require_once (__DIR__.'/menu.php');
?>