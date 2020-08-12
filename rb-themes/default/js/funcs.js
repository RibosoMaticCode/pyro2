$(document).ready(function() {
	// Load fancybox, modal and image viewer
	$(".fancy").fancybox();
	
	// Slide main
	if ($('.slide').length>0) {
		$('.slide').camera({
			height: 'auto',
			pagination: true,
			thumbnails: false,
			opacityOnGrid: false,
			time:4500,
			fx:  'scrollRight',
			loader: 'bar',
			imagePath: 'img/',
			navigationHover: false,
			mobileNavHover: false,
			playPause: false
		});
	}
	
	// Scroll with effect - Set 'a' tag with class 'scrollLink'
	$( "a.scrollLink" ).click(function( event ) {
		event.preventDefault();
		$("html, body").animate({ scrollTop: $($(this).attr("href")).offset().top }, 500);
	});
	
	// Animateblock - usar en bloques clases: "animateblock top"
	var $elems = $('.animateblock');
	var winheight = $(window).height();
	var fullheight = $(document).height();

	$(window).scroll(function(){
		animate_elems();
	});
	
	function animate_elems() {
	   	wintop = $(window).scrollTop(); // calculate distance from top of window
	  	// loop through each item to check when it animates
	   	$elems.each(function(){
	     	$elm = $(this);
	      	
	      	if($elm.hasClass('animated')) { return true; } // if already animated skip to the next item
	      	
	      	topcoords = $elm.offset().top; // element's distance from top of page in pixels
	      	
	      	if(wintop > (topcoords - (winheight*.75))) {
	       		// animate when top of the window is 3/4 above the element
	     		$elm.addClass('animated');
	   		}
	   	});
	}
});