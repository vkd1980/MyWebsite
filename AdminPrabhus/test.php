<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/headermenu.php');
?>
<div class="content">
  <!-- Sidebar -->
<?php
require_once (__DIR__.'/includes/sidebar.php');
 ?>
  <!-- Sidebar ends -->
  <!-- Main bar -->
  <div class="mainbar">
    <!-- Page heading -->
    <div class="page-head">
      <h2 class="pull-left"><i class="fa fa-file-o"></i> Add/Edit - Payment Modules</h2>

      <!-- Breadcrumb -->
      <div class="bread-crumb pull-right">
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
        <!-- Divider -->
        <span class="divider">/</span>
        <a href="./payment.php" class="bread-current">Payment</a>
      </div>

      <div class="clearfix"></div>

    </div>
    <!-- Page heading ends -->
    <!-- Matter -->

    <div class="matter">
      <div class="container">
        <div class="row">
          <div class="col-md-12">

            <div class="widget">
              <div class="widget-head">
                <div class="pull-left"> Payment Modules </div>
                <div class="widget-icons pull-right">
                  <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                  <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="widget-content">

                <div class="padd">

            <!-- Table Page -->
            <div class="page-tables">
              <!-- Table -->
              <div class="table-responsive">
                <div class="form-group col-xs-3 col-md-3 pull-right ">
                  <input type="button" id="btnaddnew" value="Add New" title="Add New" class="btn btn-success" data-toggle="modal" data-target="#myModal" />
                  <input type="button" id="btnrf" value="Refresh" title="Refresh" class="btn btn-warning" />
                </div>
                <table cellpadding="0" cellspacing="0" border="0" id="data-table-12" width="100%">
                  <thead>
                    <tr>
                      <th>SL no</th>
                      <th>Payment ID</th>
                      <th>Payment Name</th>
                      <th>Payment Method</th>
                      <th>Online Status</th>
                      <th>Status</th>
                      <th>Payment Image</th>
                      <th>Date Added</th>
                      <th>Date Modified</th>
                      <th>Action</th>

                    </tr>
                  </thead>

                </table>
                <div class="clearfix"></div>
              </div>
              </div>
            </div>
                </div>
                <div class="widget-foot">
                  <!-- Footer goes here -->
                </div>
              </div>
            </div>

          </div>
        </div>
      </div>
    </div>

  <!-- Matter ends -->
 <div class="clearfix"></div>

</div>
<!-- Content ends -->
<!-- BOF Modal DEL -->
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" >
    <div class="modal-dialog modal-dialog modal-lg"style="width: 99%;height: 100%;margin: 10px;padding:0;overflow-y:initial !important">
        <div class="modal-content" style="height:auto;min-height: 100%;border-radius: 0;height: 250px;overflow-y: auto;">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <br /><div class="modal-header" align="center">
    <h3 class="modal-title">Payment Modules</h3>
</div>

<div class="modal-body"  align="center">
    </div>

            </div>
            <div class="modal-body">

			<!-- form-->
			<form name="gridder_addform" id="gridder_addform">
        <div class="alert alert-success" id="message" align="center"></div>
<input type="hidden" name="action" id= "action" value="addnew" />
<input type="hidden"  name="Payment_id" id="Payment_id"  value="#" />
<input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <td>Payment Name</td>
								<td>Payment Method</td>
								<td>Payment_image</td>
                <td>Upload New Image</td>
                            </tr>
                        </thead>
                      </tbody>
                        <tr>
                            <td><input type="text"  name="Payment_name" id="Payment_name"  autocomplete="off" class="form-control" required autofocus /><br></td>

							<td><input type="text"  name="Payment Method" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
              <td><img id="Payment_image" src="" alt="Pymnt Image" width="75%"></td>
              <td><input type="button" value="Find" class="btn btn-info" id="btnfind" /></td>
                        </tr>
                        <tr>
                          <td>Status</td>
                          <td>Online Status</td>
                          <td>Date Added</td>
                            <td>Date Modified</td>


                        </tr>

                        <tr>
                          <td><select name="Status" id="Status"  class="form-control"  >
                   <option value="-1" required>Select </option>
                    <option value="0">InActive </option>
                    <option value="1" >Active </option>

                    </select></td>
                    <td><select name="Online_Status" id="Online_Status"  class="form-control"  >
             <option value="-1" required>Select </option>
              <option value="0">InActive </option>
              <option value="1" >Active </option>

              </select></td>
                          <td>
                            <input data-format="dd-MM-yyyy" id="date_added" type="text" class="form-control" name="date_added">
                 						</td>

                          <td>
                 						<input data-format="dd-MM-yyyy" id="date_modified" type="text"  class="form-control" name="date_modified">

                          </td>



                        </tr>
                        <tr>
                          <td align="center" colspan="4">Action</td>
                        </tr>
                        <tr>
                          <td align="center" colspan="4"><input type="submit" value="Save" class="btn btn-info" id="btnsave" />
                          <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
                        </tr>
                      </tbody>
                    </table>


                <table  class="table table-bordered table-striped " id="config_details_table">
                  <tbody>
                  <tr>
                    <td>configuration_id</td>
                    <td>configuration_title</td>
                      <td>configuration_key</td>
                      <td>configuration_value</td>
                      <td>configuration_description</td>
                      <td>configuration_group_id</td>
                      <td>Module_Id</td>
                      <td>sort_order</td>
                      <td>action   </td>               </tr>
                    </tbody>
                    <tfoot>
                      <tr>
                        <td></td>
                        <td><input type="text"  name="configuration_title" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="configuration_key" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="configuration_value" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="configuration_description" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="configuration_group_id" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="Module_Id" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="text"  name="sort_order" id="Payment_Method"  autocomplete="off" class="form-control" required/></td>
                          <td><input type="button" value="Find" class="btn btn-info" id="btnfind" /></td>               </tr>
                    </tfoot>

                </table>
</div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='btnmodalclose'data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div>
<!-- EOF Modal DEL -->
<?php
require_once (__DIR__.'/includes/footer.php');
 ?>
<script type="text/javascript">
jQuery.validator.setDefaults({
// This will ignore all hidden elements alongside `contenteditable` elements
// that have no `name` attribute
ignore: ":hidden, [contenteditable='true']:not([name])"
});

function showEdit(editableObj) {
			$(editableObj).css("background","#93b7f2");
		}
    function saveToDatabase(editableObj,column,id) {
    			$(editableObj).css("background","#FFF url(./img/loaderIcon.gif) no-repeat right");
    			$.ajax({
    				url: "includes/payments_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=update&",
    				type: "POST",
    				data:'column='+column+'&editval='+editableObj.innerHTML+'&configuration_id='+id,
    				success: function(data){
    					$(editableObj).css("background","#FDFDFD");
    				}
    		   });
    		}
$(document).ready(function () {

  $(this).find('.open').removeClass("open");
  $('#Masters').addClass('open')
  $('#featured').css('background',' #1aaef3','border-bottom',' 1px solid #ddd');

   /**********/
   $('#date_added,#date_modified').datepicker({dateFormat: "dd-mm-yy"
 });
 var dataTable = $('#data-table-12').DataTable( {
     "lengthMenu": [[25, 50, 100], [25, 50, 100]],
     "order": [[ 1, "desc" ]],
    dom: 'lBfrtip',
    searching: false,
    buttons: [],

    "processing": true,
    "serverSide": true,
    "sPaginationType": "full_numbers",
"aoColumns" :[{ "bSearchable": false, "bSortable": false,"width": "5%"},
{"bSearchable": false, "bSortable": false,"width": "5%"},
{"bSearchable": false, "bSortable": false,"width": "10%"},
{ "bSearchable": false, "bSortable": false,"width": "20%" },
{ "bSearchable": false, "bSortable": false,"width": "5%" },
{ "bSearchable": false, "bSortable": false,"width": "5%" },
{ "bSearchable": false, "bSortable": false,"width": "5%" },
{ "bSearchable": false, "bSortable": false,"width": "10%" },
{ "bSearchable": false, "bSortable": false,"width": "10%" },
{ "data": null,  //can be null or undefined
"bSortable": false,
"bSearchable": false,
"width": "10%",
"defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li><a href='#'>Something else here</a></li><li class='divider'></li><li><a href='#'>Separated link</a></li></ul></div>"
}],

    "ajax":{
      url :"includes/payments_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
      type: "post",  // method  , by default get
      error: function(){  // error handling
        $("#data-table-12").append('<tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
      }
    },
    "rowCallback": function(row, data, index){
  if(data[5]== '1'){
      $(row).find('td:eq(5)').text('Active');
      $(row).find('td:eq(5)').css('color', 'green');

  }
else{
    $(row).find('td:eq(5)').text('InActive');
      $(row).find('td:eq(5)').css('color', 'red');
  }
  if(data[4]== '1'){
      $(row).find('td:eq(4)').text('Active');
      $(row).find('td:eq(4)').css('color', 'green');

  }
else{
    $(row).find('td:eq(4)').text('InActive');
      $(row).find('td:eq(4)').css('color', 'red');
  }

  if(!data[6] == ""){
  var imgTag = '<img src=".' + data[6] + '"width="75%"/>';
  $(row).find('td:eq(6)').html(imgTag);
}
}

  });
 /***************/

     //Delegate Action Button
      $('#data-table-12 tbody').on( 'click', '#gridder_addnew', function () {
           var data = dataTable.row( $(this).parents('tr') ).data();
       //alert(data[2]);
         getvalues(data[1]);
       });
       /****/

       /****/
       //Delegate Action Button
       /**************/
       function getvalues(catid) {
           //var empcode = $("input[name='Emp_Code']:text").val();
           if (catid == null || catid == undefined || catid == '') {

           } else {
               $.ajax({
                   url: "includes/payments_loader.php",
                   data: {
                       action: "search",
                       catid: catid,
                       Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
                   },
                   type: 'post',
                   dataType: "json",
                   success: function(output) {
                       var siteArray = output.array;
                       if (!$.isArray(siteArray) || !siteArray.length) {

                           if (output[0] == 0) {
                               window.alert(output[2]);
                               clear();

                           } else {
                                   $("#action").val("update");
                                   $("#Payment_id").val(output[0]['Payment_id']),
                                   $("#Payment_name").val(output[0]['Payment_name']),
                                   $("#Payment_Method").val(output[0]['Payment Method']),
                                   $("#Online_Status").val(output[0]['Online_Status']),
                                   $("#Status").val(output[0]['Status']),
                                   $("#Payment_image").attr("src","."+output[0]['Payment_image']);
                                   $("#date_added").val($.datepicker.formatDate('dd-mm-yy',  new Date(output[0]['date_added']))),
                                   $("#date_modified").val($.datepicker.formatDate('dd-mm-yy',  new Date(output[0]['date_modified']))),
                                   $('#btnsave').val('Edit');
                                   /********/
                                   $.ajax({
                                       url: "includes/payments_loader.php",
                                       data: {
                                           action: "getconfig",
                                           catid: output[0]['Payment_name'],
                                           Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
                                       },
                                       type: 'post',
                                       dataType: "html",
                                       success: function(output) {
                                         $('#config_details_table tbody').append(output);
                                   }
                               });
                                   /**********/
                                   $('#myModal').modal('show');

                           }
                       }

                   }

               });
           }
       }
       /**************/

 $("#btncancel,#btnrf").on('click', function() {
   clear()
   dataTable.ajax.reload();
     return false;
           });


});

/*function reinitialiseFormValidation(elementSelector) {
//  var validator = $(elementSelector).validate();
  /validator.destroy();
   $.validator.unobtrusive.parse(elementSelector);
};*/
/**Form Validation**/
$("#gridder_addform").validate({
  errorPlacement: $.datepicker.errorPlacement,
            rules: {
              products_model: {required: true},
              expires_date: {
                required: true,
                dpDate: true
                      },
                date_available: {
                  required: true,
                  dpDate: true,
                  dpCompareDate: ['before', '#expires_date']
                }

                },
          messages: {
              products_model: {required: "Please enter ISBN/Code"},
              expires_date: 'Please enter a valid date (dd-mm-yyyy)',
              date_available:{ required: 'Please enter a valid date (dd-mm-yyyy)',
              dpCompareDate:'Please enter a date before Expiry Date'
            }
            },
  showErrors: function(errorMap, errorList) {
        $.each(this.successList, function(index, value) {
        return $(value)
          .popover("hide");
          });
      return $.each(errorList, function(index, value) {
        var _popover;
          //console.log(value.message);
        _popover = $(value.element)
        .popover({
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

    submitHandler: function() {
      var fdata = $("#gridder_addform").serialize();
      $.ajax({
          url: 'includes/payments_loader.php',
          type: 'POST',
          data: fdata,
          dataType: "json",
          beforeSend: function() {
              $("#message").removeClass('alert-success');
              $("#message").addClass('alert-danger');
              $('#message').text('Please Wait.....');
          },
          success: function(output) {
              if (output[0] == 'OK') {
                  $("#message").removeClass('alert-danger');
                  $("#message").addClass('alert-success');
                  $("#message").fadeIn();
                  $('#message').text(output[1]);
                  $('#message').delay(3000).fadeOut();
                  alert(output[1]);
                  clear();
              } else {
                  $("#message").fadeIn();
                  $("#message").removeClass('alert-success');
                  $("#message").addClass('alert-danger');
                  $('#message').text(output[1]);
                  clear();
                  alert(output[1]);
                  $('#message').delay(3000).fadeOut();
              }
          }
      });
      /***************/
      }
});
/**EOF Form Validation**/
function clear() {
  $("#action")
          .val("addnew");
$("#Payment_name")
        .val("");
$("#Payment_id ")
        .val("#");
$("#Payment_name")
            .val('');
$('#Payment_Method').val("");
$('#date_added').val("");
$('#date_modified').val("");
$('#Online_Status')
    .val(-1)
    .attr("selected", "selected");
    $('#Status')
        .val(-1)
        .attr("selected", "selected");
$('#btnsave').val('AddNew');
}

</script>
