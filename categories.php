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
$(document).ready(function () {
var track_page = 1; //track user scroll as page number, right now page number is 1
var loading  = false; //prevents multiple loads
var flag = true;//stop checking

   $('#ddlViewBy').change(function () {
   flag = true;
   track_page=1;
   $('#results').html('');
   $('.loading-info').show(); //show loading animation
   load_contents(track_page,$('#ddlViewBy').find(":selected").attr("id"));

    });
 //alert(srt);
load_contents(track_page,$('#ddlViewBy').find(":selected").attr("id")); //initial content load
$(window).scroll(function() { //detect page scroll
  if (flag==true){
   if($(window).scrollTop() >550) {
      track_page++; //page number increment
      load_contents(track_page,$('#ddlViewBy').find(":selected").attr("id")); //load content
    }
	}
});
//Ajax load function
function load_contents(track_page,sor){
    if(loading == false){
        loading = true;  //set loading flag on
		 $('#nomore').hide();//hide no more
        $('.loading-info').show(); //show loading animation
		$.post( './includes/categories_loader.php', {
		'page': track_page,
		'Token':'<?php echo $Ptoken;?>',
		'categories_id':'<?php echo $catID;?>',
		'sortt':sor
		},

	function(data){
        loading = false; //set loading flag off once the content is loaded
		if(data.trim().length == 0){
		//notify user if nothing to load
		$('#nomore').show();
        $('.loading-info').hide(); //show loading animation
        flag=false;
        return;
        }
        $('.loading-info').hide(); //hide loading animation once data is received

        $("#results").append(data); //append data into #results element

        }).fail(function(xhr, ajaxOptions, thrownError) { //any errors?
            alert(thrownError); //alert with HTTP error
        })
    }
}
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
