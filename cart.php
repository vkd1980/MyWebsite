<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
$Ptoken= hash_hmac('sha256', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], $_SESSION['csrf_token']);
?>

    <script>
	function Updatecart(obj,action,id,prodid){
	 	switch(action){
	 		case 'updateCartItem':
            //update
			$.get("/includes/shoppingcart_process.php", {action:"updateCartItem", id:id, prodid:prodid, qty:obj.value,Token:'<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'}, function(data){
            if(data == 'ok'){
                location.reload();
            }else if(data == 'Stkerr') {
                alert('Cart Update Failed, Does not Have Enough Stock.');
				location.reload();
            }
			else{
			alert('Cart Update Failed, please try again.');
			location.reload();
			}
        });
			break;
			case 'removeCartItem':
			if(confirm('Are you Sure')==true){
            //removeCartItem
			$.get("/includes/shoppingcart_process.php", {action:"removeCartItem", id:id, Token:'<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'}, function(data){
            if(data == 'ok'){
                location.reload();
            }else{
                alert('Failed to Remove, please try again.');

            }
        });

		}
			break;

	 	}
	}

        </script>
<!-- Cart starts -->

<div class="cart">
  <div class="container">
    <div class="row">
      <div class="col-md-12">

        <!-- Title with number of items in shopping kart -->
          <h3 class="title"><i class="fa fa-shopping-cart"></i> Items in Your Cart [<span class="color"><?php echo $cart->total_items();?></span>]</h3>
            <br />

			<div class="table-responsive">
            <!-- Table -->
              <table class="table table-striped tcart">
                <thead>
                  <tr>
                    <th>&nbsp;</th>
                    <th>Name</th>
                    <th>Quantity</th>
                    <th>Unit Price</th>
                    <th >Total</th>
					<th>&nbsp;</th>
                  </tr>
                </thead>
                <tbody>


<?php

if($cart->total_items() > 0){
 $cartItems = $cart->contents();
 foreach($cartItems as $item){
 $Cartresults= $product->getprodbyid($item['id']);
 $num_rows = mysqli_num_rows($Cartresults);
 if($num_rows > 0){
 while($rows =  mysqli_fetch_array($Cartresults)){

 if($product->CheckspecialsbyID($item['id'],"'".date("Y-m-d")."'")){
//render specialLink
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
					<td><h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5></td>';

}
elseif($product->CheckfeaturedbyID($item['id'],"'".date("Y-m-d")."'")){
// Render FeaturedLink
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
                    <td><h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5></td>';

}
else{
//render normal Link
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
                    <td><h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5></td>';

}





                    echo '<!-- Quantity with refresh and remove button -->
                    <td class="item-input">
					<div class="input-group">
					<input type="number" class="form-control text-center" value="'.$item["qty"].'" onChange="Updatecart(this,\'updateCartItem\',\''.$item["rowid"].'\','.$item["id"].')">

						</div>
                    </td>
                    <!-- Unit price -->
                    <td><h5><span class="fa fa-inr"></span> '.number_format($item["price"],2).'</h5></td>
                    <!-- Total cost -->
                    <td><h5><span class="fa fa-inr"></span> '.number_format($item["subtotal"],2).'</h5></td>
					 <td><span class="input-group-btn">

	<a class="btn btn-danger" onClick="Updatecart(this,\'removeCartItem\',\''.$item["rowid"].'\','.$item["id"].')"><i class="fa fa-trash"></i></a>

							</span></td>
                  </tr>';

 }

 }


 }
 }else{
 /*Cart Is Empty*/
  echo '<tr><td colspan="6"><p> <h3>Your cart is empty.....</h></p></td></tr>';

 }
?>


                  <tr>
                    <td><h5>Total Weight: <?php echo $cart->total_weight();?> Kg</h5></td>
                    <td align="right"><h5>Total</h5></td>
                    <td align="center"><h5><?php echo $cart->total_qty();?></h5></td>
                    <td >&nbsp;</td>
                    <td><h5><span class="fa fa-inr"></span> <?php echo number_format($cart->total(),2) ;?></h5></td>
					<td>&nbsp;</td>

                  </tr>
				  </tbody>
              </table>
			</div>


              <!--<form class="form-inline">
              <!-- Discount Coupen -->
                <!--<h5 class="title">Discount Coupen</h5>
                <div class="form-group">
					<input type="email" class="form-control" id="" placeholder="Discount Coupon">
				</div>

				<button type="submit" class="btn btn-default">Apply</button>
                <br />
                <br />
                <!-- Gift coupen -->
                <!--<h5 class="title">Gift Coupen</h5>
                <div class="form-group">
					<input type="email" class="form-control" id="" placeholder="Gift Coupon">
				</div>

				<button type="submit" class="btn btn-default">Apply</button>
              </form>

               <!-- Button s-->
              <div class="row">
                <div class="col-md-4 col-md-offset-8">
                  <div class="pull-right">
                    <a href="index.php" class="btn btn-default">Continue Shopping</a>
                    <a href="checkout.php" class="btn btn-danger">CheckOut</a>
                  </div>
                </div>
              </div>

      </div>
    </div>
  </div>
</div>

<!-- Cart ends -->

<?php
include(__DIR__.'/includes/footer.php');
?>
