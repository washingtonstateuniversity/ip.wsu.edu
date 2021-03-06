<?php
include_once( __DIR__ . '/includes/fields-of-study.php' );
include_once( __DIR__ . '/includes/map-embed-shortcode.php' );
include_once( __DIR__ . '/includes/shortcode-blockquote.php' );
include_once( __DIR__ . '/includes/shortcode-form-modal.php' );

class WSU_IP_Theme {
	/**
	 * Setup the hooks used in the theme.
	 */
	public function __construct() {
		add_filter( 'spine_child_theme_version', array( $this, 'ip_theme_version' ) );
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

		add_filter( 'wsuwp_people_item_html', array( $this, 'people_html' ), 10, 2 );
		add_filter( 'wsuwp_people_sort_items', array( $this, 'people_sort' ), 10, 1 );
	}

	/**
	 * Provides a theme version for use in cache busting.
	 *
	 * @since 2.1.4
	 *
	 * @return string
	 */
	public function ip_theme_version() {
		return '2.1.4';
	}

	/**
	 *
	 * @param string $name Name of the IP site being checked.
	 *
	 * @return bool
	 */
	public function is_ip_site( $name ) {
		$site = get_blog_details();

		$home_domain = apply_filters( 'ip_home_domain', 'ip.wsu.edu' );
		$home_path = apply_filters( 'ip_home_path', '/' );
		$future_students_domain = apply_filters( 'ip_future_students_domain', 'ip.wsu.edu' );
		$future_students_path = apply_filters( 'ip_future_students_path', '/future-students/' );
		$study_english_domain = apply_filters( 'ip_study_english_domain', 'ip.wsu.edu' );
		$study_english_path = apply_filters( 'ip_study_english_path', '/learn-english/' );
		$study_abroad_domain = apply_filters( 'ip_study_abroad_domain', 'ip.wsu.edu' );
		$study_abroad_path = apply_filters( 'ip_study_abroad_path', '/study-abroad/' );
		$scholars_abroad_domain = apply_filters( 'ip_scholars_abroad_domain', 'ip.wsu.edu' );
		$scholars_abroad_path = apply_filters( 'ip_scholars_abroad_path', '/scholars-abroad/' );
		$on_campus_domain = apply_filters( 'ip_on_campus_domain', 'ip.wsu.edu' );
		$on_campus_path = apply_filters( 'ip_on_campus_path', '/on-campus/' );

		if ( 'ip-home' === $name && $home_domain === $site->domain && $home_path === $site->path ) {
			return true;
		}

		if ( 'future-students' === $name && $future_students_domain === $site->domain && $future_students_path === $site->path ) {
			return true;
		}

		if ( 'study-english' === $name && $study_english_domain === $site->domain && $study_english_path === $site->path ) {
			return true;
		}

		if ( 'study-abroad' === $name && $study_abroad_domain === $site->domain && $study_abroad_path === $site->path ) {
			return true;
		}

		if ( 'scholars-abroad' === $name && $scholars_abroad_domain === $site->domain && $scholars_abroad_path === $site->path ) {
			return true;
		}

		if ( 'on-campus' === $name&& $on_campus_domain === $site->domain && $on_campus_path === $site->path ) {
			return true;
		}

		return false;
	}

	/**
	 * Enqueue site specific stylesheets after the child theme's stylesheet.
	 */
	public function enqueue_site_styles() {
		if ( $this->is_ip_site( 'ip-home' ) && is_front_page() ) {
			wp_enqueue_style( 'wsu-ip-home', get_stylesheet_directory_uri() . '/css/ip-home.css', array(), spine_get_child_version() );
		} elseif ( $this->is_ip_site( 'ip-home' ) ) {
			wp_enqueue_style( 'wsu-ip-home', get_stylesheet_directory_uri() . '/css/ip-home-inside.css', array(), spine_get_child_version() );
		}

		if ( $this->is_ip_site( 'future-students' ) ) {
			wp_enqueue_style( 'wsu-ip-future-students', get_stylesheet_directory_uri() . '/css/ip-future-students.css', array(), spine_get_child_version() );
		}

		if ( $this->is_ip_site( 'study-english' ) ) {
			wp_enqueue_style( 'wsu-ip-study-english', get_stylesheet_directory_uri() . '/css/ip-study-english.css', array(), spine_get_child_version() );
		}

		if ( $this->is_ip_site( 'study-abroad' ) ) {
			wp_enqueue_style( 'wsu-ip-study-abroad', get_stylesheet_directory_uri() . '/css/ip-study-abroad.css', array(), spine_get_child_version() );
		}

		if ( $this->is_ip_site( 'scholars-abroad' ) ) {
			wp_enqueue_style( 'wsu-ip-scholar-abroad', get_stylesheet_directory_uri() . '/css/ip-scholar-abroad.css', array(), spine_get_child_version() );
		}

		if ( $this->is_ip_site( 'on-campus' ) ) {
			wp_enqueue_style( 'wsu-ip-on-campus', get_stylesheet_directory_uri() . '/css/ip-on-campus.css', array(), spine_get_child_version() );
		}
	}

	/**
	 * Enqueue custom scripts for International Programs.
	 */
	public function enqueue_scripts() {
		// Our standard scripts aren't required on the IP Home page.
		if ( ! $this->is_ip_site( 'ip-home' ) ) {
			wp_enqueue_script( 'wsu-ip-fos', get_stylesheet_directory_uri() . '/js/ip-fos-view.js', array( 'backbone' ), spine_get_child_version(), true );
			wp_enqueue_script( 'wsu-ip-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'backbone' ), spine_get_child_version(), true );
		}

		if ( $this->is_ip_site( 'ip-home' ) && is_front_page() ) {
			wp_enqueue_script( 'wsu-ip-home', get_stylesheet_directory_uri() . '/js/ip-home.js', array( 'backbone' ), spine_get_child_version(), true );
		}
	}

	/**
	 * Enqueue the scripts and styles used in admin views while this theme is active.
	 */
	public function enqueue_admin_styles() {
		if ( 'page' === get_current_screen()->id ) {
			wp_enqueue_style( 'wsu-ip-builder-styles', get_stylesheet_directory_uri() . '/css/sections.css', array(), spine_get_child_version() );
		}
	}

	/**
	 * Alter the defaults provided by the WSU Color Palette plugin.
	 *
	 * @return array
	 */
	public function color_palette_values() {
		return array(
			'palette1' => array(
				'name' => 'Crimson',
				'hex' => '#981e32',
			),
			'palette2' => array(
				'name' => 'Blue One',
				'hex' => '#4f868e',
			),
			'palette3' => array(
				'name' => 'Blue Two',
				'hex' => '#2f5055',
			),
			'palette4' => array(
				'name' => 'Gray One',
				'hex' => '#8d959a',
			),
			'palette5' => array(
				'name' => 'Gray Two',
				'hex' => '#464e54',
			),
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
			<label for="<?php echo esc_attr( $section_name ); ?>[section-anchor-text]">Section Anchor Text:</label>
			<input type="text" id="<?php echo esc_attr( $section_name ); ?>[section-anchor-text]"
				   class="wsuwp-builder-section-anchor-text widefat"
				   name="<?php echo esc_attr( $section_name ); ?>[section-anchor-text]"
				   value="<?php echo esc_attr( $section_anchor_text ); ?>" />
			<p class="description">A short title for this section. Used in navigation at the top of the page.</p>
			<label for="<?php echo esc_attr( $section_name ); ?>[section-id]">Section Id:</label>
			<input type="text" id="<?php echo esc_attr( $section_name ); ?>[section-id]" class="wsuwp-builder-section-id widefat" name="<?php echo esc_attr( $section_name ); ?>[section-id]" value="<?php echo esc_attr( $section_id ); ?>" />
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

		foreach ( $clean_sections as $section ) {
			if ( isset( $section['section-id'] ) && '' !== $section['section-id'] && isset( $section['section-anchor-text'] ) && '' !== $section['section-anchor-text'] ) {
				$anchor_nav[ $section['section-id'] ] = $section['section-anchor-text'];
			}
		}

		update_post_meta( get_the_ID(), '_ip_anchor_nav_data', $anchor_nav );

		return $clean_sections;
	}

	/**
	 * Provide a custom HTML template for use with syndicated people.
	 *
	 * @param string   $html   The HTML to output for an individual person.
	 * @param stdClass $person Object representing a person received from people.wsu.edu.
	 *
	 * @return string The HTML to output for a person.
	 */
	public function people_html( $html, $person ) {
		if ( isset( $person->working_titles[0] ) ) {
			$title = $person->working_titles[0];
		} else {
			$title = ucwords( strtolower( $person->position_title ) );
		}

		if ( ! empty( $person->email_alt ) ) {
			$email = $person->email_alt;
		} else {
			$email = $person->email;
		}

		if ( ! empty( $person->office_alt ) ) {
			$office = $person->office_alt;
		} else {
			$office = $person->office;
		}

		if ( ! empty( $person->phone_alt ) ) {
			$phone = $person->phone_alt;
		} else {
			$phone = $person->phone;
		}

		if ( ! empty( $person->photos[0]->thumbnail ) ) {
			$photo = $person->photos[0]->thumbnail;
		} elseif ( isset( $person->profile_photo ) ) {
			$photo = $person->profile_photo;
		} else {
			$photo = false;
		}

		if ( ! empty( $person->bio_unit ) ) {
			$bio = $person->bio_unit;
		} elseif ( $person->bio_department ) {
			$bio = $person->bio_department;
		} else {
			$bio = '';
		}

		ob_start();

		if ( $photo ) {
			?>
			<div class="wsuwp-person-container">
				<figure class="wsuwp-person-photo">
					<img src="<?php echo esc_url( $photo ); ?>"
						 alt="<?php echo esc_attr( $person->title->rendered ); ?>" />
				</figure>
			<?php
		} else {
			?><div class="wsuwp-person-container person-no-photo"><?php
		}
		?>
			<div class="wsuwp-person-info-container">
				<div class="wsuwp-person-name"><?php echo esc_html( $person->title->rendered ); ?></div>
				<div class="wsuwp-person-position"><?php echo esc_html( $title ); ?></div>
				<div class="wsuwp-person-office"><?php echo esc_html( $office ); ?></div>
				<div class="wsuwp-person-email"><a href="mailto:<?php echo esc_html( $email ); ?>"><?php echo esc_html( $email ); ?></a></div>
				<div class="wsuwp-person-phone"><a href="tel:<?php echo esc_html( $phone ); ?>"><?php echo esc_html( $phone ); ?></a></div>
			</div>
			<div class="wsuwp-person-profile-container">
				<?php echo wp_kses_post( $bio ); ?>
			</div>
		</div>
		<?php
		$html = ob_get_contents();
		ob_end_clean();

		return $html;
	}

	/*
	 * Use the provided Content Syndicate filter to sort people results before displaying.
	 */
	public function people_sort( $people ) {
		usort( $people, array( $this, 'sort_alpha' ) );

		if ( 1 === ( count( $people ) % 2 ) ) {
			$person = new stdClass();
			$person->title = (object) array(
				'rendered' => '',
			);
			$person->office = '';
			$person->position_title = '';
			$person->email = '';
			$person->phone = '';
			$person->bio_department = '';
			$people[] = $person;
		}

		return $people;
	}

	/**
	 * Sort people alphabetically by their last name.
	 *
	 * @param stdClass $a Object representing a person.
	 * @param stdClass $b Object representing a person.
	 *
	 * @return int Whether person a's last name is alphabetically smaller or greater than person b's.
	 */
	public function sort_alpha( $a, $b ) {
		return strcasecmp( $a->last_name, $b->last_name );
	}
}
$wsu_ip_theme = new WSU_IP_Theme();

/**
 * Wrapper to determine if a current view is a specific site.
 *
 * @param string $site
 *
 * @return bool
 */
function ip_is_ip_site( $site ) {
	global $wsu_ip_theme;
	return $wsu_ip_theme->is_ip_site( $site );
}
