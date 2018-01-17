<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/headermenu.php');
$summary='';
$Order_ID='';
$EmailOrderMstr=$order->QueryOrderMaster(1);
$EmailOrderDet=$order->QueryOrderDetails(1);
$OrderHistory=$order->getorderHistory(1);


$rows =  mysqli_fetch_array($EmailOrderMstr);
$SubTotal=0;
$Odetails='';
$summary= '<!--BOF Order Confirmation-->
    <div class="row">
	<!-- Bof Message-->
<div class="clearfix"></div>
	  <div class="clearfix"></div>

	<div class="container">
    <div class="row">

	  </div>
	  </div>
<!-- Eof Message-->
        <div class="col-xs-12">
    		<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # '.$rows['orders_id'].'</h3>
    		</div>
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address><h6>
    				<strong>Billed To:</strong><br></h6>
    					<h7>'.strtoupper($rows['customers_name']).'<br>';

						if ((!empty($rows['customers_company']))){
						$summary= $summary.strtoupper($rows['customers_company']).'<br>';
						}
    					$summary= $summary.strtoupper($rows['customers_street_address']).' ,'.strtoupper($rows['customers_suburb']).'<br>';
    					 $summary= $summary.strtoupper($rows['customers_city']).' , '.strtoupper($rows['customers_state']).' - '.$rows['customers_postcode'].'
    				</h7></address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address><h6>
        			<strong>Shipped To:</strong><br></h6><h7>'.
    					strtoupper($rows['delivery_name']).'<br>';


						if ((!empty($rows['customers_company']))){
						$summary= $summary. strtoupper($rows['delivery_company']).'<br>';
						}

    					$summary= $summary. strtoupper($rows['delivery_street_address']).' , '.strtoupper($rows['delivery_suburb']).'<br>';
    					$summary= $summary. strtoupper($rows['delivery_city']).' ,'.strtoupper($rows['delivery_state']).' - '.$rows['delivery_postcode'].'
    				</h7></address>
    			</div>
    		</div>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    					<strong>Payment Method:</strong><br><h7>
    					'.$rows['payment_method'].'<br></h7>

    				</address>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
    					<strong>Shipping Method:</strong><br><h7>
    					'.$rows['shipping_method'].'<br></h7>

    				</address>
    			</div>
    		</div>

    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order Details</strong></h3>
    			</div>
    			<div class="panel-body">
    				<div class="table-responsive">
    					<table class="table table-condensed">
    						<thead>
                                <tr>
        							<td><strong>Item</strong></td>
									<td class="text-center"><strong>Quantity</strong></td>
        							<td class="text-right"><strong>Price</strong></td>

        							<td class="text-right"><strong>Totals</strong></td>
                                </tr>
    						</thead>
    						<tbody>';
                while($rowsD=mysqli_fetch_array($EmailOrderDet)){
      							$SubTotal=$SubTotal+$rowsD['final_price'];
      										 $Odetails=$Odetails.'<tr>
          								<td><h7>'.strtoupper($rowsD['products_name']).'</h7></td>
          								<td class="text-center"><h7>'.$rowsD['products_quantity'].'</h7></td>
      									<td class="text-right"><h7><span class="fa fa-inr"></span>'.number_format($rowsD['products_price'],2).'</h7></td>
          								<td class="text-right"><h7><span class="fa fa-inr"></span> '.number_format($rowsD['final_price'],2).'</h7></td>
          							</tr>';
      										 }
                           $summary= $summary.$Odetails;


                 							$summary= $summary.'<tr>
                  <td class="thick-line"></td>
                  <td class="thick-line"></td>
                  <td class="thick-line text-center"><h6><strong>Subtotal</strong></h6></td>
                  <td class="thick-line text-right"><h6><span class="fa fa-inr"></span>'.number_format($SubTotal,2).'</h65></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center"><h6><strong>Shipping</strong></h6></td>
                  <td class="no-line text-right"><h6><span class="fa fa-inr"></span> '.number_format($rows['shipping_cost'],2).'</h6></td>
                </tr>
                <tr>
                  <td class="no-line"></td>
                  <td class="no-line"></td>
                  <td class="no-line text-center"><h6><strong>Total</strong></h6></td>
                  <td class="no-line text-right"><h6><span class="fa fa-inr"></span>'.number_format($rows['order_total'],2).'</h6></td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>

<!--Eof Order Confirmation-->';


?>

<button type="button" class="btn btn-info btn-xs Orderd" id="'.$rows_details['orders_id'].'">Show Order</button>
<!-- Modal -->
<div id="myModalOrder" class="modal fade bs-example-modal-lg" role="dialog">
  <div class="modal-dialog modal-dialog modal-lg"style="width: 99%;height: 100%;margin: 10px;padding:0;overflow-y:initial !important">

    <!-- Modal content-->
    <div class="modal-content" style="height:auto;min-height: 100%;border-radius: 0;height: 250px;overflow-y: auto;">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="OrderDetails"><?php echo $summary;?></div>
      <?php
      while($Ordrows =  mysqli_fetch_array($OrderHistory)){
        echo $Ordrows['comments'] ;
      }

       ?>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>
<?php
require_once(__DIR__.'/includes/footer.php');
?>
<script>
$(document).ready(function()
{

 $('.Orderd').click(function(){
   $('#myModalOrder').modal('show');
 });
  });

</script>
