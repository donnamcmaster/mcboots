<?php
/**
 * Adds the post type and slug to the <body> class, e.g., "page-about".
 *
 * @package McBoots
 */

add_filter( 'body_class', function( $classes ) {
    global $post;

    if ( isset( $post ) ) {
    	$classes[]= "{$post->post_type}-{$post->post_name}";
    }
    return $classes;
});
