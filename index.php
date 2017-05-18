<?php
/**
 * Default template file for post lists; used primarily for blog home pages.
 *
 * @package McBoots
 */

use McBoots\Views;

get_template_part( 'template-parts/page', 'header' );

if ( have_posts() ) {
?>
	<ol class="post-list list-unstyled">

<?php
	while ( have_posts() ) : the_post();
		echo Views\render_list_item( get_post_type() );
	endwhile;
?>
	</ol>

<?php
	the_posts_navigation();

// empty list
} else {
	get_template_part( 'template-parts/content', 'none' );
}