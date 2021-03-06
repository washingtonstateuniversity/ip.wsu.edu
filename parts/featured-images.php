<?php

// If a featured image is assigned to the post, display as a background image.
if ( spine_has_background_image() ) {
	$background_image_src = spine_get_background_image_src();
	?>

	<style> #jacket { background-image: url(<?php echo esc_url( $background_image_src ); ?>); }</style>

<?php
}

// If anchor navigation data has been attached to this post, retrieve it and output
// an unordered list.
$anchor_nav_data = get_post_meta( get_the_ID(), '_ip_anchor_nav_data', true );

$anchor_html = '';

if ( $anchor_nav_data ) {
	$anchor_count = 0;
	foreach ( $anchor_nav_data as $anchor_id => $anchor_text ) {
		$anchor_count++;
		$anchor_html .= '<li class="anchor-nav-item"><a href="#' . esc_attr( $anchor_id ) . '">' . esc_html( $anchor_text ) . '</a></li>';
	}
}

if ( '' !== $anchor_html ) {
	echo '<div class="anchor-nav-wrapper anchor-count-' . esc_attr( $anchor_count ) . '"><ul class="anchor-nav">' . wp_kses_post( $anchor_html ) . '</ul></div>';
}
