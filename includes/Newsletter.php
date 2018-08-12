<?php
require_once (__DIR__.'/classes/global.inc.php');
?>
<style>

</style>
<script>
function refreshCaptcha() {
$("#captcha_code").attr('src','/includes/captcha_code.php');
}
$(document).ready(function(){


    $('#newsletter-signup').submit(function(){

    //check the form is not currently submitting
    if($(this).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $(this),
         formData = form.serialize(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
         responseMsg = $('#signup-response');

         //add status data to form
         form.data('formstatus','submitting');

         //show response message - waiting
         responseMsg.hide()
                    .addClass('response-waiting')
                    .text('Please Wait...')
                    .fadeIn(200);

         //send data to server for validation
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
                        klass = 'response-error';
						$("#Email").val('');
                    break;
                    case 'success':
                        klass = 'response-success';
						$("#Email").val('');
                    break;
                }

                //show reponse message
                responseMsg.fadeOut(200,function(){
                   $(this).removeClass('response-waiting')
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
})
</script>
<!-- Newsletter starts -->
<div class="container newsletter">
  <div class="row">
    <div class="col-md-12">
      <div class="well">
        <h5><i class="fa fa-envelope"></i> Hot Offers - Don't Miss Anything!!!</h5>
        <p>Leave us your Email,We will Notify the Exiting offers to your mailbox</p>
        <form class="form-inline" role="form" id="newsletter-signup" method="post" action="/includes/Newsletter_process.php" autocomplete="off">
          <div class="form-group">

            <!--<input type="email" class="form-control" id="search" placeholder="Subscribe">-->
            <input type="email" name="Email" class="form-control" id="Email" placeholder="Email address"  required >
            <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/includes/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
            <img id="captcha_code" src="/includes/captcha_code.php" /><button  class="btnRefresh" onClick="refreshCaptcha();">Refresh Captcha</button>
            <input type="text" name="captcha" id="captcha" class="demoInputBox" required><br>
          </div>
          <button type="submit" class="btn btn-default" id="signup-button">Subscribe</button>
          <strong>
          <p id="signup-response"></p>
          </strong>
        </form>
      </div>
    </div>
  </div>
  <div><strong>
    <p id="signup-response"></p>
    </strong></div>
</div>
<!--Newsletter ends -->
