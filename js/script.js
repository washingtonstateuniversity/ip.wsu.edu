/* global Backbone, jQuery, _ */
var wsuFOS = wsuFOS || {};
var wsuIPTheme = wsuIPTheme || {};

(function (window, Backbone, $, _, wsuIPTheme, wsuFOS) {
	'use strict';

	var header_original_position = false,
		headline_current_height = false,
		stop_position = false,
		is_sticky = false,
		main_header_text = '',
		$anchor_nav_wrapper = '';

	wsuIPTheme.appView = Backbone.View.extend({
		initialize : function() {
			$(document).scroll(this.scrollStickyHeader);
			$(document).on('touchmove', this.scrollStickyHeader);
			$(document).trigger('scroll');
		},

		scrollStickyHeader: function() {
			var scroll_position = $(document).scrollTop();

			if ( false === stop_position ) {
				stop_position = $('.main-header-sitename').height() + $('.main-header-sitename').offset().top;
			}

			if ( '' === main_header_text ) {
				main_header_text = $('.sup-header-default').text();
			}

			if ( '' === $anchor_nav_wrapper ) {
				if ( $('.anchor-nav-wrapper').length > 0 ) {
					$anchor_nav_wrapper = $('.anchor-nav-wrapper');
				} else {
					$anchor_nav_wrapper = false;
				}
			}

			if ( false === header_original_position ) {
				header_original_position = $('.anchor-nav-wrapper').offset().top;
			}

			if ( false === headline_current_height ) {
				headline_current_height = $('.anchor-nav-wrapper').outerHeight();
			}

			var sticky_position = header_original_position - scroll_position;

			if ( sticky_position <= stop_position && false === is_sticky ) {
				is_sticky = true;
				jQuery('.sup-header-default').fadeOut(100, function() { jQuery(this).text( $('.ip-headline h1').text()).fadeIn(200); });
				$('body').addClass('fixed-header');
			}

			if ( sticky_position > stop_position && true === is_sticky ) {
				is_sticky = false;
				jQuery('.sup-header-default').fadeOut(100, function() { jQuery(this).text(main_header_text).fadeIn(200); });
				$('body').removeClass('fixed-header');
				$anchor_nav_wrapper.css('top','');
			}
		}
	});

	$('a[href*=#]:not([href=#])').click(function() {
		if (location.pathname.replace(/^\//,'') == this.pathname.replace(/^\//,'') && location.hostname == this.hostname) {

			var target = $(this.hash);
			target = target.length ? target : $('[name=' + this.hash.slice(1) +']');
			if (target.length) {
				$('html,body').animate({
					scrollTop: target.offset().top
				}, 1000);
				return false;
			}
		}
	});

	var setup_form_modals = function() {
		$('.trigger-modal').on('click',function(){
			var modal_id = $(this).data('modal');
			$('body').addClass('noscroll');
			$('#' + modal_id).show();
			$('.close-modal').on('click', function() {
				$('#' + modal_id).hide();
				$('body').removeClass('noscroll');
			});
		});
	};

	$(document).ready(function() {
		window.wsuIPTheme.app = new wsuIPTheme.appView();
		if ( undefined !== wsuFOS.appView ) {
			wsuFOS.app = new wsuFOS.appView();
		}
		setup_form_modals();
	});
})(window, Backbone, jQuery, _, wsuIPTheme, wsuFOS);