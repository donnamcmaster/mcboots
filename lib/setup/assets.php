<?php
/**
 *	Enqueue Stylesheets & Scripts
 *
 *	@package McBoots
 */

add_action( 'wp_enqueue_scripts', function() {
 
 	// enqueue custom fonts if needed
// 	wp_enqueue_style( 'custom-fonts', 'http://fast.fonts.net/cssapi/c0f76065-db28-4753-b7d3-b9f583edd700.css' );

    wp_enqueue_style( 'mcboots/css', get_stylesheet_directory_uri() . '/assets/css/app.css', [], null );

    wp_enqueue_script( 'jquery' );
    
    // don't forget to combine & minimize scripts!
	wp_enqueue_script( 'bootstrap/collapse', get_stylesheet_directory_uri() . '/assets/js/collapse.js', [], null );
	wp_enqueue_script( 'bootstrap/dropdown', get_stylesheet_directory_uri() . '/assets/js/dropdown.js', [], null );
//    wp_enqueue_script( 'mcboots/js', get_stylesheet_directory_uri() . '/assets/js/app.js', [], null );
});


/**
 *	Additional Bootstrap JS scripts you may want to use
 *	
 *	NOTE: after development complete, need to combine & minimize scripts! 

	wp_enqueue_script( 'mcboots/js', get_stylesheet_directory_uri() . '/assets/js/app.min.js', [], null );
	wp_enqueue_script( 'bootstrap/affix', get_stylesheet_directory_uri() . '/assets/js/affix.js', [], null );
	wp_enqueue_script( 'bootstrap/alert', get_stylesheet_directory_uri() . '/assets/js/alert.js', [], null );
	wp_enqueue_script( 'bootstrap/button', get_stylesheet_directory_uri() . '/assets/js/button.js', [], null );
	wp_enqueue_script( 'bootstrap/carousel', get_stylesheet_directory_uri() . '/assets/js/carousel.js', [], null );
	wp_enqueue_script( 'bootstrap/modal', get_stylesheet_directory_uri() . '/assets/js/modal.js', [], null );
	wp_enqueue_script( 'bootstrap/popover', get_stylesheet_directory_uri() . '/assets/js/popover.js', [], null );
	wp_enqueue_script( 'bootstrap/scrollspy', get_stylesheet_directory_uri() . '/assets/js/scrollspy.js', [], null );
	wp_enqueue_script( 'bootstrap/tab', get_stylesheet_directory_uri() . '/assets/js/tab.js', [], null );
	wp_enqueue_script( 'bootstrap/tooltip', get_stylesheet_directory_uri() . '/assets/js/tooltip.js', [], null );
	wp_enqueue_script( 'bootstrap/transition', get_stylesheet_directory_uri() . '/assets/js/transition.js', [], null );
	
 */