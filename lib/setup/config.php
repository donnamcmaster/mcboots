<?php

// configure theme support
add_action( 'after_setup_theme', function() {

	// makes the featured image box show up in custom post types
	add_theme_support( 'post-thumbnails' );

	// tell wordpress to output the title tag
	add_theme_support( 'title-tag' );

	// make theme available for translation.
	load_theme_textdomain( 'mcboots', get_template_directory() . '/languages' );

	// switch default core markup to output valid HTML5
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );
	
	$GLOBALS['content_width'] = 1140;

});
