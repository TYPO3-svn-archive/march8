jQuery(document).ready(function(){
	jQuery('.moduleGroup').each(function(){
		resizeModuleGroup(this);
	});
	$('.slider').bxSlider({
			mode: 'horizontal',									// 'horizontal', 'vertical', 'fade'
			infiniteLoop: true,									// true, false - display first slide after last
			hideControlOnEnd: false,						// true, false - if true, will hide 'next' control on last slide and 'prev' control on first
			controls: true,											// true, false - previous and next controls
			speed: 500,													// integer - in ms, duration of time slide transitions will occupy
			easing: 'swing',                    // used with jquery.easing.1.3.js - see http://gsgd.co.uk/sandbox/jquery/easing/ for available options
			pager: false,												// true / false - display a pager
			pagerSelector: null,								// jQuery selector - element to contain the pager. ex: '#pager'
			pagerType: 'full',									// 'full', 'short' - if 'full' pager displays 1,2,3... if 'short' pager displays 1 / 4
			pagerLocation: 'top',						// 'bottom', 'top' - location of pager
			pagerShortSeparator: '/',						// string - ex: 'of' pager would display 1 of 4
			pagerActiveClass: 'pager-active',		// string - classname attached to the active pager link
			nextText: 'Siguiente',										// string - text displayed for 'next' control
			nextImage: '',											// string - filepath of image used for 'next' control. ex: 'images/next.jpg'
			nextSelector: null,									// jQuery selector - element to contain the next control. ex: '#next'
			prevText: 'Anterior',										// string - text displayed for 'previous' control
			prevImage: '',											// string - filepath of image used for 'previous' control. ex: 'images/prev.jpg'
			prevSelector: null,									// jQuery selector - element to contain the previous control. ex: '#next'
			captions: false,										// true, false - display image captions (reads the image 'title' tag)
			captionsSelector: null,							// jQuery selector - element to contain the captions. ex: '#captions'
			auto: true,												// true, false - make slideshow change automatically
			autoDirection: 'next',							// 'next', 'prev' - direction in which auto show will traverse
			autoControls: false,								// true, false - show 'start' and 'stop' controls for auto show
			autoControlsSelector: null,					// jQuery selector - element to contain the auto controls. ex: '#auto-controls'
			autoStart: true,										// true, false - if false show will wait for 'start' control to activate
			autoHover: false,										// true, false - if true show will pause on mouseover
			autoDelay: 0,                       // integer - in ms, the amount of time before starting the auto show
			pause: 5000,												// integer - in ms, the duration between each slide transition
			startText: 'start',									// string - text displayed for 'start' control
			startImage: '',											// string - filepath of image used for 'start' control. ex: 'images/start.jpg'
			stopText: 'stop',										// string - text displayed for 'stop' control
			stopImage: '',											// string - filepath of image used for 'stop' control. ex: 'images/stop.jpg'
			ticker: false,											// true, false - continuous motion ticker mode (think news ticker)
																					// note: autoControls, autoControlsSelector, and autoHover apply to ticker!
			tickerSpeed: 5000,								  // float - use value between 1 and 5000 to determine ticker speed - the smaller the value the faster the ticker speed
			tickerDirection: 'next',						// 'next', 'prev' - direction in which ticker show will traverse
			tickerHover: false,                 // true, false - if true ticker will pause on mouseover
			wrapperClass: 'bx-wrapper',					// string - classname attached to the slider wraper
			startingSlide: 0, 									// integer - show will start on specified slide. note: slides are zero based!
			displaySlideQty: 1,									// integer - number of slides to display at once
			moveSlideQty: 1,										// integer - number of slides to move at once
			randomStart: false,									// true, false - if true show will start on a random slide
			onBeforeSlide:function(){},				// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			onAfterSlide: function(){},					// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			onLastSlide: function(){},					// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			onFirstSlide: function(){},					// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			onNextSlide: function(){},					// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			onPrevSlide: function(){},					// function(currentSlideNumber, totalSlideQty, currentSlideHtmlObject) - advanced use only! see the tutorial here: http://bxslider.com/custom-pager
			buildPager: null				
	});
	var anchoTotal=$('.kwicks').parent().width();
	var cuantos=$('.kwicks li').length;
	$('.kwicks .especial').each(function(i,e){
		$(e).css('width',anchoTotal)
	})	
	$('.kwicks li').each(function(i,e){
		$(e).css('width',anchoTotal/cuantos)
	})
	 $('.kwicks').kwicks({  
	        min: 0,  
	        duration: 1000,  
	        easing: 'easeOutQuint' ,
	        sticky: false  
	    });  
	
});


function resizeModuleGroup(moduleGroupElement) {
	var groupHeight = jQuery(moduleGroupElement).height();
	if (jQuery(moduleGroupElement).children('.module').size() > 1) {
		jQuery(moduleGroupElement).children('.module').each(function(){
			var moduleHeaderHeight = jQuery(this).children('.moduleHeader').outerHeight(false);
			var moduleFooterHeight = jQuery(this).children('.moduleFooter').outerHeight(false);
			var moduleBodyWrap = jQuery(this).find('.moduleBody',0).outerHeight(false);
			var moduleHeight = jQuery(this).find('.moduleBody',0).height();
			var moduleBodyWrapHeight = groupHeight - moduleHeaderHeight - moduleFooterHeight - (moduleBodyWrap-moduleHeight);
			jQuery(this).find('.moduleBody',0).height(moduleBodyWrapHeight + 'px');
		});
	}
}