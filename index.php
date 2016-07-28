<?php
/**
 * Default template file; used primarily for blog home pages.
 * 
 * @package McBoots
 */

	if ( !is_singular() ) {
		get_template_part( 'template-parts/page', 'header' );
	}

	if ( have_posts() ) {
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		endwhile;

		the_posts_navigation();

	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
