<?php
/**
 * The template for displaying pages. Damn well better be only one of them. 
 *
 * @package McBoots
 */

	while ( have_posts() ) : the_post();
		get_template_part( 'template-parts/page', 'header' );

		$post_type_class = get_post_type().'_Views';
		echo $post_type_class::render_singular();
	endwhile;