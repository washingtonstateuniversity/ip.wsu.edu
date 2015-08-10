<?php

class IP_Form_Modal_Shortcode {
	public function __construct() {
		add_shortcode( 'ip_open_form', array( $this, 'display_open_modal' ) );
	}

	public function display_open_modal( $atts, $content ) {
		$default_atts = array(
			'id' => '',
		);
		$atts = shortcode_atts( $default_atts, $atts );

		$return_content = '<a href="#" class="trigger-modal" data-modal="modal-form-' . absint( $atts['id'] ) . '">';
		$return_content .= esc_html( $content );
		$return_content .= '</a>';

		return $return_content;
	}
}
new IP_Form_Modal_Shortcode();