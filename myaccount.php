<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
require_once(__DIR__.'/includes/header.php');
	if(!isset($_SESSION['logged_in'])){
		if (!headers_sent())
			{ header('Location: ./login.html ');
				exit;
				}else{
				echo '<script type="text/javascript">
			   window.location.href="./login.html";
				</script>
			   <noscript>
				<meta http-equiv="refresh" content="0;url=./login.html" />
			   </noscript>'; exit;
			}
	 }else{
		 
		 $email="'".$_SESSION['UserData'][1]."'";
		 //echo $email;
		 $results=$CustAddress->GetCustDAddress("'".$_SESSION['UserData'][1]."'");
		 $num_rows = mysqli_num_rows($results);
	 if($num_rows > 0)
	 {$rows =  mysqli_fetch_array($results);
		 $address='<!-- Your details -->
			  <div class="address">
				<address>
				  <!-- Your name -->
				  <h6><strong>'.strtoupper($rows['customers_firstname']).''.strtoupper($rows['customers_lastname']).'</strong><br></h6>
				  <!-- Address -->
				  <h7>'.strtoupper($rows['entry_street_address']).','.strtoupper($rows['entry_suburb']).'<br>
	 '.strtoupper($rows['city_name']).','.strtoupper($rows['state_name']).'-'.strtoupper($rows['entry_postcode']).'<br>

				  <!-- Phone number -->
				  <abbr title="Phone">P: </abbr> '.$rows['customers_telephone'].'<br />
				  <a href="mailto:'.$rows['customers_email_address'].'">'.$rows['customers_email_address'].'</a>
				</address></h7>
			  </div>';
	 }
	 $details=$order->QueryOrderHeader();
	$num_row_details = mysqli_num_rows($details);
	$detailed_rows='';
	if($num_rows > 0)
	{
		while($rows_details =  mysqli_fetch_array($details)){
		$detailed_rows = $detailed_rows.'<tr>
                  <td><h7>'.$rows_details['date_purchased'].'</h7></td>
                  <td><h7>'.$rows_details['orders_id'].'</h7></td>
                  <td><h7><span class="fa fa-inr"></span> '.number_format($rows_details['order_total'],2).'</h7></td>
                  <td><h7>'.$rows_details['orders_status_name'].'</h7></td>
				  <td><h7><button type="button" class="btn btn-info btn-xs Orderd" id="'.$rows_details['orders_id'].'">Show Order</button></h7></td>
                </tr>';

		}

	}
	 }

?>

<script>
$(document).ready(function()
{

 $('.Orderd').click(function(){
	 $.ajax({
             url: './includes/checkout_process.php',
             type: 'post',
			 data: {
					'Add_ID': this.id,
					'Token': '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>',
					'process':'OrderSummary',
					'notification':false
					},
			cache: false,
            success:function(data){
			$('#OrderDetails').empty();
			$('#myModalOrder').modal('show'),
            $('#OrderDetails').append(data);
             }
           });
 });
  });

</script>
<!-- Modal -->
<div id="myModalOrder" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
      </div>
      <div class="modal-body" id="OrderDetails"></div>
      <div class="modal-footer">
        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
      </div>
    </div>

  </div>
</div>


<div class="items">
  <div class="container">
    <div class="row">

      <div class="col-md-3 col-sm-3 hidden-xs">

        <!-- Sidebar navigation -->
        <h5 class="title">Pages</h5>
        <!-- Sidebar navigation -->
          <nav>
            <ul id="navi">
              <li><a href="myaccount.php">My Account</a></li>
              <!--<li><a href="wish-list.php">Wish List</a></li>-->
              <!--<li><a href="order-history.php">Order History</a></li>-->
              <li><a href="myprofile.php">Edit Profile</a></li>
            </ul>
          </nav>

      </div>

<!-- Main content -->
      <div class="col-md-9 col-sm-9">

          <h5 class="title">My Account</h5>
			<?php echo $address;?>

          <h5 class="title">My Recent Purchases</h5>

            <table class="table table-striped tcart">
              <thead>
                <tr>
                  <th>Date</th>
                  <th>ID</th>
                  <th>Price</th>
                  <th>Status</th>
				  <th>Show </th>
                </tr>
              </thead>
              <tbody>
                <?php echo $detailed_rows;?>
              </tbody>
            </table>

      </div>
    </div>
  </div>
</div>
<?php
require_once(__DIR__.'/includes/footer.php');
?>
