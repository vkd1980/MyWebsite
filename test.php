<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
?>
<body>

<style>
/*  bhoechie tab */
div.bhoechie-tab-container{
  z-index: 10;
  background-color: #ffffff;
  padding: 0 !important;
  border-radius: 4px;
  -moz-border-radius: 4px;
  border:1px solid #ddd;
  margin-top: 20px;
  margin-left: 50px;
  -webkit-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  box-shadow: 0 6px 12px rgba(0,0,0,.175);
  -moz-box-shadow: 0 6px 12px rgba(0,0,0,.175);
  background-clip: padding-box;
  opacity: 0.97;
  filter: alpha(opacity=97);
}
div.bhoechie-tab-menu{
  padding-right: 0;
  padding-left: 0;
  padding-bottom: 0;
}
div.bhoechie-tab-menu div.list-group{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a{
  margin-bottom: 0;
}
div.bhoechie-tab-menu div.list-group>a .glyphicon,
div.bhoechie-tab-menu div.list-group>a .fa {
  color: #5eb2d9;
}
div.bhoechie-tab-menu div.list-group>a:first-child{
  border-top-right-radius: 0;
  -moz-border-top-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a:last-child{
  border-bottom-right-radius: 0;
  -moz-border-bottom-right-radius: 0;
}
div.bhoechie-tab-menu div.list-group>a.active,
div.bhoechie-tab-menu div.list-group>a.active .glyphicon,
div.bhoechie-tab-menu div.list-group>a.active .fa{
  background-color: #5eb2d9;
  background-image: #5eb2d9;
  color: #ffffff;
}
div.bhoechie-tab-menu div.list-group>a.active:after{
  content: '';
  position: absolute;
  left: 100%;
  top: 50%;
  margin-top: -13px;
  border-left: 0;
  border-bottom: 13px solid transparent;
  border-top: 13px solid transparent;
  border-left: 10px solid #5eb2d9;
}

div.bhoechie-tab-content{
  background-color: #ffffff;
  /* border: 1px solid #eeeeee; */
  padding-left: 20px;
  padding-top: 10px;
}

div.bhoechie-tab div.bhoechie-tab-content:not(.active){
  display: none;
}
</style>
<script>
$(document).ready(function() {
var strMD5 = $.md5('test');
console.log(strMD5);
    $("div.bhoechie-tab-menu>div.list-group>a").click(function(e) {
        e.preventDefault();
        $(this).siblings('a.active').removeClass("active");
        $(this).addClass("active");
        var index = $(this).index();
        $("div.bhoechie-tab>div.bhoechie-tab-content").removeClass("active");
        $("div.bhoechie-tab>div.bhoechie-tab-content").eq(index).addClass("active");
    });
/*Order Status */
$('#OrderStaus').submit(function(){
 if($(this).data('formstatus') !== 'submitting'){
 		var form = $(this),
         formData = form.serialize(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
		 responseMsg = $('#Comments-response');
         //add status data to form
         form.data('formstatus','submitting');
         responseMsg.hide()
                    .addClass('alert alert-info statusMessage')
                    .text('Sending your message. Please wait...')
                    .fadeIn(200);//send data to server for validation
         $.ajax({
             url: formUrl,
             type: formMethod,
             data: formData,
			 cache:false,
             success:function(data){

                //setup variables
                var responseData = jQuery.parseJSON(data),
                    klass = '';

                //response conditional
                switch(responseData.status){
                    case 'error':
                        klass = 'alert alert-danger statusMessage';
						$("#comments").val('');
                    break;
                    case 'success':
                        klass = 'alert alert-success statusMessage';
						$("#comments").val('');
                    break;
                }

                //show reponse message
                responseMsg.fadeOut(200,function(){
                   $(this).removeClass('alert alert-info statusMessage')
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
	/* EOF Order Stsatus */


 });
</script>
<div class="row">
<div class="table-responsive">
<div class="col-md-12">
<!------------->
<div class="container">
	<div class="row">
        <div class="col-md-12 bhoechie-tab-container">
            <div class="col-lg-3 col-md-3 col-sm-3 col-xs-3 bhoechie-tab-menu">
              <div class="list-group">
                <a href="#" class="list-group-item active text-center">
                  <h4 class="fa fa-credit-card"></h4><br/>Credit Card
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="fa fa-credit-card"></h4><br/>Debit Card
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="fa fa-university"></h4><br/>Net Banking
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="fa fa-money"></h4><br/>Cash Card
                </a>
                <a href="#" class="list-group-item text-center">
                  <h4 class="fa fa-mobile"></h4><br/>Mobile Payments
                </a>
				<a href="#" class="list-group-item text-center">
                  <h4 class="fa fa-credit-card"></h4><br/>Wallet
                </a>
              </div>
            </div>
            <div class="col-lg-9 col-md-9 col-sm-9 col-xs-9 bhoechie-tab">
                <!-- flight section -->
                <div class="bhoechie-tab-content active">
                    <center>
					<input class="payOption"  type="hidden" name="payment_option" value="OPTCRDC" />
					<table width="100%" border="0">
						  <tr>
							<td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/CreditCard/visa.jpg" width="117" height="76" ></td>
							<td><input type="radio" id="card_type" name="card_type" value="MasterCard" readonly="readonly"/><img src="img/payment/CreditCard/mastercard.jpg" width="117" height="76"></td>
							<td><input type="radio" id="card_type" name="card_type" value="Amex" readonly="readonly"/><img src="img/payment/CreditCard/amex.jpg" width="117" height="76"></td>
							<td><input type="radio" id="card_type" name="card_type" value="JCB" readonly="readonly"/><img src="img/payment/CreditCard/jcb.jpg" width="117" height="76"></td>
						  </tr>
					</table>

                      <!--<h1 class="fa fa-plane" style="font-size:14em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Flight Reservation</h3>-->
                    </center>
                </div>
                <!-- train section -->
                <div class="bhoechie-tab-content">
                    <center>
					<input class="payOption" type="hidden" name="payment_option" value="OPTDBCRD" />
					<table width="100%" border="0">
					 <tr>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/andhra_bank.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/canara_bank.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/citibank.jpg" width="117" height="76" ></td>
					  <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/idfc_bank.jpg" width="117" height="76" ></td>
					 </tr> <tr>

					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/indian_bank.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/iob.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/Maestro_logo.png" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/mastercard.jpg" width="117" height="76" ></td>
					  </tr> <tr>

					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/pnb.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/rupay.jpg" width="117" height="76" ></td>
					  <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/sbi.jpg" width="117" height="76" ></td>
					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/union_bank.jpg" width="117" height="76" ></td>
					  </tr> <tr>

					 <td><input type="radio" id="card_type" name="card_type" value="Visa" readonly="readonly"/><img src="img/payment/DebitCard/visa.jpg" width="117" height="76" ></td>
					 </tr>
					</table>
                      <!-- <h1 class="fa fa-road" style="font-size:12em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Train Reservation</h3>-->
                    </center>
                </div>

                <!-- hotel search -->
                <div class="bhoechie-tab-content">
                    <center>
					<input class="payOption" type="hidden" name="payment_option" value="OPTNBK" />
                      <h1 class="fa fa-home" style="font-size:12em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Hotel Directory</h3>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
					<input class="payOption" type="hidden" name="payment_option" value="OPTCASHC" />
                      <h1 class="fa fa-cutlery" style="font-size:12em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Restaurant Diirectory</h3>
                    </center>
                </div>
                <div class="bhoechie-tab-content">
                    <center>
					<input class="payOption" type="hidden" name="payment_option" value="OPTMOBP" />
                      <h1 class="fa fa-credit-card" style="font-size:12em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Credit Card</h3>
                    </center>
                </div>
				<div class="bhoechie-tab-content">
                    <center>
					<input class="payOption" type="hidden" name="payment_option" value="OPTWLT" />
                      <h1 class="fa fa-credit-card" style="font-size:12em;color:#5eb2d9"></h1>
                      <h2 style="margin-top: 0;color:#5eb2d9">Cooming Soon</h2>
                      <h3 style="margin-top: 0;color:#5eb2d9">Credit Card</h3>
                    </center>
                </div>
            </div>
        </div>
  </div>
</div>
<!------------------->

</div></div></div>

<div class="row">
<div class="col-md-12">
<div class="container">

<div id="Comments-response"></div>
          <!-- Contact form (not working)-->
          <form class="form-horizontal" id="OrderStaus"  action="../includes/checkout_process.php" method="post" autocomplete="off">
            <!-- Comment -->
            <div class="form-group">
			<h5>Do you want to Say Something Regarding this Order </h5>
              <div class="col-md-9">
                <textarea name="Msg" class="form-control" id="Msg"  placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
                <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
				<input type="hidden" name="Add_ID" value="1">
				<input type="hidden" name="process" value="OrderStatus">

              </div>
			     </div>

				 <div class="form-group">
              <!-- Buttons -->
              <div class="col-md-9 col-md-offset-2">
                <button type="submit" class="btn btn-warning"  id="sendMessage" name="sendMessage" value="Send Email" >Submit</button>
                <button type="reset" class="btn btn-success" id="cancel" name="cancel">Reset</button>
              </div>
            </div>
          </form>

</div></div></div>


<?php

echo phpinfo();
//production
//PHP Version 5.4.7
//Apache Version	Apache/2.4.3
//Software version: 5.1.73

//Development
//xammp 3.2.1
//MysqlServer version: 5.6.21 tested
//Apache/2.4.10
//PHP/5.6.3
// include(__DIR__.'/includes/footer.php');*/
?>
