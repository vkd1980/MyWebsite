<script>
(function(a){
    a.fn.codexworld_rating_widget = function(p){
        var p = p||{};
        var b = p&&p.starLength?p.starLength:"5";
        var c = p&&p.callbackFunctionName?p.callbackFunctionName:"";
        var e = p&&p.initialValue?p.initialValue:"0";
        var d = p&&p.imageDirectory?p.imageDirectory:"img";
        var r = p&&p.inputAttr?p.inputAttr:"";
        var f = e;
        var g = a(this);
        b = parseInt(b);
        init();
        g.next("ul").children("li").hover(function(){
            $(this).parent().children("li").css('background-position','0px 0px');
            var a = $(this).parent().children("li").index($(this));
            $(this).parent().children("li").slice(0,a+1).css('background-position','0px -28px')
			/////////////////
			var a = $(this).parent().children("li").index($(this));
            var attrVal = (r != '')?g.attr(r):'';
            f = a+1;
            g.val(f);
            if(c != ""){
                eval(c+"("+g.val()+", "+attrVal+")")
            }
			////////////////
        },function(){});
        g.next("ul").children("li").click(function(){
            var a = $(this).parent().children("li").index($(this));
            var attrVal = (r != '')?g.attr(r):'';
            f = a+1;
            g.val(f);
            if(c != ""){
                eval(c+"("+g.val()+", "+attrVal+")")
            }
        });
        g.next("ul").hover(function(){},function(){
            if(f == ""){
                $(this).children("li").slice(0,f).css('background-position','0px 0px')
            }else{
                $(this).children("li").css('background-position','0px 0px');
                $(this).children("li").slice(0,f).css('background-position','0px -28px')
            }
        });
        function init(){
            $('<div style="clear:both;"></div>').insertAfter(g);
            g.css("float","left");
            var a = $("<ul>");
            a.addClass("codexworld_rating_widget");
            for(var i=1;i<=b;i++){
                a.append('<li style="background-image:url('+d+'/widget_star.gif)"><span>'+i+'</span></li>')
            }
            a.insertAfter(g);
            if(e != ""){
                f = e;
                g.val(e);
                g.next("ul").children("li").slice(0,f).css('background-position','0px -28px')
            }
        }
    }
})(jQuery);
</script>
<style>
.codexworld_rating_widget{
    padding: 0px;
    margin: 0px;
    float: left;
}
.codexworld_rating_widget li{
    line-height: 0px;
    width: 28px;
    height: 28px;
    padding: 0px;
    margin: 0px;
    margin-left: 2px;
    list-style: none;
    float: left;
    cursor: pointer;
}
.codexworld_rating_widget li span{
    display: none;
}
span.stars, span.stars span {
    display: block;
	background: url(../img/stars.png) 0 -16px repeat-x;
    width: 80px;
    height: 16px;
}

span.stars span {
    background-position: 0 0;
}
</style>

<script>
$(function() {
    $("#rating_star").codexworld_rating_widget({
        starLength: '5',
        initialValue: '',
        //callbackFunctionName: 'processRating',
        imageDirectory: '../img/',
        //inputAttr: 'postID'
    });
});
$.fn.stars = function() {
    return $(this).each(function() {
        // Get the value
        var val = parseFloat($(this).html());
        // Make sure that the value is in 0 - 5 range, multiply to get width
        var size = Math.max(0, (Math.min(5, val))) * 16;
        // Create stars holder
        var $span = $('<span />').width(size);
        // Replace the numerical value with stars
        $(this).html($span);
    });
}
$(function() {
    $('span.stars').stars();
});
</script>
<script>
	
$( function() {
    $( "#accordion" ).accordion({
	  animate: 1200,
	  heightStyle: "content"
    });
		
  } );
  
			  </script>
			  
			<div class="tab-pane" id="tab3">
           <h5>Product Reviews</h5>			
            <hr />
			<?php echo hash_hmac('sha256', $_SERVER['SERVER_NAME'].'/includes/'.basename(__FILE__, '.php').'.php', $_SESSION['csrf_token']);
			?>
			
			<div id="accordion">
 <h3>Ravi Kumar - <span class="color">4/5</span><span class="stars">5</span></h3>
 <div>
              
              <p class="rmeta">27/1/2012</p>
              <p id="para" >Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.Suspendisse potenti. Morbi ac felis nec mauris imperdiet fermentum. Aenean sodales augue ac lacus hendrerit sed rhoncus erat hendrerit. Vivamus vel ultricies elit. Curabitur lacinia nulla vel tellus elementum non mollis justo aliquam.</p>
		 </div>	
		 
  <h3>Section 2</h3>
  <div>
    <p>Sed non urna. Donec et ante. Phasellus eu ligula. Vestibulum sit amet purus. Vivamus hendrerit, dolor at aliquet laoreet, mauris turpis porttitor velit, faucibus interdum tellus libero ac justo. Vivamus non quam. In suscipit faucibus urna. </p>
  </div>
  <h3>Section 3</h3>
  <div>
    <p>Nam enim risus, molestie et, porta ac, aliquam ac, risus. Quisque lobortis. Phasellus pellentesque purus in massa. Aenean in pede. Phasellus ac libero ac tellus pellentesque semper. Sed ac felis. Sed commodo, magna quis lacinia ornare, quam ante aliquam nisi, eu iaculis leo purus venenatis dui. </p>
    <ul>
      <li>List item one</li>
      <li>List item two</li>
      <li>List item three</li>
    </ul>
  </div>
  <h3>Section 4</h3>
  <div>
    <p>Cras dictum. Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum ante ipsum primis in faucibus orci luctus et ultrices posuere cubilia Curae; Aenean lacinia mauris vel est. </p><p>Suspendisse eu nisl. Nullam ut libero. Integer dignissim consequat lectus. Class aptent taciti sociosqu ad litora torquent per conubia nostra, per inceptos himenaeos. </p>
  </div>
</div>
 
            <?php
			 if(isset($_SESSION['logged_in'])){
 echo '<hr />
            <h5 class="title">Write a Review</h5>
            <div class="form form-small">
			
              <!-- Review form (not working)-->
              <form class="form-horizontal" name="frmreview">
                <!-- Name -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name2" >Your Name</label>
                  <div class="col-md-6">
				  <input type="hidden" id="custid" name="custid" value="'.$_SESSION['UserData'][0].'" />
                    <input type="text" class="form-control" id="name2" value="'.$_SESSION['UserData'][2].'"disabled="disabled">
                  </div>
                </div>
                <!-- Select box -->
                <div class="form-group">
                  <label class="control-label col-md-3">Rating</label>
                  <div class="col-md-6">
                   <input name="rating" value="0" id="rating_star" type="hidden" postID="1" />
                  </div>
                </div>
                <!-- Review -->
                <div class="form-group">
                  <label class="control-label col-md-3" for="name">Your Review</label>
                  <div class="col-md-6">
                    <textarea class="form-control"></textarea>
                  </div>
                </div>
                <!-- Buttons -->
                <div class="form-group">
                  <!-- Buttons -->
                  <div class="col-md-6 col-md-offset-3">
                    <button type="submit" class="btn btn-default">Post</button>
                    <button type="reset" class="btn btn-default">Reset</button>
                  </div>
                </div>
              </form>
            </div>';
  }
  else
  {
  echo'<div class="form-group">
       <div class="col-md-6">
	   <h5>Please <a href="../login.html">Login</a> to Write Review</h5>
        </div>
        </div>';
  }
			?>
          </div>
		  
       