<?php
/**
 * The template for displaying search results pages.
 *
 * @package McBoots
 */

	get_template_part( 'template-parts/page', 'header' );

	if ( have_posts() ) {
?>
	<ul class="unstyled-list">

<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', 'search' );
		endwhile;

		the_posts_navigation();
?>
	</ul>

<?php

	} else {

		get_template_part( 'template-parts/content', 'none' );

	}
