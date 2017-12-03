<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
?>
<!-- Page content starts -->
<style>
form .error {
  color: #ff0000;
}
</style>
<script src="../js/jquery.validate.js"></script>
<script src="../js/xbootstrap.min.js"></script>
<script>

  $(document).ready(function()
{
$( "#datepicker" ).datepicker
	({
      changeMonth: true,
      changeYear: true,
	  yearRange: "-100:+0",
	  dateFormat: 'dd-M-yy'
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
url: "includes/country_loader.php",
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
url: "includes/country_loader.php",
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
$("form[name='create_account']").validate({
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
      form.submit();
    }
  });
/*EOF Validation*/
});
  </script>

<div class="items">
  <div class="container">
    <div class="row"> <span class=""></span>
      <!-- Sidebar -->
      <div class="col-md-3 col-sm-3 hidden-xs">
        <?php
				//require_once(__DIR__.'/includes/Sidebar/sidebar_menu.php');
				require_once(__DIR__.'/includes/Sidebar/sidebar_featured.php');
				 			?>
        <br />
      </div>
      <!-- Main content -->
      <div class="col-md-9 col-sm-9">
        <!-- Some content -->
        <h3 class="title">New ? Register for New Account<span class="color">!!!</span></h3>
        <h4 >NOTE: If you already have an account with us, please login at the <a href="../login.html">login page</a>.</h4>
         <div class="formy well">
         <div class="alert" style="color:#FF0000;">* Required information</div>

          <div type="button" class="btn btn-info">
            <h6>Address Details</h6>
          </div>
          <div class="form">
            <!-- Register form (not working)-->
            <form name="create_account" action="../includes/signup_process.php" method="post" id="create_account" class="form-horizontal">
              <input type="hidden" name="action" value="process" />
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
                  <input type="text" name="FirstName" size = "33" maxlength = "32"  class="form-control" id="FirstName" placeholder="First Name" pattern="[A-Za-z]{1,32}" required >
                </div>
              </div>
              <!-- Last Name -->
              <div class="form-group">
                <label class="control-label col-md-3" for="LastName">Last Name:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="LastName" size = "33" maxlength = "32" class="form-control" id="LastName" placeholder=" Last Name" pattern="[A-Za-z]{1,32}"  required>
                </div>
              </div>
			  <!-- Company Name -->
              <div class="form-group">
                <label class="control-label col-md-3" for="company">Company Name:</label>
                <div class="col-md-6">
                  <input type="text" name="company" size = "33" maxlength = "32" class="form-control" id="company" placeholder=" Company Name If Any" pattern="[A-Za-z]{1,32}"  >
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
$stmt = "SELECT countries_id ,countries_name FROM countries";
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
              <div type="button" class="btn btn-info">
                <h6>Additional Contact Details</h6>
              </div>
              <br class="clearfix">
              </br>
              <!-- Telephone -->
              <div class="form-group">
                <label class="control-label col-md-3" for="telephone">Mob:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-6">
                  <input type="text" name="telephone" size = "33" maxlength = "32" class="form-control" id="telephone" pattern="[789][0-9]{9}" title="Eg:9812346789" placeholder="Please type your Mob Number" required="required">
                </div>
              </div>
              <!-- Age -->
              <div class="form-group">
                <label class="control-label col-md-3" for="telephone">Date of Birth:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-3">
                  <input type="text" name="dob" id="datepicker"  class="form-control datepiker" autocomplete="off"  data-provide="datepicker" placeholder="Date of birth"/>
                </div>
              </div>
              <div type="button" class="btn btn-info">
                <h6>Login Details</h6>
              </div>
              <br class="clearfix">
              </br>
              <!-- Email -->
              <div class="form-group">
                <label class="control-label col-md-3" for="Emaill">Email:</label><span class="alert" style="color:#FF0000;">*</span>
                <div class="col-md-8">
                  <input type="email" name="Emaill" class="form-control" id="Emaill" placeholder="Email address"  required>
                </div>
              </div>
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
              <div type="button" class="btn btn-info">
                <h6>Newsletter and Email Details</h6>
              </div>
              <br class="clearfix">
              </br>
              <!-- Checkbox -->
              <div class="form-group">
                <div class="col-md-8 col-md-offset-3">
                  <label class="checkbox-inline">
                  <input type="checkbox" name="newsletter" id="newsletter">
                  Subscribe to Our Newsletter. </label><span class="alert" style="color:#FF0000;">*</span>
                </div>
              </div>
              <!-- Checkbox -->
              <div class="form-group">
                <div class="col-md-8 col-md-offset-3">
                  <label class="checkbox-inline">
                  <input type="checkbox" id="terms" name="terms" required="" minlength="1" aria-required="true">
                  Agree with Terms and Conditions </label><span class="alert" style="color:#FF0000;">*</span>
                </div>
              </div>
              <!-- Buttons -->
              <div class="form-actions">
                <!-- Buttons -->
                <div class="col-md-8 col-md-offset-3">
                  <button type="submit" class="btn btn-danger">Register</button>
                  <button type="reset" id="reset" class="btn btn-default">Reset</button>
                </div>
              </div>
            </form>
            <div class="clearfix"></div>
            <hr />
            <p>Already have an Account? <a href="../login.html">Login</a></p>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content ends -->
<?php
include(__DIR__.'/includes/footer.php');
?>
