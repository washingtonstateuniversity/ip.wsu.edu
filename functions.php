<?php

class WSU_IP_Theme {
	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 15 );
		add_filter( 'wsu_color_palette_values', array( $this, 'color_palette_values' ) );
		add_action( 'spine_output_builder_section', array( $this, 'output_builder_section_ids' ), 10, 3 );

		// Filter the cleaned data when saving any time of section.
		add_filter( 'spine_builder_save_columns', array( $this, 'save_builder_columns' ), 10, 2 );
		add_filter( 'spine_builder_save_banner',  array( $this, 'save_builder_columns' ), 10, 2 );
		add_filter( 'spine_builder_save_header',  array( $this, 'save_builder_columns' ), 10, 2 );
	}

	/**
	 * Enqueue custom scripts for International Programs.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wsu-ip-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), spine_get_script_version(), true );
	}

	/**
	 * Enqueue the scripts and styles used in admin views while this theme is active.
	 */
	public function enqueue_admin_styles() {
		if ( 'page' === get_current_screen()->id ) {
			wp_enqueue_style( 'wsu-ip-builder-styles', get_stylesheet_directory_uri() . '/css/sections.css', array(), spine_get_script_version() );
		}
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

	/**
	 * Output the HTML required to capture section ID and anchor text for a section.
	 *
	 * @param $section_name
	 * @param $ttfmake_section_data
	 * @param $context
	 */
	public function output_builder_section_ids( $section_name, $ttfmake_section_data, $context ) {
		$section_id = isset( $ttfmake_section_data['data']['section-id'] ) ? $ttfmake_section_data['data']['section-id'] : '';
		$section_anchor_text = isset( $ttfmake_section_data['data']['section-anchor-text'] ) ? $ttfmake_section_data['data']['section-anchor-text'] : '';
		?>
		<div class="wsuwp-builder-meta" style="width:100%; margin-top:10px;">
			<label for="<?php echo $section_name; ?>[section-anchor-text]">Section Anchor Text:</label>
			<input type="text" id="<?php echo $section_name; ?>[section-anchor-text]"
				   class="wsuwp-builder-section-anchor-text widefat"
				   name="<?php echo $section_name; ?>[section-anchor-text]"
				   value="<?php echo esc_attr( $section_anchor_text ); ?>" />
			<p class="description">Enter a short title for this anchor. This will be used in navigation at the top of the page.</p>
			<label for="<?php echo $section_name; ?>[section-id]">Section Id:</label>
			<input type="text" id="<?php echo $section_name; ?>[section-id]" class="wsuwp-builder-section-id widefat" name="<?php echo $section_name; ?>[section-id]" value="<?php echo esc_attr( $section_id ); ?>" />
			<p class="description">Enter a single ID to apply it to the <code>section</code> element represented by this builder area.</p>
		</div>
	<?php
	}

	/**
	 * Save additional builder data for columns not handled by the parent theme.
	 *
	 * @param array $clean_data Current array of cleaned data for storage.
	 * @param array $data       Original array of data.
	 *
	 * @return array Cleaned data with our updates.
	 */
	public function save_builder_columns( $clean_data, $data ) {
		if ( isset( $data['section-id'] ) ) {
			$clean_data['section-id'] = sanitize_key( $data['section-id'] );
		}

		if ( isset( $data['section-anchor-text'] ) ) {
			$clean_data['section-anchor-text'] = sanitize_text_field( esc_html( $data['section-anchor-text'] ) );
		}

		return $clean_data;
	}
}
new WSU_IP_Theme();