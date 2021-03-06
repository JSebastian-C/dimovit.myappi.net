(function($) {
	"use strict";

setTimeout(function() {
	jQuery('#pageloader').fadeOut();
}, 30000);
jQuery(document).ready(function(e) {
	//search toggle focus
	jQuery('.search-toggle').on('click', function(e) {
		jQuery('body').toggleClass('enable-search');
		return false;
	});

	//carousel
	jQuery(".init-carousel").each(function(){
		var carousel_id = jQuery(this).attr('id');
		var auto_play = jQuery(this).data('autoplay');
		var items = jQuery(this).data('items');
		var navigation = jQuery(this).data('navigation');
		if(jQuery(this).hasClass('single-carousel')){ //single style
			jQuery(this).owlCarousel({
				singleItem:true,
				autoHeight: true,
				autoPlay: auto_play,
				addClassActive : true,
				stopOnHover: true,
				slideSpeed : 600,
				navigation: navigation?true:false,
				navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			});
		}else{
			jQuery(this).owlCarousel({
				autoPlay: auto_play,
				items: items?items:4,
				itemsDesktop: items?false:4,
				itemsDesktopSmall: items?(items>3?3:false):3,
				singleItem: items==1?true:false,
				slideSpeed: 500,
				addClassActive : true,
				navigation: navigation?true:false,
				navigationText:["<i class='fa fa-angle-left'></i>","<i class='fa fa-angle-right'></i>"],
			});
		}
	});
	//post slider
	jQuery('.post-slider-prev').on('click',function(e) {
		var owl = jQuery(this).closest('.post-slider-carousel').data('owlCarousel');
		owl.prev();
		return false;
    });
	jQuery('.post-slider-next').on('click',function(e) {
		var owl = jQuery(this).closest('.post-slider-carousel').data('owlCarousel');
		owl.next();
		return false;
    });
	
	//grid turn to carousel
	if(jQuery(window).width()<977){
		jQuery(".grid-listing").owlCarousel({ addClassActive : true });
	}
	
	//Countdown
	jQuery('[data-countdown]').each(function() {
		var $this = jQuery(this), finalDate = jQuery(this).data('countdown');
		var day_label = $this.data('daylabel');
		var hour_label = $this.data('hourlabel');
		var minute_label = $this.data('minutelabel');
		var second_label = $this.data('secondlabel');
		var show_second = $this.data('showsecond');
		$this.countdown(finalDate, {elapse: true})
		  .on('update.countdown', function(event) {
			if (event.elapsed) { // Either true or false
			  $this.html(event.strftime(''
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%D</span><span class="countdown-label main-color-1">'+day_label+'</span></span>'
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%H</span><span class="countdown-label main-color-1">'+hour_label+'</span></span>'
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%M</span><span class="countdown-label main-color-1">'+minute_label+'</span></span>'
				+ (show_second?'<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%S</span><span class="countdown-label main-color-1">'+second_label+'</span></span>':'')
			));
			} else {
			  $this.html(event.strftime(''
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%D</span><span class="countdown-label main-color-1">'+day_label+'</span></span>'
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%H</span><span class="countdown-label main-color-1">'+hour_label+'</span></span>'
				+ '<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%M</span><span class="countdown-label main-color-1">'+minute_label+'</span></span>'
				+ (show_second?'<span class="countdown-block"><span class="countdown-number main-color-1-bg dark-div minion">%S</span><span class="countdown-label main-color-1">'+second_label+'</span></span>':'')
			));
			}
		});
	});
	if(jQuery('.colorbox-grid').length){
		jQuery('.colorbox-grid').colorbox({
			rel: function(){
				return jQuery(this).data('rel');
			},
			inline:true,
			href: function(){
				if(jQuery(this).data('isgallery')){
					return jQuery(this).data('content')+' .popup-data-gallery';
				}else{
					return jQuery(this).data('content')+' .popup-data:not(.popup-data-gallery)';
				}
			},
			width: 900,
			responsive: true,
			onOpen: function(){
				jQuery('body').addClass('popup-active');
			},
			onClosed: function(){
				jQuery('body').removeClass('popup-active');
			},
			previous: '<i class="fa fa-chevron-left"></i>',
			next: '<i class="fa fa-chevron-right"></i>',
			close: '<i class="fa fa-times"></i>',
		});
	}

	jQuery( "#comment-submit" ).on('click', function() {
		var $a = jQuery("#comment").val();
		var $b = "Your comment ...";
		if ( $a == $b){
			jQuery("#comment").val('');
		}
	});
	
	//mobile menu
	jQuery('.mobile-menu-toggle').on('click', function(e) {
        jQuery('body').toggleClass('enable-mobile-menu');
		return false;
    });
	jQuery(document).mouseup(function(e){
		var container = jQuery(".mobile-menu-wrap, #off-canvas-search");
		if (!container.is(e.target) && container.has(e.target).length === 0){
			jQuery('body').removeClass('enable-mobile-menu');
		}
	});
	//improve mobile menu
	jQuery('.mobile-menu li a').on('click', function(){
		jQuery('body').removeClass('enable-mobile-menu');
	});
	
	//smooth link #
	jQuery('a[href*="#"]:not([href="#"])').on('click', function() {
		if(jQuery(this).hasClass('featured-tab') || jQuery(this).hasClass('popup-gallery-comment') || jQuery(this).parents('ul').hasClass('tabs') || jQuery(this).hasClass('comment-reply-link') || jQuery(this).hasClass('ui-tabs-anchor') || jQuery(this).data('vc-container') || jQuery(this).parents('div').hasClass('wpb_tour_next_prev_nav')){
			return true;
		}else if(location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') 
			|| location.hostname == this.hostname) {
			var target = jQuery(this.hash);
			target = target.length ? target : jQuery('[name=' + this.hash.slice(1) +']');
			   if (target.length) {
				jQuery('html,body,#body-wrap').animate({
					 scrollTop: target.offset().top - 50
				}, 660);
				return true;
			}
		}
	});
	
	//paralax bg
	var $window = jQuery(window);
	jQuery('.pc .ia_paralax .wpb_row, .pc .is-paralax').each(function(){
		var $bgobj = jQuery(this); // assigning the object
		var yPos = -( ($window.scrollTop()-$bgobj.offset().top + 30) / 5);
		var ycss = 'background-position: 50% '+ yPos + 'px !important; transition: none;';
		$bgobj.attr('style', ycss);
		
		jQuery(window).scroll(function() {
			var yPos = -( ($window.scrollTop()-$bgobj.offset().top + 30) / 5);
			var ycss = 'background-position: 50% '+ yPos + 'px !important; transition: none;';
			$bgobj.attr('style', ycss);
		});
	});

	jQuery( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" id="add1" class="plus" />' ).prepend( '<input type="button" value="-" id="minus1" class="minus" />' );
	jQuery('.buttons_added #minus1').on('click', function(e) {
		var value = parseInt(jQuery(this).siblings('input.qty').val()) - 1;
		if(value>=0){
			jQuery(this).siblings('input.qty').val(value);
			jQuery('.woocommerce-cart-form *[name="update_cart"]').prop("disabled", false);
		}
    });
	jQuery('.buttons_added #add1').on('click', function(e) {
		var value = parseInt(jQuery(this).prev().val()) + 1;
		jQuery(this).prev().val(value);
		jQuery('.woocommerce-cart-form *[name="update_cart"]').prop("disabled", false);
    });

    //fix ajax
    jQuery( document.body ).on( 'updated_cart_totals', function(){
		jQuery( 'div.quantity:not(.buttons_added), td.quantity:not(.buttons_added)' ).addClass( 'buttons_added' ).append( '<input type="button" value="+" id="add1" class="plus" />' ).prepend( '<input type="button" value="-" id="minus1" class="minus" />' );
		jQuery('.buttons_added #minus1').on('click', function(e) {
			var value = parseInt(jQuery(this).siblings('input.qty').val()) - 1;
			if(value>=0){
				jQuery(this).siblings('input.qty').val(value);
				jQuery('.woocommerce-cart-form *[name="update_cart"]').prop("disabled", false);
			}
	    });
		jQuery('.buttons_added #add1').on('click', function(e) {
			var value = parseInt(jQuery(this).prev().val()) + 1;
			jQuery(this).prev().val(value);
			jQuery('.woocommerce-cart-form *[name="update_cart"]').prop("disabled", false);
	    });
	});
	
	
	jQuery(document).mouseup(function(e){
		var container = jQuery("#off-canvas-search form");
		if (!container.is(e.target) && container.has(e.target).length === 0){
			jQuery('body').removeClass('enable-search');
		}
	});

	
	
});//document ready
jQuery(window).scroll(function(e) {
	//fixed effect
	if(jQuery(window).width()>992){
		jQuery(".fixed-effect").each(function(index, element) {
			var windowHeight = jQuery(window).height();
			var offset =  jQuery(this).offset().top;
			var inner_height = jQuery('.fixed-effect-inner',this).outerHeight();
			var scrollTop = jQuery(document).scrollTop();
			if((scrollTop + windowHeight) >= offset){
				var opacity = ((scrollTop + windowHeight)-offset)/inner_height;
				jQuery('.fixed-effect-inner',this).css('opacity', opacity);
				jQuery('.fixed-effect-inner',this).css('margin-top', (opacity-1)*300);
			}
		});
	}else{
		jQuery(".fixed-effect").each(function(index, element) {
			jQuery('.fixed-effect-inner',this).css('opacity', 1);
			jQuery('.fixed-effect-inner',this).css('margin-bottom', 0);
		});
	}
});
jQuery(window).resize(function(e) {
	if(jQuery(window).width()<977){
		jQuery(".grid-listing").each(function(index, element) {
			if(!jQuery(this).hasClass('owl-carousel')){
				jQuery(this).owlCarousel({ addClassActive : true });
			}
		});
	}else{
		jQuery(".grid-listing").each(function(index, element) {
            if(jQuery(this).hasClass('owl-carousel')){
				var owl = jQuery(this).data('owlCarousel');
				owl.destroy();
			}
        });
	}
	//fixed effect
    jQuery(".fixed-effect").each(function(index, element) {
        var inner_height = jQuery('.fixed-effect-inner',this).outerHeight();
		jQuery(this).css('height', inner_height);
    });
});

jQuery(window).scroll(function(e) {
	if( jQuery(window).width() > 991 && jQuery('.summary.portrait-screenshot').length && jQuery('.images .ias-devide-wrap').length){
		var scrollTop = jQuery(window).scrollTop();
		
		var box_height = jQuery('.summary.portrait-screenshot').outerHeight();
		var box_offset = jQuery('.summary.portrait-screenshot').offset().top;
		
		var mobile_height = jQuery('.images .ias-devide-wrap').height();
		var mobile_offset = jQuery('.images .ias-devide-wrap').offset().top;
		
		var menu_height = 50 + jQuery('#wpadminbar').height();

		if( mobile_offset - scrollTop - menu_height - 30 <=0 ){
			margin_top = scrollTop - mobile_offset + menu_height + 30;
			if(margin_top >= mobile_height - box_height){
				margin_top = mobile_height - box_height;
			}
		}else{
			margin_top = 0;
		}
		jQuery('.summary.portrait-screenshot').css('margin-top',margin_top);
	}else{
		jQuery('.summary.portrait-screenshot').css('margin-top',0);
	}
});

// Get browser add body class
jQuery.each(jQuery.browser, function(i) {
    jQuery('body').addClass(i);
    return false;  
});
// Get OS
var os = [
    'iphone',
    'ipad',
    'windows',
    'mac',
    'linux',
	'android',
	'mobile'
];
var match = navigator.appVersion.toLowerCase().match(new RegExp(os.join('|')));
if (match) {
    jQuery('body').addClass(match[0]);
}
if(typeof match[0] == 'undefined'){
	match[0]='';
}
if ( (navigator.appVersion.indexOf("Win")!=-1 || navigator.appVersion.indexOf("Mac")!=-1 || navigator.appVersion.indexOf("X11")!=-1 || match[0]=='windows' || match[0]=='mac') && match[0]!='iphone' && match[0]!='ipad'){
	jQuery('body').addClass('pc');
}else{
	jQuery('body').addClass('mobile');
}
//End body class

//Loading effect
jQuery(window).load(function(e) {
	jQuery("#pageloader").fadeOut(500);
});

})(jQuery);


function getCookie(cname) {
  var name = cname + "=";
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for(var i = 0; i <ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return "";
}
function setCookie(cname, cvalue, exdays) {
  var d = new Date();
  d.setTime(d.getTime() + (exdays*24*60*60*1000));
  var expires = "expires="+ d.toUTCString();
  document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
}