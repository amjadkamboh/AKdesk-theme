jQuery(document).ready(function($) {

	// Procedure Drop Down Trigger Code
	jQuery('.dropct').click(function (e) {
		e.stopPropagation();
		jQuery(this).toggleClass("active");
	});
	// Hides the unordered list when clicking outside of it
	jQuery(document).click(function () {
		jQuery(".dropct").removeClass("active");
	});
	// Slider
	var $owl = $('.owl-carousel-6');
	$owl.owlCarousel({
		nav:true,
		loop: false,
		items: 6,
		margin:0,
		dots: false,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:3
			},
			1000:{
				items:4
			},
			1200:{
				items:5
			},
			1201:{
				items:6
			}
		}
	});
	var $owl = $('.owl-carousel-4');
	$owl.owlCarousel({
		nav:true,
		loop: false,
		items: 4,
		margin:0,
		dots: false,
		responsive:{
			0:{
				items:1
			},
			600:{
				items:2
			},
			1000:{
				items:3
			},
			1001:{
				items:4
			}
		}
	});
	// Submenu trigger
	$('.sidebar ul.menu .menu-item-has-children,.genesis-nav-menu .menu-item-has-children').append('<div class="trigger-sub">+</div>');
	$(".trigger-sub").click(function(){
		$(this).siblings("ul.sub-menu").slideToggle();
		$(this).toggleClass("active");
	});
	// Newsletter Trigger Code
	jQuery(".popup-news-triggers").click(function(e){
		e.stopPropagation();
		e.preventDefault();
		jQuery(".popup-schedule").fadeIn("slow");
		jQuery("body").addClass("hiiden-f");
	}); 
	jQuery(".cross-popup, .popup-schedule").click(function(){
		jQuery(".popup-schedule").fadeOut("slow");
		jQuery("body").removeClass("hiiden-f");
	});
	jQuery('.popup-schedule-wrap').click(function (e) {
		e.stopPropagation();
	});
	// Mobile Menu get our free newsletter Code
	jQuery( "body" ).append('<div class="menu-overlay"></div>');
	jQuery( ".header-menu" ).append('<div class="menu-close">close <span>x</span></div>');
	jQuery( ".header-menu" ).prepend('<div class="menu-close">close <span>x</span></div>');
	jQuery( ".site-header .menu-item-has-children " ).prepend('<div class="menu-sub-close">+</div>');
	jQuery(".heeader-menuicon").click(function(){
		jQuery(".header-menu,.menu-overlay").fadeToggle();
	});
	jQuery(".menu-overlay,.menu-close").click(function(){
		jQuery(".header-menu,.menu-overlay").fadeOut();
		jQuery(this).siblings("a").addClass("sub-menu-active");
		jQuery(".site-header .sub-menu").fadeOut();
		jQuery(".menu-sub-close").removeClass("sub-menu-active");
		jQuery("a").removeClass("sub-menu-active");
	});
	jQuery(".menu-sub-close").click(function(){
		jQuery(this).siblings(".site-header .sub-menu").slideToggle('slow');
		jQuery(this).toggleClass("sub-menu-active");
		jQuery(this).siblings("a").toggleClass("sub-menu-active");
	});
});