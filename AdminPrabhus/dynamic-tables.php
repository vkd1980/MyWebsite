<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/header.php');
require_once (__DIR__.'/includes/headermenu.php');

?>
<!-- Content Starts -->

<div class="content">
  <!-- Sidebar -->
  <?php
require_once (__DIR__.'/includes/sidebar.php');
?>
  <!-- Main bar -->
  <div class="mainbar">
    <!-- Page heading -->
    <div class="page-head">
      <h2 class="pull-left"><i class="fa fa-file-o"></i> Add/Edit ==> Products</h2>

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
                <div class="pull-left">Data Tables</div>
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
                <table cellpadding="0" cellspacing="0" border="0" id="data-table-12" width="100%">
                  <thead>
                    <tr>
                      <th>Category</th>
                      <th>Parent Category</th>
                      <th>CategoryID</th>
                      <th>Action</th>

                    </tr>
                  </thead>
                  <tfoot>
                    <tr>
                      <th>Category</th>
                      <th>Parent Category</th>
                      <th>CategoryID</th>
                      <th>Action</th>

                    </tr>
                  </tfoot>
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
$(document).ready(function() {
  var dataTable = $('#data-table-12').DataTable( {
    "processing": true,
    "serverSide": true,
    "language": {
        searchPlaceholder: "Search Category"
    },
    "sPaginationType": "full_numbers",

     "aoColumns" :[null,
{ "bSearchable": false, "bSortable": false },
{ "bSearchable": false, "bSortable": false,"bVisible":false },
{ "data": null, // can be null or undefined
   "bSortable": false,
   "bSearchable": false,
  "defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li><a href='#'>Something else here</a></li><li class='divider'></li><li><a href='#'>Separated link</a></li></ul></div>"
}],

    "ajax":{
      url :"includes/subject_master_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
      type: "post",  // method  , by default get
      error: function(){  // error handling
        $("#data-table-12").append('<tbody class="employee-grid-error"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
      }
    }
  } );
  /********/
  $('#data-table-12 tbody').on( 'click', '#gridder_addnew', function () {
       var data = dataTable.row( $(this).parents('tr') ).data();
       alert( data[0] +"'ID is: "+ data[2] );
   } );

} );
 </script>
