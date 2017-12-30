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
    <h2 class="pull-left"><i class="fa fa-table"></i> Add/Edit ==> Publishers </h2>

    <!-- Breadcrumb -->
    <div class="bread-crumb pull-right">
      <a href="index.html"><i class="fa fa-home"></i> Home</a>
      <!-- Divider -->
      <span class="divider">/</span>
      <a href="#" class="bread-current">Dashboard</a>
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
							<div class="pull-left"> Publisher Master </div>
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
										<th>CategoryID</th>
										<th>SL no</th>
										<th>Publihsers</th>
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
<!-- Mainbar ends -->
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
                <br /><div  class="modal-header" align="center">
    <h3 class="modal-title">Publisher Master</h3>
</div>

            </div>
            <div class="modal-body">

                <div class="alert alert-success" id="message" align="center"></div>
                <form name="gridder_addform" id="gridder_addform">
                    <input type="hidden" name="action" id="action" value="addnew" />
                    <input type="hidden" name="manufacturers_id" id="manufacturers_id" class="gridder_add" />
                    <table class="table table-bordered table-striped ">
                        <thead>
                            <tr>
                                <td>Publisher Name</th>
                                    <td>Action</th>
                            </tr>
                        </thead>
                        <tr>
                            <td>
                                <input type="text" name="manufacturers_name" id="manufacturers_name" autocomplete="off" class="form-control" />
                            </td>
                            <td align="center">
                                <input type="submit" value="Save" class="btn btn-info" id="btnsave" />
                                <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" />
                            </td>
                        </tr>

                    </table>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" id='btnmodalclose' data-dismiss="modal">Close</button>
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
	 var dataTable = $('#data-table-12').DataTable( {
          "lengthMenu": [[25, 50, 100,-1], [25, 50, 100,"All"]],
					 "order": [[ 2, "asc" ]],
         dom: 'lBfrtip',
				 buttons: [
		         {extend: 'csv',title: 'Publihsers',exportOptions: {columns: [ 1, 2]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to CSV'},
		         {extend: 'excel',title: 'Publihsers',exportOptions: {columns: [ 1, 2]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to Excel '},
		         {extend: 'print',title: 'Publihsers',exportOptions: {columns: [ 1, 2]},action: newExportAction,text: '<i class="fa fa-print"></i> Print'}
		     ],
         "processing": true,
         "serverSide": true,
         "language": {
             searchPlaceholder: "Search Publihsers"
         },
         "sPaginationType": "full_numbers",
 "aoColumns" :[{ "bSearchable": false, "bSortable": false,"bVisible":false },
 {"bSearchable": false, "bSortable": false,"width": "10%"},
 { "bSearchable": true, "bSortable": true,"width": "40%" },
 { "data": null,  //can be null or undefined
  "bSortable": false,
  "bSearchable": false,
  "width": "10%",
 "defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li><a href='#'>Something else here</a></li><li class='divider'></li><li><a href='#'>Separated link</a></li></ul></div>"
 }],

         "ajax":{
           url :"includes/publisher_master_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
           type: "post",  // method  , by default get
           error: function(){  // error handling
             $("#data-table-12").append('<tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
           }
         }

       });
dataTable.on( 'order.dt search.dt', function () {
		dataTable.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
			 cell.innerHTML = i+1;
			  });
			}).draw();
			//Delegate Action Button
$('#data-table-12 tbody').on( 'click', '#gridder_addnew', function () {
  var data = dataTable.row( $(this).parents('tr') ).data();
    getvalues(data[0]);
  });
	$("#manufacturers_name").focus();
	$('#message').hide();
	//LoadGrid();
$("#gridder_addform").validate({
					rules: {
							manufacturers_name: {
							minlength: 2,
							required: true
							}
								},
					messages: {
						manufacturers_name: {
						required: "Please enter Publisher Name",
						minlength: "Publisher Name must consist of at least 2 characters"
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
			savedata('#gridder_addform','includes/publisher_master_loader.php','<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>');
			}
});
$('#manufacturers_name').focusout(function() {
	this.value = this.value.toUpperCase();
});
function getvalues(catid) {
				//var empcode = $("input[name='Emp_Code']:text").val();
				if (catid == null || catid == undefined || catid == '') {

				} else {
				$.ajax({
						url: "includes/publisher_master_loader.php",
						data: {
								action: 'search',
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
												$("#action")
														.val("addnew");
												$("#manufacturers_id")
														.val("");
												$("#manufacturers_name")
														.val("");

										} else {
												$("#action")
														.val("update");
												$("#manufacturers_id")
														.val(output[0]);
												$("#manufacturers_name")
														.val(output[1]);
												$('#btnsave').val('Edit');
												$('#myModal').modal('show');
												$("#manufacturers_name").focus();
										}
								}
						}

				});
			}
		}
$("#btncancel,#btnrf").on('click', function() {
	clear()
	dataTable.ajax.reload();
	return false;
	});

	  });
function clear() {
		$("#action")
			.val("addnew");
		$("#manufacturers_id")
			 .val("");
		$("#manufacturers_name")
			  .val("");
		$("#filter")
			  .val("");
		$('#btnsave').val('Addnew');

			}
</script>
