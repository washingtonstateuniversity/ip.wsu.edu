<?php

class WSUWP_IP_Map_Shortcode {
	/**
	 * Setup hooks
	 */
	public $loaded_map = 'ip-campus-map';
	public function __construct() {
		add_shortcode( 'wsu_ip_map', array( $this, 'display_map' ) );
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_map_script' ) );
	}

	/**
	 * Enqueue the mapping scripts and styles when a page with the proper shortcode tag is being displayed.
	 */
	public function enqueue_map_script() {
		if ( ! is_singular( 'page' ) ) {
			return;
		}

		$post = get_post();
		if ( isset( $post->post_content ) && has_shortcode( $post->post_content, 'wsu_ip_map' ) ) {
			wp_enqueue_style( 'jquery-ui-smoothness', 'https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.3/themes/smoothness/jquery-ui.min.css', array(), false );
			wp_enqueue_style( 'wsu-ip-map-style', 'https://beta.maps.wsu.edu/content/dis/css/map.view.styles.css', array(), false );
			wp_enqueue_script( 'wsu-ip-map', 'https://beta.maps.wsu.edu/embed/'+$loaded_map, array( 'jquery' ), false, true );
		}
	}

	/**
	 * Output the required map data for display once the beta.maps.wsu.edu script fires.
	 *
	 * @param $atts
	 *
	 * @return string
	 */
	public function display_map( $atts ) {
		$default_atts = array(
			'version' => '',
			'scheme' => 'https',
			'map' => '',
		);
		$atts = shortcode_atts( $default_atts, $atts );
		$loaded_map=$atts['map'];
		$map_path = sanitize_title_with_dashes( $atts['map'] );

		if ( empty( $map_path ) ) {
			return '';
		}

		$content = '<div id="map-embed-' . $map_path . '"></div>';
		$content .= '<script>var map_view_scripts_block = true; var map_view_id = "map-embed-' . esc_js( $map_path ) .'";</script>';

		return $content;
	}
}
new WSUWP_IP_Map_Shortcode();