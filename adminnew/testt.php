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
      <h2 class="pull-left"><i class="fa fa-file-o"></i> Invoice</h2>
    </div>
    <!-- Page heading ends -->
    <!-- Matter -->
    <div class="matter">
      <div class="container">
        <div class="row">
          <div class="col-md-12">
            <div class="widget">
              <div class="widget-head">
                <div class="pull-left">Invoice</div>
                <div class="widget-icons pull-right"> <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a> <a href="#" class="wclose"><i class="fa fa-times"></i></a> </div>
                <div class="clearfix"></div>
              </div>
              <div class="widget-content">
                <form class="form-vertical" role="form">
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_model" class="control-label">ISBN/Code</label>
                    <input type="text"  class="form-control" id="products_model" placeholder="ISBN/Code">
                  </div>
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_author" class="control-label">Author</label>
                    <input type="text"  class="form-control" id="products_author" placeholder="Author">
                  </div>
                  <div class="form-group col-xs-6 col-md-6">
                    <label for="name" class="control-label">Title</label>
                    <input type="text"  class="form-control" id="name" placeholder="Title">
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="manufacturers_id" class="control-label">Publisher</label>
                    <select name="manufacturers_id" id="manufacturers_id" class="form-control">
                    </select>
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="master_categories_id" class="control-label">Subject</label>
                    <select name="master_categories_id" id="master_categories_id" class="form-control">
                    </select>
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="products_edition" class="control-label">Edition</label>
                    <input type="text"  class="form-control" id="products_edition" placeholder="Edition">
                  </div>
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_curid" class="control-label">Currency</label>
                    <select name="products_curid" class="form-control">
                    </select>
                  </div>
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_rate" class="control-label">Rate</label>
                    <input type="email"  class="form-control" id="products_rate" placeholder="Rate">
                  </div>
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_price" class="control-label">Price</label>
                    <input type="email"  class="form-control" id="products_price" placeholder="Price">
                  </div>
                  <div class="form-group col-xs-3 col-md-3">
                    <label for="products_quantity" class="control-label">Stock</label>
                    <input type="email"  class="form-control" id="products_quantity" placeholder="Stock">
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="product_min_qty" class="control-label"> Re-Order Qty </label>
                    <input type="email"  class="form-control" id="product_min_qty" placeholder="Re-Order Qty">
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="products_weight" class="control-label">Weight in KG </label>
                    <input type="email"  class="form-control" id="products_weight" placeholder="Weight in KG">
                  </div>
                  <div class="form-group col-xs-4 col-md-4">
                    <label for="products_image" class="control-label">Image</label>
                    <input type="email"  class="form-control" id="products_image" placeholder="Image">
                  </div>
                </form>
                <div class="widget-foot">
                  <div class="pull-right">
                    <button class="btn btn-info btn-sm">Send Invoice</button>
                     
                    <button class="btn btn-default btn-sm">Cancel</button>
                  </div>
                  <div class="clearfix"></div>
                </div>
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
<?php
require_once (__DIR__.'/includes/footer.php');
 ?>
