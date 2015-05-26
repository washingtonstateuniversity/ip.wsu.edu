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

	$(window).scroll(function() {
		if ($(this).scrollTop() > 1){
			$('#binder > main > header > div.header-group').addClass("sticky");
		}
		else{
			$('#binder > main > header > div.header-group').removeClass("sticky");
		}
	});

	process_section_backgrounds = function() {
		var $bg_sections = $('.section-wrapper-has-background');

		$bg_sections.each( function() {
			var background_image = $(this).data('background');
			$(this).css('background-image', 'url(' + background_image + ')' );
		});
	};

	$(document).ready( function() {
		process_section_backgrounds();
	});
}(jQuery, window));