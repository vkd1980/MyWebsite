<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
if(!isset($_SESSION['logged_in'])){
if (!headers_sent())
    {
        header('Location: ./login.html ');
        exit;
        }
    else
        {
        echo '<script type="text/javascript">
       window.location.href="./login.html";
        </script>
       <noscript>
        <meta http-equiv="refresh" content="0;url=./login.html" />
       </noscript>'; exit;
    }
 }

 else{
 if(!isset($_SESSION['cart_contents']))
 {
 if (!headers_sent())
    {
        header('Location: ./cart.html');
        exit;
        }
    else
        {
        echo '<script type="text/javascript">
       window.location.href="./cart.html";
        </script>
       <noscript>
        <meta http-equiv="refresh" content="0;url=./cart.html" />
       </noscript>'; exit;
    }
 }

 /* Starting Checkout Process */
if ((isset($_REQUEST['process']))&&(!empty($_REQUEST['process']))){
$process= filter_var(($_REQUEST['process']), FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
/* Start switch */
switch($process){
case "Select_Address":

$str= '
<!-- BOF Address Selection-->
<div class="checkout">
<div class="container">
<div class="row">

 <!-- Checkout page title -->
  <br><br>
<div class="row">
  <div class="col-sm-3"><div class="titleActive"><h3><i class="fa fa-address-book" aria-hidden="true"></i> Select Address </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-truck">  </i> Select Shipping </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-list-alt">  </i> Order Summary </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-check">  </i> Order Complete </h3></div></div>
</div>
<br><br>

<div class="table-responsive">';

$results = $CustAddress->GetCustAddress("'".$_SESSION['UserData'][1]."'");
$num_rows = mysqli_num_rows($results);
if($num_rows > 0){
while($rows =  mysqli_fetch_array($results)){
$str=$str.'<div class="col-sm-4 ">
<form id="AddressForm'.$rows["address_book_id"].'" method="post" action="/includes/checkout_process.php">
<input type="hidden" name="Token" value="'. hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
<input type="hidden" name="Add_ID" value="'. $rows["address_book_id"].'" >

<table>
<tr ><td>'.strtoupper($rows["entry_firstname"]).' '.strtoupper($rows["entry_lastname"]).'</td></tr>
<tr><td>'.strtoupper($rows["entry_street_address"]).'</td></tr>
<tr><td>'.strtoupper($rows["entry_suburb"]).'</td></tr>
<tr><td>'.strtoupper($rows["city_name"]).'</td></tr>
<tr><td>'.strtoupper($rows["state_name"]).'</td></tr>
<tr><td><a class="btn btn-warning editthis" value="'.$rows["address_book_id"].'"><i class="glyphicon glyphicon-menu-left"></i> Edit This</a>&nbsp;<button  id="'.$rows["address_book_id"].'" class="btn btn-success checkoutBtn" >Select this</button></td></tr>

 </form>
</table></div>';
}
}


$str=$str.' </div>
 </div>
 </div>
</div>';
echo $str;
?>
<script src="../js/jquery.validate.js"></script>
<script src="../js/xbootstrap.min.js"></script>
<script>
$(document).ready(function()
{
$('#Cust_id').val(<?php echo $_SESSION['UserData'][0]; ?>);
//Checkout process
 $('.checkoutBtn').click(function(){

    //check the form is not currently submitting
    if($('#AddressForm'+$(this).attr('id')).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $('#AddressForm'+$(this).attr('id')),
         formData = form.serialize()+ "&process=SelectedAddress",
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
         responseMsg = $('#signup-response');

         //add status data to form
         form.data('formstatus','submitting');
		 //$('#Addre').modal('show');
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
					//$('#Addre').modal('hide');
                    break;
                    case 'success':
					//$('#Addre').modal('hide');
					 form.data('formstatus','idle');
                     window.location.replace("http://<?php echo$_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.html?process=Select_Shipping';?>");
                    break;
                }


           }
      });
    }
    //prevent form from submitting
    return false;

    });
	//EOF Checkout Process
	$('.editthis').click(function(){

	if($('#AddressForm'+$(this).attr('value')).data('formstatus') !== 'submitting'){
	 $.ajax({
             url: '../includes/address_loader.php',
             type: 'post',
             data: {
				'id': $(this).attr('value'),
				'Token': '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>',
				'page':'<?php echo basename(__FILE__, '.php').'.php';?>'
			},

             success:function(data){
                //setup variables
                var responseData = jQuery.parseJSON(data);
				console.log(data);
                //response conditional
                switch(responseData.status){
                    case 'error':
					alert('Something Went wrong');
                    break;
                    case 'success':
					$('#Cust_id').val(responseData.Adetails['Cust_id']),
					$('#action').val('Edit'),
					$("#submit").html('Edit');
					$('#Cust_address_book_id').val(responseData.Adetails['Cust_address_book_id']),
					responseData.Adetails['Entry_gender']=='M' ? $('#gender-male').prop('checked', true) : $('#gender-female').prop('checked', true),
					$('#FirstName').val(responseData.Adetails['Cust_entry_firstname']),
					$('#Isdefault').val(responseData.Adetails['Isdefault']),
					$('#LastName').val(responseData.Adetails['Cust_entry_lastname']),
					$('#company').val(responseData.Adetails['Cust_entry_company']),
					$('#street_address').val(responseData.Adetails['Cust_entry_street_address']),
					$('#suburb').val(responseData.Adetails['Cust_entry_suburb']),
					$('#pin').val(responseData.Adetails['Cust_entry_postcode']),
					$('#telephone').val(responseData.Adetails['Cust_Telephone']);
                    break;
                }


           }

      });	}
	});
	$.validator.addMethod("checkforzero", function(value, element, arg) {
            return arg != value;
        }, "Value Cannot Be Zero.");
	$.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
);
	//Country Change
$("#Country").change(function()
{
//$('#Addre').modal('show');
$.ajax
({
type: "POST",
url: "../includes/country_loader.php",
data: {
        'id': $(this).val(),
        'Token': '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>',
		'page':'<?php echo basename(__FILE__, '.php').'.php';?>',
		'type':'state'
    },
cache: false,
success: function(html)
{
if($.trim(html) === ""){
//$('#Addre').modal('hide');
$('#City')
    .empty()
    .append('<option selected="selected" value="0">Select State</option>')
;
$('#State')
    .empty()
    .append('<option selected="selected" value="0">Select Country</option>')
;
/*$("#State").prop("disabled", true);
$("#City").prop("disabled", true);*/
}
else
{
//$('#Addre').modal('hide');
/*$("#State").prop("disabled", false); */
$("#City option[value=0]").text('Select State');
$("#State").html(html);
}
}
});

});
//State Change

$("#State").change(function()
{
//$('#Addre').modal('show');
$.ajax
({
type: "POST",
url: "../includes/country_loader.php",
data: {
        'id': $(this).val(),
        'Token': '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>',
		'page':'<?php echo basename(__FILE__, '.php').'.php';?>',
		'type':'city'
    },
cache: false,
success: function(html)
{
if($.trim(html) === ""){
//$('#Addre').modal('hide');
$("#City").prop("disabled", true);
$('#City')
    .empty()
    .append('<option selected="selected" value="0">Select State</option>')
;
}
else
{
//$('#Addre').modal('hide');
$("#City").prop("disabled", false);
$("#City").html(html);
}
}
});

});
/*BOF Validation*/
$("form[name='AddressForm']").validate({
    // Specify validation rules
    rules: {
      // The key name on the left side is the name attribute
      // of an input field. Validation rules are defined
      // on the right side
      FirstName: "required",
      LastName: "required",
	  street_address: "required",
	  suburb: "required",
	  pin: {
	 	required: true,
		regex: /[1-9][0-9]{5}$/,
		digits: true
	  },
	  telephone: {
		  required: true,
		  digits: true,
		  regex: /[789][0-9]{9}/,
		  minlength: 10,
		maxlength: 10
	  },
      Emaill: {
        required: true,
        email: true
      },
	  passwordconfirm: {
        required: true,
        minlength: 8,
		maxlength: 10,
		regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,10}/,
		equalTo: "#passwordnew"
      },
	  passwordnew: {
        required: true,
        minlength: 8,
		maxlength: 10,
		regex: /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[$@$!%*?&])[A-Za-z\d$@$!%*?&]{8,10}/
      },
	  City: {
         required: true,
         checkforzero: "0"
              },
	State:{
         required: true,
         checkforzero: "0"
              },
	 Country:{
         required: true,
         checkforzero: "0"
              }
    },
    // Specify validation error messages
    messages: {
      FirstName: "Please Enter Your First Name",
      LastName: "Please Enter Your Last Name",
	  street_address: "Please Enter Your House Number and Street",
      telephone:{
		  required: "Please Enter Mobile Number",
		  digits: "Please enter Numbers Only"
	  },
	 passwordnew: {
        required: "Please Enter a Password",
        minlength: "Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character",
		maxlength: "Maximum 10 characters",
		regex: "Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character"
      },
	  passwordconfirm: {
        required: "Please Enter a Password",
        minlength: "Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character",
		maxlength: "Maximum 10 characters",
		regex: "Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character",
		equalTo: "Password Entered are not Matching"
      },
      Emaill:{
		required: "Please enter an Email Address",
        email: "Please Enter a Valid Email"
	      },
	 pin: {
		required: "Please enter an Email Address",
		digits: "Please enter Numbers Only",
		regex: "Enter Pin Code Correctly"
		   },
	City: {
		required: "Please Select City",
		checkforzero: "Please Select City",
		   },
	State: {
		required: "Please Select State",
		checkforzero: "Please Select State",
		   },
	Country: {
		required: "Please Select Country",
		checkforzero: "Please Select Country",
		   }
	},
	showErrors: function(errorMap, errorList) {
                    $.each(this.successList, function(index, value) {
                        return $(value).popover("hide");
                    });
                    return $.each(errorList, function(index, value) {
                        var _popover;
                        console.log(value.message);
                        _popover = $(value.element).popover({
                                trigger: "manual",
                                placement: "top",
                                content: value.message,
                                template: "<div class=\"popover\"><div class=\"arrow\"></div><div class=\"popover-inner\"><div class=\"popover-content\"><p></p></div></div></div>"
                            });
                        _popover.data("popover")
                            .options.content = value.message;
                        return $(value.element)
                            .popover("show");
                    });
                },
    // Make sure the form is submitted to the destination defined
    // in the "action" attribute of the form when valid
	  submitHandler: function(form) {
      //form.submit();
	  console.log($(form).serialize());
	  $.ajax({
            url: "../includes/address_loader.php",
            type: "POST",
            data: $(form).serialize(),
            cache: false,
           success:function(data){
		   var responseData = jQuery.parseJSON(data);
		   console.log(data);
                //response conditional
                switch(responseData.status){
					case 'error':
					alert(responseData.message);
					location.reload();
                    break;
					case 'success':
					alert(responseData.message);
					location.reload();
					 break;

				}

            }
        });
    }
  });
/*EOF Validation*/

});
  </script>
<div class="items">
  <div class="container">
<div class="col-md-9 col-sm-9" >
<div class="form">
 <h4 class="title"><i></i>Add a New Billing Address</h4>
            <!-- Register form (not working)-->
            <form name="AddressForm" method="post" id="AddressForm" class="form-horizontal">
			<input type="hidden" name="Cust_id" id="Cust_id" value="" />
			<input type="hidden" name="Cust_address_book_id" id="Cust_address_book_id" value="" />
              <input type="hidden" name="action" id="action" value="Addnew" />
			  <input type="hidden" name="Isdefault" id="Isdefault" value="0" />
              <div class="form-group">
                <div class="col-md-8 col-md-offset-3">
                  <label class="checkbox-inline">Mr.
                  <input type="radio" name="gender" value="M" id="gender-male" required />
                  </label>
                  <label class="checkbox-inline"> Ms
                  <input type="radio" name="gender" value="F" id="gender-female" required  />
                  </label><span class="alert" style="color:#FF0000;">*</span>
                </div>
              </div>
              <!-- First Name -->
              <div class="form-group">
                <label class="control-label col-md-3" for="FirstName">First Name:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="FirstName" size = "33" maxlength = "32"  class="form-control" id="FirstName" placeholder="First Name" pattern="[A-Za-z\s]{1,32}" required >
                </div>
              </div>
              <!-- Last Name -->
              <div class="form-group">
                <label class="control-label col-md-3" for="LastName">Last Name:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="LastName" size = "33" maxlength = "32" class="form-control" id="LastName" placeholder=" Last Name" pattern="[A-Za-z\s]{1,32}"  required>
                </div>
              </div>
			  <!-- Company Name -->
              <div class="form-group">
                <label class="control-label col-md-3" for="company">Company Name:</label>
                <div class="col-md-6">
                  <input type="text" name="company" size = "33" maxlength = "32" class="form-control" id="company" placeholder=" Company Name If Any" pattern="[A-Za-z\s]{1,32}"  >
                </div>
              </div>
              <!-- Street Address -->
              <div class="form-group">
                <label class="control-label col-md-3" for="street_address">Street Address:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="street_address" size = "41" maxlength= "64" class="form-control" id="street_address" placeholder=" Street Address"   required>
                  <input type="text" name="should_be_empty"  size="40" id="CAAS" style="visibility:hidden; display:none;" autocomplete="off" />
                  <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
                </div>
              </div>
              <!-- Address Line 2 -->
              <div class="form-group">
                <label class="control-label col-md-3" for="suburb">Address Line 2:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="suburb" size = "33" maxlength= "32" class="form-control" id="suburb" placeholder="Address"  required>
                </div>
              </div>
              <!-- City -->
              <div class="form-group">
                <label class="control-label col-md-3" for="City">City:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-5">
                  <select class="form-control" name="City" id="City"  required >
                    <option value="0">Select Country</option>
                  </select>
                </div>
              </div>
              <!-- State -->
              <!-- Select box -->
              <div class="form-group">
                <label class="control-label col-md-3">State</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-5">
                  <select name="State" class="form-control" id="State"  required >
                    <option value='0'>Select Country</option>
                  </select>
                </div>
              </div>
              <!-- Select box -->
              <div class="form-group">
                <label class="control-label col-md-3">Country</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-5">
                  <?php
$DBC = new DB();
$con =$DBC->connect();
$stmt = $con->prepare("SELECT * FROM countries");
$stmt->execute();
$result = $stmt->get_result();
$stmt->close();
$con->close();
echo " <select class='form-control' name='Country' id='Country'  required >";
?>
                  <option value='0'>Select Country</option>
                  <?php
while ($row = mysqli_fetch_array($result)) {
echo "<option value='" . $row['countries_id'] . "'>" . $row['countries_name'] . "</option>";
}
echo "</select>";
?>
                </div>
              </div>
              <!-- Address Line 2 -->
              <div class="form-group">
                <label class="control-label col-md-3" for="suburb">Pin Code:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-3">
                  <input type="text" name="pin" size = "33" maxlength= "32" class="form-control" id="pin" placeholder="Pincode" required>
                </div>
              </div>

              <!-- Telephone -->
              <div class="form-group">
                <label class="control-label col-md-3" for="telephone">Mob:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="telephone" size = "33" maxlength = "32" class="form-control" id="telephone" pattern="[789][0-9]{9}" title="Eg:9812346789" placeholder="Please type your Mob Number" required="required">
                </div>
              </div>


              <br class="clearfix">
              </br>

              <!-- Buttons -->
              <div class="form-actions">
                <!-- Buttons -->
                <div class="col-md-8 col-md-offset-3">
                  <button type="submit" class="btn btn-warning" id="submit">Save</button>
                  <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <hr />

          </div>
		  <!---->
		  </div>
		   </div>
		    </div>
<?php

break;
case "Select_Shipping":
if(!isset($_SESSION['Address'])){
//redirect to cart Page
if (!headers_sent())
    {
        header('Location: ./checkout.html?process=Select_Address');
        exit;
        }
    else
        {
        echo '<script type="text/javascript">
       window.location.href="./checkout.html?process=Select_Address";
        </script>
       <noscript>
        <meta http-equiv="refresh" content="0;url=./checkout.html?process=Select_Address" />
       </noscript>'; exit;
    }
}
?>
<script>
$(document).ready(function()
{
$('.shippingSel').click(function(){

if($("input:radio[name='Shipping_mod']").is(":checked")) {

    console.log($("input[name='Shipping_mod']:checked").val());
	//check the form is not currently submitting
    if($('#ShippingForm'+$("input[name='Shipping_mod']:checked").val()).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $('#ShippingForm'+$("input[name='Shipping_mod']:checked").val()),
         formData = form.serialize()+ "&process=SelectedShipping",
         formUrl = form.attr('action'),
         formMethod = form.attr('method');

         //add status data to form
         form.data('formstatus','submitting');
		 console.log(formData);
		 //$('#Addre').modal('show');
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
					//$('#Addre').modal('hide');
                    break;
                    case 'success':
					//$('#Addre').modal('hide');
					 form.data('formstatus','idle');
                     window.location.replace(responseData.Location);
                    break;
                }


           }
      });
    }
    //prevent form from submitting
    return false;
  }
  else
  {
 	$("#data td").toggleClass("highlight");
  alert('You have not Selected Any Shipping !');
  }
});


});
</script>
<div class="checkout">
	<!--<div class="container">
		<div class="row">

	 Cart starts -->
<div class="cart">
  <div class="container">
    <div class="row">
	 <!-- Checkout page title -->
  <br><br>
<div class="row">
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-address-book" aria-hidden="true"></i> Select Address </h3></div></div>
  <div class="col-sm-3"><div class="titleActive"><h3><i class="fa fa-truck">  </i> Select Shipping </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-list-alt">  </i> Order Summary </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-check">  </i> Order Complete </h3></div></div>
</div>
<br><br>
      <div class="col-md-12">

			<div class="table-responsive">

            <!-- Table -->
			<h3 >Cart Items</h3>
              <table class="table tcart">
                <thead>
                  <tr>
                    <td>&nbsp;</td>
                    <td><h4>Name</h4></td>
                    <td><h5>Quantity</h4></td>
                    <td align="right"><h5>Unit Price</h4></td>
                    <td align="right"><h5>Total</h4></td>
					<td>&nbsp;</td>
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

 if($product->CheckspecialsbyID($item['id'],date("Y-m-d"))){
//render specialLink
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
					<td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}
elseif($product->CheckfeaturedbyID($item['id'],date("Y-m-d"))){
// Render FeaturedLink
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
                    <td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}
else{
//render normal Link
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
                    <td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}





                    echo '<!-- Quantity with refresh and remove button -->
                    <td><h6>'.$item["qty"].'</h6></td>
                    <!-- Unit price -->
                    <td align="right"><h6><span class="fa fa-inr"></span> '.number_format($item["price"],2).'</h6></td>
                    <!-- Total cost -->
                    <td align="right"><h6><span class="fa fa-inr"></span> '.number_format($item["subtotal"],2).'</h6></td>
					 <td>&nbsp;</td>
                  </tr>';

 }

 }


 }
 }else{
 /*Cart Is Empty*/
  echo '<tr><td colspan="6"><p> <h3>Your cart is empty.....</h></p></td></tr>';

 }
?>
	                </tbody>
				</table>
				<!---->
				<h3 >Select Shipping</h3>
				<table class="table table-hover table-condensed" id="data">
				<thead>
				<tr>
				<td colspan="6" align="justify"><h5>Shipper</h5></td>
				<td align="right"><h5>Shipping Charge</h5></td>
				</tr></thead>
				<?php
			$Postage = ShowPostage();
		 for ($i = 0; $i < count($Postage); $i++) {
		 $str='';
		 $str='<form id="ShippingForm'.$Postage[$i]['ShippingID'].'" method="post" action="/includes/checkout_process.php">
		 <input type="hidden" name="Token" value="'. hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
		 <input type="hidden" name="Add_ID" value="'. $Postage[$i]['ShippingID'].'" >
		  <input type="hidden" name="ShippingCost" value="'. $Postage[$i]['Postage'].'" >
		 </form>
		 <tr>

                    <td colspan="6" align="justify"><h5><input type="radio" id="Shipping_mod'.$Postage[$i]['ShippingID'].'" class="Postage" name="Shipping_mod" value ="'.$Postage[$i]['ShippingID'].'">';
					if( !is_null($Postage[$i]['Img']) || !empty($Postage[$i]['Img']))
					{$str=$str.'<img width="100px" height="40px" src="'.$Postage[$i]['Img'].'" />';
					}

					$str=$str.'&nbsp;&nbsp;'.$Postage[$i]['Method'].'('.$Postage[$i]['Packets'].'X Packets)

                    </h5></td><td align="right"><h5><span class="fa fa-inr"></span> '.number_format($Postage[$i]['Postage'],2).'</h5></td>


                  </tr>';
				  echo $str;

}?>
              </table>
			  <!---->
			</div>

               <!-- Button s-->
              <div class="row">
                <div class="col-md-4 col-md-offset-8">
                  <div class="pull-right">
                    <a href="checkout.html?process=Select_Address" class="btn btn-warning">Back</a>
                    <a class="btn btn-success shippingSel">Continue..</a>
                  </div>
                </div>
              </div>

      </div>
    </div>
  </div>
</div>

<!-- Cart ends-->
</div><?php
break;
case "Select_Payment":
if(!isset($_SESSION['Shipping'])){
//redirect to cart Page
if (!headers_sent())
    {
        header('Location: ./checkout.html?process=Select_Shipping');
        exit;
        }
    else
        {
        echo '<script type="text/javascript">
       window.location.href="./checkout.html?process=Select_Shipping";
        </script>
       <noscript>
        <meta http-equiv="refresh" content="0;url=./checkout.html?process=Select_Shipping" />
       </noscript>'; exit;
    }
}
elseif(isset($_POST["encResp"]) && !empty($_POST["encResp"]))
{
?>
<script>
$(document).ready(function()
{
 		//$('#Addre').modal('show');
		 $.ajax({
             url: './includes/checkout_process.php',
             type: 'post',
             data: '<?php echo 'encResp='.$_POST["encResp"] ?>'+'&Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'+'&Ordertotal=<?php echo ($_SESSION['Shipping']['Shipping_Cost']+$cart->total())?>',

             success:function(data){
                //setup variables
                var responseData = jQuery.parseJSON(data);
                //response conditional
                switch(responseData.status){
                    case 'error':
					//$('#Addre').modal('hide');
                    break;
                    case 'success':
					var url = responseData.Location;
					var form = $('<form action="' + url + '" method="post">' +
					  '<input type="text" name="OID" value="' + responseData.order_ID + '" />' +
					  '</form>');
					//$('#Addre').modal('hide');
					 form.data('formstatus','idle');
                    $('body').append(form);
					form.submit();
                    break;
					case 'Aborted':
					//$('#Addre').modal('hide');
					$('#Pymnt').remove();
					$('#Msg').append('<div class ="alert alert-danger" align="center"><h4>Your Payment was not Successful, '+responseData.message+'<br><a href="./checkout.php?process=Select_Payment">Click Here Pay Again </a></h4></div>');
					break;
					case 'Failure':
					//$('#Addre').modal('hide');
					$('#Pymnt').remove();
					$('#Msg').append('<div class ="alert alert-danger" align="center"><h4>Your Payment was not Successful, '+responseData.message+'<br><a href="./checkout.php?process=Select_Payment">Click Here Pay Again </a></h4></div>');
					break;
                }


           }
      });
});
</script>
	<div class="clearfix"></div>
	  <div class="clearfix"></div>
	  <br><br>
	<div class="container">
	<div class="col-md-12">
	<div class="row"id="Msg"></div>
	<div id="Pymnt" class="modal fade in" data-backdrop="static" data-keyboard="false" >
  <div class="loader" align="center" ><img src="../img/loader.gif" style="width: 100px;height: 100px;"/><p ><h2 >We are processing your Payment and will redirect to Payment Gateway <br>Do not Close or refresh the Page</p></h2></div>

	 </div>
	  </div>
<?php
}
else{

/*******************/
?>
<!------------BOF Payment Modal------------->
  <div id="Paymentmodal" class="modal fade" role="dialog">
  <div class="modal-dialog">

    <!-- Modal content-->
    <div class="modal-content">
      <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
   <div class="modal-body modalimg">
   <center>
   <iframe src="" id="paymentFrame" width="482" height="450" frameborder="0" scrolling="No" ></iframe>
</center>
    <img src="" class="imagepreview">
   </div>
   <div class="modal-footer">
  </div>
  </div>
 </div>
 </div>
  <!-----------EOF Payment Modal----------------->

<script>
$(document).ready(function()
{
var payop='<table width="100%"><tr><td colspan="3"><h4>Payment Option: </h4></td></tr><tr><td class="no-line" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTCRDC" /> Credit Card</h5></td><td class="no-line" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTDBCRD" /> Debit Card</h5></td><td class="no-line" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTNBK" /> Net Banking</h5></td></tr><tr><td colspan="3">&nbsp;</td></tr><tr><td class="no-line" width="16%" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTCASHC" /> Cash Card</h5></td><td class="no-line" width="16%" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTMOBP" /> Mobile Payments</h5></td><td class="no-line" width="16%" height="18"><h5><input class="payOption" type="radio" name="payment_option" value="OPTWLT" /> Wallet</h5><input type="hidden" id="card_type" name="card_type" value="" readonly="readonly"/></td></tr><tr><td colspan="3">&nbsp;</td></tr><tr><td><h5>Card Name:</h5></td><td colspan="6"><h5><select name="card_name" style="width:300px" id="card_name"> <option value="">Select</option><option value="" >test</option> </select> </h5></td></tr></table>';
/*$('input[name="Payment_mod"]').click(function(){
if($($('#PymntName'+$("input[name='Payment_mod']:checked").val())).val()=='CCAvenue'){
$('#paymentoptions').empty();
$('#paymentoptions').append(payop);
}
else{
$('#paymentoptions').empty();
}
});*/
$('.PaymentSel').click(function(){
if($("input:radio[name='Payment_mod']").is(":checked") && $('#terms').is(":checked") ) {
	switch($($('#PymntName'+$("input[name='Payment_mod']:checked").val())).val()){
	case 'Cash On Delivery':
	//check the form is not currently submitting
    if($('#PaymentForm'+$("input[name='Payment_mod']:checked").val()).data('formstatus') !== 'submitting'){

         //setup variables
        var form = $('#PaymentForm'+$("input[name='Payment_mod']:checked").val()),
         formData = form.serialize()+ "&process=SelectedPayment",
         formUrl = form.attr('action'),
         formMethod = form.attr('method');

         //add status data to form
         form.data('formstatus','submitting');
		 //console.log(formData);
		 //$('#Addre').modal('show');
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
					//$('#Addre').modal('hide');
                    break;
                    case 'success':
					var url = responseData.Location;
					var form = $('<form action="' + url + '" method="post">' +
					  '<input type="text" name="OID" value="' + responseData.order_ID + '" />' +
					  '</form>');
					//$('#Addre').modal('hide');
					 form.data('formstatus','idle');
                    $('body').append(form);
					form.submit();
                    break;
                }


           }
      });
    }
    //prevent form from submitting
    return false;
	break;
	case 'CCAvenue':
	if( ($('#paymentoptions').not(':empty')) && ($("input:radio[name='payment_option']").not(":checked")) &&($('#card_name option:selected').text()== 'Select'))
  {
 	alert('Either you have not selected Payment Option ');
	$("#paymentoptions td").toggleClass("highlight");
	 }
	 else{
	  console.log($('#card_name option:selected').text());
	//check the form is not currently submitting
    if($('#PaymentForm'+$("input[name='Payment_mod']:checked").val()).data('formstatus') !== 'submitting'){

         //setup variables
        var form = $('#PaymentForm'+$("input[name='Payment_mod']:checked").val()),
         formData = form.serialize()+ "&process=SelectedPayment",
         formUrl = form.attr('action'),
         formMethod = form.attr('method');

         //add status data to form
         form.data('formstatus','submitting');
		 //console.log(formData);
		 //$('#Addre').modal('show');
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
					//$('#Addre').modal('hide');
                    break;
                    case 'success':
					var url = responseData.production_url;
					//$('#Addre').modal('hide'),
					 form.data('formstatus','idle'),
					//$('#Addre').modal('hide'),
					 form.data('formstatus','idle'),
                   $('#paymentFrame').prop('src', responseData.production_url);
				   window.addEventListener('message', function(e) {
		    	 $("#paymentFrame").css("height",e.data['newHeight']+'px');
		 	 }, false);
				   $('#Paymentmodal').modal('show');
                    break;
                }


           }
      });
    }
    //prevent form from submitting
    return false;
	break;

	 }
	}//EOF SwitchPaymentname
  }

  else
  {
 	//$("#data td").toggleClass("highlight");
  alert('Either You have not Selected Any Payment Method'+ /n +'or not accepted Terms and Conditions !');
  }

});


});
</script>

<div class="container">
<br><br>
<div class="row">
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-address-book" aria-hidden="true"></i> Select Address </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-truck">  </i> Select Shipping </h3></div></div>
  <div class="col-sm-3"><div class="titleActive"><h3><i class="fa fa-list-alt">  </i> Order Summary </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-check">  </i> Order Complete </h3></div></div>
</div>
<br><br>

    <div class="row">

        <div class="col-xs-12">
    		<!--<div class="invoice-title">
    			<h2>Invoice</h2><h3 class="pull-right">Order # 12345</h3>
    		</div>-->
    		<hr>
    		<div class="row">
    			<div class="col-xs-6">
    				<address>
    				<h4><strong>Billed To:</strong></h4><br><h5>
					<?php
					$AddressString='';
					$AddressString= $AddressString .$_SESSION['Address']['Cust_entry_firstname'].''. $_SESSION['Address']['Cust_entry_lastname'].'<br>';
					if (isset($_SESSION['Address']['entry_company'])){
					$AddressString= $AddressString . $_SESSION['Address']['entry_company'].'<br>';
					}

					$AddressString= $AddressString .$_SESSION['Address']['Cust_entry_street_address'].'<br>'.
					$_SESSION['Address']['Cust_entry_suburb'].' , '.
					$_SESSION['Address']['Cust_city_name'].'<br>'.
					$_SESSION['Address']['Cust_state_name'].' - '.
					$_SESSION['Address']['Cust_entry_postcode'].'<br>';
					echo $AddressString;
					?>
    				</address></h5>
    			</div>
    			<div class="col-xs-6 text-right">
    				<address>
        			<h4><strong>Shipped To:</strong></h4><br><h5>
    					<?php
					$AddressString='';
					$AddressString= $AddressString .$_SESSION['Address']['Cust_entry_firstname'].''. $_SESSION['Address']['Cust_entry_lastname'].'<br>';
					if (isset($_SESSION['Address']['entry_company'])){
					$AddressString= $AddressString . $_SESSION['Address']['entry_company'].'<br>';
					}

					$AddressString= $AddressString .$_SESSION['Address']['Cust_entry_street_address'].'<br>'.
					$_SESSION['Address']['Cust_entry_suburb'].' , '.
					$_SESSION['Address']['Cust_city_name'].'<br>'.
					$_SESSION['Address']['Cust_state_name'].' - '.
					$_SESSION['Address']['Cust_entry_postcode'].'<br>';
					echo $AddressString;
					?>
    				</address></h5>
    			</div>
    		</div>

    	</div>
    </div>

    <div class="row">
    	<div class="col-md-12">
    		<div class="panel panel-default">
    			<div class="panel-heading">
    				<h3 class="panel-title"><strong>Order summary</strong></h3>
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
    						<tbody>

							<!--BOF Cart-->

<?php

if($cart->total_items() > 0){
 $cartItems = $cart->contents();
 foreach($cartItems as $item){
 $Cartresults= $product->getprodbyid($item['id']);
 $num_rows = mysqli_num_rows($Cartresults);
 if($num_rows > 0){
 while($rows =  mysqli_fetch_array($Cartresults)){

 if($product->CheckspecialsbyID($item['id'],date("Y-m-d"))){
//render specialLink
echo '<tr>
                    <!-- Index -->
                    <!-- Product  name -->
					<td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}
elseif($product->CheckfeaturedbyID($item['id'],date("Y-m-d"))){
// Render FeaturedLink
echo '<tr>
                    <!-- Index -->
                    <!-- Product  name -->
                    <td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-pf-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}
else{
//render normal Link
echo '<tr>
                    <!-- Index -->
                    <!-- Product  name -->
                    <td><h6><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-p-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h6></td>';

}





                    echo '<!-- Quantity with refresh and remove button -->
                    <td class="text-center"><h6>'.$item["qty"].'</h6></td>
                    <!-- Unit price -->
                    <td class="text-right"><h6><span class="fa fa-inr"></span> '.number_format($item["price"],2).'</h6></td>
                    <!-- Total cost -->
                    <td class="text-right"><h6><span class="fa fa-inr"></span> '.number_format($item["subtotal"],2).'</h6></td>
					 <td>&nbsp;</td>
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
    								<td class="thick-line text-center"><h5><strong> Subtotal</strong></h5></td>
    								<td class="thick-line text-center"><h5><?php echo $cart->total_qty();?></h5></td>
    								<td class="thick-line"></td>
    								<td class="thick-line text-right"><h5><span class="fa fa-inr"></span> <?php echo number_format($cart->total(),2) ;?></h5></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><h5><strong>Shipping (<?php echo $_SESSION['Shipping']['Shipping Name'];?>)</strong></h5></td>
    								<td class="no-line text-right"><h5><span class="fa fa-inr"></span> <?php echo number_format($_SESSION['Shipping']['Shipping_Cost'],2);?></h5></td>
    							</tr>
    							<tr>
    								<td class="no-line"></td>
    								<td class="no-line"></td>
    								<td class="no-line text-center"><h5><strong>Total</strong></h5></td>
    								<td class="no-line text-right"><h5><span class="fa fa-inr"></span> <?php echo number_format(($_SESSION['Shipping']['Shipping_Cost']+$cart->total()),2);?></h5></td>
    							</tr>
    						</tbody>
							<tfoot>
								<tr>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
								</tr>
								</tfoot>
    					</table>
						<table class="table table-condensed" id="data">
								<?php
								$Payments=ShowPayments();
								for ($i = 0; $i < count($Payments); $i++) {
								$str='';
								if ($Payments[$i]['name']=='CCAvenue'){
								$str='<form id="PaymentForm'.$Payments[$i]['PaymentID'].'" method="post" action="/includes/checkout_process.php">
		 <input type="hidden" name="Token" value="'. hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
		 <input type="hidden" name="Add_ID" value="'. $Payments[$i]['PaymentID'].'" >
		 <input type="hidden" id="PymntName'. $Payments[$i]['PaymentID'].'" name="PymntName" value="'. $Payments[$i]['name'].'" >
		 <input type="hidden" name="Ordertotal" value="'. ($_SESSION['Shipping']['Shipping_Cost']+$cart->total()).'" >
		 </form>
		 <tr>
									<td class="no-line"><h5><input type="radio" id="Payment_mod'.$Payments[$i]['PaymentID'].'" class="Postage" name="Payment_mod" value ="'.$Payments[$i]['PaymentID'].'">&nbsp;&nbsp;'.$Payments[$i]['paymentMethod'].'</td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
								</tr>';

								}
								else{
						$str='<form id="PaymentForm'.$Payments[$i]['PaymentID'].'" method="post" action="/includes/checkout_process.php">
		 <input type="hidden" name="Token" value="'. hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']).'" >
		 <input type="hidden" name="Add_ID" value="'. $Payments[$i]['PaymentID'].'" >
		 <input type="hidden" id="PymntName'. $Payments[$i]['PaymentID'].'" name="PymntName" value="'. $Payments[$i]['name'].'" >
		 <input type="hidden" name="Ordertotal" value="'. ($_SESSION['Shipping']['Shipping_Cost']+$cart->total()).'" >
		 </form>
		 <tr>
									<td class="no-line"><h5><input type="radio" id="Payment_mod'.$Payments[$i]['PaymentID'].'" class="Postage" name="Payment_mod" value ="'.$Payments[$i]['PaymentID'].'">&nbsp;&nbsp;'.$Payments[$i]['paymentMethod'].'</td>
									<td class="no-line"></td>
									<td class="no-line"></td>
									<td class="no-line"></td>
								</tr>';
								}
								echo $str;
								}
								?>

    					</table>
    				</div>
					<div class="table-responsive" class="panel panel-default" id="paymentoptions"></div><!--EOF Payment op-->
          <!-terms and conditions-->
          <div class="row">
            <div class="col-md-12">
              <tale>
                <tr>
              <td><input type="checkbox" name="terms" id="terms"></td>
              <td> <h7> I hereby Accept <a href="terms.html">Terms & conditions</a></h7></td>
            </tr>
            </table>
            </div>
          </div>

    			</div>
    		</div>
    	</div>
    </div>

	<!-- Button s-->
              <div class="row">
                <div class="col-md-4 col-md-offset-8">
                  <div class="pull-right">
                    <a href="checkout.html?process=Select_Shipping" class="btn btn-warning">Back</a>
                    <a class="btn btn-success PaymentSel">Proceed to Payment</a>
                  </div>
                </div>
              </div>

</div>
<?php
/***************/
}
break;
case "Order_Summary":

if (!isset($_POST['OID']) or empty($_POST['OID']))
{
if (!headers_sent())
    {
        header('Location: ./checkout.html?process=Select_Payment');
        exit;
        }
    else
        {
        echo '<script type="text/javascript">
       window.location.href="./checkout.html?process=Select_Payment";
        </script>
       <noscript>
        <meta http-equiv="refresh" content="0;url=./checkout.html?process=Select_Payment" />
       </noscript>'; exit;
    }
}
else{
$OID= filter_var($_POST['OID'], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
?>
<script>
$(document).ready(function()
{
		 $.ajax({
             url: './includes/checkout_process.php',
             type: 'post',
			data: '<?php echo 'Add_ID='.$_POST["OID"] ?>&Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&process=OrderSummary&notification=true',
			 cache: false,
             success:function(data){
			 console.log(data);
               $('#OrdSmmry').append('<div class ="alert alert-success" align="center"><h4>Your Order Successfully Placed. We will send a confirmation when your order ships. </h4></div>'+data);
                }


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
						$("#Msg").val('');
                    break;
                    case 'success':
                        klass = 'alert alert-success statusMessage';
						$("#Msg").val('');
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
<div class="container">
<br><br>
<div class="row">
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-address-book" aria-hidden="true"></i> Select Address </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-truck">  </i> Select Shipping </h3></div></div>
  <div class="col-sm-3"><div class="titleInActive"><h3><i class="fa fa-list-alt">  </i> Order Summary </h3></div></div>
  <div class="col-sm-3"><div class="titleActive"><h3><i class="fa fa-check">  </i> Order Complete </h3></div></div>
</div>
<br><br>
<div id="OrdSmmry"></div>

<div class="row">
<div class="col-md-12">
<div class="container">
<div id="Comments-response"><h5> </h5></div>
          <!-- Contact form (not working)-->
          <form class="form-horizontal" id="OrderStaus"  action="../includes/checkout_process.php" method="post" autocomplete="off">
            <!-- Comment -->
            <div class="form-group">
			<h5>Do you want to Add Comments ?? </h5>
              <div class="col-md-9">
                <textarea name="Msg" class="form-control" id="Msg"  placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
                <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
				<input type="hidden" name="Add_ID" value="1">
				<input type="hidden" name="process" value="OrderStatus">

              </div>
			     </div>

				 <div class="form-group">
              <!-- Buttons -->
              <div class="col-md-9 col-md-offset-8">
                <button type="submit" class="btn btn-warning"  id="sendMessage" name="sendMessage" value="Send Email" >Submit</button>
                <button type="reset" class="btn btn-success" id="cancel" name="cancel">Reset</button>
              </div>
            </div>
          </form>

</div></div></div>

</div>
<?php

}




//Eof Order Confirmation
break;
}
/* End Switch */
}
 else/*Default View of Shopping cart*/
 {
 ?>
 <!--cart Start-->
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

 if($product->CheckspecialsbyID($item['id'],date("Y-m-d"))){
//render specialLink
echo '<tr>
                    <!-- Index -->
					<!-- Product image -->
                    <td><img src="img/photos/'.$rows['products_image'].'" alt="" /></td>
                    <!-- Product  name -->
					<td><h5><a href="../'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['categories_name']))).'-c-'.$rows['master_categories_id'].'/'.strtolower(preg_replace('#[ -]+#', '-',preg_replace("/[^a-zA-Z0-9\s]/", "",  $rows['products_name']))).'-ps-'.$rows['products_id'].'.html">'.strtoupper($rows['products_name']).'</a></h5></td>';

}
elseif($product->CheckfeaturedbyID($item['id'],date("Y-m-d"))){
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
                    <a href="checkout.php?process=Select_Address" class="btn btn-danger">CheckOut</a>
                  </div>
                </div>
              </div>

      </div>
    </div>
  </div>
</div>

<!-- Cart ends -->

 <!--eof Cart-->
 <?php
 }

 /*EOF Login Check */
 }

?>

<?php
require_once (__DIR__.'/includes/recent.php');
include(__DIR__.'/includes/footer.php');
?>
