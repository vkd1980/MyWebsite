<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/headermenu.php');

?>
<!--BOF Upload Image Modal-->
<!-- Modal -->
<div id="myModalImage"  role="dialog">
 <div class="modal-dialog">
   <div class="modal-content">
     <div class="modal-header">
       <button type="button" class="close" data-dismiss="modal">&times;</button>
       <h4 class="modal-title">Modal Header</h4>
     </div>
     <div class="modal-body">
       <div class="alert alert-success" id="messageImg" align="center"></div>
       <form class="form-vertical" role="form" id="uploadimage" action="" method="post" enctype="multipart/form-data">
         <div class="row">
           <div class="col-xs-12 col-md-12">
           <h4><label id="Lisbn" class="control-label">ISBN</label>
           &nbsp;&nbsp;<label id="LTitle" class="control-label">Title</label></h4>
          </div>
          <div class="col-xs-12 col-md-12" id="image_preview"><img id="previewing" width="130px" height="150px" src="/img/photos/default.png" /></div>
          <div class="form-group col-xs-12 col-md-12" id="selectImage">
         <div class="form-group col-xs-6 col-md-6">
     <label for="file" class="control-label">Select Your Image File</label>
       <input type="file" name="file" id="file" required />
     </div>
     <div class="form-group col-xs-6 col-md-6">
       <input name="pmodel" type="hidden" id="pmodel" >
     <input name="Token" type="hidden" id="Token"value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
       <input name="max_width_box" type="hidden" id="max_width_box" value="236" size="4">
       <input name="max_height_box" type="hidden" id="max_height_box" value="409" size="4">
       <div class="clearfix"></div>
       <input type="submit" value="Upload" class="submit" />
       <div class="clearfix"></div>
         </div>
       </div>
        </div>--row
       </form>
     </div>
     <div class="modal-footer">
            <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
          </div>
   </div>
 </div>

</div>
<!--EOF Upload Image Modal-->
