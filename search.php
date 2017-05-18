<?php
/**
 * The template for displaying search results pages.
 *
 * @package McBoots
 */

use McBoots\Views;

get_template_part( 'template-parts/page', 'header' );

if ( have_posts() ) {
?>
	<ul class="post-list list-unstyled">

<?php
	while ( have_posts() ) : the_post();
		echo Views\render_list_item( get_post_type() );
	endwhile;
?>
	</ul>

<?php
	the_posts_navigation();

// empty list
} else {
	get_template_part( 'template-parts/content', 'none' );
}