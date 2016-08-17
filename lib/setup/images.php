<?php
/**
 *	Configure Image Sizes
 *
 * @package McBoots
 */

add_action( 'after_setup_theme', function() {
	// fixed sizes for special situations
//	add_image_size( 'home-slide', 1170, 500, true );

	// for the pop-up gallery images
    add_image_size( 'max-gallery', 1200, 800 );

	// for embedding
//    add_image_size( 'content-wide', 765, 420 );
});
