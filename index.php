<?php
//Maha ganapathaye Namah!
//Bookstore FrontEnd V 1.0
//� I biz Info Solutions
require_once (__DIR__.'/includes/classes/global.inc.php');

require_once (__DIR__.'/includes/header.php');

?>
<script>

			// Revolution Slider
			var revapi;
			jQuery(document).ready(function() {
				   revapi = jQuery('.tp-banner').revolution(
					{
						delay: 9000,
						startwidth: 1170,
						startheight: 250,
						hideThumbs: 200,
						shadow: 0,
						navigationType: "none",
						hideThumbsOnMobile: "on",
						hideArrowsOnMobile: "on",
						hideThumbsUnderResoluition: 0,
						touchenabled: "on",
						fullWidth: "off"
					});
			});
		</script>
		<div class="tp-banner-container">
			<div class="tp-banner">
				<ul>	<!-- SLIDE  -->
					<li data-transition="slotfade-vertical" data-slotamount="7" data-masterspeed="1500">
						<!-- MAIN IMAGE -->
						<img src="img/slider/slide-back.jpg"  alt="" data-duration="2000" />
						<!-- LAYER NR. 4 -->
						<div class="tp-caption skewfromright customout"
							data-x="centre"
							data-y="0"
							data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
							data-speed="600"
							data-start="1000"
							data-easing="Power4.easeOut"
							data-endspeed="300"
							data-endeasing="Power1.easeIn"
							data-captionhidden="on"
							style="z-index: 4"><img class="img-responsive" src="img/slider/carslide3.jpg" alt="" />
						</div>

					</li>
					<li data-transition="slotfade-vertical" data-slotamount="7" data-masterspeed="1500">
						<!-- MAIN IMAGE -->
						<img src="img/slider/slide-back.jpg"  alt="" data-duration="2000" />
						<!-- LAYER NR. 4 -->
						<div class="tp-caption skewfromright customout"
							data-x="centre"
							data-y="0"
							data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
							data-speed="600"
							data-start="1000"
							data-easing="Back.easeInOut"
							data-endspeed="300"
							data-endeasing="Power1.easeIn"
							data-captionhidden="on"
							style="z-index: 4"><img class="img-responsive" src="img/slider/carslide4.jpg" alt="" />
						</div>

					</li>
					<li data-transition="slotfade-vertical" data-slotamount="7" data-masterspeed="1500">
						<!-- MAIN IMAGE -->
						<img src="img/slider/slide-back.jpg"  alt="" data-duration="2000" />
						<!-- LAYER NR. 4 -->
						<div class="tp-caption skewfromright customout"
							data-x="centre"
							data-y="0"
							data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
							data-speed="600"
							data-start="1000"
							data-easing="Power4.easeOut"
							data-endspeed="300"
							data-endeasing="Power1.easeIn"
							data-captionhidden="on"
							style="z-index: 4"><img class="img-responsive" src="img/slider/carslide5.jpg" alt="" />
						</div>

					</li>
					<li data-transition="slotfade-vertical" data-slotamount="7" data-masterspeed="1500">
						<!-- MAIN IMAGE -->
						<img src="img/slider/slide-back.jpg"  alt="" data-duration="2000" />
						<!-- LAYER NR. 4 -->
						<div class="tp-caption skewfromright customout"
							data-x="centre"
							data-y="0"
							data-customout="x:0;y:0;z:0;rotationX:0;rotationY:0;rotationZ:0;scaleX:0.75;scaleY:0.75;skewX:0;skewY:0;opacity:0;transformPerspective:600;transformOrigin:50% 50%;"
							data-speed="600"
							data-start="1000"
							data-easing="Back.easeInOut"
							data-endspeed="300"
							data-endeasing="Power1.easeIn"
							data-captionhidden="on"
							style="z-index: 4"><img class="img-responsive" src="img/slider/carslide2.jpg" alt="" />
						</div>

					</li>
					</ul>
		</div>
		<div class="col-xs-12 col-md-12 well well-sm" id="type">

		</div>
	</div>
	<!--/ Slider ends -->


<?php
require_once(__DIR__.'/includes/specials.php');
require_once(__DIR__.'/includes/popular_deals.php');
require_once(__DIR__.'/includes/New_arrival.php');
require_once (__DIR__.'/includes/recent.php');

require_once (__DIR__.'/includes/footer.php');
?>
