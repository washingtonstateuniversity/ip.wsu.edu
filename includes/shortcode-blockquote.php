<?php

class WSU_IP_Blockquote_Shortcode {

	/**
	 * Setup the plugin.
	 */
	public function __construct() {
		add_action( 'init', array( $this, 'setup_shortcode_ui' ) );
		add_shortcode( 'ip_blockquote', array( $this, 'display_ip_blockquote' ) );
	}

	/**
	 * Configure support for the Progress Bar shortcode with Shortcode UI.
	 */
	public function setup_shortcode_ui() {
		if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			return;
		}
		array(

			// Available shortcode attributes and default values. Required. Array.
			// Attribute model expects 'attr', 'type' and 'label'
			// Supported field types: text, checkbox, textarea, radio, select, email, url, number, and date.
			'attrs' => array(
				array(
					'label' => 'Attachment',
					'attr'  => 'attachment',
					'type'  => 'attachment',
					'libraryType' => array( 'image' ),
					'addButton'   => 'Select Image',
					'frameTitle'  => 'Select Image',
				),
				array(
					'label' => 'Cite',
					'attr'  => 'source',
					'type'  => 'text',
					'meta' => array(
						'placeholder' => 'Test placeholder',
						'data-test'    => 1,
					),
				),
				array(
					'label'    => 'Select Page',
					'attr'     => 'page',
					'type'     => 'post_select',
					'query'    => array( 'post_type' => 'page' ),
					'multiple' => true,
				),
			),
		);
		$args = array(
			'label'         => 'Blockquote',
			'listItemImage' => 'dashicons-editor-quote',
			'post_type'     => array( 'post', 'page' ),
			'inner_content' => array(
				'label' => 'Blockquote text',
			),
			'attrs'         => array(
				array(
					'label'    => 'Image (Optional)',
					'attr'     => 'image',
					'type'     => 'attachment',
					'libraryType' => array( 'image' ),
					'addButton' => 'Select Image',
					'frameTitle' => 'Select Image',
				),
			),
		);
		shortcode_ui_register_for_shortcode( 'ip_blockquote', $args );
	}

	/**
	 * Display the International Programs blockquote shortcode.
	 *
	 * @param array  $atts    Attributes assigned to the blockquote display.
	 * @param string $content Content used in the blockquote element itself.
	 *
	 * @return string
	 */
	public function display_ip_blockquote( $atts, $content ) {

		$content = '<blockquote>' . wp_kses_post( $content ) . '</blockquote>';

		if ( isset( $atts['image'] ) && 0 !== absint( $atts['image'] ) ) {
			$content = '<div class="column one">' . $content . '</div><div class="column two">' . wp_get_attachment_image( $atts['image'], 'thumbnail', false ) . '</div>';
		}

		return $content;
	}
}
new WSU_IP_Blockquote_Shortcode();