(function($,window){
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