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
                <div class="pull-left">Books Master </div>
                <div class="widget-icons pull-right"> <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> <a href="#" class="wclose"><i class="fa fa-times"></i></a> </div>
                <div class="clearfix"></div>
              </div>
              <div class="widget-content">
                <!--Table starts-->
                <div class="padd">

   					<!-- Table Page -->
   					<div class="page-tables">
   						<!-- Table -->
   						<div class="table-responsive">
   							<div class="form-group col-xs-3 col-md-3 pull-right ">
   								<input type="button" id="btnaddnew" value="Add New" title="Add New" class="btn btn-success"  />
   								<input type="button" id="btnrf" value="Refresh" title="Refresh" class="btn btn-warning" />
   							</div>
   							<table cellpadding="0" cellspacing="0" border="0" id="data-table-12" width="100%">
   								<thead>
   									<tr>
   										<th> products_id </th>
   										<th> SL no </th>
                      <th> ISBN/Code</th>
   										<th> Author </th>
                      <th> Title </th>
                      <th> Publihser </th>
                      <th> Subject </th>
                      <th> CUR </th>
                      <th> Rate </th>
   										<th> Action </th>

   									</tr>
   								</thead>

   							</table>
   							<div class="clearfix"></div>
   						</div>
   						</div>
   					</div>
                <!--Table Ends-->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
    <!-- Matter ends -->
  </div>
  <!-- Main bar ends -->
  <!-- Sidebar ends -->
  <div class="clearfix"></div>
</div>
<!-- Content ends -->
<!-- BOF Modal DEL -->
 <div class="modal fade bs-example-modal-lg" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true" >
     <div class="modal-dialog modal-lg" style="width: 99%;height: 100%;margin: 10px;padding:0;overflow-y:initial !important">
         <div class="modal-content" style="height:auto;min-height: 100%;border-radius: 0;height: 250px;overflow-y: auto;">
           <div class="modal-header" align="center">
<h3 class="modal-title"> Book Master </h3>
</div>

           <!--form-->
           <form class="form-vertical" role="form" name="gridder_addform" id="gridder_addform" >
             <div class="alert alert-success" id="message" align="center"></div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_model" class="control-label">ISBN/Code</label>
               <input type="text" name="products_model" class="form-control" id="products_model" placeholder="ISBN/Code">
               <input type="hidden" name="action" id= "action" value="addnew" >
               <input type="hidden"  name="products_id" id="products_id" value="0" >
             </div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_author" class="control-label">Author</label>
               <input type="text" name="products_author" class="form-control" id="products_author" placeholder="Author">
             </div>
             <div class="form-group col-xs-6 col-md-6">
               <label for="products_name" class="control-label">Title</label>
               <input type="text" name="products_name"  class="form-control" id="products_name" placeholder="Title">
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="manufacturers_id" class="control-label">Publisher</label>
               <select name="manufacturers_id" id="manufacturers_id" class="form-control">
                 <option value="-1">Select </option>
                 <?php $query 	= $db->select("SELECT * FROM manufacturers ORDER BY manufacturers_name");
                 while ($row = mysqli_fetch_array($query))
                 {
                 echo "<option value='" . $row['manufacturers_id'] . "'>" . $row['manufacturers_name'] . "</option>";
                 }
                 ?>
               </select>
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="master_categories_id" class="control-label">Subject</label>
               <select name="master_categories_id" id="master_categories_id" class="form-control">
                 <option value="-1">Select </option>
                  <?php $result = $db->select("SELECT * FROM categories ORDER BY categories_name");
             while ($row = mysqli_fetch_array($result))
             {
             echo "<option value='" . $row['categories_id'] . "'>" . $row['categories_name'] . "</option>";
             }
             ?>
               </select>
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="products_edition" class="control-label">Edition</label>
               <input type="text" name="products_edition" class="form-control" id="products_edition" placeholder="Edition">
             </div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_curid" class="control-label">Currency</label>
               <select name="products_curid" id="products_curid" class="form-control" onchange="calcprice">
                 <option value="-1">Select </option>
                 <?php $query 	= $db->select("SELECT currencies_id,symbol_left,title FROM currencies ORDER BY title");
                 while ($row = mysqli_fetch_array($query))
                 {
                 echo "<option value='" . $row['currencies_id'] . "'>" . $row['symbol_left'] . "</option>";
                 }
                 ?>
               </select>
             </div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_rate" class="control-label">Rate</label>
               <input type="text" style="text-align:right;" onKeyPress='return isNumberKeydecimal(event)' name="products_rate" class="form-control" id="products_rate" placeholder="Rate">
             </div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_price" class="control-label">Price</label>
               <input type="text" style="text-align:right;" name="products_price" onKeyPress='return isNumberKeydecimal(event)' class="form-control" id="products_price" placeholder="Price" readonly>
             </div>
             <div class="form-group col-xs-3 col-md-3">
               <label for="products_quantity" class="control-label">Stock</label>
               <input type="text" style="text-align:right;" name="products_quantity" onKeyPress='return isNumberKey(event)' class="form-control" id="products_quantity" placeholder="Stock">
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="product_min_qty" class="control-label"> Re-Order Qty </label>
               <input type="text" style="text-align:right;" name="product_min_qty" onKeyPress='return isNumberKey(event)' class="form-control" id="product_min_qty" placeholder="Re-Order Qty">
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="products_weight" class="control-label">Weight in KG </label>
               <input type="text" style="text-align:right;" name="products_weight" onKeyPress='return isNumberKeydecimal(event)' class="form-control" id="products_weight" placeholder="Weight in KG">
             </div>
             <div class="form-group col-xs-4 col-md-4">
               <label for="products_image" class="control-label">Image</label>
               <input type="text" name="products_image" class="form-control" value="default.png" id="products_image" placeholder="Image" readonly>
             </div>

             <div class="form-group col-xs-12 col-md-12">
               <label for="products_description1" class="control-label">Product Description</label>
               <textarea name="products_description1" id="products_description1"></textarea>
               <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />

             </div>

           <!--Eof Form-->
           <div class="clearfix"></div>
           <div class="modal-footer">
             <input type="submit" value="Addnew" class="btn btn-info btn-sm" id="btnsave" />
             <input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning btn-sm" /> 
               <button type="button" class="btn btn-default" id="btnmodalclose"data-dismiss="modal">Close</button>
           </div>
 </form>
         </div>
     </div>
 </div>
 <!-- EOF Modal DEL -->
 <!--BOF Upload Image Modal-->
 <!-- Modal -->
<div id="myModalImage" class="modal fade" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal">&times;</button>
        <h4 class="modal-title"> Upload Image </h4>
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
        <input name="pid" type="hidden" id="pid" >
      <input name="Token" type="hidden" id="Token"value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" >
        <input name="max_width_box" type="hidden" id="max_width_box" value="236" size="4">
        <input name="max_height_box" type="hidden" id="max_height_box" value="409" size="4">
        <div class="clearfix"></div>
        <input type="submit" value="Upload" class="submit" />
        <div class="clearfix"></div>
          </div>
        </div>
         </div>
        </form>
      </div>
      <div class="modal-footer">
             <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           </div>
    </div>
  </div>
</div>
 <!--EOF Upload Image Modal-->
<?php
require_once (__DIR__.'/includes/footer.php');
 ?>

 <script type="text/javascript">
 $(document).ready(function () {
  $(this).find('.open').removeClass("open");
  $('#Masters').addClass('open')
  $('#book_master').css('background',' #1aaef3','border-bottom',' 1px solid #ddd');
  $('#message').hide();
  $('#messageImg').hide();
  CKEDITOR.replace( 'products_description1' );
  /**********/
  var dataTable = $('#data-table-12').DataTable( {
      "lengthMenu": [[25, 50, 100], [25, 50, 100]],
      "order": [[ 0, "Desc" ]],
     dom: 'lBfrtip',
     buttons: [
         {extend: 'csv',title: 'Book Master',exportOptions: {columns: [ 1, 2, 3, 4, 5, 6, 7]},text: '<span class="fa fa-file-excel-o"></span> Export to CSV'},
         {extend: 'excel',title: 'Book Master',exportOptions: {columns: [ 1, 2, 3, 4, 5, 6, 7]},text: '<span class="fa fa-file-excel-o"></span> Export to Excel '},
         {extend: 'print',title: 'Book Master',exportOptions: {columns: [ 1, 2, 3, 4, 5, 6, 7]},text: '<i class="fa fa-print"></i> Print',customize: function ( win ) {
                    $(win.document.body)
                        .css( 'font-size', '10pt' )

                    $(win.document.body).find( 'table' )
                        .addClass( 'compact' )
                        .css( 'font-size', 'inherit' );
                }
       }
     ],

     "processing": true,
     "serverSide": true,
     "language": {
         searchPlaceholder: "Search Books"
     },
     "sPaginationType": "full_numbers",
"aoColumns" :[{ "bSearchable": false, "bSortable": false,"bVisible":false },
{"bSearchable": false, "bSortable": false,"width": "5%"},
{"bSearchable": true, "bSortable": true,"width": "10%"},
{ "bSearchable": true, "bSortable": true,"width": "15%" },
{ "bSearchable": true, "bSortable": true,"width": "30%" },
{ "bSearchable": true, "bSortable": true,"width": "15%" },
 { "bSearchable": true, "bSortable": true,"width": "10%" },
 { "bSearchable": false, "bSortable": false,"width": "5%" },
 { "bSearchable": false, "bSortable": false,"width": "5%" },
{ "data": null,  //can be null or undefined
"bSortable": false,
"bSearchable": false,
"width": "5%",
"defaultContent": "<div class='btn-group'><button class='btn btn-info dropdown-toggle' data-toggle='dropdown'>Action <span class='caret'></span></button><ul class='dropdown-menu'><li id='gridder_addnew'><a href='#'>Edit</a></li><li id='ImageUp'><a href='#'>Upload Image</a></li></ul></div>"
}],

     "ajax":{
       url :"includes/book_master_loader.php?Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&action=All&catid=0",
       type: "post",  // method  , by default get
       error: function(){  // error handling
         $("#data-table-12").append('<tbody"><tr><th colspan="3">No data found in the server</th></tr></tbody>');
       }
     }

   });
  /***************/
  dataTable.on( 'order.dt search.dt', function () {
          dataTable.column(1, {search:'applied', order:'applied'}).nodes().each( function (cell, i) {
              cell.innerHTML = i+1;
          });
      }).draw();
      //Delegate Action Button
       $('#data-table-12 tbody').on( 'click', '#gridder_addnew', function () {
            var data = dataTable.row( $(this).parents('tr') ).data();
        //alert(data[2]);
          getvalues(data[2]);
        });
        //Delegate Action Button
         $('#data-table-12 tbody').on( 'click', '#ImageUp', function () {
           var data = dataTable.row( $(this).parents('tr') ).data();
           //alert(data[2]);
             $('#Lisbn').text('ISBN/Code :-'+data[2]);
             $('#LTitle').text('Title :-'+data[4]);
             $('#pmodel').val(data[2]);
             $('#pid').val(data[0]);
           $.ajax({
    url:'/img/photos/'+data[2]+'.jpg',
    type:'HEAD',
    error: function()
    {
        //file not exists
        $('#previewing').prop('src', '/img/photos/default.png');

    },
    success: function()
    {
        //file exists
        $('#previewing').prop('src', '/img/photos/'+data[2]+'.jpg');
        }
    });
                $('#myModalImage').modal('show');
          });

    var getData = function (request, response) {
        $.getJSON(
            "includes/book_master_loader.php?action=ModSearch&Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&catid=" + request.term,
            function (data) {
                response(data);
            });
    };

    var selectItem = function (event, ui) {
        $("#products_model").val(ui.item.value);
        return false;
    }

    $("#products_model").autocomplete({
        source: getData,
        select: selectItem,
        minLength: 4,
        change: function() {
            //$("#products_model").val("").css("display", 2);
        }
    });
    //$("#products_model").autocomplete( "option", "appendTo", "#gridder_addform" );
    /**************/
    function getvalues(catid) {
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
                            //window.alert(output[2]);
                            //clear()

                        } else {
                                $("#action").val("update");
                                $("#products_id").val(output[0]['products_id']),
                                $("#products_model").val(output[0]['products_model']),
                                $("#products_author").val(output[0]['products_author']),
                                $("#products_name").val(output[0]['products_name']),
                                $("#products_edition").val(output[0]['products_edition'])
                                $("#master_categories_id").val(output[0]['master_categories_id']),
                                $("#manufacturers_id").val(output[0]['manufacturers_id']),
                                $("#products_weight").val(output[0]['products_weight']),
                                $("#products_rate").val(output[0]['products_rate']),
                                $("#product_min_qty").val(output[0]['product_min_qty']),
                                $("#products_curid").val(output[0]['products_curid']),
                                $("#products_price").val(output[0]['products_price']),
                                $("#products_image").val(output[0]['products_image']),
                                $("#products_quantity").val(output[0]['products_quantity']),
                                CKEDITOR.instances['products_description1'].setData(output[0]['products_description']);
                            $('#btnsave').val('Edit');
                            $('#myModal').modal('show');
                            $("#title").focus();

                        }
                    }

                }

            });
        }
    }
    /**************/
    $("#products_model").focusout(function(){

      //Get data from DB
      $.getJSON(
          "includes/book_master_loader.php?action=search&Token=<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>&catid=" + $("#products_model").val(),
          function (data) {
            console.log(data);
            if (data[0]!=0){
              $("#action").val("update");
              $("#products_model").val(data[0]['products_model']),
              $("#products_id").val(data[0]['products_id']),
              $("#products_author").val(data[0]['products_author']),
              $("#products_name").val(data[0]['products_name']),
              $("#products_edition").val(data[0]['products_edition'])
              $("#master_categories_id").val(data[0]['master_categories_id']),
              $("#manufacturers_id").val(data[0]['manufacturers_id']),
              $("#products_weight").val(data[0]['products_weight']),
              $("#products_rate").val(data[0]['products_rate']),
              $("#product_min_qty").val(data[0]['product_min_qty']),
              $("#products_curid").val(data[0]['products_curid']),
              $("#products_price").val(data[0]['products_price']),
              $("#products_image").val(data[0]['products_image']),
              $("#products_quantity").val(data[0]['products_quantity']),
              CKEDITOR.instances['products_description1'].setData(data[0]['products_description']);
              $('#btnsave').val('Edit');
            }
          });

      //Eof Get data from DB
    });
    /**Form Validation**/
    $("#gridder_addform").validate({
    					rules: {
                  products_model: {required: true},
                  products_author: {required: true},
                  products_name: {required: true},
                  manufacturers_id: {selectcat: "-1",required: true},
                  master_categories_id: {selectcat: "-1",required: true},
                  products_edition: {required: true},
                  products_curid: {selectcat: "-1",required: true},
                  products_rate: {required: true,number:true},
                  products_price:{required: true,number:true},
                  products_quantity:{required: true,number:true},
                  product_min_qty:{required: true,number:true},
                  products_weight:{required: true,number:true}
    								},
    					messages: {
                  products_model: {required: "Please enter ISBN/Code"},
                  products_author: {required: "Please enter Author Name"},
                  products_name: {required: "Please enter Book Name"},
                  products_edition: {required: "Please enter Edition"},
                  products_rate: {required: "Please enter Book Price",number:"Please enter Book Price in Number"},
                  products_quantity:{required: "Please enter Stock or Enter 0",number:"Please enter Stock in Number"},
                  product_min_qty:{required: "Please enter Re-Order Qty or Enter 0",number:"Please enter Re-Order Qty in Number"},
                  products_weight:{required: "Please enter Weight in KG",number:"Please enter Weight in Number"}
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
  var PD= CKEDITOR.instances['products_description1'].getData();
          $.ajax({
              url: 'includes/book_master_loader.php',
              type: 'POST',
              data: "products_description=" + PD + "&" + fdata,
              dataType: "json",
              beforeSend: function() {
                calcprice()
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
                    alert (output[1]);
                      $("#message").fadeIn();
                      $("#message").removeClass('alert-success');
                      $("#message").addClass('alert-danger');
                      $('#message').text(output[1]);
                      alert(output[1]);
                      $('#message').delay(3000).fadeOut();
                  }
              }
          });
          /***************/
    			}
    });
    /**EOF Form Validation**/
$("#btncancel").on('click', function() {
  clear()
  });
  $("#btnaddnew").on('click', function() {
    clear()
    $('#myModal').modal('show');
    });
    $("#btnrf").on('click', function() {
    	//clear()
    	dataTable.ajax.reload();
    	return false;
    	});
      $.validator.addMethod("selectcat", function(value, element, arg) {
          return arg != value;
      }, "Select This.");


  $("#products_rate").focusout(function(){
    calcprice()
  });
  /*********Image*********/
  $("#uploadimage").on('submit',(function(e) {
e.preventDefault();
$("#messageImg").empty();
$('#loading').show();
$.ajax({
url: "image_up_loader.php", // Url to which the request is send
type: "POST",
dataType: "json",            // Type of request to be send, called as method
data: new FormData(this), // Data sent to server, a set of key/value pairs (i.e. form fields and values)
contentType: false,       // The content type used when sending data to the server.
cache: false,             // To unable request pages to be cached
processData:false,        // To send DOMDocument or non processed data file it is set to false
success: function(data)   // A function to be called if request succeeds
{
  console.log(data);
if (data[0] == 'OK') {
$('#loading').hide();
$("#messageImg").removeClass('alert-danger');
$("#messageImg").addClass('alert-success');
$("#messageImg").fadeIn();
$('#messageImg').text(data[1]);
$('#messageImg').delay(3000).fadeOut();
}
else {
  $("#messageImg").fadeIn();
  $("#messageImg").removeClass('alert-success');
  $("#messageImg").addClass('alert-danger');
  $('#messageImg').text(data[1]);
  $('#messageImg').delay(3000).fadeOut();
}
}
});
}));

// Function to preview image after validation
$(function() {
$("#file").change(function() {
$("#messageImg").empty(); // To remove the previous error message
var file = this.files[0];
var imagefile = file.type;
var match= ["image/jpeg","image/png","image/jpg"];
if(!((imagefile==match[0]) || (imagefile==match[1]) || (imagefile==match[2])))
{
$('#previewing').attr('src','/img/photos/default.png');

$("#messageImg").text("Please Select A valid Image File"+"<br>Only jpeg, jpg and png Images type allowed");
return false;
}
else
{
var reader = new FileReader();
reader.onload = imageIsLoaded;
reader.readAsDataURL(this.files[0]);
}
});
});
function imageIsLoaded(e) {
$("#file").css("color","green");
$('#image_preview').css("display", "block");
$('#previewing').attr('src', e.target.result);
$('#previewing').attr('width', '150px');
$('#previewing').attr('height', '130px');
};
/*********Image*********/
});

function clear() {
		$("#action").val("addnew");
      $("#products_id").val('0'),
      $("#products_model").val(''),
      $("#products_author").val(''),
      $("#products_name").val(''),
      $("#products_edition").val('')
      $("#master_categories_id").val('-1'),
      $("#manufacturers_id").val('-1'),
      $("#products_weight").val(''),
      $("#products_rate").val(''),
      $("#product_min_qty").val(''),
      $("#products_curid").val('-1'),
      $("#products_price").val(''),
      $("#products_image").val('default.png'),
      $("#products_quantity").val(''),
      CKEDITOR.instances['products_description1'].setData('');
		$('#btnsave').val('Addnew');

			}
      function calcprice(){
        var id = $("#products_curid").val();
        $.ajax({
            url: 'includes/currency_master_loader.php',
            type: 'POST',
            data: {
                action: "Rate",
                currencies_id: id,
                Token: '<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>'
            },
            dataType: "json",
            success: function(output) {
                if (output[0] == 'OK') {
                  $("#products_price").val(numeral($("#products_rate").val()* output[2]).format('0.00'));
                }
            }
        });
      }
 </script>
