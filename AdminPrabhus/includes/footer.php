<?php ?>
<!-- Footer starts -->
<footer>
  <div class="container">
    <div class="row">
      <div class="col-md-12">
            <!-- Copyright info -->
            <p class="copy">Copyright &copy; 2012 | <a href="#">Your Site</a> </p>
      </div>
    </div>
  </div>
</footer>

<!-- Footer ends -->

<!-- Scroll to top -->
<span class="totop"><a href="#"><i class="fa fa-chevron-up"></i></a></span>

<!-- JS -->
<script src="//cdn.ckeditor.com/4.8.0/standard/ckeditor.js"></script>
<script src="js/jquery.js"></script> <!-- jQuery -->
<!--<script src="js/bootstrap.min.js"></script> <!-- Bootstrap -->
<script src="http://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/2.3.0/js/bootstrap.min.js"></script>
<script src="js/jquery-ui.min.js"></script> <!-- jQuery UI -->
<script src="js/moment.min.js"></script> <!-- Moment js for full calendar -->
<script src="js/fullcalendar.min.js"></script> <!-- Full Google Calendar - Calendar -->
<script src="js/jquery.rateit.min.js"></script> <!-- RateIt - Star rating -->
<script src="js/jquery.prettyPhoto.js"></script> <!-- prettyPhoto -->
<script src="js/jquery.slimscroll.min.js"></script> <!-- jQuery Slim Scroll -->
<!-- <script src="js/jquery.dataTables.min.js"></script> <!-- Data tables -->
<script src="https://cdn.datatables.net/1.10.16/js/jquery.dataTables.min.js"></script> <!-- Data tables -->
<script src="https://cdn.datatables.net/buttons/1.5.0/js/dataTables.buttons.min.js"></script> <!-- Data tables buttons -->
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.html5.min.js"></script><!-- Data tables buttons -->
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.print.min.js"></script><!-- Data tables buttons -->
<script src="//cdn.datatables.net/buttons/1.5.0/js/buttons.flash.min.js"></script><!-- Data tables buttons -->
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script><!-- Data tables buttons -->
<!--<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/pdfmake.min.js"></script><!-- Data tables buttons -->
<script src="//cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.32/vfs_fonts.js"></script><!-- Data tables buttons -->
<script src="js/Numeral.js"></script> <!-- Numeral  -->
<!-- jQuery Flot -->
<script src="js/excanvas.min.js"></script>
<script src="js/jquery.flot.js"></script>
<script src="js/jquery.flot.resize.js"></script>
<script src="js/jquery.flot.pie.js"></script>
<script src="js/jquery.flot.stack.js"></script>

<!-- jQuery Notification - Noty -->
<script src="js/jquery.noty.js"></script> <!-- jQuery Notify -->
<script src="js/themes/default.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/bottom.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/topRight.js"></script> <!-- jQuery Notify -->
<script src="js/layouts/top.js"></script> <!-- jQuery Notify -->
<!-- jQuery Notification ends -->

<script src="js/sparklines.js"></script> <!-- Sparklines -->
<script src="js/jquery.cleditor.min.js"></script> <!-- CLEditor -->
<script src="js/bootstrap-datetimepicker.min.js"></script> <!-- Date picker -->
<script src="js/jquery.onoff.min.js"></script> <!-- Bootstrap Toggle -->
<script src="js/filter.js"></script> <!-- Filter for support page -->
<script src="js/custom.js"></script> <!-- Custom codes -->
<script src="js/charts.js"></script> <!-- Charts & Graphs -->
<script src="js/jquery.validate.js"></script> <!-- Validator -->
<!-- Script for this page -->
<script type="text/javascript">
/**********************/
var oldExportAction = function (self, e, dt, button, config) {
  if (button[0].className.indexOf('buttons-excel') >= 0) {
      if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
          $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
      }
      else {
          $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
      }
  }
  else if (button[0].className.indexOf('buttons-csv') >= 0) {
      if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
          $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
      }
      else {
          $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
      }
  }
  else if (button[0].className.indexOf('buttons-print') >= 0) {
      $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
  }
};

var newExportAction = function (e, dt, button, config) {
  var self = this;
  var oldStart = dt.settings()[0]._iDisplayStart;

  dt.one('preXhr', function (e, s, data) {
      // Just this once, load all data from the server...
      data.start = 0;
      data.length = 2147483647;

      dt.one('preDraw', function (e, settings) {
          // Call the original action function
          oldExportAction(self, e, dt, button, config);

          dt.one('preXhr', function (e, s, data) {
              // DataTables thinks the first item displayed is index 0, but we're not drawing that.
              // Set the property to what it was before exporting.
              settings._iDisplayStart = oldStart;
              data.start = oldStart;
          });

          // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
          setTimeout(dt.ajax.reload, 0);

          // Prevent rendering of the full data to the DOM
          return false;
      });
  });

  // Requery the server with the new one-time export settings
  dt.ajax.reload();
};
/**********************/
</script>

</body>
</html>
