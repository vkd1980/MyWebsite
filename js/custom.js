	/* JS */

/* Flex image slider */


$('.flex-image').flexslider({
  direction: "vertical",
  controlNav: false,
  directionNav: true,
  pauseOnHover: true,
  slideshowSpeed: 10000      
});


/* Flexslider for product images */


$('.product-image-slider').flexslider({
  direction: "vertical",
  controlNav: false,
  directionNav: true,
  pauseOnHover: true,
  slideshowSpeed: 10000      
});
/**Ajax Loader*/
$body = $("body");

$(document).on({
   	 ajaxStart: function() { $body.addClass("loading");    },
     ajaxStop: function() { $body.removeClass("loading"); }    
});


/* Carousel */

$(document).ready(function() {
			
	 var recent = $("#owl-recent");
	 
	recent.owlCarousel({
		autoPlay: 3000, //Set AutoPlay to 3 seconds
		items : 4,
		mouseDrag : false,
		pagination : false
	});
	
	$(".next").click(function(){
			recent.trigger('owl.next');
	  })
	  
	  $(".prev").click(function(){
			recent.trigger('owl.prev');
	  })
});


/* Support */

$("#slist a").click(function(e){
   e.preventDefault();
   $(this).next('p').toggle(200);
});



/* Scroll to Top */

$(document).ready(function(){
						   
$('.cartclose').click(function(){
		$('#cartModal').modal('toggle');			  
	});
  $(".totop").hide();
	//$(".loader").hide();
  $(function(){
    $(window).scroll(function(){
      if ($(this).scrollTop()>600)
      {
        $('.totop').fadeIn(2000);
      } 
      else
      {
        $('.totop').fadeOut(2000);
      }
    });

    $('.totop a').click(function (e) {
      e.preventDefault();
      $('body,html').animate({scrollTop: 0}, 2000);
    });

  });
  /// BOF Image Popup
  $(document).on('click', '.item-image , .test', function(){
   $('.imagepreview').attr('src', $(this).find('img').attr('src'));
			$('#imagemodal').modal('show'); 
});
  /// EOF Image PopUp
  
 });

// Menu caret
 $(function(){
    $(".dropdown").hover(            
            function() {
			 	$(this).toggleClass('open');
				$('b', this).toggleClass('caret fa fa-caret-up');                       
            });
    });

