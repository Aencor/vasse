<?php


function theme_scripts() {

	if (is_single() && comments_open() && get_option("thread_comments")) {
		wp_enqueue_script("comment-reply");
	}

	wp_register_script(
		"theme-defer",
		get_template_directory_uri() . "/assets/build/main.js",
		['jquery'], // Dependencia de jQuery
		'1.0.1',
		false
	);
	wp_enqueue_script("theme-defer");
	
	// Main Style
	wp_enqueue_style(
		"master",
		get_template_directory_uri() . "/assets/build/style.css",
		true,
		"1.1",
		"all"
	);
}

add_action("wp_enqueue_scripts", "theme_scripts", 9999);
