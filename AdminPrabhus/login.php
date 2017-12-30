<?php require_once (__DIR__.'/includes/classes/global.inc.php');
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
  <meta charset="utf-8">
  <!-- Title and other stuffs -->
  <title>Login - Bookstore Admin</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="description" content="">
  <meta name="keywords" content="">
  <meta name="author" content="">

  <!-- Stylesheets -->
  <link href="css/bootstrap.min.css" rel="stylesheet">
  <link rel="stylesheet" href="css/font-awesome.min.css">
  <link href="css/style.css" rel="stylesheet">

  <script src="js/respond.min.js"></script>
  <!--[if lt IE 9]>
  <script src="js/html5shiv.js"></script>
  <![endif]-->

  <!-- Favicon -->
  <link rel="shortcut icon" href="img/favicon/favicon.png">

</head>

<body>

<!-- Form area -->
<div class="admin-form">
  <div class="container">

    <div class="row">
      <div class="col-md-12">
        <!-- Widget starts -->
            <div class="widget worange">
              <!-- Widget head -->
              <div class="widget-head">
                <i class="fa fa-lock"></i> Login
              </div>
<div id="display_error" style="display:none"class="alert alert-danger fade in"></div>
              <div class="widget-content">
                <div class="padd">
                  <!-- Login form -->
                  <form action="includes/login_process.php" method="post" name="login_form" id="loginform" class="form-horizontal" autocomplete="off">
                  <form class="form-horizontal">
                    <!-- Email -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="Email">Email</label>
                      <div class="col-lg-9">
                        <input type="email" class="form-control" name="Email" id="Email" placeholder="Email" required autofocus>
                        <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], $_SESSION['csrf_token']);?>" >
                        <input type="hidden" name="process" value="logging" >
                      </div>
                    </div>
                    <!-- Password -->
                    <div class="form-group">
                      <label class="control-label col-lg-3" for="Password" >Password</label>
                      <div class="col-lg-9">
                        <input type="password" class="form-control" name="Password" id="Password" placeholder="Password" required pattern=".{6,12}" title="6 to 12 characters.">
                      </div>
                    </div>
                    <!-- Remember me checkbox and sign in button
                    <div class="form-group">
					<div class="col-lg-9 col-lg-offset-3">
                      <div class="checkbox">
                        <label>
                          <input type="checkbox"> Remember me
                        </label>
						</div>
					</div>
					</div>-->
                        <div class="col-lg-9 col-lg-offset-3">
							<button type="submit" class="btn btn-info btn-sm">Sign in</button>
							<button type="reset" class="btn btn-default btn-sm">Reset</button>
						</div>
                    <br />
                  </form>

				</div>
                </div>

                <div class="widget-foot">
                  Forget Password? <a href="#">Click here</a>
                </div>
            </div>
      </div>
    </div>
  </div>
</div>



<!-- JS -->
<script src="js/jquery.js"></script>
<script src="js/bootstrap.min.js"></script>
<script src="js/jquery.md5.js"></script>
<script>
$(document).ready(function(){
$("#loginform").submit(function (e) {
$('#Password').val($.md5($('#Password').val()));
Msgdiv = $('#display_error');
  e.preventDefault();
  var obj = $(this), action = obj.attr('name'); /*Define variables*/
$.ajax({
      type: "POST",
      url: e.target.action,
      data: obj.serialize(),
      cache: false,
      beforeSend: function() {
          console.log(obj.serialize());
      },
      success: function (data) {
        console.log(data);
        var responseData = jQuery.parseJSON(data);
        switch(responseData.status){
            case 'Error':
            Msgdiv.show()
                       .addClass('alert-danger fade in')
                       .text(responseData.message)
                       .fadeOut(2600, "linear");
            break;
            case 'success':
             window.location.replace(responseData.Location);
            //window.location.href = responseData.camefrom;
            break;
        }
      }
  });
});
});
</script>
</body>
</html>
<?php echo '<pre>' . print_r($_SESSION, TRUE) . '</pre>';
echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], $_SESSION['csrf_token']);
?>
