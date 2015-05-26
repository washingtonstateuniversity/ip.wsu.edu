<?php

class WSU_IP_Theme {
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_filter( 'wsu_color_palette_values', array( $this, 'color_palette_values' ) );
	}

	/**
	 * Enqueue custom scripts for International Programs.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wsu-ip-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), spine_get_script_version(), true );
	}

	/**
	 * Alter the defaults provided by the WSU Color Palette plugin.
	 *
	 * @return array
	 */
	public function color_palette_values() {
		return array(
			'crimson' => array( 'name' => 'Crimson',  'hex' => '#981e32' ),
			'blue1'   => array( 'name' => 'Blue One', 'hex' => '#4f868e' ),
			'blue2'   => array( 'name' => 'Blue Two', 'hex' => '#2f5055' ),
			'gray1'   => array( 'name' => 'Gray One', 'hex' => '#8d959a' ),
			'gray2'   => array( 'name' => 'Gray Two', 'hex' => '#464e54' ),
		);
	}
}
new WSU_IP_Theme();