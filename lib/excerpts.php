<?php
/**
 *	Custom Post Excerpts
 *	- filters for excerpt parameters are customized in lib/setup/config.php, e.g.: 
 
add_filter( 'excerpt_length', 14 );
add_filter( 'excerpt_more', ' [&hellip;]' );

 *
 * @package McBoots
 */

namespace McBoots\Excerpts;


/**
 *	Returns a "continue" link for excerpts
 *	- defaults to current $post->ID
 */
function read_more_link ( $post_id ) {
	$read_more_text = 'read more';
	return ' <a href="'. get_permalink( $post_id ) . '" class="read-more">' . apply_filters( 'mcb_excerpt_read_more', $read_more_text ) . '</a>';
}


/**
 *	Custom excerpt code
 *	- similar to wp_trim_excerpt in wp-includes/formatting.php
 *	- but can't use wp_trim_excerpt because you can't use apply_filters( 'the_content' ) outside loop
 *	- also this function allows special case override of default excerpt length
 */
function get_custom_excerpt ( $post_id=null, $excerpt_length=null, $read_more_link=false ) {
	$post_to_excerpt = get_post( $post_id );
	if ( empty( $post_to_excerpt ) ) {
		return '';
	}
	$text = $post_to_excerpt->post_excerpt ? $post_to_excerpt->post_excerpt : $post_to_excerpt->post_content;
	$text = trim_excerpt( $text, $excerpt_length )
	if ( $read_more_link ) {
		$text .= read_more_link( $post_to_excerpt->ID );
	}
	return $text;
}

/**
 *	Trim excerpt outside the loop
 *	- similar to wp_trim_excerpt in wp-includes/formatting.php
 *	- but can't use wp_trim_excerpt because it only works on current post in the loop
 *	- also this function allows special case override of default excerpt length
 */
function trim_excerpt ( $text='', $excerpt_length=null ) {
	$text = wpautop( wptexturize( strip_shortcodes( $text ) ) );
	$text = str_replace( ']]>', ']]&gt;', $text );

	// allow this function to override normal excerpt length
	$excerpt_length = !is_null( $excerpt_length ) ? $excerpt_length : apply_filters( 'excerpt_length', 55 );
	$excerpt_more = apply_filters( 'excerpt_more', ' ' . '[&hellip;]' );

	$text = wp_trim_words( $text, $excerpt_length, $excerpt_more );
	return $text;
}
