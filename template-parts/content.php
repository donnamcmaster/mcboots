<?php
/**
 * template-parts/content.php
 *
 * Template part for displaying posts in a list (e.g., index, archive, search).
 *
 * Generic with special case for post_type = "post"
 * - to display custom post types differently, use content-<post_type>.php
 * - to display post formats differently, use content-<post_format>.php
 * Note: don't name your post type the same as a post format that you're using!
 *
 * @package McBoots
 */
?>

<li>

	<article id="post-<?php the_ID(); ?>" <?php post_class(); ?>>

		<header class="entry-header">
<?php
		the_title( '<h2 class="entry-title"><a href="' . esc_url( get_permalink() ) . '" rel="bookmark">', '</a></h2>' );

		if ( 'post' === get_post_type() ) {
			get_template_part( 'template-parts/entry-meta', 'head' );
		}
?>
		</header><!-- .entry-header -->

		<div class="entry-content entry-summary">
			<?php the_excerpt(); ?>
		</div><!-- entry-content entry-summary -->

		<footer>
<?php
		if ( 'post' === get_post_type() ) {
			get_template_part( 'template-parts/entry-meta', 'foot' );
		}
		edit_post_link();
?>
		</footer>

	</article><!-- #post-## -->

</li>
