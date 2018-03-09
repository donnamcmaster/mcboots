<?php
/**
 *	Configure Theme Support
 *
 * @package McBoots
 */

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
	
	// options specific to McBoots
//	add_theme_support( 'mcboots-sidebars' );
//	add_theme_support( 'mcboots-blog' );

	$GLOBALS['content_width'] = 1140;

});

// customize excerpt parameters 
add_filter( 'excerpt_length', 20 );
add_filter( 'excerpt_more', ' [&hellip;]' );
add_filter( 'mcb_excerpt_read_more', ' read more&nbsp;&raquo;' );
