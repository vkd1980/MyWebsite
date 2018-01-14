<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');
include(__DIR__.'/includes/header.php');
?>
<style>
#searchid{
	width:500px;
	border-radius: 4px;
    border: 1px solid #f3f3f3;
    box-shadow: inset 0px 0px 1px #5eb2d9;
    -webkit-transition: box-shadow 1s ease;
    -moz-transition: box-shadow 1s ease;
    -o-transition: box-shadow 1s ease;
    transition: box-shadow 1s ease;
    transition: all 1s ease-in-out;
	padding:10px;
	font-size:14px;
	}

	#searchresult
	{
		position:absolute;
		width:500px;
		padding:10px;
		display:none;
		margin-top:-1px;
		border-top:0px;
		overflow:hidden;
		border:1px #CCC solid;
		background-color: white;
	}
	.show
	{
	min-height:80px;
    max-height: 100px;
    max-width: 500px;
    margin: 10px auto;
    padding: 10px 10px;
    border-radius: 4px;
    border: 1px solid #f3f3f3;
    box-shadow: inset 0px 0px 1px #5eb2d9;
    -webkit-transition: box-shadow 1s ease;
    -moz-transition: box-shadow 1s ease;
    -o-transition: box-shadow 1s ease;
    transition: box-shadow 1s ease;
    transition: all 1s ease-in-out;
	}
	.show img{
	width:50px;
	height:80px;
	float:left;
	margin-right:6px;
	margin-top: -9px;
	}
	.show p{
	text-overflow: ellipsis;
	}
	.show:hover
	{
		background:#f5f5f5;
		color:#5eb2d9;
		cursor:pointer;
	}
</style>
<script type="text/javascript">
$(function(){
$(".search").keyup(function()
{
var searchid = $(this).val();
var dataString = 'search='+ searchid;
if(searchid!='')
{
    $.ajax({
    type: "POST",
    url: "../includes/search_process.php",
    data: dataString,
    cache: false,
    success: function(html)
    {
			//console.log(html);
    $("#searchresult").html(html).show();
    }
    });
}
else
{
$("#searchresult").hide();
}
});

$('#searchid').click(function(){
   /*$("#result").fadeout();*/
});

$('#searchid' )
  .focusout(function() {
  /*$("#searchresult").hide();*/
  $("#searchid").val('');
});
});
</script>
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
        <div class="container">
          <input type="text" class="search" id="searchid" placeholder="Keywords of Book Name, Author, Category, Publisher" />
          <div id="searchresult" ></div>
        </div>
      </div>
    </div>
  </div>
</div>
<?php

 include(__DIR__.'/includes/footer.php');
?>
<script type="text/javascript">
$(document).on({
   	 ajaxStart: function() { $body.removeClass("loading");    },
});
</script>
