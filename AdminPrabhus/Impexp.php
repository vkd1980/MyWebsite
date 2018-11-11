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
      <h2 class="pull-left"><i class="fa fa-file-o"></i> Import/Export- Book Master</h2>

      <!-- Breadcrumb -->
      <div class="bread-crumb pull-right">
        <a href="index.php"><i class="fa fa-home"></i> Home</a>
        <!-- Divider -->
        <span class="divider">/</span>
        <a href="./Impexp.php" class="bread-current">Import / Export</a>
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
                <div class="pull-left"><b> EXPORT NEW PRODUCTS </b></div>
                <div class="widget-icons pull-right">
                  <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                  <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                </div>
                <div class="clearfix"></div>
              </div>

              <div class="widget-content">

                <div class="padd">
              <b> <p> Select "From Date" and Today's Date as "To Date" to Export New Products Added Till Yesterday </b></p>
<form action="includes/export.php" method="post" name="upload_excel" enctype="multipart/form-data">
  <input type="hidden" name="action" id= "action" value="ExportPro" />
  <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
  <thead>
      <tr>
      <td>From Date</td>
      <td>To Date</td>
      <td>Action</td>
      </tr>
  </thead>
  <tr>
    <td><input type="text" name="FrmDate"required class="form-control" autocomplete="off"  id="FrmDate"></td>
    <td><input type="text" name="ToDate"required class="form-control" autocomplete="off"  id="ToDate"></td>
    <td><input type="submit" name="ExportPro" class="btn btn-success" value="Export to CSV"/><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
  </tr>
  </table>
</form>

            <!-- Table Page -->

            </div>
                </div>
                <div class="widget-foot">
                  <!-- Footer goes here -->
                </div>
              </div><!--Widget-->
            </div>
            <!--Bof Export Stock-->
            <div class="col-md-12">

              <div class="widget">
                <div class="widget-head">
                  <div class="pull-left"> Export Stock </div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">

                  <div class="padd">
<p> Select Today's Date to Export Stock </p>
<form action="includes/export.php" method="post" name="ExportStk" enctype="multipart/form-data">
  <input type="hidden" name="action" id= "action" value="ExportStk" />
  <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
<thead>
<tr>
<td>Date</td>
<td>Action</td>
</tr>
</thead>
<tr>
<td><input type="text" name="StockDate"required class="form-control" autocomplete="off"  id="StockDate"></td>
<td><input type="submit" name="ExportStk" class="btn btn-success" value="Export to CSV"/><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
</tr>
</table>
</form>
              </div>
                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div><!--Widget-->
              </div>
            <!--Eof Export Stock-->
            <!--Bof Subject Export-->
            <div class="col-md-12">

              <div class="widget">
                <div class="widget-head">
                  <div class="pull-left"> Export Subject </div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">

                  <div class="padd">
<p> Export Subject </p>
<form action="includes/export.php" method="post" name="ExportSbjt" enctype="multipart/form-data">
  <input type="hidden" name="action" id= "action" value="ExportSbjt" />
  <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
<thead>
<tr>
<td>Action</td>
</tr>
</thead>
<tr>
<td><input type="submit" name="ExportSbjt" class="btn btn-success" value="Export to CSV"/><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
</tr>
</table>
</form>
              </div>
                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div><!--Widget-->
              </div>
            <!--Eof Subject Export-->

            <!--Bof Publisher Export-->
            <div class="col-md-12">

              <div class="widget">
                <div class="widget-head">
                  <div class="pull-left"> Export Publisher </div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">

                  <div class="padd">
<p> Export Publisher </p>
<form action="includes/export.php" method="post" name="ExportPub" enctype="multipart/form-data">
  <input type="hidden" name="action" id= "action" value="ExportPub" />
  <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
<table class="table table-bordered table-striped ">
<thead>
<tr>
<td>Action</td>
</tr>
</thead>
<tr>
<td><input type="submit" name="ExportPub" class="btn btn-success" value="Export to CSV"/><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
</tr>
</table>
</form>
              </div>
                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div><!--Widget-->
              </div>
            <!--Eof Publisher Export-->

            <div class="col-md-12">

              <div class="widget">
                <div class="widget-head">
                  <div class="pull-left"> Import New Products </div>
                  <div class="widget-icons pull-right">
                    <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                    <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                  </div>
                  <div class="clearfix"></div>
                </div>

                <div class="widget-content">

                  <div class="padd">
                    <p> Select CSV File(ExportPro.csv) to Import New Products</p>
          <form action="includes/export.php" method="post" name="Import_CSV" enctype="multipart/form-data">
            <input type="hidden" name="action" id= "action" value="ImportPro" />
            <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
          <table class="table table-bordered table-striped ">
          <thead>
          <tr>
          <td><label class="col-md-4 control-label" for="filebutton">Select File</label></td>
          <td>Action</td>
          </tr>
          </thead>
          <tr>
          <td><input type="file" name="file" id="file" class="input-large" required></td>
          <td><button type="submit" id="submit" name="ImportPro" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
          </tr>
          </table>
          </form>

              </div>
                  </div>
                  <div class="widget-foot">
                    <!-- Footer goes here -->
                  </div>
                </div><!--Widget-->
              </div>
            <!--Eof Import New Products-->
            <!--Bof Import Stock-->
                        <div class="col-md-12">

                          <div class="widget">
                            <div class="widget-head">
                              <div class="pull-left"> Import Stock </div>
                              <div class="widget-icons pull-right">
                                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                              </div>
                              <div class="clearfix"></div>
                            </div>

                            <div class="widget-content">

                              <div class="padd">
            <p> Select File (ExportStk.csv) to Import Stock </p>
            <form action="includes/export.php" method="post" name="ImportStk" enctype="multipart/form-data">
              <input type="hidden" name="action" id= "action" value="ImportStk" />
              <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
            <table class="table table-bordered table-striped ">
            <thead>
            <tr>
            <td><label class="col-md-4 control-label" for="filebutton">Select File</label></td>
            <td>Action</td>
            </tr>
            </thead>
            <tr>
            <td><input type="file" name="fileStk" id="fileStk" class="input-large" required></td>
            <td><button type="submit" id="submit" name="ImportStk" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
            </tr>
            </table>
            </form>
                          </div>
                              </div>
                              <div class="widget-foot">
                                <!-- Footer goes here -->
                              </div>
                            </div><!--Widget-->
                          </div>
                        <!--Eof Import Stock-->
                        <!--Bof Import Subject-->
                        <div class="col-md-12">

                          <div class="widget">
                            <div class="widget-head">
                              <div class="pull-left"> Import Subject </div>
                              <div class="widget-icons pull-right">
                                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                              </div>
                              <div class="clearfix"></div>
                            </div>

                            <div class="widget-content">

                              <div class="padd">
            <p> Select File (ExportSbjt.csv) to Import Subject </p>
            <form action="includes/export.php" method="post" name="ImportSbjt" enctype="multipart/form-data">
              <input type="hidden" name="action" id= "action" value="ImportSbjt" />
              <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
            <table class="table table-bordered table-striped ">
            <thead>
            <tr>
            <td><label class="col-md-4 control-label" for="filebutton">Select File</label></td>
            <td>Action</td>
            </tr>
            </thead>
            <tr>
            <td><input type="file" name="fileSbjt" id="fileSbjt" class="input-large" required></td>
            <td><button type="submit" id="submit" name="ImportSbjt" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
            </tr>
            </table>
            </form>
                          </div>
                              </div>
                              <div class="widget-foot">
                                <!-- Footer goes here -->
                              </div>
                            </div><!--Widget-->
                          </div>
                        <!--Eof Import Subject-->
                        <!--Bof Import Publisher-->
                        <div class="col-md-12">

                          <div class="widget">
                            <div class="widget-head">
                              <div class="pull-left"> Import Publisher </div>
                              <div class="widget-icons pull-right">
                                <a href="#" class="wminimize"><i class="fa fa-chevron-up"></i></a>
                                <a href="#" class="wclose"><i class="fa fa-times"></i></a>
                              </div>
                              <div class="clearfix"></div>
                            </div>

                            <div class="widget-content">

                              <div class="padd">
            <p> Select File (ExportPub.csv) to Import Publisher </p>
            <form action="includes/export.php" method="post" name="ImportPub" enctype="multipart/form-data">
              <input type="hidden" name="action" id= "action" value="ImportPub" />
              <input type="hidden" name="Token" id= "Token" value="<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);?>" />
            <table class="table table-bordered table-striped ">
            <thead>
            <tr>
            <td><label class="col-md-4 control-label" for="filebutton">Select File</label></td>
            <td>Action</td>
            </tr>
            </thead>
            <tr>
            <td><input type="file" name="filePub" id="filePub" class="input-large" required></td>
            <td><button type="submit" id="submit" name="ImportPub" class="btn btn-primary button-loading" data-loading-text="Loading...">Upload</button><input type="button" id="btncancel" value="Clear" title="Clear" class="btn btn-warning" /></td>
            </tr>
            </table>
            </form>
                          </div>
                              </div>
                              <div class="widget-foot">
                                <!-- Footer goes here -->
                              </div>
                            </div><!--Widget-->
                          </div>
                        <!--Eof Import Pub-->

          </div><!--Row-->
        </div>
      </div>
    </div>
    <!-- Matter ends -->
    <div class="clearfix"></div>

    </div>
    <!-- Content ends -->
    <?php
    require_once (__DIR__.'/includes/footer.php');
     ?>
     <script>
     $(document).ready(function () {
     $( "#FrmDate,#StockDate,#ToDate,#SbjtDt" ).datepicker().datepicker("setDate", new Date());
     } );
     $('#FrmDate,#StockDate,#SbjtDt').datepicker({maxDate:0,
     dateFormat: "dd-mm-yy"
   });
   $('#ToDate').datepicker({minDate: 0,
   dateFormat: "dd-mm-yy" });
     </script>
