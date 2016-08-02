<?php

/**
 * Class Post_Views
 *
 * Default template pieces for posts of type "post". 
 * Subclass of Base_Views. 
 * 
 * To override any of the Base_Views functions, copy the function to this class and
 * edit as needed. 
 *
 * This is the file to edit if you want to add support for Post Formats. 
 *
 * @package McBoots
 */

class Post_Views extends Base_Views {

	public static function entry_meta_head ( $is_singular, $is_search=false ) {
		get_template_part( 'template-parts/entry-meta', 'head' );
	}

	public static function entry_meta_foot ( $is_singular, $is_search=false ) {
		get_template_part( 'template-parts/entry-meta', 'foot' );
	}

	public static function post_navigation ( $is_singular, $is_search=false ) {
		the_post_navigation();
	}

	public static function comments_template ( $is_singular, $is_search=false ) {
		// if comments are open or we have at least one comment, load up the comment template.
		if ( comments_open() || get_comments_number() ) :
			comments_template();
		endif;
	}
}
