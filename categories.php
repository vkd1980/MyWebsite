<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//© I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
$Ptoken= hash_hmac('sha256', $_SERVER['SERVER_NAME'].$_SERVER['PHP_SELF'], $_SESSION['csrf_token']);
if(isset($_GET["categories_id"]) and (!empty($_GET["categories_id"])))
{
$catID=filter_var($_REQUEST["categories_id"], FILTER_SANITIZE_NUMBER_INT, FILTER_FLAG_STRIP_HIGH);
$PgHeading= $category-> getcatnamebyid($_REQUEST["categories_id"]);
}
else
{
$catID='all';
$PgHeading= 'All Subjects';
}?>

<script>
var ajax_arry=[];
 var ajax_index =0;
 var sctp = 10;
 $(function(){
 $('.loading-info').show()
 $('#nomore').hide();//hide no more
 $.ajax({
 url:'./includes/categories_loader.php',
 type:"POST",
 data:{
 'page': '1',
 'Token':'<?php echo $Ptoken;?>',
 'categories_id':'<?php echo $catID;?>',
 'sortt':'all'
 },
 cache: false,
 success: function(response){
 $('.loading-info').hide();
 $('#results').html(response);
 }
 });
 $('#ddlViewBy').change(function () {

   $('#results').html('');
   $('.loading-info').show(); //show loading animation
  $.ajax({
 url:'./includes/categories_loader.php',
 type:"POST",
 data:{
 'page': '1',
 'Token':'<?php echo $Ptoken;?>',
 'categories_id':'<?php echo $catID;?>',
 'sortt':$('#ddlViewBy').find(":selected").attr("id")
 },
 cache: false,
 success: function(response){
 $('.loading-info').hide();
 $('#results').html(response);
 }
 });
    });
 $(window).scroll(function(){

 var height = $('#results').height();
 var scroll_top = $(this).scrollTop();
 if(ajax_arry.length>0){
 $('.loading-info').hide();
 for(var i=0;i<ajax_arry.length;i++){
 ajax_arry[i].abort();
 }
}
 var page = $('#results').find('.nextpage').val();
 var isload = $('#results').find('.isload').val();
var sortt=$('#ddlViewBy').find(":selected").attr("id");
 //if ((($(window).scrollTop()+document.body.clientHeight)==$(window).height()) && isload=='true'){
 if (($(window).scrollTop() >= ($(document).height() - $(window).height())*0.6)&& isload=='true'){
 $('.loading-info').show()
 var ajaxreq = $.ajax({
 url:'./includes/categories_loader.php',
 type:"POST",
 data:{
 'page': page,
 'Token':'<?php echo $Ptoken;?>',
 'categories_id':'<?php echo $catID;?>',
 'sortt':sortt
 },
 cache: false,
 success: function(response){
      if(response.trim().length == 0){
		   //notify user if nothing to load
		  $('#nomore').show();
        $('.loading-info').hide(); //show loading animation
        $('#results').find('.isload').val('false');
        return;
        }

 $('#results').find('.nextpage').remove();
 $('#results').find('.isload').remove();
 //$('#results').hide();
 $('#results').append(response);
 }
 });
 ajax_arry[ajax_index++]= ajaxreq;
 }
 return false;
 if($(window).scrollTop() == $(window).height()) {
 alert("bottom!");
 }
 });
});
 </script>
<!-- Items -->

<div class="items">
  <div class="container">
    <div class="row"> <span class=""></span>
      <!-- Sidebar -->
      <div class="col-md-3 col-sm-3 hidden-xs">
        <?php
				//require_once(__DIR__.'/includes/Sidebar/sidebar_menu.php');
				require_once(__DIR__.'/includes/Sidebar/sidebar_featured.php');
				 			?>
        <br />
      </div>
      <!-- Main content -->
      <div class="col-md-9 col-sm-9">
        <!-- Breadcrumb -->
        <!--<ul class="breadcrumb">
          <li><a href="index.php">Home</a></li>
          <li><a href="items.php">Smartphone</a></li>
          <li class="active">Apple</li>
        </ul>
        <!-- Title -->
        <h4 class="pull-left">Subject >>> <?php echo $PgHeading ;?></h4>
        <!-- Sorting -->
        <div class="form-group pull-right">
          <select class="form-control" id="ddlViewBy">
            <option  selected="selected" id="all">Sort By</option>
            <option id="a2z">Name (A-Z)</option>
            <option id="z2a">Name (Z-A)</option>
            <option id="l2h">Price (Low-High)</option>
            <option id="h2l">Price (High-Low)</option>
            <option id="rts">Ratings</option>
          </select>
        </div>
        <div class="clearfix"></div>
        <div class="row" id="results">
          <!--append results-->
        </div>
        <div class="btn-info" id="nomore">
          <h3 style="color:#FFFFFF" align="center"><span class="fa fa-ban"></span> No more records!</h3>
        </div>
        <div class="loading-info" align="center"><img src="/img/loader.gif" /></div>
      </div>
    </div>
  </div>
</div>
<?php
include(__DIR__.'/includes/recent.php');
include(__DIR__.'/includes/footer.php');
?>
<script type="text/javascript">
$(document).on({
   	 ajaxStart: function() { $body.removeClass("loading");    },
});
</script>
