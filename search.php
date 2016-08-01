<?php
/**
 * The template for displaying search results pages.
 *
 * @package McBoots
 */

	get_template_part( 'template-parts/page', 'header' );

	if ( have_posts() ) {

?>
	<ul class="post-list unstyled-list">
<?php
		while ( have_posts() ) : the_post();
			$post_type = get_post_type();
			$selector = ( $post_type == 'post' ) ? get_post_format() : $post_type;
			get_template_part( 'template-parts/content', $selector );
		endwhile;
?>
	</ul>

<?php

		the_posts_navigation();

	// empty list
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
