<?php
require_once (__DIR__.'/includes/global.inc.php');

$error = "";
$empcode = "";
$password = "";
$FYid= "";
//check to see if they've submitted the login form
if(isset($_POST['submit-login'])) { 
	$empcode = $_POST['empcode'];
	$password = $_POST['password'];
	$FYid= $_POST['cmbfinyear'];
	$userTools = new UserTools();
	if($userTools->login($empcode, $password,$FYid)){
		//successful login, redirect them to a page
		header("Location:welcome.php");
	}else{
	
		$error = "<div class='alert alert-danger' role='alert'> <span class='glyphicon glyphicon-warning-sign'>   </span>  Incorrect username or password. Please try again.</div>";
	}
}
//login.php
include'includes/header.php';
?>	<script type="text/javascript">
		$()
    .ready(function() {
	$("#empcode").focus();
	$.validator.addMethod("selectfinyear", function(value, element, arg) {
            return arg != value;
        }, "Select Financial Year.");
	$("#loginForm")
            .validate({
                rules: {
                    empcode: {
                        minlength: 4,
                        required: true,
                        number: true
                    },
                    password: {
                        minlength: 5,
                        required: true
                    },
                    cmbfinyear: {
                        selectfinyear: "0"
                       
                    }

                },
                messages: {
                    empcode: {
                        required: "Please enter Employee Code",
                        minlength: "Your Employee Code must consist of at least 5 characters",
                        number: "Enter Numbers Only"
                    },
                    password: {
                        required: "Please enter your Password",
                        minlength: "Your Password must consist of at least 5 characters"
                    }
                },
                showErrors: function(errorMap, errorList) {
                    $.each(this.successList, function(index, value) {
                        return $(value).popover("hide");
                    });
                    return $.each(errorList, function(index, value) {
                        var _popover;
                        //console.log(value.message);
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

                /*submitHandler: function() {
                    alert("Submit");
                }*/
            });
	});	</script>	
		
	<!-- BOF Contents-->
	
		
		<div class="container">
		
		<?php
		echo $error;?>	<div class="col-md-6 col-md-offset-3" >
	
	<div class="row">
<div class="panel panel-primary well">
<div class="panel-heading">Login to Continue</div>
<br>
	<form id="loginForm" name="loginForm" action="index.php" method="post" >
	         <div class="form-group">
            <label for="empcode">Employee Code</label>
			<input type="text" id="empcode" name="empcode" value="<?php echo $empcode; ?>" autocomplete="off" class="form-control" />
                    </div>
        <div class="form-group">
            <label for="password">Password</label>
			 <input type="password" id="password" name="password" value="<?php echo $password; ?>" autocomplete="off" class="form-control"  />
                </div>
		<div class="form-group">
		<label for="cmbfinyear">Fin Year</label>
		<?php		$sql = "SELECT Finyear_ID,Finyear FROM tbl_finyear_master 	";
		
$result = mysql_query($sql);

echo "<select name='cmbfinyear' class='form-control'>";
?><option value='0'>Select Financial Year</option><?php
while ($row = mysql_fetch_array($result)) {
    echo "<option value='" . $row['Finyear_ID'] . "'>" . $row['Finyear'] . "</option>";
}
echo "</select>";
?></div>
                <button type="submit"  name="submit-login" id="btn_submit" class="btn btn-primary">Login</button>
    </form>
	</div>
		</div>
	</div>
	
</div>
<!-- EOF Contents-->
	
<?php include'includes/footer.php';?>