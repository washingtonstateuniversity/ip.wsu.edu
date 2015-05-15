<?php

add_action( 'wp_enqueue_scripts', 'wpb_adding_scripts' );
/**
 * Enqueue custom scripts for IP
 */
function wpb_adding_scripts() {
	wp_enqueue_script( 'wsu-ip-js', get_stylesheet_directory_uri() . '/js/script.js', array( 'jquery' ), spine_get_script_version(), true );
}