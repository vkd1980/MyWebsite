<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
?>
<style>

 .statusMessage, input[type="submit"], input[type="button"] {
  -moz-border-radius: 10px;
  -webkit-border-radius: 10px;
  border-radius: 10px;
}


/* Style for the contact form and status messages */

.statusMessage {
  border: 1px solid #aaa;
  -moz-box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  -webkit-box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  box-shadow: 0 0 1em rgba(0, 0, 0, .5);
  opacity: .95;
}
.antispam { display:none;}
</style>
<script>
$(document).ready(function(){

    $('#contactForm').submit(function(){

    //check the form is not currently submitting
    if($(this).data('formstatus') !== 'submitting'){

         //setup variables
         var form = $(this),
         formData = form.serialize(),
         formUrl = form.attr('action'),
         formMethod = form.attr('method'),
			 responseMsg = $('#sendingMessage-response');

         //add status data to form
         form.data('formstatus','submitting');

         //show response message - waiting
         responseMsg.hide()
                    .addClass('alert alert-info statusMessage')
                    .text('Sending your message. Please wait...')
                    .fadeIn(200);

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
                        klass = 'alert alert-danger statusMessage';
						$("#senderName").val('');
						$("#senderEmail").val('');
						$("#message").val('');
						$("#PhoneNumber").val('');
                    break;
                    case 'success':
                        klass = 'alert alert-success statusMessage';
						$("#senderName").val('');
						$("#senderEmail").val('');
						$("#message").val('');
						$("#PhoneNumber").val('');
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
})
</script>
<!-- Page heading starts -->
<div class="page-head">
  <div class="container">
    <div class="row">
      <div class="col-md-12">
        <h2>Contact Us</h2>
        <h6>Write to Us</h6>
      </div>
    </div>
  </div>
</div>
<!-- Page Heading ends -->
<!-- Page content starts -->
<div class="content contact-two">
  <div class="container">
    <div class="row">
      <div class="col-md-6">
        <!-- Contact form -->
        <h4 class="title">Contact Form</h4>
        <div class="form">
          <!-- Contact form (not working)-->
          <form class="form-horizontal" id="contactForm"  method="post" action="/includes/contact_us_process.php" autocomplete="off">
            <!-- Name -->
            <div class="form-group">
              <label class="control-label col-md-2" for="senderName">Name</label>
              <div class="col-md-9">
                <input type="text" class="form-control"  name="senderName" id="senderName" placeholder="Please type your name" required="required" maxlength="40" />
              </div>
            </div>
            <!-- Email -->
            <div class="form-group">
              <label class="control-label col-md-2" for="senderEmail">Email</label>
              <div class="col-md-9">
                <input type="email"  class="form-control" name="senderEmail" id="senderEmail" placeholder="Please type your email address" required="required" maxlength="50" />
              </div>
            </div>
            <!-- Phone -->
            <div class="form-group">
              <label class="control-label col-md-2" for="senderEmail">Phone</label>
              <div class="col-md-9">
                <input type="text"  class="form-control" id="PhoneNumber" name="PhoneNumber" pattern="[789][0-9]{9}" title="Phone number with 7-9 and remaing 9 digit with 0-9" placeholder="Please type your Mob Number" required="required">
              </div>
            </div>
            <!-- Comment -->
            <div class="form-group">
              <label class="control-label col-md-2" for="comment">Message</label>
              <div class="col-md-9">
                <textarea name="message" class="form-control" id="message" placeholder="Please type your message" required="required" cols="80" rows="10" maxlength="10000"></textarea>
                <input type="hidden" name="Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
                <p class="antispam">Leave this empty:
                  <input type="text" name="url" />
                </p>
              </div>
            </div>
            <!-- Buttons -->
            <div class="form-group">
              <!-- Buttons -->
              <div class="col-md-9 col-md-offset-2">
                <button type="submit" class="btn btn-warning"  id="sendMessage" name="sendMessage" value="Send Email" >Submit</button>
                <button type="reset" class="btn btn-default" id="cancel" name="cancel">Reset</button>
              </div>
            </div>
          </form>
        </div>
        <div id="sendingMessage-response"></div>
        <hr />
        <div class="center">
          <!-- Social media icons -->
          <strong>Get in touch:</strong>
          <div class="social"> <a href="#"><i class="fa fa-facebook facebook"></i></a> <a href="#"><i class="fa fa-twitter twitter"></i></a> <a href="#"><i class="fa fa-linkedin linkedin"></i></a> <a href="#"><i class="fa fa-google-plus google-plus"></i></a> <a href="#"><i class="fa fa-pinterest pinterest"></i></a> </div>
        </div>
      </div>
      <div class="col-md-6">
        <h4 class="title">Google Map</h4>
        <!-- Google maps -->
        <div class="gmap">
          <!-- Google Maps. Replace the below iframe with your Google Maps embed code -->
          <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3946.0877712811807!2d76.94460511420439!3d8.490846893895284!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3b05bba3793c6939%3A0x5e02029ad375bd3a!2sPrabhus+Books!5e0!3m2!1sen!2sin!4v1481383183684" width="400" height="300" frameborder="0" style="border:0" allowfullscreen></iframe>
        </div>
        <hr />
        <!-- Address section -->
        <h4 class="title">Address</h4>
        <div class="address">
          <address>
          <!-- Company name -->
          <strong>Prabhus Books</strong><br>
          <!-- Address -->
          Ayurveda College Jn<br>
          Old Sreekandeswaram Road<br>
          Thiruvananthapuram-695 001<br>
          <!-- Phone number -->
          <abbr title="Phone">Phone:</abbr> +91-471-2478397.
          </address>
          <address>
          <!-- Name -->
          <strong>Full Name</strong><br>
          <!-- Email -->
          <a href="mailto:#">salesteam(at)prabhusbooks(dot)com</a>
          </address>
        </div>
      </div>
    </div>
  </div>
</div>
<!-- Page content ends -->
<?php
include(__DIR__.'/includes/footer.php');
?>
