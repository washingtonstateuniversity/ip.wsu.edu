(function( $ ){
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

	process_section_backgrounds = function() {
		var $bg_sections = $('.section-wrapper-has-background');

		$bg_sections.each( function() {
			var background_image = $(this).data('background');
			$(this).css('background-image', 'url(' + background_image + ')' );
		});
	};

	setup_form_modals = function() {
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

	$(document).ready( function() {
		process_section_backgrounds();
		setup_form_modals();
	});

	if ( undefined !== wsuFOS.appView ) {
		wsuFOS.app = new wsuFOS.appView();
	}
}(jQuery, window));