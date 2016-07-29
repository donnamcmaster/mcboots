<?php
/**
 * The template for displaying archive pages.
 * 
 * @package McBoots
 */

	get_template_part( 'template-parts/page', 'header' );

	if ( have_posts() ) {
?>
	<ol reversed class="unstyled-list">

<?php
		while ( have_posts() ) : the_post();
			get_template_part( 'template-parts/content', get_post_format() );
		endwhile;

?>
	</ol>

<?php
		the_posts_navigation();

	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
