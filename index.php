<?php
/**
 * Default template file for post lists; used primarily for blog home pages.
 *
 * @package McBoots
 */

	get_template_part( 'template-parts/page', 'header' );

	if ( have_posts() ) {

?>
	<ol class="post-list unstyled-list">
<?php
		while ( have_posts() ) : the_post();
			$post_type_class = get_post_type().'_Views';
			echo $post_type_class::render_list_item();
		endwhile;
?>
	</ol>

<?php
		the_posts_navigation();

	// empty list
	} else {
		get_template_part( 'template-parts/content', 'none' );
	}
