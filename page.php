<?php
/**
 * The template for displaying pages. Damn well better be only one of them. 
 *
 * @package McBoots
 */

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/page', 'header' );
		get_template_part( 'template-parts/content', 'page' );
	endwhile;