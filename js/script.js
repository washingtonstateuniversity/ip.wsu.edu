/* global Backbone, jQuery, _ */
var wsuFOS = wsuFOS || {};
var wsuIPTheme = wsuIPTheme || {};

(function (window, Backbone, $, _, wsuIPTheme, wsuFOS) {
	'use strict';

	var header_original_position = false,
		headline_current_height = false,
		calculated_height = false,
		last_position = false,
		is_sticky = false;

	wsuIPTheme.appView = Backbone.View.extend({
		initialize : function() {
			$(document).scroll(this.scrollStickyHeader);
			$(document).on('touchmove', this.scrollStickyHeader);
			$(document).trigger('scroll');
		},

		scrollStickyHeader: function() {
			var scroll_position = $(document).scrollTop();

			if ( false === last_position ) {
				last_position = scroll_position;
			}

			if ( false === header_original_position ) {
				header_original_position = $('.ip-headline').offset().top;
			}

			if ( false === headline_current_height ) {
				headline_current_height = $('.ip-headline').outerHeight();
			}

			if ( false === calculated_height ) {
				calculated_height = header_original_position + $('.anchor-nav-wrapper').height() + headline_current_height;
			}

			var sticky_position = header_original_position - scroll_position;

			if ( sticky_position <= 0 && false === is_sticky ) {
				is_sticky = true;
				$('body').addClass('fixed-header');
				$('.main-header').css('height', calculated_height + 'px' );
			}

			if ( sticky_position > 0 && true === is_sticky ) {
				is_sticky = false;
				$('body').removeClass('fixed-header');
				$('.main-header').css('height', 'auto');
				$('.anchor-nav-wrapper').css('top','');
			}

			// Scrolling down, headline should get smaller as header gets sticky.
			if ( is_sticky && ( last_position <= scroll_position ) ) {
				if ( ( scroll_position - header_original_position ) <= 240 ) {
					$('.ip-headline h1').css('font-size', ( ( 180 - ( ( scroll_position - header_original_position ) / 2 ) ) / 2.368421053 ) + 'px');
					$('.anchor-nav-wrapper').css('top', Math.floor( ( 180 - ( ( scroll_position - header_original_position ) ) / 2 ) ) );
				}
			}

			// Scrolling up, headline should get larger when we reach the top.
			if ( is_sticky && ( last_position > scroll_position ) ) {
				if ( ( scroll_position - header_original_position ) <= 240 ) {
					$('.ip-headline h1').css('font-size', ( ( 180 - ( ( scroll_position - header_original_position ) / 2 ) ) / 2.368421053 ) + 'px');
					$('.anchor-nav-wrapper').css('top', Math.floor( ( ( 180 - ( ( scroll_position - header_original_position ) / 2 ) ) ) ) );
				}
			}

			last_position = scroll_position;
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