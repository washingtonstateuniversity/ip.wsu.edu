<?php
include_once( __DIR__ . '/includes/fields-of-study.php' );

class WSU_IP_Theme {
	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_action( 'wp_enqueue_scripts', array( $this, 'enqueue_scripts' ) );
		add_action( 'spine_enqueue_styles', array( $this, 'enqueue_site_styles' ) );
		add_action( 'admin_enqueue_scripts', array( $this, 'enqueue_admin_styles' ), 15 );
		add_filter( 'wsu_color_palette_values', array( $this, 'color_palette_values' ) );
		add_action( 'spine_output_builder_section', array( $this, 'output_builder_section_ids' ), 10, 3 );

		// Filter the cleaned data when saving any time of section.
		add_filter( 'spine_builder_save_columns', array( $this, 'save_builder_columns' ), 10, 2 );
		add_filter( 'spine_builder_save_banner',  array( $this, 'save_builder_columns' ), 10, 2 );
		add_filter( 'spine_builder_save_header',  array( $this, 'save_builder_columns' ), 10, 2 );

		add_filter( 'make_prepare_data', array( $this, 'prepare_page_nav' ), 10, 1 );
	}

	/**
	 *
	 * @param string $name Name of the IP site being checked.
	 *
	 * @return bool
	 */
	public function is_ip_site( $name ) {
		$site = get_blog_details();

		$home_domain = apply_filters( 'ip_home_domain', 'stage.ip.wsu.edu' );
		$future_students_domain = apply_filters( 'ip_future_students_domain', 'stage.future-students.ip.wsu.edu' );
		$study_english_domain = apply_filters( 'ip_study_english_domain', 'stage.study-english.ip.wsu.edu' );
		$study_abroad_domain = apply_filters( 'ip_study_abroad_domain', 'stage.study-abroad.ip.wsu.edu' );
		$scholars_abroad_domain = apply_filters( 'ip_scholars_abroad_domain', 'stage.scholars-abroad.ip.wsu.edu' );
		$on_campus_domain = apply_filters( 'ip_on_campus_domain', 'stage.on-campus.ip.wsu.edu' );

		if ( 'ip-home' === $name && $home_domain === $site->domain ) {
			return true;
		}

		if ( 'future-students' === $name && $future_students_domain === $site->domain ) {
			return true;
		}

		if ( 'study-english' === $name && $study_english_domain === $site->domain ) {
			return true;
		}

		if ( 'study-abroad' === $name && $study_abroad_domain === $site->domain ) {
			return true;
		}

		if ( 'scholars-abroad' === $name && $scholars_abroad_domain === $site->domain ) {
			return true;
		}

		if ( 'on-campus' === $name&& $on_campus_domain === $site->domain ) {
			return true;
		}

		return false;
	}

	/**
	 * Enqueue site specific stylesheets after the child theme's stylesheet.
	 */
	public function enqueue_site_styles() {
		if ( $this->is_ip_site( 'ip-home' ) ) {
			wp_enqueue_style( 'wsu-ip-home', get_stylesheet_directory_uri() . '/css/ip-home.css', array(), spine_get_script_version() );
		}

		if ( $this->is_ip_site( 'future-students' ) ) {
			wp_enqueue_style( 'wsu-ip-future-students', get_stylesheet_directory_uri() . '/css/ip-future-students.css', array(), spine_get_script_version() );
		}

		if ( $this->is_ip_site( 'study-english' ) ) {
			wp_enqueue_style( 'wsu-ip-study-english', get_stylesheet_directory_uri() . '/css/ip-study-english.css', array(), spine_get_script_version() );
		}

		if ( $this->is_ip_site( 'study-abroad' ) ) {
			wp_enqueue_style( 'wsu-ip-study-abroad', get_stylesheet_directory_uri() . '/css/ip-study-abroad.css', array(), spine_get_script_version() );
		}

		if ( $this->is_ip_site( 'scholars-abroad' ) ) {
			wp_enqueue_style( 'wsu-ip-scholars-abroad', get_stylesheet_directory_uri() . '/css/ip-scholars-abroad.css', array(), spine_get_script_version() );
		}

		if ( $this->is_ip_site( 'on-campus' ) ) {
			wp_enqueue_style( 'wsu-ip-on-campus', get_stylesheet_directory_uri() . '/css/ip-on-campus.css', array(), spine_get_script_version() );
		}
	}

	/**
	 * Enqueue custom scripts for International Programs.
	 */
	public function enqueue_scripts() {
		wp_enqueue_script( 'wsu-ip-fos', get_stylesheet_directory_uri() . '/js/ip-fos-view.js', array( 'backbone' ), spine_get_script_version(), true );
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
			<p class="description">A short title for this section. Used in navigation at the top of the page.</p>
			<label for="<?php echo $section_name; ?>[section-id]">Section Id:</label>
			<input type="text" id="<?php echo $section_name; ?>[section-id]" class="wsuwp-builder-section-id widefat" name="<?php echo $section_name; ?>[section-id]" value="<?php echo esc_attr( $section_id ); ?>" />
			<p class="description">A single ID to be applied to this <code>section</code> element.</p>
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

	/**
	 * Process the cleaned data after a page is built and grab any sections with both
	 * IDs and anchor text to help build an anchor navigation.
	 *
	 * @param array $clean_sections
	 *
	 * @return array The unmodified list of data.
	 */
	public function prepare_page_nav( $clean_sections ) {
		$anchor_nav = array();

		foreach( $clean_sections as $section ) {
			if ( isset( $section['section-id'] ) && '' !== $section['section-id'] && isset( $section['section-anchor-text'] ) && '' !== $section['section-anchor-text'] ) {
				$anchor_nav[ $section['section-id'] ] = $section['section-anchor-text'];
			}
		}

		update_post_meta( get_the_ID(), '_ip_anchor_nav_data', $anchor_nav );

		return $clean_sections;
	}
}
new WSU_IP_Theme();