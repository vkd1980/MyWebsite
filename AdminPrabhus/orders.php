<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/headermenu.php');
?>
<div class="content">
  <!-- BOF Modal -->
  <div id="myModalOrder" class="modal fade bs-example-modal-lg" role="dialog">
    <div class="modal-dialog modal-dialog modal-lg"style="width: 99%;height: 100%;margin: 10px;padding:0;overflow-y:initial !important">

      <!-- Modal content-->
      <div class="modal-content" style="height:auto;min-height: 100%;border-radius: 0;height: 250px;overflow-y: auto;">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body" id="OrderDetails"><!--BOF Order Confirmation-->
          <!--Eof Order Confirmation-->
          >
        </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>
              </div>

            </div>
</div>
<!-- EOF Modal -->
  <!-- Sidebar -->
<?php
require_once (__DIR__.'/includes/sidebar.php');
 ?>
 <!-- Sidebar ends -->
 <!-- Main bar -->
 <div class="mainbar">

   <!-- Page heading -->
   <div class="page-head">
     <h2 class="pull-left"><i class="fa fa-table"></i> Add/Edit ==> Currency </h2>

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
 							<div class="pull-left"> Currency Master </div>
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
 										<th> SL no </th>
                    <th> Order Number </th>
 										<th> Date </th>
                    <th> Customer Name </th>
                    <th> Amount </th>
                    <th> Order Status </th>
 										<th> Action </th>

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



 <?php
 require_once (__DIR__.'/includes/footer.php');
  ?>

  <script type="text/javascript">
 $(document).ready(function () {
   $(this).find('.open').removeClass("open");
   $('#Order').addClass('open')
   $('#orders').css('background',' #1aaef3','border-bottom',' 1px solid #ddd');
     /**********/
   var dataTable = $('#data-table-12').DataTable( {
       "lengthMenu": [[25, 50, 100], [25, 50, 100]],
       "order": [[ 1, "desc" ]],
      dom: 'lBfrtip',
      searching: false,
      buttons: [
          {extend: 'csv',title: 'Currency',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to CSV'},
          {extend: 'excel',title: 'Currency',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<span class="fa fa-file-excel-o"></span> Export to Excel '},
          {extend: 'print',title: 'Currency',exportOptions: {columns: [ 1, 2, 3, 4, 5]},action: newExportAction,text: '<i class="fa fa-print"></i> Print'}
      ],

      "processing": true,
      "serverSide": true,
      "sPaginationType": "full_numbers",
 "aoColumns" :[{ "bSearchable": false, "bSortable": false,"width": "5%"},
 {"bSearchable": false, "bSortable": false,"width": "5%"},
 { "bSearchable": false, "bSortable": false,"width": "10%" },
 { "bSearchable": true, "bSortable": false,"width": "15%" },
 { "bSearchable": false, "bSortable": false,"width": "5%" },
  { "bSearchable": false, "bSortable": false,"width": "10%" },
 { "data": null,  //can be null or undefined
 "bSortable": false,
 "bSearchable": false,
 "width": "10%",
 "defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li><a href='#'>Something else here</a></li><li class='divider'></li><li><a href='#'>Separated link</a></li></ul></div>"
 }],

      "ajax":{
        url :"includes/order_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
        type: "post",  // method  , by default get
        error: function(){  // error handling
          $("#data-table-12").append('<tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
        }
      },
      "rowCallback": function(row, data, index){
    if(data[5]== 'Pending'){
        $(row).find('td:eq(5)').css('color', 'red');
    }
    if(data[5]== 'Processing'){
        $(row).find('td:eq(5)').css('color', 'blue');
    }
    if(data[5]== 'Delivered'){
        $(row).find('td:eq(5)').css('color', 'green');
    }
    if(data[5]== 'Shipped'){
        $(row).find('td:eq(5)').css('color', 'yellow');
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
          //alert(data[1]);
            getvalues(data[1]);
         });
         $("#title").focus();
         $('#message').hide();

         function getvalues(catid) {
             //var empcode = $("input[name='Emp_Code']:text").val();
             if (catid == null || catid == undefined || catid == '') {

             } else {
                 $.ajax({
                     url: "includes/order_loader.php",
                     data: {
                         action: "Search",
                         OrderID: catid,
                         Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
                     },
                     type: 'post',
                     success: function(data) {
                       //console.log(data);
                       $('#OrderDetails').empty();
			                 $('#myModalOrder').modal('show'),
                      $('#OrderDetails').append(data);
                    //  $("OrderStatFrm").removeData("validator");
                    //$("OrderStatFrm").removeData("unobtrusiveValidation");
                    //$.validator.unobtrusive.parse("form");


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

/*function reinitialiseFormValidation(elementSelector) {
  //  var validator = $(elementSelector).validate();
    /validator.destroy();
     $.validator.unobtrusive.parse(elementSelector);
};*/
function saveedata() {
  savedata('#OrderStatFrm','includes/order_loader.php','<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>');
}
function clear() {
  $("#comments")
          .val("");
  $("#StatusID")
              .val('0');
  $('#StatusIDName').val("");

}

</script>
