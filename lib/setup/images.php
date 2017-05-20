<?php
/**
 *	Configure Image Sizes and Galleries
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


/**
 *	Configure the gallery thumbnail and enlarged (popup) image sizes.
 *
 * @package McBoots
 */

// avoids having the gallery popup image be unnecessarily huge
// the default size is 'full'
// 'max-gallery' is defined in lib/setup/images.php
add_filter( 'mcb_gallery_enlarged_size', function() {
	return 'max-gallery';
});

/*
usually no need to filter 'mcb_gallery_thumb_size' as 'thumbnail' is default
add_filter( 'mcb_gallery_thumb_size', function() {
	return 'thumbnail';
});
*/

/**
 *	Add Gallery Titles
 *	- adds title attribute to image tags; will show up as Magnific gallery captions
 *	- uses caption if configured, otherwise image title
 */
add_filter( 'mcb_get_gallery_caption', function( $caption, $id ) {
	$_post = get_post( $id );
	if ( !$_post ) return $caption;
	$caption = $_post->post_excerpt ? $_post->post_excerpt : $_post->post_title;
	return esc_html( $caption );
}, 10, 2 );
