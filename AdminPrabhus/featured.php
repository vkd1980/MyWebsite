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
      <h2 class="pull-left"><i class="fa fa-file-o"></i> Add/Edit - Featured</h2>

      <!-- Breadcrumb -->
      <div class="bread-crumb pull-right">
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
        <!-- Divider -->
        <span class="divider">/</span>
        <a href="./featured.php" class="bread-current">Featured</a>
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
                <div class="pull-left"> featured </div>
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
                      <th>featured ID</th>
                      <th>ISBN</th>
                      <th>Product Name</th>
                      <th>Expiry Date</th>
                      <th>Status</th>
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
<div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span>
                </button>
                <br /><div class="modal-header" align="center">
    <h3 class="modal-title">featured</h3>
</div>

<div class="modal-body"  align="center">
    </div>

            </div>
            <div class="modal-body">

			<!-- form-->
			<form name="gridder_addform" id="gridder_addform">
        <div class="alert alert-success" id="message" align="center"></div>
<input type="hidden" name="action" id= "action" value="addnew" />
<input type="hidden"  name="featured_id" id="featured_id"  value="#" />
<input type="hidden"  name="products_id" id="products_id" value="#"/>
<input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <td>ISBN</td>
								<td>Author</td>
								<td>Title</td>
                <td>Price</td>
                            </tr>
                        </thead>
                        <tr>
                            <td><input type="text"  name="products_model" id="products_model"  autocomplete="off" class="form-control" required autofocus /><br><input type="button" value="Find" class="btn btn-info" id="btnfind" /></td>

							<td><input type="text"  name="products_author" id="products_author"  autocomplete="off" class="form-control" required/></td>
              <td><input type="text"  name="products_name" id="products_name"  autocomplete="off" class="form-control" required/></td>
              <td><input type="text"  name="products_price" id="products_price"  autocomplete="off" class="form-control" required/></td>
                        </tr>
                        <tr>
                          <td>Special Price</td>
                          <td>Expiry Date</td>
                            <td>Date Available</td>
                              <td>Status</td>

                        </tr>

                        <tr>
                          <td></td>
                          <td>
                            <input data-format="dd-MM-yyyy" id="expires_date" type="text" class="form-control" name="expires_date">
                 						</td>

                          <td>
                 						<input data-format="dd-MM-yyyy" id="date_available" type="text"  class="form-control" name="date_available">

                          </td>
                    <td><select name="status" id="status"  class="form-control"  >
             <option value="-1" required>Select </option>
              <option value="0">InActive </option>
              <option value="1" >Active </option>

              </select></td>


                        </tr>
                        <tr>
                          <td align="center" colspan="4">Action</td>
                        </tr>
                        <tr>
                          <td align="center" colspan="4"><input type="submit" value="Save" class="btn btn-info" id="btnsave" />
                          <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
                        </tr>
                    </table>

                </form>
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
$(document).ready(function () {
  $(this).find('.open').removeClass("open");
  $('#Masters').addClass('open')
  $('#featured').css('background',' #1aaef3','border-bottom',' 1px solid #ddd');
  
   /**********/
   $('#expires_date,#date_available').datepicker({minDate: 0,
   dateFormat: "dd-mm-yy"
 });
 var dataTable = $('#data-table-12').DataTable( {
     "lengthMenu": [[25, 50, 100], [25, 50, 100]],
     "order": [[ 1, "desc" ]],
    dom: 'lBfrtip',
    searching: false,
    buttons: [
        {extend: 'csv',title: 'Featured',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to CSV'},
        {extend: 'excel',title: 'Featured',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to Excel '},
        {extend: 'print',title: 'Featured',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<i class="fa fa-print"></i> Print'}
    ],

    "processing": true,
    "serverSide": true,
    "sPaginationType": "full_numbers",
"aoColumns" :[{ "bSearchable": false, "bSortable": false,"width": "5%"},
{"bSearchable": false, "bSortable": false,"width": "5%"},
{"bSearchable": true, "bSortable": false,"width": "10%"},
{ "bSearchable": true, "bSortable": false,"width": "20%" },
{ "bSearchable": false, "bSortable": false,"width": "5%" },
{ "bSearchable": false, "bSortable": false,"width": "5%" },
{ "data": null,  //can be null or undefined
"bSortable": false,
"bSearchable": false,
"width": "10%",
"defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li><a href='#'>Something else here</a></li><li class='divider'></li><li><a href='#'>Separated link</a></li></ul></div>"
}],

    "ajax":{
      url :"includes/featured_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
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
  if(data[5]== '0'){
    $(row).find('td:eq(5)').text('InActive');
      $(row).find('td:eq(5)').css('color', 'red');
  }

}

  });
 /***************/

 /*dataTable.on( 'order.dt search.dt', function () {
         dataTable.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
             cell.innerHTML = i+1;
         });
     }).draw();*/
     //Delegate Action Button
      $('#data-table-12 tbody').on( 'click', '#gridder_addnew', function () {
           var data = dataTable.row( $(this).parents('tr') ).data();
       //alert(data[2]);
         getvalues(data[1]);
       });
       /****/
       $("#btnfind").on('click', function() {
         var data = $("#products_model").val();
         findvalues(data);
       });
       /****/
       //Delegate Action Button

       /**************/
       function findvalues(catid) {
           //var empcode = $("input[name='Emp_Code']:text").val();
           if (catid == null || catid == undefined || catid == '') {

           } else {
               $.ajax({
                   url: "includes/book_master_loader.php",
                   data: {
                       action: "search",
                       catid: catid,
                       Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
                   },
                   type: 'post',
                   dataType: "json",
                   success: function(output) {
                     console.log(output);
                       var siteArray = output.array;
                       if (!$.isArray(siteArray) || !siteArray.length) {

                           if (output[0] == 0) {
                               window.alert(output[2]);
                               clear();

                           } else {
                                   $("#products_id").val(output[0]['products_id']),
                                   $("#products_model").val(output[0]['products_model']),
                                   $("#products_author").val(output[0]['products_author']),
                                   $("#products_name").val(output[0]['products_name']),
                                   $("#products_price").val(output[0]['products_price']);
                                   $('#myModal').modal('show');
                               $("#price").focus();

                           }
                       }

                   }

               });
           }
       }
       /**************/
       /**************/
       function getvalues(catid) {
           //var empcode = $("input[name='Emp_Code']:text").val();
           if (catid == null || catid == undefined || catid == '') {

           } else {
               $.ajax({
                   url: "includes/featured_loader.php",
                   data: {
                       action: "search",
                       catid: catid,
                       Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
                   },
                   type: 'post',
                   dataType: "json",
                   success: function(output) {
                     console.log(output);
                       var siteArray = output.array;
                       if (!$.isArray(siteArray) || !siteArray.length) {

                           if (output[0] == 0) {
                               window.alert(output[2]);
                               clear();

                           } else {
                                   $("#action").val("update");
                                   $("#featured_id").val(output[0]['featured_id']),
                                   $("#products_id").val(output[0]['products_id']),
                                   $("#products_model").val(output[0]['products_model']),
                                   $("#products_author").val(output[0]['products_author']),
                                   $("#products_name").val(output[0]['products_name']),
                                   $("#products_price").val(output[0]['products_price']);
                                   $("#expires_date").val($.datepicker.formatDate('dd-mm-yy',  new Date(output[0]['expires_date']))),
                                   $("#date_available").val($.datepicker.formatDate('dd-mm-yy',  new Date(output[0]['featured_date_available']))),
                                   $('#status').val(output[0]['status']),
                                   $('#btnsave').val('Edit');
                                   $('#myModal').modal('show');
                                   $("#price").focus();

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
          url: 'includes/featured_loader.php',
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
$("#products_model")
        .val("");
$("#featured_id ")
        .val("#");
$("#products_id")
      .val("#");
$("#products_author")
            .val('');
$('#products_name').val("");
$('#products_price').val("");
$('#expires_date').val("");
$('#date_available').val("");
$('#status')
    .val(-1)
    .attr("selected", "selected");
$('#btnsave').val('AddNew');
}

</script>
