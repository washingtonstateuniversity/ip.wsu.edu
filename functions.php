<?php // Opening PHP tag - nothing should be before this, not even whitespace

// Custom Function to Include
function wpb_adding_scripts() {

wp_register_script('fittext', get_stylesheet_directory_uri() . '/js/jquery.fittext.js', array('jquery'), true);
wp_enqueue_script('fittext');
}

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );