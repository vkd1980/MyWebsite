<?php require_once (__DIR__.'/Includes/global.inc.php');?>
<!DOCTYPE html PUBLIC '-//W3C//DTD XHTML 1.0 Transitional//EN' 'http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd'>
<html xmlns='http://www.w3.org/1999/xhtml' dir='ltr' lang='en'>
<head>
<title>..::: Bookstore V 1.0 :::..</title>
<meta http-equiv='Content-Type' content='text/html; charset=utf-8' />
<meta name='keywords' content='Bookstore V 1.0' />
<meta name='description' content='..::: Bookstore V 1.0 :::..' />
<meta http-equiv='imagetoolbar' content='no' />
<meta name='author' content='IBiz Info Solutions&reg; Team and others' />
<meta name='viewport' content='width=device-width, initial-scale=1.0'/><?php
$css = '';
$handle = '';
$file = '';
// open the "css" directory
if ($handle = opendir('Includes/css')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('Includes/css/' . $file)) {
            // insert HTML code for loading Javascript files
            $css .= '<link rel="stylesheet" href="Includes/css/' . $file .
                '" type="text/css" media="all" />' . "\n";
        }
    }
    closedir($handle);
    echo $css;}
	$js = '';
$handle = '';
$file = '';
// open the "js" directory
if ($handle = opendir('Includes/js')) {
    // list directory contents
    while (false !== ($file = readdir($handle))) {
        // only grab file names
        if (is_file('Includes/js/' . $file)) {
            // insert HTML code for loading Javascript files
            $js .= '<script src="Includes/js/' . $file . '" type="text/javascript"></script>' . "\n";
        }
    }
    closedir($handle);
    echo $js;
}?>
<style>
html *
{
   font-size: 1em !important;
   color: #000 !important;
   font-family: Lucida Console !important;
}
</style><?php
if (isset($_REQUEST['token']) && $_REQUEST['token'] != "") {
if($_REQUEST['token'] == $_SESSION['token']) { 
$action = isset($_REQUEST['action']) ? mysql_real_escape_string($_REQUEST['action']) : '';
switch($action) {
case "load":
$id=isset($_REQUEST['id']) ? mysql_real_escape_string($_REQUEST['id']) : '';
$finyear=isset($_REQUEST['finyear']) ? mysql_real_escape_string($_REQUEST['finyear']) : '';
$query="SELECT products.*,tbl_cashsale_master.*,tbl_cashsale_details.*,currencies.symbol_left, tbl_emp_master.Emp_Code,tbl_cashsale_details.Finyear_ID FROM (((tbl_cashsale_master LEFT JOIN tbl_cashsale_details ON 
tbl_cashsale_master.CashBill_ID=tbl_cashsale_details.CashBill_ID)
LEFT JOIN currencies ON tbl_cashsale_details.Cur_ID=currencies.currencies_id)
LEFT JOIN products ON tbl_cashsale_details.Product_ID=products.products_id)
LEFT JOIN tbl_emp_master ON tbl_cashsale_master.Emp_ID=tbl_emp_master.Emp_ID
WHERE (((tbl_cashsale_master.CashBill_ID)=$id)
And ((tbl_cashsale_master.Finyear_ID)=$finyear)
And ((tbl_cashsale_details.Finyear_ID)=$finyear))
order by tbl_cashsale_details.Timestamp;";
$result= $db->select($query);
$count  = mysql_num_rows($result);
if($count > 0) {
			while($fetch = mysql_fetch_array($result)) {
				$record[] = $fetch;
			}
		}
		$responsetext ="";
			if($count <= 0) {
			echo "<tr id='norecords'>
                <td colspan='12' align='center'>No records found <a href='addnew' id='gridder_insert' class='gridder_insert'><img src='includes/images/insert.png' alt='Add New' title='Add New' /></a></td>
            </tr>";
			 } 
			 else {
            $i = 0;
			$subtotal=0;
			foreach($record as $records) {
            $i = $i + 1;
			 $name=$records['Name'];
			 $cashbillno=$records['Cashbill_No'];
			 $date= date_format(date_create($records['Bill_Date']),'jS M Y');
			 $address=$records['Address'];
			$mobno=$records['Mob_No'];
			$add=number_format($records['Add'],2);
			$less=number_format($records['Less'], 2);
			$amount=number_format($records['Amount'],2);
			$remark=$records['Remark'];
			$empc=$records['Emp_Code'];
			$disc=$records['Discount'];
			$subtotal=$subtotal + $records['Amt'];
			$responsetext .= "<tr><td>".$i."</td><td>".$records['products_model']."</td>
            <td>".$records['products_author'].' : '. $records['products_name']."</td>
            <td class='text-right'>".$records['Qty']."</td>
			<td class='text-right'>".number_format($records['products_rate'],2)."</td>
			<td class='text-right'>".number_format($records['Ex_Rate'],2)."</td>
            <td class='text-right'>".number_format($records['Price'],2)."</td>
            <td class='text-right'>".number_format($records['Amt'],2)."</td>
          </tr>";
			
			}
			}
			$responsetext .= "</tbody>";
			echo "<div class='container'>
      <div class='row'>
        <div class='col-xs-12 text-center'>
		<h4>PRABHUS BOOKS </h4>
		<h5><small>Ayurveda College Jn Old Sreekandeswaram Road</small></h5>
			<h5><small>Thiruvananthapuram-695001</small></h5>
			<h5><small>Ph: 0471 2478397, 2473496 Email:prabhusbooks@gmail.com</small></h5>
          <h4><small>CASH BILL</small></h4>
        </div>
        
      </div>
      <div class='row'>
        <div class='col-xs-5'>
         <h5>To: ".$name."</h5>
		 <h5>Address: ".$address." Mob: ".$mobno."</h5>		 
        </div>
        <div class='col-xs-5 col-xs-offset-2 text-right'>
         <h5>Cash Bill No: #" .$cashbillno." Date: ".$date."</h5>
      </div>
      <!-- / end client details section -->
      <table class='table table-bordered'>
        <thead>
          <tr>
		  <th>
              <h5>SLNo</h5>
            </th>
            <th>
              <h5>ISBN</h5>
            </th>
            <th>
              <h5>Author & Title</h5>
            </th>
            <th>
              <h5>Qty</h5>
            </th>
            
			<th>
              <h5>Rate</h5>
            </th>
			
			<th>
              <h5>Ex-Rate</h5>
            </th>
			<th>
              <h5>Price</h5>
            </th>
            <th>
              <h5>Sub Total</h5>
            </th>
          </tr>
        </thead>
        <tbody>".$responsetext."<tr>
            <td colspan='3'>Rupees ".$spellnum->get_string($amount) ."</td>
            <td class='text-right'>&nbsp;</td>
            <td class='text-right'>&nbsp;</td>
            <td class='text-right'>&nbsp;</td>
            <td class='text-right'>&nbsp;</td>
            <td class='text-right'>&nbsp;</td>
          </tr></table>
			
      <div class='row text-right'>
	  
       <div class='col-xs-2 col-xs-offset-8 '>
          <p>
            <strong>
            Sub Total : <br>
            Add : <br>
			Less : ".$disc." %<br>
            Total : <br>
            </strong>
          </p>
        </div>
        <div class='col-xs-2'>
          <strong>
         ".number_format($subtotal,2)."&nbsp;<br>
         ". $add."&nbsp;<br>
		 ".$less."&nbsp;<br>
         ".$amount."&nbsp;<br>
          </strong>
        </div>
      </div>
      <div class='row'>
        <div class='col-xs-5'>
          
        </div>
        <div class='col-xs-7'>
          <div class='span7'>
            </div>
        </div>
      </div>
    </div>";
			//echo '<br>'.number_format($subtotal,2);
						break;
	}
	
}
	else
	{$response= array("ERROR","Hacking attempt");
	echo json_encode($response);}
	}
	else{
	$response= array("ERROR","Invalid Access");
	echo json_encode($response);}
?>

    <!--<div class="container">
      <div class="row">
        <div class="col-xs-12 text-center">
		<h4>PRABHUS BOOKS </h4>
		<h5><small>Ayurveda College Jn Old Sreekandeswaram Road</small></h5>
			<h5><small>Thiruvananthapuram-695001</small></h5>
			<h5><small>Ph: 0471 2478397, 2473496 Email:prabhusbooks@gmail.com</small></h5>
          <h4><small>CASH BILL</small></h4>
        </div>
        
      </div>
      <div class="row">
        <div class="col-xs-5">
         <h5>To: <?php echo $name?></h5>
		 <h5>Address: <?php echo $address?></h5>		 
        </div>
        <div class="col-xs-5 col-xs-offset-2 text-right">
         <h5>Cash Bill No: #<?php echo $cashbillno?> Date: <?php echo $date;?></h5>
      </div>
       <!--/ end client details section 
      <table class="table table-bordered">
        <thead>
          <tr>
		  <th>
              <h5>SLNo</h5>
            </th>
            <th>
              <h5>ISBN</h5>
            </th>
            <th>
              <h5>Author & Title</h5>
            </th>
            <th>
              <h5>Qty</h5>
            </th>
            
			<th>
              <h5>Rate</h5>
            </th>
			
			<th>
              <h5>Ex-Rate</h5>
            </th>
			<th>
              <h5>Price</h5>
            </th>
            <th>
              <h5>Sub Total</h5>
            </th>
          </tr>
        </thead>
        <tbody>
         <!-- <tr>
            <td>1</td>
			<td>Article</td>
            <td><a href="#">Title of your article here</a></td>
            <td class="text-right">-</td>
			<td class="text-right">$200.00</td>
			<td class="text-right">$1.00</td>
            <td class="text-right">$200.00</td>
            <td class="text-right">$200.00</td>
          </tr>
          <tr>
            <td>2</td>
			<td>Template Design</td>
            <td><a href="#">Details of project here</a></td>
            <td class="text-right">10</td>
			<td class="text-right">$200.00</td>
			<td class="text-right">$1.00</td>
            <td class="text-right">75.00</td>
            <td class="text-right">$750.00</td>
          </tr>
          <tr>
            <td>3</td>
			 <td>Development</td>
            <td><a href="#">WordPress Blogging theme</a></td>
            <td class="text-right">5</td>
			<td class="text-right">$200.00</td>
			<td class="text-right">$1.00</td>
            <td class="text-right">50.00</td>
            <td class="text-right">$250.00</td>
          </tr>
		  <?php echo $responsetext;?>
		  
        </tbody>
      </table>
      <div class="row text-right">
        <div class="col-xs-2 col-xs-offset-8">
          <p>
            <strong>
            Sub Total : <br>
            Add : <br>
			Less : <br>
            Total : <br>
            </strong>
          </p>
        </div>
        <div class="col-xs-2">
          <strong>
          <?php echo number_format($subtotal,2)?><br>
          <?php echo $add?><br>
		   <?php echo $less ?><br>
          <?php echo $amount?><br>
          </strong>
        </div>
      </div>
      <div class="row">
        <div class="col-xs-5">
          
        </div>
        <div class="col-xs-7">
          <div class="span7">
            </div>
        </div>
      </div>
    </div>-->
  