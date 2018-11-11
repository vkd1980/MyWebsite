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
    /*Scrolling text*/
    $.fn.typer = function(text, options){
        options = $.extend({}, {
            char: ' ',
            delay: 1000,
            duration: 600,
            endless: true
        }, options || text);

        text = $.isPlainObject(text) ? options.text : text;

        var elem = $(this),
            isTag = false,
            c = 0;

        (function typetext(i) {
            var e = ({string:1, number:1}[typeof text] ? text : text[i]) + options.char,
                char = e.substr(c++, 1);

            if( char === '<' ){ isTag = true; }
            if( char === '>' ){ isTag = false; }
            elem.html(e.substr(0, c));
            if(c <= e.length){
                if( isTag ){
                    typetext(i);
                } else {
                    setTimeout(typetext, options.duration/10, i);
                }
            } else {
                c = 0;
                i++;

                if (i === text.length && !options.endless) {
                    return;
                } else if (i === text.length) {
                    i = 0;
                }
                setTimeout(typetext, options.delay, i);
            }
        })(0);
    };

                $('#MsgScroll').typer(['<b>We are back Online You can Place Orders</b> ']);
