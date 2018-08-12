<?php
//if((empty($_SERVER['HTTP_X_REQUESTED_WITH']) or strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) != 'xmlhttprequest') or empty($_REQUEST)){/*Detect AJAX and POST request*/
  //$response= array("ERROR","Hacking attempt");
	//echo json_encode($response);
  //exit();
//}
require_once (__DIR__.'/classes/global.inc.php');
if(!empty($_REQUEST['Token']) && (hash_equals($_REQUEST['Token'],hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/orders.php', $_SESSION['csrf_token']))) && !empty($_REQUEST['action']) ){
  $action = isset($_REQUEST['action']) ? filter_var(($_REQUEST['action']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH): '';
  switch($action) {
    case "All":
    $requestData= $_REQUEST;
    $columns = array(
    // datatable column index  => database column name
      1 => 'orders.orders_id',
      2 => 'date_purchased',
      3 => 'customers.customers_firstname customers.customers_lastname',
      4 => 'order_total',
      5 => 'orders_status_name');
      $OrderMaster= $order->QueryOrderHeader();

  $sql = "SELECT orders_id FROM orders ";
  $query=$db->select($sql);
  $totalData = mysqli_num_rows($query);
  $totalFiltered = $totalData;
  $sql="SELECT orders.orders_id,orders.customers_id,orders.date_purchased,orders.order_total,orders_status.orders_status_name,customers.customers_firstname,customers.customers_lastname
FROM (orders
LEFT JOIN orders_status ON orders.orders_status = orders_status.orders_status_id)
LEFT JOIN customers ON customers.customers_id = orders.customers_id WHERE orders_status.orders_status_id<>0 ";
//$sql .="WHERE orders_status.orders_status_id<>0";
if( !empty($requestData['search']['value']) ) {   // if there is a search parameter, $requestData['search']['value'] contains search parameter
$sql.=" AND ( customers.customers_firstname LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR customers.customers_lastname LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
$sql.=" OR orders_status.orders_status_name LIKE '%".filter_var(($requestData['search']['value']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."%' ";
}
$query=$db->select($sql);
$totalFiltered = mysqli_num_rows($query); // when there is a search parameter then we have to modify total number filtered rows as per search result.
$sql.=" ORDER BY ". $columns[filter_var(($requestData['order'][0]['column']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)]."   ".filter_var(($requestData['order'][0]['dir']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH)."  LIMIT ".filter_var(($requestData['start']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ,".filter_var(($requestData['length']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH)." ";
//echo $sql;
$query=$db->select($sql);
$data = array();
$i=1;
while( $row=mysqli_fetch_array($query) ) {  // preparing an array
  $nestedData=array();
  $nestedData[] =$i;
  $nestedData[] = $row["orders_id"];
  $nestedData[] = $row["date_purchased"];
  $nestedData[] =$row["customers_firstname"].''.$row["customers_lastname"];
  //$nestedData[] = $row["customers_lastname"];
  $nestedData[] = $row["order_total"];
  $nestedData[] = $row["orders_status_name"];
  $data[] = $nestedData;
  $i++;
}
$json_data = array(
      //"draw"            => intval( $requestData['draw'] ),   // for every request/draw by clientside , they send a number as a parameter, when they recieve a response/data they first check the draw number, so we are sending same number in draw.
      "recordsTotal"    => intval( $totalData ),  // total number of records
      "recordsFiltered" => intval( $totalFiltered ), // total number of records after searching, if there is no searching then totalFiltered = totalData
      "data"            => $data   // total data array
      );
echo json_encode($json_data);  // send data as json format
    break;
case "UpdateOrdrStatus":
$OrderID= isset($_REQUEST['OrderID']) ? filter_var(($_REQUEST['OrderID']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$Comments= isset($_REQUEST['comments']) ? filter_var(($_REQUEST['comments']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$StatusID=isset($_REQUEST['StatusID']) ? filter_var(($_REQUEST['StatusID']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
$StatusIDName=isset($_REQUEST['StatusIDName']) ? filter_var(($_REQUEST['StatusIDName']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH) : '';
$result= $order->SaveOrderStatusHistory($OrderID,$StatusID,$Comments);
        if (($result==true) &&($StatusID==!0)) {
        $query = "UPDATE `orders` SET `orders_status`='".$StatusID."',`last_modified`='".date("Y-m-d H:i:s",time())."' WHERE  `orders_id`='".$OrderID."'";
        //echo json_encode($db->updatedb($query));
        $Status= $db->updatedb($query);
        //print_r($Status);
              if (($Status[0]=="OK") && ($_REQUEST['Notify']=='on') )
              {
              //BOF send SMS and Mail
              //BOF Order Confirmation
          		$EmailOrderMstr=$order->QueryOrderMaster($OrderID);
          		$EmailOrderDet=$order->QueryOrderDetails($OrderID);
          		$rows =  mysqli_fetch_array($EmailOrderMstr);
          		$SubTotal=0;
          		$Odetails='';

          					// BOF Send Mail

          					$message_html = file_get_contents('../../email/email_status.html');
          					$message_html = str_replace('%customers_name%', strtoupper($rows['customers_name']), $message_html);
                    $message_html = str_replace('%Status%', strtoupper($StatusIDName), $message_html);
                    $message_html = str_replace('%Remark%', $Comments, $message_html);
          					$message_html = str_replace('%orders_id%', $rows['orders_id'], $message_html);
          					$message_html = str_replace('%date_purchased%', $rows['date_purchased'], $message_html);
          					$message_html = str_replace('%customers_company%', strtoupper($rows['customers_company']), $message_html);
          					$message_html = str_replace('%customers_street_address%', strtoupper($rows['customers_street_address']), $message_html);
          					$message_html = str_replace('%customers_suburb%', strtoupper($rows['customers_suburb']), $message_html);
          					$message_html = str_replace('%customers_city%', strtoupper($rows['customers_city']), $message_html);
          					$message_html = str_replace('%customers_state%', strtoupper($rows['customers_state']), $message_html);
          					$message_html = str_replace('%customers_postcode%', $rows['customers_postcode'], $message_html);
          					$message_html = str_replace('%customers_telephone%', $rows['customers_telephone'], $message_html);

          					$message_html = str_replace('%delivery_name%', strtoupper($rows['delivery_name']), $message_html);
          					$message_html = str_replace('%delivery_company%',strtoupper( $rows['delivery_company']), $message_html);
          					$message_html = str_replace('%delivery_street_address%', strtoupper($rows['delivery_street_address']), $message_html);
          					$message_html = str_replace('%delivery_suburb%',strtoupper( $rows['delivery_suburb']), $message_html);
          					$message_html = str_replace('%delivery_city%', strtoupper($rows['delivery_city']), $message_html);
          					$message_html = str_replace('%delivery_state%', strtoupper($rows['delivery_state']), $message_html);
          					$message_html = str_replace('%delivery_postcode%', $rows['delivery_postcode'], $message_html);
          					$message_html = str_replace('%customers_telephone%', $rows['customers_telephone'], $message_html);

          					$message_html = str_replace('%ip_address%', $rows['ip_address'], $message_html);
          					$message_html = str_replace('%payment_method%', $rows['payment_method'], $message_html);
          					$message_html = str_replace('%shipping_method%', $rows['shipping_method'], $message_html);
          					$message_html = str_replace('%shipping_cost%', number_format($rows['shipping_cost'],2), $message_html);
          					$message_html = str_replace('%order_total%', number_format($rows['order_total'],2), $message_html);
          					$EmailBody='';
          					while($rowsD=mysqli_fetch_array($EmailOrderDet)){
          							$SubTotal=$SubTotal+$rowsD['final_price'];
          							$EmailBody=$EmailBody.'
          										 <tr>
          										   <td width="50%" height="18" align="left" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737"> '.strtoupper($rowsD['products_name']).'</td>
          										   <td width="10%" height="18" align="center" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.strtoupper($rowsD['products_quantity']).'</td>
          										   <td width="20%" height="18" align="right" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.number_format($rowsD['products_price'],2).'</td>
          										   <td width="20%" height="18" align="right" valign="middle" style="font-family:Arial,Helvetica,sans-serif;font-size:12px;color:#373737;border-left:solid 1px #e4e6eb"> '.number_format($rowsD['final_price'],2).'</td>
          										 </tr>';
          										 $Odetails=$Odetails.'<tr>
              								<td><h7>'.strtoupper($rowsD['products_name']).'</h7></td>
              								<td class="text-center"><h7>'.$rowsD['products_quantity'].'</h7></td>
          									<td class="text-right"><h7><span class="fa fa-inr"></span>'.number_format($rowsD['products_price'],2).'</h7></td>
              								<td class="text-right"><h7><span class="fa fa-inr"></span> '.number_format($rowsD['final_price'],2).'</h7></td>
              							</tr>';
          										 }

          						$message_html = str_replace('%details%', $EmailBody, $message_html);
          						$message_html = str_replace('%SubTotal%', number_format($SubTotal,2), $message_html);


          					//EOF Send Mail
                    $mail = new PHPMailer();
                    $mail->SMTPOptions = array(
                        'ssl' => array(
                            'verify_peer' => false,
                            'verify_peer_name' => false,
                            'allow_self_signed' => true
                        )
                    );
                    $mail->IsSMTP();
                    $mail->Host = SMTP_SERVER;
                    $mail->SMTPAuth = true;
                    $mail->Username = SMTP_USER_NAME;
                    $mail->Password = SMTP_PASSWORD;
                    $mail->SetFrom('admin@prabhusbooks.com', 'Prabhus Books Online');
                    $mail->addReplyTo('admin@prabhusbooks.com', 'Prabhus Books Online');
                    $mail->AddAddress($rows['customers_email_address']);
                    $mail->Subject = '..::Prabhus Books Online::.. Order Status -'.$StatusIDName;
                    $mail->AddBCC('admin@prabhusbooks.com', 'Administrator');
                    $mail->MsgHTML($message_html);
                    $mail->Send();
                    sendsms($rows['customers_telephone'],"Dear ".$rows['customers_name']." , Your Order ".$rows['orders_id']." has been ".$StatusIDName." .");
              //EOF Send SMS and Mail
              //echo "ok";
              echo json_encode($Status);
              }
              else {
                //DO not send SMS and Mail else give response ok
                //echo "Notok ($Status[0]==OK) && ($_REQUEST[Notify]==on)";
                echo json_encode($Status);
              }

          }
        else{
          $response= array("ERROR","An error has occured");
          echo json_encode($response);
        }

    break;
    case "Search":
    $OrderID= isset($_REQUEST['OrderID']) ? filter_var(($_REQUEST['OrderID']), FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH) : '';
    $summary='';

    $EmailOrderMstr=$order->QueryOrderMaster($OrderID);
    $EmailOrderDet=$order->QueryOrderDetails($OrderID);
    $OrderHistory=$order->getorderHistory($OrderID);


    $rows =  mysqli_fetch_array($EmailOrderMstr);
    $SubTotal=0;
    $Odetails='';
    $summary= '<div class="row">
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
              <input type="hidden" name="OrderID" id= "OrderID" value='.$rows['orders_id'].' />
              <input type="hidden" name="Token" id= "Token" value='.hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).' />
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
                </table><form name="OrderStatFrm" id="OrderStatFrm"><table width="100%" >
                <div class="alert alert-success" id="message" align="center"></div>
                  <tr>
                  <th width="1%">&nbsp;</th>
                    <th width="20%">Order Status</th>
                    <th width="20%">Order Status Comment </th>
                    <th width="20%">DateTime</th>
                  </tr>
                  ';
                  $i=1;
                while($Ordrows =  mysqli_fetch_array($OrderHistory)){
                  $summary= $summary.'<tr><td>'.$i.'</td><td>'.$Ordrows['orders_status_name'].'</td><td>'.$Ordrows['comments'].'<td>'.$Ordrows['date_added'].'</td>
                </tr>';
                $i++;
                }
              $summary= $summary.'

              <input type="hidden" name="OrderID" id= "OrderID" value='.$rows['orders_id'].' />
              <input type="hidden" name="action" id = "action" value=UpdateOrdrStatus />
                          <tr><td>&nbsp;</td><td><select name="StatusID" id= "StatusID">
                  <option value="0">Comments Only </option>';
                  $resultset = $order->getorderstatus();
                  while ($rowd = mysqli_fetch_array($resultset))
                  {
                  $summary= $summary."<option value='" . $rowd['orders_status_id'] . "'>" . $rowd['orders_status_name'] . "</option>";
                  }

                  $summary= $summary.'</select>
                  </td><td><input type="text"  name="comments" id="comments"  autocomplete="off" class="form-control" required /> </td>
                  <input type="hidden" name="StatusIDName" id = "StatusIDName" value="" />
                  <td>&nbsp;<input type="checkbox" name="Notify" id="Notify" >Notify Customer  &nbsp;<input type="Submit" name="Submit" id="OrdStat" value="Submit" /></td>

                </tr>
              </table></form></div>
            </div></div>
            </div>
            </div><script>
            $(document).ready(function()
            {
              $("#message").hide();
              /*************/
              $("#OrderStatFrm").validate({
                  rules: {
                        comments: {minlength: 4,required: true}
                        },
                  messages: {
                          comments: {required: "Please enter Comments",minlength: "Comments must consist of at least 5 characters"
                          }
                          },
                  showErrors: function(errorMap, errorList) {
                      $.each(this.successList, function(index, value) {
                      return $(value)
                      .popover("hide");
                                  });
                        return $.each(errorList, function(index, value) {
                          var _popover;
                          //console.log(value.message);
                                  _popover = $(value.element)
                                    .popover({
                                    trigger: "manual",
                                    placement: "top",
                                    content: value.message,
                                    template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                                    });
                                _popover.data("popover").options.content = value.message;
                                return $(value.element)
                                .popover("show");
                                  });
                              },
                          submitHandler: function() {
                            $("#StatusIDName").val($( "#StatusID option:selected" ).text());
                            saveedata();

                                      }
                          });

              /*************/
                 });</script>';
            echo $summary;
    break;
  }
}

else{
$response= array("ERROR","Invalid Access");
echo json_encode($response);
}
?>
