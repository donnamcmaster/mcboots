<?php
/**
 * Default template file; used primarily for blog home pages.
 * 
 * @package McBoots
 */

	get_template_part( 'template-parts/page', 'header' );


	if ( have_posts() ) {

		if ( !is_singular() ) {
?>
	<ol reversed class="unstyled-list">

<?php
	}
		while ( have_posts() ) : the_post();

			get_template_part( 'template-parts/content', get_post_format() );

		endwhile; // end of the loop

		the_posts_navigation();

		if ( !is_singular() ) {
?>
	</ol>

<?php
		}

	// empty list
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}

