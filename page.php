<?php
/**
 * The template for displaying pages.
 *
 * @package McBoots
 */

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/content', 'page' );
	endwhile;