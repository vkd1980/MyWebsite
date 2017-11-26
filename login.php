<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions+
require_once (__DIR__.'/includes/classes/global.inc.php');
if(empty($_REQUEST['camefrom']) || (!isset($_REQUEST['camefrom'])))
{
$camefrom ='./';

}
else
{
$camefrom = filter_var($_REQUEST['camefrom'], FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_HIGH);
}
include(__DIR__.'/includes/header.php');
?>
<script>
$(document).ready(function(){
	$("#forgetpwd").click(function(){
		 $('#Forgetpasswordmodal	').modal('show');
	});
	//bof forgetpwd function
	$('#ForgotEmailform').submit(function(e){
		e.preventDefault();
		var obj = $(this), action = obj.attr('name'); /*Define variables*/
		Msgdiv = $('#forgetpwdmsg');
		$.ajax({
				type: "POST",
				url: "./includes/login_process.php",
				data:obj.serialize()+'&Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&process=forgetpwd',
				cache: false,
				success: function (data) {
					$('#ForgotEmail').val('');
					var responseData = jQuery.parseJSON(data);
					switch(responseData.status){
							case 'Error':
							Msgdiv.show()
												 .addClass('alert-danger fade in')
												 .text(responseData.message)
												 .fadeOut(2600, "linear");
									$('#forgetpwdmodal').modal('toggle');
							break;
							case 'success':
							Msgdiv.show()
												 .addClass('alert-success fade in')
												 .text(responseData.message)
												 .fadeOut(2600, "linear");
									$('#forgetpwdmodal').modal('toggle');
							break;
					}
				}
		});
	});
	//eof forgetpwd funtion

	$("#loginform").submit(function (e) {
    e.preventDefault();
    var obj = $(this), action = obj.attr('name'); /*Define variables*/
	$.ajax({
        type: "POST",
        url: e.target.action,
        data: obj.serialize(),
        cache: false,
        success: function (JSON) {
            if (JSON.error != '') {
		         $("#loginform #display_error").show().html(JSON.error);
				            } else {
							window.location.href = JSON.camefrom;
            }
        }
    });
});
});
</script>
<!--BOF Forgetpassword Modal-->
<div id="Forgetpasswordmodal" class="modal fade" role="dialog">
<div class="modal-dialog">

	<!-- Modal content-->
	<div class="modal-content">
		<div class="modal-header">
	<button type="button" class="close" data-dismiss="modal">&times;</button>
	<h5>Reset your Password</h5>
			</div>

 <div class="modal-body modalimg">
<div id="forgetpwdmsg" style="display:none"class="alert fade in"></div>
<div class="form">
	<form action="/includes/login_process.php" method="post" name="ForgotEmail_form" id="ForgotEmailform" class="form-horizontal" autocomplete="off">
		<input type="email" name="ForgotEmail" class="form-control" id="ForgotEmail" placeholder="Email address"  required autofocus><br>
<button id="ForgotEmailbtn"  type="submit" class="btn btn-info">Reset Password</button>
	</form>
</div>

 </div>
 <div class="modal-footer">
</div>
</div>
</div>
</div>
<!--EOF Forgetpassword Modal-->

<!-- Page content starts -->
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">

        <!-- Some content -->
                  <h3 class="title">Login to Shop <span class="color">!</span></h3>
									  <h4 >Don't Have Account ??, Please signup <a href="../signup.html">Sign Up</a>.</h4>
                <!--<p>Nullam in est urna. In vitae adipiscing enim. Curabitur rhoncus condimentum lorem, non convallis dolor faucibus eget. In vitae adipiscing enim. Curabitur rhoncus condimentum lorem, non convallis dolor faucibus eget. In ut nulla est. </p>-->
                  <h5>Access to your Account and </h5>
				  <div class="lists">
                  <ul>
                    <li><h6>View/Edit your WishList</h6></li>
                    <li><h6>View and Cancel pending Orders</h6></li>
                    <li><h6>Add and Edit your Billing Address and Shipping Address</h6></li>

                  </ul>
				  </div>


                </div>


<!-- Login form -->
                <div class="col-md-6">
                  <div class="formy well">
                     <h4 class="title">Login to Your Account</h4>
                                  <div class="form">

                                      <!-- Login  form (not working)-->
                                      <form action="/includes/login_process.php" method="post" name="login_form" id="loginform" class="form-horizontal" autocomplete="off">
                                          <!-- Username -->
                                          <div class="form-group">
                                            <label class="control-label col-md-3" for="username2">Username</label>
                                            <div class="col-md-8">
                                              <input type="email" name="Email" class="form-control" id="Email" placeholder="Email address"  required autofocus>
											  <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], $_SESSION['csrf_token']);?>" >
                  <input type="hidden" name="camefrom" value="<?php echo $camefrom;?>" >
									<input type="hidden" name="process" value="logging" >
                                            </div>
                                          </div>
                                          <!-- Password -->
                                          <div class="form-group">
                                            <label class="control-label col-md-3" for="password2">Password</label>
                                            <div class="controls col-md-8">
                                              <input type="password" name="Password" id="Password" class="form-control" id="password2" placeholder="Password" required pattern=".{6,12}" title="6 to 12 characters.">
                                            </div>
                                          </div>
                                          <!-- Checkbox -->
                                          <div class="form-group">
                                             <div class="col-md-8 col-md-offset-3">
											 <div id="display_error" style="display:none"class="alert alert-danger fade in"></div>
                  <!-- Display Error Container -->
                                                <!--<label class="checkbox-inline">
                                                   <input type="checkbox" id="inlineCheckbox3" value="agree"> Remember Password
                                                </label>-->
                                             </div>
                                          </div>

                                          <!-- Buttons -->
                                          <div class="form-group">
                                             <!-- Buttons -->
											 <div class="col-md-8 col-md-offset-3">
												<button id="loginbtn"  type="submit" class="btn btn-info">Login</button>
												<button type="reset" class="btn btn-default">Reset</button>
											 </div>
                                          </div>
                                      </form>
                                      <hr />
                                      <h5>New Account</h5>
                                             Don't have an Account? <a href="../signup.html">Register</a>
																						 <h6><a href="#" id="forgetpwd">Forget Password ?</a></h6>
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
