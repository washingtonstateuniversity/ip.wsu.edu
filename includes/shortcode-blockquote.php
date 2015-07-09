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
	 * Configure support for the blockquote shortcode with Shortcode UI.
	 */
	public function setup_shortcode_ui() {
		if ( ! function_exists( 'shortcode_ui_register_for_shortcode' ) ) {
			return;
		}

		$args = array(
			'label'         => 'Blockquote',
			'listItemImage' => 'dashicons-editor-quote',
			'post_type'     => array( 'post', 'page' ),
			'inner_content' => array(
				'label' => 'Blockquote text',
			),
			'attrs'         => array(
				array(
					'label'    => 'Source',
					'attr'     => 'cite',
					'type'     => 'text',
				),
				array(
					'label'    => 'Image (Optional)',
					'attr'     => 'image',
					'type'     => 'attachment',
					'libraryType' => array( 'image' ),
					'addButton' => 'Select Image',
					'frameTitle' => 'Select Image',
				),
				array(
					'label'    => 'Image placement',
					'attr'     => 'image_placement',
					'type'     => 'select',
					'description' => 'Choose where the image, if one is provided, should be displayed.',
					'options'  => array(
						''         => 'Text in column one, image in column two',
						'reverse'  => 'Image in column one, text in column two',
						'together' => 'Image in text in a single column',
					)
				),
				array(
					'label'   => 'Wrapper class',
					'attr'    => 'wrapper',
					'type'    => 'text',
					'description' => 'If provided, a wrapping container will be created around the blockquote with this class assigned.',
				)
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

		$content = '<blockquote><span class="blockquote-internal"><span class="blockquote-content">' . wp_kses_post( $content ) . '</span>';
		if ( ! empty( $atts['cite'] ) ) {
			$content .= '<cite>' . wp_kses_post( $atts['cite'] ) . '</cite>';
		}
		$content .= '</span></blockquote>';

		if ( isset( $atts['image'] ) && 0 !== absint( $atts['image'] ) ) {
			if ( empty( $atts['image_placement'] ) ) {
				$content = '<div class="column one">' . $content . '</div><div class="column two">' . wp_get_attachment_image( $atts['image'], 'thumbnail', false ) . '</div>';
			} elseif ( 'together' === $atts['image_placement'] ) {
				$content = '<div class="column one">' . $content . wp_get_attachment_image( $atts['image'], 'thumbnail', false ) . '</div>';
			} elseif ( 'reverse' === $atts['image_placement'] ) {
				$content = '<div class="column one">' . wp_get_attachment_image( $atts['image'], 'thumbnail', false ) . '</div><div class="column two">' . $content . '</div>';
			}

		}

		if ( ! empty( $atts['wrapper'] ) ) {
			$content = '<div class="' . esc_attr( $atts['wrapper'] ) . '">' . $content . '</div>';
		}

		return $content;
	}
}
new WSU_IP_Blockquote_Shortcode();