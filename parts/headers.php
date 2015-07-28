<?php

/**
 * Retrieve an array of values to be used in the header.
 *
 * site_name
 * site_tagline
 * page_title
 * post_title
 * section_title
 * subsection_title
 * posts_page_title
 * sup_header_default
 * sub_header_default
 * sup_header_alternate
 * sub_header_alternate
 */
$spine_main_header_values = spine_get_main_header();

if ( spine_get_option( 'main_header_show' ) == 'true' ) :

?>
<header class="main-header">
	<div class="main-header-sitename">
		<sup class="sup-header">
			<span class="sup-header-default"><?php echo strip_tags( $spine_main_header_values['sup_header_default'], '<a>' ); ?></span>
		</sup>
	</div>
	<?php if ( spine_has_featured_image() ) {
		$featured_image_src = spine_get_featured_image_src(); ?>
		<figure class="featured-image" style="background-image: url('<?php echo $featured_image_src ?>');">
			<?php spine_the_featured_image(); ?>
		</figure>
	<?php } ?>
	<div class="ip-headline">
			<h1><?php echo strip_tags( $spine_main_header_values['sub_header_default'], '<a>' ); ?></h1>
	</div>
</header>

<?php endif; ?>