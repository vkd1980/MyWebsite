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
/*$results = $CustAddress->GetCustAddress("'".$_SESSION['UserData'][1]."'");
$num_rows = mysqli_num_rows($results);

if($num_rows > 0){
	$rows =  mysqli_fetch_array($results);
}*/
?>
<script src="../js/jquery.validate.js"></script>
<script src="../js/xbootstrap.min.js"></script>
<script>
$(document).ready(function()
{
	getAddress();
	function getAddress(){


	if($('#AddressFormMy'+$(this).attr('value')).data('formstatus') !== 'submitting'){
	 $.ajax({
             url: '../includes/address_loader.php',
             type: 'post',
             data: {
				'id': '<?php echo $_SESSION['UserData'][0]; ?>',
				'Token': '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>',
				'page':'<?php echo basename(__FILE__, '.php').'.php';?>',
				'mail':'<?php echo $_SESSION['UserData'][1]; ?>'
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
					$('#Cust_address_book_id').val(responseData.Adetails['Cust_address_book_id']),
					responseData.Adetails['Entry_gender']=='M' ? $('#gender-male').prop('checked', true) : $('#gender-female').prop('checked', true),
					$('#FirstName').val(responseData.Adetails['Cust_entry_firstname']),
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

	}
$('#Cust_id').val(<?php echo $_SESSION['UserData'][0]; ?>);
//Checkout process

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

$('#City')
    .empty()
    .append('<option selected="selected" value="0">Select State</option>')
;
$('#State')
    .empty()
    .append('<option selected="selected" value="0">Select Country</option>')
;

}
else
{

$("#City option[value=0]").text('Select State');
$("#State").html(html);
}
}
});

});
//State Change

$("#State").change(function()
{

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

$("#City").prop("disabled", true);
$('#City')
    .empty()
    .append('<option selected="selected" value="0">Select State</option>')
;
}
else
{

$("#City").prop("disabled", false);
$("#City").html(html);
}
}
});

});
/*BOF Validation*/
$("form[name='AddressFormMy']").validate({
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
	Terms:{
		required:true,
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
	  Terms:{
		  required: "Please Agree Terms and conditions"
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

	$('#passwordnew').val($.md5($('#passwordnew').val()));
	$('#passwordconfirm').val($.md5($('#passwordconfirm').val()));
			console.log($(form).serialize());
      //form.submit();
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
      <div class="row">
  <!-- Sidebar -->
      <div class="col-md-3 col-sm-3 hidden-xs">

        <h5 class="title">Pages</h5>
        <!-- Sidebar navigation -->
          <nav>
            <ul id="navi">
              <li><a href="myaccount.html"><h7>My Account</h7></a></li>
              <!-- <li><a href="wish-list.php">Wish List</a></li>
              <li><a href="order-history.php">Order History</a></li>-->
              <li><a href="myprofile.html"><h7>Edit Profile</h7></a></li>
            </ul>
          </nav>

      </div>
<!-- EOF Sidebar -->

<div class="col-md-9 col-sm-9" >
 <!-- Title -->
          <h5 class="title">Edit Profile</h5>
            <!-- Register form (not working)-->
            <form name="AddressFormMy" method="post" id="AddressFormMy" class="form-horizontal">
			<input type="hidden" name="Cust_id" id="Cust_id" value="" />
			<input type="hidden" name="Cust_address_book_id" id="Cust_address_book_id" value="" />
              <input type="hidden" name="action" id="action" value="Default" />
			  <input type="hidden" name="Isdefault" id="Isdefault" value="1" />
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
$stmt = "SELECT countries_id,countries_name FROM countries";
$result = $DBC->select($stmt);
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
			  <!---->
			   <!-- Password -->
              <div class="form-group">
                <label class="control-label col-md-3" for="password2">Password</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-5">
                  <input type="password" name="passwordnew" class="form-control" value="" size = "21" maxlength= "40"  id="passwordnew" placeholder="Password" title="Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character"  required>
                </div>
              </div>
              <!-- Password -->
              <div class="form-group">
                <label class="control-label col-md-3" for="confirmation">Confirm Password:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-5">
                  <input class="form-control"type="password" name="passwordconfirm" size = "21" maxlength= "40" id="passwordconfirm" placeholder="Password" title="Minimum 8 and Maximum 10 characters at least 1 Uppercase Alphabet, 1 Lowercase Alphabet, 1 Number and 1 Special Character"  required >
                </div>
              </div>


              <!-- Checkbox -->
               <div class="form-group">
               <div class="col-md-6 col-md-offset-2">
                <label class="checkbox inline">
                 <input type="checkbox" name ="Terms" id="Terms" value="agree"> Agree with Terms and Conditions
                 </label>
                </div>
                </div>
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
		    </div>
<?php
include(__DIR__.'/includes/footer.php');
?>
