<?php
/**
 * Initial setup and constants
 */
function monk_theme_setup() {
	// Enable plugins to manage the document title
	add_theme_support("title-tag");

	// Add post thumbnails
	add_theme_support("post-thumbnails");

	// Add Menus
	add_theme_support("menus");

	// Add HTML5 markup for captions
	add_theme_support("html5", ["caption", "comment-form", "comment-list"]);
}
add_action("after_setup_theme", "monk_theme_setup");

// Adding Theme Support
add_theme_support("custom-logo");

function enqueue_gsap() {
	wp_enqueue_script('gsap', 'https://cdnjs.cloudflare.com/ajax/libs/gsap/3.11.4/gsap.min.js', array(), null, true);
}
add_action('wp_enqueue_scripts', 'enqueue_gsap');