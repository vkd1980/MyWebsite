<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions+
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
$userTools = new UserTools();
if($userTools->logout()){
$Message= "Loggedout Successfully";
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
//
}
?>
<div class="content">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
	  <h5><?php echo $Message;?></h5>
	  </div>
	  </div>
	  </div>

<?php
include(__DIR__.'/includes/footer.php');
?>
